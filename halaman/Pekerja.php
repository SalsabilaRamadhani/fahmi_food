<?php
// =================================================================
// BAGIAN LOGIKA & KONEKSI DATABASE (PHP)
// =================================================================

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include 'auth.php';
include 'koneksi.php';
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
  header("Location: ../Index.php?page=pekerja");
  exit;
}

// --- FUNGSI HELPER UNTUK UPDATE STATUS PEKERJA SECARA OTOMATIS ---
function updateStatusPekerja($pdo, $id_pekerja)
{
  // Cek apakah masih ada riwayat gaji yang belum dibayar untuk pekerja ini
  $sql_check = "SELECT COUNT(*) FROM riwayat_gaji WHERE id_pekerja = ? AND keterangan = 'Belum Dibayar'";
  $stmt_check = $pdo->prepare($sql_check);
  $stmt_check->execute([$id_pekerja]);
  $belum_dibayar_count = $stmt_check->fetchColumn();

  // Tentukan status baru
  $new_status = ($belum_dibayar_count == 0) ? 'Dibayar' : 'Belum Dibayar';

  // Update status di tabel pekerja_lepas
  $sql_update = "UPDATE pekerja_lepas SET status_pembayaran = ? WHERE id_pekerja = ?";
  $stmt_update = $pdo->prepare($sql_update);
  $stmt_update->execute([$new_status, $id_pekerja]);
}

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
        // --- [UBAH] --- Status pembayaran tidak lagi di-edit secara manual di sini
        $sql = "UPDATE pekerja_lepas SET nama_pekerja = ?, kontak = ?, alamat = ? WHERE id_pekerja = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['nama_pekerja'], $_POST['kontak'], $_POST['alamat'], $_POST['id_pekerja_edit']]);
        $_SESSION['notif'] = ['pesan' => 'Data pekerja berhasil diperbarui!', 'tipe' => 'sukses'];
        break;

      case 'tambah_gaji_riwayat':
        $pdo->beginTransaction();
        try {
          $id_pekerja_gaji = $_POST['id_pekerja_gaji'];
          $sql_insert = "INSERT INTO riwayat_gaji (id_pekerja, tanggal, berat_barang_kg, tarif_per_kg, total_gaji, keterangan) VALUES (?, ?, ?, ?, ?, ?)";
          $stmt_insert = $pdo->prepare($sql_insert);
          $stmt_insert->execute([$id_pekerja_gaji, $_POST['tanggal'], $_POST['berat_barang_kg'], $_POST['tarif_per_kg'], $_POST['total_gaji'], $_POST['keterangan']]);

          // --- [UBAH] --- Panggil fungsi helper untuk update status
          updateStatusPekerja($pdo, $id_pekerja_gaji);

          $pdo->commit();
          $_SESSION['notif'] = ['pesan' => 'Riwayat gaji berhasil ditambahkan!', 'tipe' => 'sukses'];
        } catch (Exception $e) {
          $pdo->rollBack();
          $_SESSION['notif'] = ['pesan' => 'Gagal menyimpan data: ' . $e->getMessage(), 'tipe' => 'error'];
        }
        break;

      case 'hapus_pekerja':
        $sql = "DELETE FROM pekerja_lepas WHERE id_pekerja = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['id_pekerja_hapus']]);
        $_SESSION['notif'] = ['pesan' => 'Data pekerja berhasil dihapus.', 'tipe' => 'sukses'];
        break;
    }
  } catch (PDOException $e) {
    $_SESSION['notif'] = ['pesan' => 'Terjadi kesalahan database: ' . $e->getMessage(), 'tipe' => 'error'];
  }

  $search_query = isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '';
  header("Location: Index.php?page=pekerja" . $search_query);
  exit;
}

// =================================================================
// PENGAMBILAN DATA DARI DATABASE (READ)
// =================================================================

