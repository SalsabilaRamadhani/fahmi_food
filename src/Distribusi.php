<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'auth.php';
include 'koneksi.php';

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
  header("Location: ../Index.php?page=distribusi");
  exit;
}

/* =================== HANDLE FORM ==================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  try {
    if ($action === 'tambah') {
      // Ambil header pesanan
      $nama   = trim($_POST['nama_distributor'] ?? '');
      $alamat = trim($_POST['alamat_distributor'] ?? '');
      $tgl    = $_POST['tgl_pesanan'] ?? date('Y-m-d');
      $status = $_POST['status_pengiriman'] ?? 'Diproses';

      // Ambil detail multi-produk
      $details = $_POST['detail'] ?? [];
      if (!is_array($details) || count($details) === 0) {
        throw new Exception('Tambahkan minimal 1 produk.');
      }

      $stmt = $pdo->prepare("
        INSERT INTO distribusi
          (nama_distributor, alamat_distributor, id_produk, jumlah_pesanan, tanggal_pesanan, status_pengiriman)
        VALUES (?,?,?,?,?,?)
      ");

      $any = false;
      foreach ($details as $row) {
        $id_produk = isset($row['id_produk']) ? (int)$row['id_produk'] : 0;
        $jumlah    = isset($row['jumlah']) ? (int)$row['jumlah'] : 0;
        if ($id_produk > 0 && $jumlah > 0) {
          $stmt->execute([$nama, $alamat, $id_produk, $jumlah, $tgl, $status]);
          $any = true;
        }
      }
      if (!$any) throw new Exception('Detail produk belum lengkap.');

      $_SESSION['notif'] = ['pesan' => 'Pesanan berhasil ditambahkan!', 'tipe' => 'sukses'];

    } elseif ($action === 'edit') {
      // Edit tetap per baris (per produk), sesuai desain tabel
      $stmt = $pdo->prepare("
        UPDATE distribusi
           SET nama_distributor=?, alamat_distributor=?, id_produk=?, jumlah_pesanan=?, tanggal_pesanan=?, status_pengiriman=?
         WHERE id_distribusi=?
      ");
      $stmt->execute([
        $_POST['nama_distributor'],
        $_POST['alamat_distributor'],
        (int)$_POST['id_produk'],
        (int)$_POST['jumlah_pesanan'],
        $_POST['tgl_pesanan'],
        $_POST['status_pengiriman'],
        (int)$_POST['id_distribusi']
      ]);
      $_SESSION['notif'] = ['pesan' => 'Pesanan berhasil diperbarui!', 'tipe' => 'sukses'];

    } elseif ($action === 'hapus') {
      $stmt = $pdo->prepare("DELETE FROM distribusi WHERE id_distribusi = ?");
      $stmt->execute([(int)$_POST['id_distribusi_hapus']]);
      $_SESSION['notif'] = ['pesan' => 'Pesanan berhasil dihapus.', 'tipe' => 'sukses'];
    }
  } catch (Exception $e) {
    $_SESSION['notif'] = ['pesan' => 'Kesalahan: ' . $e->getMessage(), 'tipe' => 'error'];
  }

  header("Location: Index.php?page=distribusi");
  exit;
}

/* =================== DATA UTAMA ==================== */
$daftar_distribusi = $pdo->query("
  SELECT d.*, p.nama_produk
  FROM distribusi d
  JOIN produk p ON d.id_produk = p.id_produk
  ORDER BY d.id_distribusi DESC
")->fetchAll(PDO::FETCH_ASSOC);

$produk_options = $pdo->query("
  SELECT id_produk, nama_produk
  FROM produk
  ORDER BY nama_produk
")->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="flex-1 bg-gray-100">
  <section class="p-6 overflow-x-auto">
    <?php if (isset($_SESSION['notif'])): ?>
      <div class="mb-4 p-4 rounded-md text-white font-bold <?= $_SESSION['notif']['tipe'] === 'sukses' ? 'bg-green-500' : 'bg-red-500'; ?>">
        <?= htmlspecialchars($_SESSION['notif']['pesan']); ?>
      </div>
      <?php unset($_SESSION['notif']); ?>
    <?php endif; ?>

    <button id="btnTambah" class="mb-4 inline-flex items-center gap-2 bg-blue-700 text-white text-sm font-normal px-4 py-2 rounded" type="button">
      <i class="fas fa-plus"></i> Input Pesanan
    </button>

    <table class="w-full border border-gray-300 text-sm bg-white">
      <thead>
        <tr class="bg-blue-200 text-black text-left">
          <th class="border border-gray-300 px-3 py-2">No.</th>
          <th class="border border-gray-300 px-3 py-2">Distributor</th>
          <th class="border border-gray-300 px-3 py-2">Alamat</th>
          <th class="border border-gray-300 px-3 py-2">Produk</th>
          <th class="border border-gray-300 px-3 py-2">Jumlah</th>
          <th class="border border-gray-300 px-3 py-2">Tanggal Pesanan</th>
          <th class="border border-gray-300 px-3 py-2">Status</th>
          <th class="border border-gray-300 px-3 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($daftar_distribusi)): ?>
          <tr>
            <td colspan="8" class="border border-gray-300 px-3 py-4 text-center text-gray-500">Belum ada data distribusi.</td>
          </tr>
        <?php else: foreach ($daftar_distribusi as $i => $d): ?>
          <tr>
            <td class="border border-gray-300 px-3 py-2"><?= $i + 1 ?>.</td>
            <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($d['nama_distributor']) ?></td>
            <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($d['alamat_distributor']) ?></td>
            <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($d['nama_produk']) ?></td>
            <td class="border border-gray-300 px-3 py-2"><?= (int)$d['jumlah_pesanan'] ?> kg</td>
            <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($d['tanggal_pesanan']) ?></td>
            <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($d['status_pengiriman']) ?></td>
            <td class="border border-gray-300 px-3 py-2 space-x-2">
              <button class="btnEdit px-3 py-1 text-xs text-white rounded" style="background-color:#1d4ed8;"
                data-id="<?= $d['id_distribusi'] ?>"
                data-nama="<?= htmlspecialchars($d['nama_distributor']) ?>"
                data-alamat="<?= htmlspecialchars($d['alamat_distributor']) ?>"
                data-id_produk="<?= $d['id_produk'] ?>"
                data-jumlah="<?= (int)$d['jumlah_pesanan'] ?>"
                data-tanggal="<?= $d['tanggal_pesanan'] ?>"
                data-status="<?= htmlspecialchars($d['status_pengiriman']) ?>">Edit</button>
              <form method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                <input type="hidden" name="action" value="hapus">
                <input type="hidden" name="id_distribusi_hapus" value="<?= $d['id_distribusi'] ?>">
                <button type="submit" class="bg-red-700 text-white text-xs px-3 py-1 rounded hover:bg-red-800">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </section>

  <!-- Modal Tambah/Edit -->
  <div id="modalForm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <form action="" method="POST" id="formDistribusi" class="bg-white p-6 rounded w-[680px] max-w-[92vw] relative shadow">
      <input type="hidden" name="action" id="formAction" value="tambah">
      <input type="hidden" name="id_distribusi" id="formIdDistribusi">

      <button type="button" class="btnClose absolute top-2 right-3 text-gray-600 hover:text-black text-xl font-bold">&times;</button>

      <h2 id="formTitle" class="text-lg font-semibold text-gray-800 mb-4">Tambah Pesanan</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label class="block text-sm text-gray-700 mb-1">Nama Distributor</label>
          <input type="text" name="nama_distributor" id="formNama" required class="w-full border px-3 py-2 rounded">
        </div>
        <div>
          <label class="block text-sm text-gray-700 mb-1">Tanggal Pesanan</label>
          <input type="date" name="tgl_pesanan" id="formTanggal" required class="w-full border px-3 py-2 rounded" value="<?= date('Y-m-d') ?>">
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm text-gray-700 mb-1">Alamat Distributor</label>
          <input type="text" name="alamat_distributor" id="formAlamat" required class="w-full border px-3 py-2 rounded">
        </div>
        <div>
          <label class="block text-sm text-gray-700 mb-1">Status Pengiriman</label>
          <select name="status_pengiriman" id="formStatus" required class="w-full border px-3 py-2 rounded">
            <option value="">-- Pilih Status --</option>
            <option value="Diproses">Diproses</option>
            <option value="Dikirim">Dikirim</option>
            <option value="Selesai">Selesai</option>
          </select>
        </div>
      </div>

      <div class="mt-4">
        <div class="text-sm font-semibold text-gray-800 mb-2">Detail Produk</div>
        <div id="produkList"></div>
        <button type="button" class="mt-2 bg-blue-700 text-white text-xs px-3 py-1 rounded" onclick="addRow()">+ Tambah Produk</button>
      </div>

      <div class="mt-5">
        <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded">Simpan</button>
      </div>
    </form>
  </div>
</main>

<script>
  // ===== Modal basic =====
  const btnTambah = document.getElementById('btnTambah');
  const modal = document.getElementById('modalForm');
  const closeModal = () => modal.classList.add('hidden');
  const openModal  = () => modal.classList.remove('hidden');
  document.querySelectorAll('.btnClose').forEach(btn => btn.onclick = closeModal);
  window.onclick = e => { if (e.target === modal) closeModal(); };

  btnTambah.onclick = () => {
    document.getElementById('formTitle').textContent = 'Tambah Pesanan';
    document.getElementById('formAction').value = 'tambah';
    document.getElementById('formIdDistribusi').value = '';
    // reset field header
    ['formNama','formAlamat','formTanggal','formStatus'].forEach(id => {
      const el = document.getElementById(id);
      if (id==='formTanggal') el.value = '<?= date('Y-m-d') ?>';
      else el.value = '';
    });
    // reset detail
    document.getElementById('produkList').innerHTML = '';
    rowCount = 0;
    addRow();
    openModal();
  };

  // ===== Edit (per baris) =====
  document.querySelectorAll('.btnEdit').forEach(btn => {
    btn.onclick = () => {
      document.getElementById('formTitle').textContent = 'Edit Pesanan';
      document.getElementById('formAction').value = 'edit';
      document.getElementById('formIdDistribusi').value = btn.dataset.id;
      document.getElementById('formNama').value = btn.dataset.nama;
      document.getElementById('formAlamat').value = btn.dataset.alamat;
      document.getElementById('formTanggal').value = btn.dataset.tanggal;
      document.getElementById('formStatus').value = btn.dataset.status;

      // detail untuk edit (satu baris sesuai row yang diklik)
      document.getElementById('produkList').innerHTML = '';
      rowCount = 0;
      addRow(btn.dataset.id_produk, btn.dataset.jumlah);
      openModal();
    };
  });

  // ===== Dynamic rows (multi-produk) =====
  const produkOptions = `<?php foreach ($produk_options as $p) {
    echo '<option value="'.(int)$p['id_produk'].'">'.htmlspecialchars($p['nama_produk']).'</option>';
  } ?>`;

  let rowCount = 0;
  function addRow(selectedProduk = '', jumlah = '') {
    rowCount++;
    const id = rowCount;
    const row = document.createElement('div');
    row.className = 'produk-row border border-gray-200 rounded p-3 mb-2';
    row.innerHTML = `
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
        <div>
          <label class="block text-sm text-gray-700 mb-1">Produk</label>
          <select name="detail[${id}][id_produk]" class="w-full border px-3 py-2 rounded" required>
            <option value="">-- Pilih Produk --</option>
            ${produkOptions}
          </select>
        </div>
        <div>
          <label class="block text-sm text-gray-700 mb-1">Jumlah (kg)</label>
          <input type="number" name="detail[${id}][jumlah]" min="1" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div class="text-right md:text-left">
          <button type="button" class="bg-red-600 text-white text-xs px-3 py-2 rounded" onclick="this.closest('.produk-row').remove()">Hapus</button>
        </div>
      </div>`;
    document.getElementById('produkList').appendChild(row);

    // Set nilai awal jika diberikan (mode edit)
    if (selectedProduk) row.querySelector('select').value = selectedProduk;
    if (jumlah) row.querySelector('input').value = jumlah;
  }

  // Validasi minimal 1 baris detail
  document.getElementById('formDistribusi').addEventListener('submit', function(e) {
    const rows = [...document.querySelectorAll('.produk-row')];
    let ok = 0;
    rows.forEach(r => {
      const pr = r.querySelector('select');
      const j  = r.querySelector('input[type="number"]');
      if (pr.value && parseInt(j.value||'0') > 0) ok++;
    });
    if (ok === 0) {
      e.preventDefault();
      alert('Tambahkan minimal 1 produk dengan jumlah yang benar.');
    }
  });
</script>
