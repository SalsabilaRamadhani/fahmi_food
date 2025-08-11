<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'auth.php';
include 'koneksi.php';
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
  header("Location: ../Index.php?page=pekerja"); exit;
}

// Ambil stok AGAR PITA siap dikemas (sisa stok > 0, relasi produksi harus valid)
$sql_stok_pita = "
  SELECT s.*, p.nama_produk, pr.tgl_produksi
  FROM stok s
  JOIN produk p ON s.id_produk = p.id_produk
  LEFT JOIN produksi pr ON s.id_produksi = pr.id_produksi
  WHERE p.nama_produk = 'Agar Pita' AND s.status_stok = 'Siap dikemas' AND s.jumlah_stok > 0
  ORDER BY pr.tgl_produksi DESC, s.id_stok DESC
";
$stok_pita_list = $pdo->query($sql_stok_pita)->fetchAll(PDO::FETCH_ASSOC);

// --- FUNGSI HELPER UNTUK UPDATE STATUS Gaji OTOMATIS ---
function updateStatusPekerja($pdo, $id_pekerja) {
  $sql_check = "SELECT COUNT(*) FROM riwayat_gaji WHERE id_pekerja = ? AND keterangan = 'Belum Dibayar'";
  $stmt_check = $pdo->prepare($sql_check);
  $stmt_check->execute([$id_pekerja]);
  $belum_dibayar_count = $stmt_check->fetchColumn();
  $new_status = ($belum_dibayar_count == 0) ? 'Dibayar' : 'Belum Dibayar';
  $sql_update = "UPDATE pekerja_lepas SET status_pembayaran = ? WHERE id_pekerja = ?";
  $stmt_update = $pdo->prepare($sql_update);
  $stmt_update->execute([$new_status, $id_pekerja]);
}

// === CRUD & PROSES ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  try {
    switch ($action) {
      case 'tambah_pekerja':
        $sql = "INSERT INTO pekerja_lepas (nama_pekerja, kontak, alamat, status_pembayaran, id_admin) VALUES (?, ?, ?, 'Belum Dibayar', 1)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['nama_pekerja'], $_POST['kontak'], $_POST['alamat']]);
        $_SESSION['notif'] = ['pesan' => 'Data pekerja berhasil ditambahkan!', 'tipe' => 'sukses'];
        break;

      case 'edit_pekerja':
        $sql = "UPDATE pekerja_lepas SET nama_pekerja = ?, kontak = ?, alamat = ? WHERE id_pekerja = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['nama_pekerja'], $_POST['kontak'], $_POST['alamat'], $_POST['id_pekerja_edit']]);
        $_SESSION['notif'] = ['pesan' => 'Data pekerja berhasil diperbarui!', 'tipe' => 'sukses'];
        break;

      case 'ambil_stok_pekerja':
        $id_pekerja = $_POST['id_pekerja_ambil'];
        $id_stok = $_POST['id_stok_ambil'];
        $jumlah_kg = (int)$_POST['jumlah_kg'];
        $tanggal = date('Y-m-d');
        // Ambil data stok
        $stok = $pdo->query("SELECT * FROM stok WHERE id_stok = $id_stok")->fetch();
        if (!$stok) throw new Exception("Stok tidak ditemukan.");
        if ($jumlah_kg < 20) throw new Exception("Minimal ambil 20 kg!");
        if ($jumlah_kg > $stok['jumlah_stok']) throw new Exception("Tidak cukup stok tersedia.");
        // Insert pengambilan
        $gaji = $jumlah_kg * 2500;
        $pdo->beginTransaction();
        $pdo->prepare("INSERT INTO pengambilan_stok_pekerja (id_pekerja, id_stok, tanggal_ambil, jumlah_kg, total_gaji, status) VALUES (?, ?, ?, ?, ?, ?)")
          ->execute([$id_pekerja, $id_stok, $tanggal, $jumlah_kg, $gaji, 'Sedang dikerjakan']);
        // Insert ke riwayat_gaji otomatis
        $pdo->prepare("INSERT INTO riwayat_gaji (id_pekerja, tanggal, berat_barang_kg, tarif_per_kg, total_gaji, keterangan) VALUES (?, ?, ?, ?, ?, ?)")
          ->execute([$id_pekerja, $tanggal, $jumlah_kg, 2500, $gaji, 'Belum Dibayar']);
        // Kurangi stok
        $pdo->prepare("UPDATE stok SET jumlah_stok = jumlah_stok - ? WHERE id_stok = ?")->execute([$jumlah_kg, $id_stok]);
        // Jika stok habis, update status stok
        $pdo->prepare("UPDATE stok SET status_stok = 'Sudah diambil pekerja' WHERE id_stok = ? AND jumlah_stok <= 0")->execute([$id_stok]);
        updateStatusPekerja($pdo, $id_pekerja);
        $pdo->commit();
        $_SESSION['notif'] = ['pesan' => 'Pengambilan stok & riwayat gaji tersimpan!', 'tipe' => 'sukses'];
        break;

      case 'hapus_pekerja':
        $sql = "DELETE FROM pekerja_lepas WHERE id_pekerja = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['id_pekerja_hapus']]);
        $_SESSION['notif'] = ['pesan' => 'Data pekerja berhasil dihapus.', 'tipe' => 'sukses'];
        break;
    }
  } catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $_SESSION['notif'] = ['pesan' => 'Error: ' . $e->getMessage(), 'tipe' => 'error'];
  }
  $search_query = isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '';
  header("Location: Index.php?page=pekerja" . $search_query);
  exit;
}

