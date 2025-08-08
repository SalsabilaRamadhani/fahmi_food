<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'auth.php';
include 'koneksi.php';
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
  header("Location: ../Index.php?page=distribusi"); exit;
}

// Ambil semua stok yg siap distribusi (stok > 0 & status "Sudah dipacking"/"Tersedia")
$sql_stok = "
  SELECT s.*, p.nama_produk
  FROM stok s
  JOIN produk p ON s.id_produk = p.id_produk
  WHERE (s.status_stok = 'Sudah dipacking' OR s.status_stok = 'Tersedia') AND s.jumlah_stok > 0
  ORDER BY p.nama_produk, s.id_stok DESC
";
$stok_list = $pdo->query($sql_stok)->fetchAll(PDO::FETCH_ASSOC);

// Indexing produk → array stok per produk, biar mudah di JS
$stok_map = [];
foreach ($stok_list as $row) {
  $stok_map[$row['id_produk']][] = $row;
}

// Semua produk
$produk_options = $pdo->query("SELECT id_produk, nama_produk FROM produk ORDER BY nama_produk ASC")->fetchAll(PDO::FETCH_ASSOC);

// ===== SUBMIT FORM DISTRIBUSI =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'tambah') {
  try {
    $pdo->beginTransaction();
    $nama_toko = $_POST['nama_toko'];
    $tanggal_distribusi = $_POST['tanggal_distribusi'];
    $status = $_POST['status'];
    $catatan = $_POST['catatan'] ?? '';
    $id_admin = 1;

    // Insert master distribusi
    $pdo->prepare("INSERT INTO distribusi (nama_toko, tanggal_distribusi, status, catatan, id_admin)
      VALUES (?, ?, ?, ?, ?)")
      ->execute([$nama_toko, $tanggal_distribusi, $status, $catatan, $id_admin]);
    $id_distribusi = $pdo->lastInsertId();

    // Loop setiap detail
    foreach ($_POST['detail'] as $row) {
      $id_produk = $row['id_produk'];
      $id_stok = $row['id_stok'];
      $jumlah = (int)$row['jumlah'];

      // Validasi: stok cukup
      $stok_data = $pdo->query("SELECT jumlah_stok FROM stok WHERE id_stok = $id_stok")->fetch();
      if (!$stok_data || $jumlah > $stok_data['jumlah_stok']) {
        throw new Exception("Stok tidak cukup untuk salah satu produk!");
      }

      // Insert detail
      $pdo->prepare("INSERT INTO distribusi_detail (id_distribusi, id_produk, id_stok, jumlah_kg)
        VALUES (?, ?, ?, ?)")
        ->execute([$id_distribusi, $id_produk, $id_stok, $jumlah]);

      // Kurangi stok
      $pdo->prepare("UPDATE stok SET jumlah_stok = jumlah_stok - ? WHERE id_stok = ?")
        ->execute([$jumlah, $id_stok]);
      // Jika stok habis, update status stok
      $pdo->prepare("UPDATE stok SET status_stok = 'Habis' WHERE id_stok = ? AND jumlah_stok <= 0")
        ->execute([$id_stok]);
    }

    $pdo->commit();
    $_SESSION['notif'] = ['pesan' => 'Distribusi berhasil disimpan!', 'tipe' => 'sukses'];
  } catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $_SESSION['notif'] = ['pesan' => 'Gagal simpan distribusi: ' . $e->getMessage(), 'tipe' => 'error'];
  }
  header("Location: Index.php?page=distribusi");
  exit;
}

// ====== BACA DATA DISTRIBUSI ======
$sql_dist = "SELECT d.*, GROUP_CONCAT(CONCAT(pr.nama_produk,' (',dd.jumlah_kg,' kg)') SEPARATOR ', ') AS detail_produk
  FROM distribusi d
  JOIN distribusi_detail dd ON d.id_distribusi = dd.id_distribusi
  JOIN produk pr ON dd.id_produk = pr.id_produk
  GROUP BY d.id_distribusi
  ORDER BY d.tanggal_distribusi DESC, d.id_distribusi DESC";