$search_term = $_GET['search'] ?? '';
// --- [UBAH TOTAL] --- Query untuk mendapatkan total dibayar dan belum dibayar per pekerja
$sql_pekerja = "SELECT 
                    pl.*, 
                    (SELECT SUM(rg.total_gaji) FROM riwayat_gaji rg WHERE rg.id_pekerja = pl.id_pekerja AND rg.keterangan = 'Dibayar') as total_dibayar,
                    (SELECT SUM(rg.total_gaji) FROM riwayat_gaji rg WHERE rg.id_pekerja = pl.id_pekerja AND rg.keterangan = 'Belum Dibayar') as total_belum_dibayar
                FROM 
                    pekerja_lepas pl";
$params = [];
if (!empty($search_term)) {
  $sql_pekerja .= " WHERE pl.nama_pekerja LIKE ?";
  $params[] = "%" . $search_term . "%";
}
$sql_pekerja .= " ORDER BY pl.nama_pekerja ASC";
$stmt = $pdo->prepare($sql_pekerja);
$stmt->execute($params);
$pekerja_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- [UBAH TOTAL] --- Menghitung ringkasan total dari tabel riwayat_gaji
$sql_summary = "SELECT keterangan, SUM(total_gaji) as total_per_keterangan FROM riwayat_gaji GROUP BY keterangan";
$summary_list = $pdo->query($sql_summary)->fetchAll(PDO::FETCH_KEY_PAIR);
$summary_dibayar = $summary_list['Dibayar'] ?? 0;
$summary_belum_dibayar = $summary_list['Belum Dibayar'] ?? 0;
?>