// ===== DATA UTAMA =====
$search_term = $_GET['search'] ?? '';
$sql_pekerja = "SELECT pl.*,
    (SELECT SUM(rg.total_gaji) FROM riwayat_gaji rg WHERE rg.id_pekerja = pl.id_pekerja AND rg.keterangan = 'Dibayar') as total_dibayar,
    (SELECT SUM(rg.total_gaji) FROM riwayat_gaji rg WHERE rg.id_pekerja = pl.id_pekerja AND rg.keterangan = 'Belum Dibayar') as total_belum_dibayar
  FROM pekerja_lepas pl";
$params = [];
if (!empty($search_term)) {
  $sql_pekerja .= " WHERE pl.nama_pekerja LIKE ?";
  $params[] = "%" . $search_term . "%";
}
$sql_pekerja .= " ORDER BY pl.nama_pekerja ASC";
$stmt = $pdo->prepare($sql_pekerja);
$stmt->execute($params);
$pekerja_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_summary = "SELECT keterangan, SUM(total_gaji) as total_per_keterangan FROM riwayat_gaji GROUP BY keterangan";
$summary_list = $pdo->query($sql_summary)->fetchAll(PDO::FETCH_KEY_PAIR);
$summary_dibayar = $summary_list['Dibayar'] ?? 0;
$summary_belum_dibayar = $summary_list['Belum Dibayar'] ?? 0;
?>