$distribusi_list = $pdo->query($sql_dist)->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="flex-1 bg-gray-100">
  <section class="p-6 overflow-x-auto">
    <?php if (isset($_SESSION['notif'])): ?>
      <div class="mb-4 flex items-center p-4 rounded-md font-bold shadow <?php
        echo $_SESSION['notif']['tipe'] === 'sukses'
          ? 'bg-green-500 text-white'
          : 'bg-red-500 text-white';
      ?>">
        <i class="fas <?php
          echo $_SESSION['notif']['tipe'] === 'sukses'
            ? 'fa-check-circle'
            : 'fa-exclamation-triangle';
        ?> mr-3 text-2xl"></i>
        <span><?php echo htmlspecialchars($_SESSION['notif']['pesan']); ?></span>
        <button onclick="this.parentNode.style.display='none'" class="ml-auto bg-transparent border-none text-white text-2xl font-bold opacity-80 hover:opacity-100">&times;</button>
      </div>
      <?php unset($_SESSION['notif']); ?>
    <?php endif; ?>

    <!-- FORM DISTRIBUSI -->
    <div class="bg-white p-6 rounded shadow-md max-w-3xl mb-8 mx-auto">
      <h2 class="text-lg font-bold mb-4 text-blue-700">Input Distribusi</h2>
      <form method="POST" id="formDistribusi" autocomplete="off">
        <input type="hidden" name="action" value="tambah">
        <div class="mb-3 flex flex-col md:flex-row gap-4">
          <div class="flex-1">
            <label class="block text-sm mb-1">Nama Toko</label>
            <input type="text" name="nama_toko" class="w-full border rounded px-3 py-2" required>
          </div>
          <div>
            <label class="block text-sm mb-1">Tanggal</label>
            <input type="date" name="tanggal_distribusi" class="border rounded px-3 py-2" value="<?= date('Y-m-d') ?>" required>
          </div>
          <div>
            <label class="block text-sm mb-1">Status</label>
            <select name="status" class="border rounded px-3 py-2" required>
              <option value="Dikirim">Dikirim</option>
              <option value="Selesai">Selesai</option>
              <option value="Retur">Retur</option>
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label class="block text-sm mb-1">Catatan (opsional)</label>
          <textarea name="catatan" class="w-full border rounded px-3 py-2"></textarea>
        </div>
        <div class="mb-3">
          <label class="block text-sm font-semibold mb-2 text-blue-700">Detail Produk</label>
          <div id="produkDetails"></div>
          <button type="button" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-1 rounded" id="btnTambahBaris">+ Tambah Produk</button>
        </div>
        <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2 rounded font-semibold text-base mt-4">Simpan Distribusi</button>
      </form>
    </div>

    <!-- TABEL DISTRIBUSI -->
    <h3 class="font-semibold text-lg mb-2 text-blue-700">Riwayat Distribusi</h3>
    <table class="w-full border border-gray-300 text-sm bg-white">
      <thead class="bg-blue-200">
        <tr>
          <th class="border px-3 py-2">No.</th>
          <th class="border px-3 py-2">Tanggal</th>
          <th class="border px-3 py-2">Nama Toko</th>
          <th class="border px-3 py-2">Produk</th>
          <th class="border px-3 py-2">Status</th>
          <th class="border px-3 py-2">Catatan</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($distribusi_list)): ?>
          <tr><td colspan="6" class="text-center text-gray-500 py-6">Belum ada distribusi tercatat.</td></tr>
        <?php else: ?>
          <?php foreach ($distribusi_list as $i => $dist): ?>
            <tr>
              <td class="border px-3 py-2"><?= $i+1 ?>.</td>
              <td class="border px-3 py-2"><?= date('d M Y', strtotime($dist['tanggal_distribusi'])) ?></td>
              <td class="border px-3 py-2"><?= htmlspecialchars($dist['nama_toko']) ?></td>
              <td class="border px-3 py-2"><?= htmlspecialchars($dist['detail_produk']) ?></td>
              <td class="border px-3 py-2"><?= htmlspecialchars($dist['status']) ?></td>
              <td class="border px-3 py-2"><?= htmlspecialchars($dist['catatan']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </section>
</main>

<script>
  // Map stok per produk untuk select stok dinamis
  const stokMap = <?= json_encode($stok_map) ?>;
  const produkList = <?= json_encode($produk_options) ?>;

  function barisProduk(idx) {
    return `
    <div class="flex gap-2 mb-2 produk-row" data-idx="${idx}">
      <div class="flex-1">
        <select name="detail[${idx}][id_produk]" class="select-produk w-full border rounded px-2 py-1" required>
          <option value="" disabled selected>-- Pilih Produk --</option>
          ${produkList.map(p => `<option value="${p.id_produk}">${p.nama_produk}</option>`).join('')}
        </select>
      </div>
      <div class="flex-1">
        <select name="detail[${idx}][id_stok]" class="select-stok w-full border rounded px-2 py-1" required disabled>
          <option value="" disabled selected>Pilih produk dulu</option>
        </select>
      </div>
      <div>
        <input type="number" name="detail[${idx}][jumlah]" min="1" class="input-jumlah w-20 border rounded px-2 py-1" placeholder="Kg" required disabled>
      </div>
      <div>
        <button type="button" class="btnHapusBaris bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded">&times;</button>
      </div>
    </div>
    `;
  }

  let barisCount = 0;
  function tambahBarisProduk() {
    barisCount++;
    const div = document.createElement('div');
    div.innerHTML = barisProduk(barisCount);
    document.getElementById('produkDetails').appendChild(div.firstChild);
  }

  // Initial satu baris
  document.addEventListener('DOMContentLoaded', function() {
    tambahBarisProduk();
    document.getElementById('btnTambahBaris').addEventListener('click', tambahBarisProduk);

    document.getElementById('produkDetails').addEventListener('change', function(e) {
      if (e.target.classList.contains('select-produk')) {
        const row = e.target.closest('.produk-row');
        const idx = row.dataset.idx;
        const id_produk = e.target.value;
        const stokSelect = row.querySelector('.select-stok');
        const jumlahInput = row.querySelector('.input-jumlah');
        stokSelect.innerHTML = '';
        stokSelect.disabled = true;
        jumlahInput.value = '';
        jumlahInput.disabled = true;
        if (id_produk && stokMap[id_produk]) {
          stokSelect.innerHTML = '<option value="" disabled selected>-- Pilih Stok --</option>' +
            stokMap[id_produk].map(s => `<option value="${s.id_stok}" data-max="${s.jumlah_stok}">Batch #${s.id_stok} | Sisa: ${s.jumlah_stok}kg</option>`).join('');
          stokSelect.disabled = false;
        } else {
          stokSelect.innerHTML = '<option value="" disabled selected>Tidak ada stok tersedia</option>';
        }
      }
      if (e.target.classList.contains('select-stok')) {
        const row = e.target.closest('.produk-row');
        const jumlahInput = row.querySelector('.input-jumlah');
        jumlahInput.value = '';
        jumlahInput.disabled = !e.target.value;
        if (e.target.value) {
          jumlahInput.max = e.target.selectedOptions[0].dataset.max || '';
        }
      }
    });

    document.getElementById('produkDetails').addEventListener('input', function(e) {
      if (e.target.classList.contains('input-jumlah')) {
        const row = e.target.closest('.produk-row');
        const stokSelect = row.querySelector('.select-stok');
        const max = parseInt(stokSelect.selectedOptions[0]?.dataset.max) || 0;
        if (parseInt(e.target.value) > max) {
          e.target.value = max;
        }
      }
    });

    document.getElementById('produkDetails').addEventListener('click', function(e) {
      if (e.target.classList.contains('btnHapusBaris')) {
        e.target.closest('.produk-row').remove();
      }
    });
  });
</script>
