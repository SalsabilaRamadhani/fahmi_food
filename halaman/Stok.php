<?php
// =================================================================
// BAGIAN LOGIKA & KONEKSI DATABASE (PHP)
// =================================================================

// Cek jika sesi belum aktif, maka mulai sesi
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include 'auth.php'; // Otentikasi Anda
include 'koneksi.php'; // Koneksi ke database

// Cek jika skrip diakses langsung
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
  header("Location: ../Index.php?page=stok");
  exit;
}

// Logika untuk menangani form (Create, Update, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  $id_admin = 1; // Diasumsikan ID admin adalah 1 dari sesi

  try {
    switch ($action) {
      // ============== CREATE ==============
      case 'tambah':
        $id_produk = $_POST['id_produk'];
        $status_stok = $_POST['status_stok'];
        $jumlah = $_POST['jumlah'];

        $sql = "INSERT INTO stok (id_produk, status_stok, jumlah, id_admin) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_produk, $status_stok, $jumlah, $id_admin]);
        $_SESSION['notif'] = ['pesan' => 'Data stok berhasil ditambahkan!', 'tipe' => 'sukses'];
        break;

      // ============== UPDATE ==============
      case 'edit':
        $id_stok = $_POST['id_stok_edit'];
        $status_stok = $_POST['status_stok'];
        $jumlah = $_POST['jumlah'];

        // Produk (id_produk) tidak diubah saat edit untuk menjaga integritas
        $sql = "UPDATE stok SET status_stok = ?, jumlah = ? WHERE id_stok = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$status_stok, $jumlah, $id_stok]);
        $_SESSION['notif'] = ['pesan' => 'Data stok berhasil diperbarui!', 'tipe' => 'sukses'];
        break;

      // ============== DELETE ==============
      case 'hapus':
        $id_stok = $_POST['id_stok_hapus'];
        $sql = "DELETE FROM stok WHERE id_stok = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_stok]);
        $_SESSION['notif'] = ['pesan' => 'Data stok berhasil dihapus.', 'tipe' => 'sukses'];
        break;
    }
  } catch (PDOException $e) {
    $_SESSION['notif'] = ['pesan' => 'Terjadi kesalahan database: ' . $e->getMessage(), 'tipe' => 'error'];
  }
  // Redirect kembali ke halaman stok
  header("Location: Index.php?page=stok");
  exit;
}

// =================================================================
// PENGAMBILAN DATA DARI DATABASE (READ)
// =================================================================

// Ambil semua data stok dengan join ke tabel produk
$sql_stok = "SELECT s.id_stok, s.id_produk, p.nama_produk, s.status_stok, s.jumlah
             FROM stok s 
             JOIN produk p ON s.id_produk = p.id_produk 
             ORDER BY s.id_stok DESC";
$stok_list = $pdo->query($sql_stok)->fetchAll(PDO::FETCH_ASSOC);

// Ambil semua produk untuk opsi di form tambah
$produk_options = $pdo->query("SELECT id_produk, nama_produk FROM produk ORDER BY nama_produk ASC")->fetchAll(PDO::FETCH_ASSOC);