<main class="flex-1 bg-gray-100">
  <section class="p-6 overflow-x-auto">
    <?php if (isset($_SESSION['notif'])): ?>
      <div class="mb-4 p-4 rounded-md text-white font-bold <?php echo $_SESSION['notif']['tipe'] === 'sukses' ? 'bg-green-500' : 'bg-red-500'; ?>"><?php echo htmlspecialchars($_SESSION['notif']['pesan']); ?></div>
    <?php unset($_SESSION['notif']);
    endif; ?>

    <div class="flex flex-col md:flex-row md:items-center md:space-x-4 mb-4">
      <button id="btnTambahPekerja" class="flex-shrink-0 inline-flex items-center gap-2 bg-[#2f4ea1] text-white text-sm font-normal px-4 py-2 rounded shadow-sm hover:shadow-md transition-shadow mb-2 md:mb-0" type="button"><i class="fas fa-plus"></i> Tambah Pekerja</button>
      <form action="Index.php" method="GET" class="flex flex-1 max-w-md">
        <input type="hidden" name="page" value="pekerja"><input type="text" name="search" placeholder="Cari nama pekerja..." class="flex-grow border border-gray-300 rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#2f4ea1]" value="<?php echo htmlspecialchars($search_term); ?>"><button type="submit" class="bg-[#2f4ea1] text-white px-6 py-2 rounded-r shadow-sm hover:shadow-md transition-shadow">Cari</button>
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
          <th class="border border-gray-300 px-3 py-2 w-40">Status Pekerja</th>
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
                <a href="Index.php?page=riwayat_gaji&id_pekerja=<?php echo $pekerja['id_pekerja']; ?>" class="btnHistory bg-gray-500 text-white text-xs px-3 py-1 rounded inline-block">Riwayat</a>
                <button class="btnGaji bg-green-600 text-white text-xs px-2 py-1 rounded inline-flex items-center gap-1" data-id-pekerja="<?php echo $pekerja['id_pekerja']; ?>" data-nama-pekerja="<?php echo htmlspecialchars($pekerja['nama_pekerja']); ?>"><i class="fas fa-plus"></i> Gaji</button>
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

  <div id="modalGaji" class="fixed inset-0 bg-black bg-opacity-50 flex hidden items-center justify-center z-50">
    <form action="" method="POST" class="bg-white p-6 shadow-md rounded w-80 relative">
      <button type="button" class="btnClose absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
      <h2 class="text-black font-semibold text-lg mb-1">Tambah Gaji</h2>
      <p class="text-sm text-gray-600 mb-4" id="namaPekerjaGaji"></p>
      <input type="hidden" name="action" value="tambah_gaji_riwayat"><input type="hidden" name="id_pekerja_gaji" id="id_pekerja_gaji"><input type="hidden" name="tarif_per_kg" id="tarif_per_kg" value="2500"><input type="hidden" name="total_gaji" id="total_gaji_hidden">
      <div class="mb-4"><label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label><input type="date" name="tanggal" id="tanggal" class="w-full px-3 py-2 border border-gray-300 rounded" required /></div>
      <div class="mb-4"><label for="berat_barang_kg" class="block text-sm font-medium text-gray-700 mb-1">Berat (Kg)</label><input type="number" step="0.1" name="berat_barang_kg" id="berat_barang_kg" placeholder="e.g., 10.5" class="w-full px-3 py-2 border border-gray-300 rounded" required /></div>
      <div class="mb-2 text-sm">Tarif per Kg: <span class="font-mono">Rp. 2.500</span></div>
      <div class="mb-4 text-sm">Total Gaji: <span class="font-mono font-bold" id="total_gaji_display">Rp. 0</span></div>
      <div class="mb-6"><label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan Pembayaran</label><select name="keterangan" id="keterangan" class="w-full px-3 py-2 border border-gray-300 rounded">
          <option value="Dibayar">Dibayar</option>
          <option value="Belum Dibayar">Belum Dibayar</option>
        </select></div>
      <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded">Simpan</button>
    </form>
  </div>

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
    const modals = {
      tambah: document.getElementById('modalTambah'),
      edit: document.getElementById('modalEdit'),
      hapus: document.getElementById('modalHapus'),
      gaji: document.getElementById('modalGaji'),
    };
    const openModal = (modal) => {
      if (modal) modal.classList.remove('hidden');
    };
    const closeModal = (modal) => {
      if (modal) {
        modal.classList.add('hidden');
        if (modal.id === 'modalGaji') {
          modal.querySelector('form').reset();
          document.getElementById('total_gaji_display').textContent = 'Rp. 0';
        }
      }
    };
    document.getElementById('btnTambahPekerja')?.addEventListener('click', () => openModal(modals.tambah));
    modals.hapus?.querySelector('.btnCancelHapus')?.addEventListener('click', () => closeModal(modals.hapus));
    Object.values(modals).forEach(modal => {
      if (!modal) return;
      modal.querySelector('.btnClose')?.addEventListener('click', () => closeModal(modal));
      modal.addEventListener('click', e => {
        if (e.target === modal) closeModal(modal);
      });
    });
    const modalGajiForm = document.getElementById('modalGaji');
    if (modalGajiForm) {
      const beratInput = modalGajiForm.querySelector('#berat_barang_kg');
      const tarifInput = modalGajiForm.querySelector('#tarif_per_kg');
      const totalGajiDisplay = modalGajiForm.querySelector('#total_gaji_display');
      const totalGajiHidden = modalGajiForm.querySelector('#total_gaji_hidden');
      beratInput.addEventListener('input', () => {
        const berat = parseFloat(beratInput.value) || 0;
        const tarif = parseInt(tarifInput.value) || 0;
        const total = Math.round(berat * tarif);
        totalGajiHidden.value = total;
        totalGajiDisplay.textContent = 'Rp. ' + total.toLocaleString('id-ID');
      });
    }
    document.body.addEventListener('click', function(e) {
      const target = e.target.closest('button, a');
      if (!target) return;
      const data = target.dataset;
      if (target.classList.contains('btnGaji')) {
        e.preventDefault();
        document.getElementById('id_pekerja_gaji').value = data.idPekerja;
        document.getElementById('namaPekerjaGaji').textContent = `Untuk: ${data.namaPekerja}`;
        openModal(modals.gaji);
      } else if (target.classList.contains('btnEdit')) {
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