<main class="flex-1 bg-gray-100">
  <section class="p-6 overflow-x-auto">
    <?php if (isset($_SESSION['notif'])): ?>
      <div class="mb-4 p-4 rounded-md text-white font-bold <?php echo $_SESSION['notif']['tipe'] === 'sukses' ? 'bg-green-500' : 'bg-red-500'; ?>">
        <?php echo htmlspecialchars($_SESSION['notif']['pesan']); ?>
      </div>
    <?php unset($_SESSION['notif']); endif; ?>

    <div class="flex flex-col md:flex-row md:items-center md:space-x-4 mb-4">
      <button id="btnTambahPekerja" class="flex-shrink-0 inline-flex items-center gap-2 bg-[#2f4ea1] text-white text-sm font-normal px-4 py-2 rounded shadow-sm hover:shadow-md transition-shadow mb-2 md:mb-0" type="button"><i class="fas fa-plus"></i> Tambah Pekerja</button>
      <form action="Index.php" method="GET" class="flex flex-1 max-w-md">
        <input type="hidden" name="page" value="pekerja">
        <input type="text" name="search" placeholder="Cari nama pekerja..." class="flex-grow border border-gray-300 rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#2f4ea1]" value="<?php echo htmlspecialchars($search_term); ?>">
        <button type="submit" class="bg-[#2f4ea1] text-white px-6 py-2 rounded-r shadow-sm hover:shadow-md transition-shadow">Cari</button>
      </form>
    </div>

    <table class="w-full border border-gray-300 text-sm bg-white text-left">
      <thead class="bg-[#bdd4f2] text-xs text-gray-900">
        <tr>
          <th class="border border-gray-300 px-3 py-2 w-12">No.</th>
          <th class="border border-gray-300 px-3 py-2 w-40">Nama</th>
          <th class="border border-gray-300 px-3 py-2 w-32">Kontak</th>
          <th class="border border-gray-300 px-3 py-2 w-40">Total Dibayar</th>
          <th class="border border-gray-300 px-3 py-2 w-40">Total Belum Dibayar</th>
          <th class="border border-gray-300 px-3 py-2 w-40">Status Gaji</th>
          <th class="border border-gray-300 px-3 py-2 w-52">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($pekerja_list)): ?>
          <tr>
            <td colspan="7" class="border border-gray-300 px-3 py-4 text-center text-gray-500">Data pekerja tidak ditemukan.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($pekerja_list as $index => $pekerja): ?>
            <tr>
              <td class="border border-gray-300 px-3 py-2"><?php echo $index + 1; ?>.</td>
              <td class="border border-gray-300 px-3 py-2"><?php echo htmlspecialchars($pekerja['nama_pekerja']); ?></td>
              <td class="border border-gray-300 px-3 py-2"><?php echo htmlspecialchars($pekerja['kontak']); ?></td>
              <td class="border border-gray-300 px-3 py-2 text-green-700">Rp. <?php echo number_format($pekerja['total_dibayar'] ?? 0, 0, ',', '.'); ?></td>
              <td class="border border-gray-300 px-3 py-2 text-red-700">Rp. <?php echo number_format($pekerja['total_belum_dibayar'] ?? 0, 0, ',', '.'); ?></td>
              <td class="border border-gray-300 px-3 py-2"><span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo $pekerja['status_pembayaran'] == 'Dibayar' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>"><?php echo htmlspecialchars($pekerja['status_pembayaran']); ?></span></td>
              <td class="border border-gray-300 px-3 py-2 space-x-1 flex items-center justify-center ">
                <button class="btnAmbilStok bg-yellow-600 text-white text-xs px-2 py-1 rounded inline-flex items-center gap-1"
                  data-id-pekerja="<?php echo $pekerja['id_pekerja']; ?>"
                  data-nama-pekerja="<?php echo htmlspecialchars($pekerja['nama_pekerja']); ?>">
                  <i class="fas fa-box-open"></i> Ambil Stok
                </button>
                <a href="Index.php?page=riwayat_gaji&id_pekerja=<?php echo $pekerja['id_pekerja']; ?>" class="btnHistory bg-gray-500 text-white text-xs px-3 py-1 rounded inline-block">Riwayat</a>
                <button class="btnEdit bg-[#2f4ea1] text-white text-xs px-3 py-1 rounded" data-id-pekerja="<?php echo $pekerja['id_pekerja']; ?>" data-nama="<?php echo htmlspecialchars($pekerja['nama_pekerja']); ?>" data-kontak="<?php echo htmlspecialchars($pekerja['kontak']); ?>" data-alamat="<?php echo htmlspecialchars($pekerja['alamat']); ?>">Edit</button>
                <button class="btnHapus bg-red-700 text-white text-xs px-3 py-1 rounded" data-id-pekerja="<?php echo $pekerja['id_pekerja']; ?>">Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <table class="w-full max-w-sm border border-gray-300 text-sm mt-4 bg-white">
      <thead class="bg-[#bdd4f2] text-gray-900 text-xs">
        <tr>
          <th class="border border-gray-300 px-3 py-1 text-center" colspan="2">Ringkasan Finansial</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border border-gray-300 px-3 py-1 font-medium">Total Gaji (Status: Dibayar)</td>
          <td class="border border-gray-300 px-3 py-1">Rp. <?php echo number_format($summary_dibayar, 0, ',', '.'); ?></td>
        </tr>
        <tr>
          <td class="border border-gray-300 px-3 py-1 font-medium">Total Gaji (Status: Belum Dibayar)</td>
          <td class="border border-gray-300 px-3 py-1">Rp. <?php echo number_format($summary_belum_dibayar, 0, ',', '.'); ?></td>
        </tr>
        <tr class="bg-gray-50">
          <td class="border border-gray-300 px-3 py-1 font-bold">Total Pekerja</td>
          <td class="border border-gray-300 px-3 py-1 font-bold"><?php echo count($pekerja_list); ?> Orang</td>
        </tr>
      </tbody>
    </table>
  </section>

  <!-- MODAL AMBIL STOK PEKERJA -->
  <div id="modalAmbilStokPekerja" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <form action="" method="POST" class="bg-white p-6 shadow-md rounded w-80 relative">
      <button type="button" class="btnClose absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
      <h2 class="text-black font-semibold text-lg mb-1">Ambil Stok “Agar Pita”</h2>
      <div class="text-sm mb-3"><span id="namaPekerjaAmbil"></span></div>
      <input type="hidden" name="action" value="ambil_stok_pekerja">
      <input type="hidden" name="id_pekerja_ambil" id="id_pekerja_ambil">
      <div class="mb-3">
        <label for="id_stok_ambil" class="block text-sm font-medium text-gray-700 mb-1">Pilih Stok Siap Dikemas</label>
        <select name="id_stok_ambil" id="id_stok_ambil" class="w-full px-3 py-2 border border-gray-300 rounded" required>
          <option value="" disabled selected>-- Pilih Stok --</option>
          <?php foreach ($stok_pita_list as $stok):
            $tgl = ($stok['tgl_produksi'] && $stok['tgl_produksi'] !== '0000-00-00')
                  ? date('d-m-Y', strtotime($stok['tgl_produksi'])) : '-'; ?>
            <option value="<?php echo $stok['id_stok']; ?>"
              data-sisa="<?php echo $stok['jumlah_stok']; ?>">
              (<?= $tgl ?>) <?= $stok['nama_produk'] ?> | Sisa: <?= $stok['jumlah_stok'] ?> kg
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label>Jumlah diambil (kg)</label>
        <input type="number" min="20" name="jumlah_kg" id="jumlah_kg_ambil" class="w-full px-3 py-2 border border-gray-300 rounded" required>
        <div id="ambilStokInfo" class="text-xs text-gray-500"></div>
        <div id="ambilStokError" class="text-xs text-red-600 mt-1 hidden"></div>
      </div>
      <!-- Tanggal ambil otomatis hari ini -->
      <input type="hidden" name="tanggal_ambil" id="tanggal_ambil" value="<?= date('Y-m-d') ?>">
      <div class="mb-3 text-sm">Tanggal Ambil: <span id="showTanggalAmbil"><?= date('d-m-Y') ?></span></div>
      <div class="mb-3 text-sm">Tarif: <span class="font-mono">Rp. 2.500 / kg</span></div>
      <div class="mb-3 text-sm">Total Gaji: <span id="ambilStokTotalGaji" class="font-mono font-bold text-blue-800">Rp. 0</span></div>
      <button type="submit" class="w-full bg-yellow-600 text-white py-2 rounded">Ambil & Catat Gaji</button>
    </form>
  </div>

  <!-- MODAL TAMBAH/EDIT/HAPUS pekerja lepas ... (modal lain, seperti sebelumnya, sama) ... -->
  <div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 flex hidden items-center justify-center z-50">
    <form action="" method="POST" class="bg-white p-6 shadow-md rounded w-80 relative">
      <button type="button" class="btnClose absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
      <h2 class="text-black font-semibold text-lg mb-4">Tambah Pekerja Baru</h2>
      <input type="hidden" name="action" value="tambah_pekerja">
      <div class="mb-4"><label for="nama_pekerja_tambah" class="block text-sm font-medium text-gray-700 mb-1">Nama</label><input type="text" name="nama_pekerja" id="nama_pekerja_tambah" class="w-full px-3 py-2 border border-gray-300 rounded" required /></div>
      <div class="mb-4"><label for="kontak_tambah" class="block text-sm font-medium text-gray-700 mb-1">Kontak</label><input type="text" name="kontak" id="kontak_tambah" class="w-full px-3 py-2 border border-gray-300 rounded" required /></div>
      <div class="mb-6"><label for="alamat_tambah" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label><textarea name="alamat" id="alamat_tambah" class="w-full px-3 py-2 border border-gray-300 rounded" required></textarea></div>
      <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded">Simpan</button>
    </form>
  </div>
  <div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 flex hidden items-center justify-center z-50">
    <form action="" method="POST" class="bg-white p-6 shadow-md rounded w-80 relative">
      <button type="button" class="btnClose absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
      <h2 class="text-black font-semibold text-lg mb-4">Edit Data Pekerja</h2>
      <input type="hidden" name="action" value="edit_pekerja"><input type="hidden" name="id_pekerja_edit" id="id_pekerja_edit">
      <div class="mb-4"><label for="nama_pekerja_edit" class="block text-sm font-medium text-gray-700 mb-1">Nama</label><input type="text" name="nama_pekerja" id="nama_pekerja_edit" class="w-full px-3 py-2 border border-gray-300 rounded" required /></div>
      <div class="mb-4"><label for="kontak_edit" class="block text-sm font-medium text-gray-700 mb-1">Kontak</label><input type="text" name="kontak" id="kontak_edit" class="w-full px-3 py-2 border border-gray-300 rounded" required /></div>
      <div class="mb-6"><label for="alamat_edit" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label><textarea name="alamat" id="alamat_edit" class="w-full px-3 py-2 border border-gray-300 rounded" required></textarea></div>
      <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded">Simpan Perubahan</button>
    </form>
  </div>
  <div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-50 flex hidden items-center justify-center z-50">
    <div class="w-[320px] border p-6 bg-white rounded-md relative">
      <button type="button" class="btnClose absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
      <h2 class="font-semibold text-black mb-3 text-lg">Konfirmasi Hapus</h2>
      <p class="text-gray-700 mb-5 text-sm">Data pekerja dan seluruh riwayat gajinya akan dihapus permanen.</p>
      <form action="" method="POST" class="flex justify-end space-x-3">
        <input type="hidden" name="action" value="hapus_pekerja"><input type="hidden" name="id_pekerja_hapus" id="id_pekerja_hapus">
        <button type="button" class="btnCancelHapus border border-gray-400 text-black text-sm font-medium rounded px-4 py-2 hover:bg-gray-100">Batal</button>
        <button type="submit" class="bg-red-600 text-white text-sm font-medium rounded px-4 py-2 hover:bg-red-700">Ya, Hapus</button>
      </form>
    </div>
  </div>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Modal management
    const modals = {
      tambah: document.getElementById('modalTambah'),
      edit: document.getElementById('modalEdit'),
      hapus: document.getElementById('modalHapus'),
      ambilStok: document.getElementById('modalAmbilStokPekerja'),
    };
    const openModal = (modal) => { if (modal) modal.classList.remove('hidden'); };
    const closeModal = (modal) => { if (modal) modal.classList.add('hidden'); };
    document.getElementById('btnTambahPekerja')?.addEventListener('click', () => openModal(modals.tambah));
    modals.hapus?.querySelector('.btnCancelHapus')?.addEventListener('click', () => closeModal(modals.hapus));
    Object.values(modals).forEach(modal => {
      if (!modal) return;
      modal.querySelector('.btnClose')?.addEventListener('click', () => closeModal(modal));
      modal.addEventListener('click', e => { if (e.target === modal) closeModal(modal); });
    });

    // Ambil Stok Modal (pekerja lepas)
    document.querySelectorAll('.btnAmbilStok').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = btn.dataset.idPekerja;
        const nama = btn.dataset.namaPekerja;
        document.getElementById('id_pekerja_ambil').value = id;
        document.getElementById('namaPekerjaAmbil').textContent = 'Pekerja: ' + nama;
        // Set tanggal ambil otomatis hari ini
        var now = new Date();
        var tglVal = now.toISOString().slice(0,10);
        document.getElementById('tanggal_ambil').value = tglVal;
        document.getElementById('showTanggalAmbil').textContent =
          now.toLocaleDateString('id-ID');
        openModal(modals.ambilStok);
      });
    });

    // Validasi dan info stok pada modal ambil stok pekerja
    var stokSelect = document.getElementById('id_stok_ambil');
    var jumlahInput = document.getElementById('jumlah_kg_ambil');
    var info = document.getElementById('ambilStokInfo');
    var error = document.getElementById('ambilStokError');
    var totalGaji = document.getElementById('ambilStokTotalGaji');
    stokSelect.addEventListener('change', function(e) {
      var sisa = stokSelect.selectedOptions[0]?.dataset.sisa || 0;
      info.textContent = 'Sisa stok: ' + sisa + ' kg (Minimal ambil 20 kg)';
      jumlahInput.max = sisa;
      jumlahInput.value = '';
      error.classList.add('hidden');
      totalGaji.textContent = 'Rp. 0';
    });
    jumlahInput.addEventListener('input', function() {
      var max = parseInt(jumlahInput.max) || 0;
      var val = parseInt(jumlahInput.value) || 0;
      if (val > max) {
        error.textContent = 'Tidak boleh melebihi stok tersedia!';
        error.classList.remove('hidden');
      } else if (val > 0) {
        error.classList.add('hidden');
        totalGaji.textContent = 'Rp. ' + (val * 2500).toLocaleString('id-ID');
      }
    });

    // Edit & Hapus (sama seperti modal sebelumnya)
    document.body.addEventListener('click', function(e) {
      const target = e.target.closest('button, a');
      if (!target) return;
      const data = target.dataset;
      if (target.classList.contains('btnEdit')) {
        e.preventDefault();
        document.getElementById('id_pekerja_edit').value = data.idPekerja;
        document.getElementById('nama_pekerja_edit').value = data.nama;
        document.getElementById('kontak_edit').value = data.kontak;
        document.getElementById('alamat_edit').value = data.alamat;
        openModal(modals.edit);
      } else if (target.classList.contains('btnHapus')) {
        e.preventDefault();
        document.getElementById('id_pekerja_hapus').value = data.idPekerja;
        openModal(modals.hapus);
      }
    });
  });
</script>