// Ambil ringkasan total stok per status
$stok_summary = $pdo->query("SELECT status_stok, SUM(jumlah) as total_jumlah 
                             FROM stok 
                             GROUP BY status_stok")->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="flex-1 bg-gray-100">
  <section class="p-6 overflow-x-auto">
    <?php if (isset($_SESSION['notif'])): ?>
      <div class="mb-4 p-4 rounded-md text-white font-bold <?php echo $_SESSION['notif']['tipe'] === 'sukses' ? 'bg-green-500' : 'bg-red-500'; ?>">
        <?php echo htmlspecialchars($_SESSION['notif']['pesan']); ?>
      </div>
    <?php unset($_SESSION['notif']);
    endif; ?>

    <button id="btnTambahStok" class="mb-4 inline-flex items-center gap-2 bg-blue-700 text-white text-sm font-normal px-4 py-2 rounded" type="button">
      <i class="fas fa-plus"></i> Tambah Stok
    </button>

    <table class="w-full border border-gray-300 text-sm bg-white">
      <thead>
        <tr class="bg-blue-200 text-black text-left">
          <th class="border border-gray-300 px-3 py-2">No.</th>
          <th class="border border-gray-300 px-3 py-2">ID Produk</th>
          <th class="border border-gray-300 px-3 py-2">Nama Produk</th>
          <th class="border border-gray-300 px-3 py-2">Status Stok</th>
          <th class="border border-gray-300 px-3 py-2">Jumlah Stok</th>
          <th class="border border-gray-300 px-3 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-left">
        <?php if (empty($stok_list)): ?>
          <tr>
            <td colspan="6" class="border border-gray-300 px-3 py-4 text-center text-gray-500">
              Belum ada data stok.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($stok_list as $index => $item): ?>
            <tr>
              <td class="border border-gray-300 px-3 py-2"><?php echo $index + 1; ?>.</td>
              <td class="border border-gray-300 px-3 py-2"><?php echo htmlspecialchars($item['id_produk']); ?></td>
              <td class="border border-gray-300 px-3 py-2"><?php echo htmlspecialchars($item['nama_produk']); ?></td>
              <td class="border border-gray-300 px-3 py-2"><?php echo htmlspecialchars($item['status_stok']); ?></td>
              <td class="border border-gray-300 px-3 py-2"><?php echo htmlspecialchars($item['jumlah']); ?> kg</td>
              <td class="border border-gray-300 px-3 py-2 space-x-2">
                <button class="btnEdit bg-blue-700 text-white text-xs px-3 py-1 rounded"
                  data-id-stok="<?php echo $item['id_stok']; ?>"
                  data-id-produk="<?php echo $item['id_produk']; ?>"
                  data-nama-produk="<?php echo htmlspecialchars($item['nama_produk']); ?>"
                  data-status="<?php echo htmlspecialchars($item['status_stok']); ?>"
                  data-jumlah="<?php echo $item['jumlah']; ?>">Edit</button>
                <button class="btnHapus bg-red-700 text-white text-xs px-3 py-1 rounded"
                  data-id-stok="<?php echo $item['id_stok']; ?>">Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="mt-8">
      <h3 class="text-lg font-semibold mb-2 text-gray-700">Ringkasan Stok</h3>
      <table class="w-full max-w-md border border-gray-300 text-sm bg-white">
        <thead>
          <tr class="bg-blue-200 text-black text-left">
            <th class="border border-gray-300 px-3 py-2 w-12">No.</th>
            <th class="border border-gray-300 px-3 py-2">Status Stok</th>
            <th class="border border-gray-300 px-3 py-2">Total Jumlah Stok (kg)</th>
          </tr>
        </thead>
        <tbody class="text-left">
          <?php if (empty($stok_summary)): ?>
            <tr>
              <td colspan="3" class="border border-gray-300 px-3 py-4 text-center text-gray-500">Data ringkasan kosong.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($stok_summary as $index => $summary): ?>
              <tr>
                <td class="border border-gray-300 px-3 py-2"><?php echo $index + 1; ?>.</td>
                <td class="border border-gray-300 px-3 py-2"><?php echo htmlspecialchars($summary['status_stok']); ?></td>
                <td class="border border-gray-300 px-3 py-2"><?php echo htmlspecialchars($summary['total_jumlah']); ?> kg</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>

  <div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <form action="" method="POST" class="bg-white p-6 shadow-md rounded w-80 relative">
      <button type="button" class="btnClose absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold" aria-label="Close modal">&times;</button>
      <h2 class="text-black font-semibold text-lg mb-4">Tambah Stok</h2>
      <input type="hidden" name="action" value="tambah">

      <div class="mb-4">
        <label for="id_produk_tambah" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
        <select name="id_produk" id="id_produk_tambah" class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
          <option value="" disabled selected>-- Pilih Produk --</option>
          <?php foreach ($produk_options as $option): ?>
            <option value="<?php echo $option['id_produk']; ?>"><?php echo htmlspecialchars($option['nama_produk']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-4">
        <label for="status_stok_tambah" class="block text-sm font-medium text-gray-700 mb-1">Status Stok</label>
        <select name="status_stok" id="status_stok_tambah" class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
          <option value="" disabled selected>-- Pilih Status --</option>
          <option value="Siap dikemas">Siap dikemas</option>
          <option value="Siap dipacking">Siap dipacking</option>
          <option value="Sudah dipacking">Sudah dipacking</option>
          <option value="Reject">Reject</option>
        </select>
      </div>

      <div class="mb-6">
        <label for="jumlah_tambah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah (kg)</label>
        <input type="number" name="jumlah" id="jumlah_tambah" min="0" placeholder="Masukkan jumlah" class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required />
      </div>

      <button type="submit" name="submit" class="w-full bg-blue-700 text-white py-2 rounded">Simpan</button>
    </form>
  </div>

  <div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <form action="" method="POST" class="bg-white p-6 shadow-md rounded w-80 relative">
      <button type="button" class="btnClose absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold" aria-label="Close modal">&times;</button>
      <h2 class="text-black font-semibold text-lg mb-4">Edit Stok</h2>
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="id_stok_edit" id="id_stok_edit">

      <div class="mb-4">
        <label for="nama_produk_edit" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
        <input type="text" id="nama_produk_edit" class="w-full px-3 py-2 border bg-gray-200 text-gray-500 rounded" readonly />
      </div>

      <div class="mb-4">
        <label for="status_stok_edit" class="block text-sm font-medium text-gray-700 mb-1">Status Stok</label>
        <select name="status_stok" id="status_stok_edit" class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required>
          <option value="Siap dikemas">Siap dikemas</option>
          <option value="Siap dipacking">Siap dipacking</option>
          <option value="Sudah dipacking">Sudah dipacking</option>
          <option value="Reject">Reject</option>
        </select>
      </div>

      <div class="mb-6">
        <label for="jumlah_edit" class="block text-sm font-medium text-gray-700 mb-1">Jumlah (kg)</label>
        <input type="number" name="jumlah" id="jumlah_edit" min="0" class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm" required />
      </div>

      <button type="submit" name="submit" class="w-full bg-blue-700 text-white py-2 rounded">Simpan Perubahan</button>
    </form>
  </div>

  <div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="w-[320px] border border-gray-300 shadow-md p-6 bg-white rounded-md relative">
      <button type="button" class="btnClose absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold" aria-label="Close modal">&times;</button>
      <h2 class="font-semibold text-black mb-3 text-lg">Konfirmasi Hapus</h2>
      <p class="text-gray-700 mb-5 text-sm leading-relaxed">Apakah Anda yakin akan menghapus data stok ini?</p>
      <form action="" method="POST" class="flex justify-end space-x-3">
        <input type="hidden" name="action" value="hapus">
        <input type="hidden" name="id_stok_hapus" id="id_stok_hapus">
        <button type="button" class="btnCancelHapus border border-gray-400 text-black text-sm font-medium rounded px-4 py-2 hover:bg-gray-100">Batal</button>
        <button type="submit" class="bg-red-600 text-white text-sm font-medium rounded px-4 py-2 hover:bg-red-700">Ya, Hapus</button>
      </form>
    </div>
  </div>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // --- Elemen Modal ---
    const modalTambah = document.getElementById('modalTambah');
    const modalEdit = document.getElementById('modalEdit');
    const modalHapus = document.getElementById('modalHapus');

    // --- Tombol ---
    const btnTambahStok = document.getElementById('btnTambahStok');
    const btnCancelHapus = document.querySelector('.btnCancelHapus');

    const allModals = [modalTambah, modalEdit, modalHapus];

    // --- Fungsi Buka/Tutup Modal ---
    const openModal = (modal) => modal.classList.remove('hidden');
    const closeModal = (modal) => modal.classList.add('hidden');

    // --- Event Listeners ---
    btnTambahStok.addEventListener('click', () => openModal(modalTambah));
    btnCancelHapus.addEventListener('click', () => closeModal(modalHapus));

    // Event listener untuk semua tombol close (x) dan klik di luar modal
    allModals.forEach(modal => {
      modal.querySelector('.btnClose').addEventListener('click', () => closeModal(modal));
      modal.addEventListener('click', e => {
        if (e.target === modal) closeModal(modal);
      });
    });

    // Event untuk tombol edit
    document.querySelectorAll('.btnEdit').forEach(button => {
      button.addEventListener('click', (e) => {
        const data = e.target.dataset;
        document.getElementById('id_stok_edit').value = data.idStok;
        document.getElementById('nama_produk_edit').value = `${data.namaProduk} (ID: ${data.idProduk})`;
        document.getElementById('status_stok_edit').value = data.status;
        document.getElementById('jumlah_edit').value = data.jumlah;
        openModal(modalEdit);
      });
    });

    // Event untuk tombol hapus
    document.querySelectorAll('.btnHapus').forEach(button => {
      button.addEventListener('click', (e) => {
        const idStok = e.target.dataset.idStok;
        document.getElementById('id_stok_hapus').value = idStok;
        openModal(modalHapus);
      });
    });
  });
</script>