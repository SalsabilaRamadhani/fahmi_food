<?php
// =================================================================
// BAGIAN LOGIKA & KONEKSI DATABASE (PHP)
// =================================================================

// Cek jika sesi belum aktif, maka mulai sesi
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include 'auth.php'; // Otentikasi
include 'koneksi.php'; // Koneksi ke database

// Cek jika skrip diakses langsung
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
  header("Location: ../Index.php?page=produksi");
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
        $tgl_produksi = $_POST['tanggal_produksi'];
        $jumlah_produksi = (int)$_POST['jumlah_produksi'];
        $jumlah_dikemas = (int)$_POST['jumlah_dikemas'];
        $jumlah_reject = (int)$_POST['jumlah_reject'];

        // === VALIDASI BACKEND ===
        if (($jumlah_dikemas + $jumlah_reject) > $jumlah_produksi) {
          $_SESSION['notif'] = [
            'pesan' => 'GAGAL: Total jumlah dikemas dan reject tidak boleh melebihi jumlah produksi.',
            'tipe' => 'error'
          ];
        } else {
          // Jika valid, lanjutkan simpan ke database
          $sql = "INSERT INTO produksi (id_produk, tgl_produksi, jumlah_produksi, jumlah_dikemas, jumlah_reject, id_admin) VALUES (?, ?, ?, ?, ?, ?)";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$id_produk, $tgl_produksi, $jumlah_produksi, $jumlah_dikemas, $jumlah_reject, $id_admin]);
          $_SESSION['notif'] = ['pesan' => 'Data produksi berhasil ditambahkan!', 'tipe' => 'sukses'];
        }
        break;

      // ============== UPDATE ==============
      case 'edit':
        $id_produksi = $_POST['id_produksi_edit'];
        $tgl_produksi = $_POST['tanggal_produksi'];
        $jumlah_produksi = (int)$_POST['jumlah_produksi'];
        $jumlah_dikemas = (int)$_POST['jumlah_dikemas'];
        $jumlah_reject = (int)$_POST['jumlah_reject'];

        // === VALIDASI BACKEND ===
        if (($jumlah_dikemas + $jumlah_reject) > $jumlah_produksi) {
          $_SESSION['notif'] = [
            'pesan' => 'GAGAL: Total jumlah dikemas dan reject tidak boleh melebihi jumlah produksi.',
            'tipe' => 'error'
          ];
        } else {
          // Jika valid, lanjutkan update
          $sql = "UPDATE produksi SET tgl_produksi = ?, jumlah_produksi = ?, jumlah_dikemas = ?, jumlah_reject = ? WHERE id_produksi = ?";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$tgl_produksi, $jumlah_produksi, $jumlah_dikemas, $jumlah_reject, $id_produksi]);
          $_SESSION['notif'] = ['pesan' => 'Data produksi berhasil diperbarui!', 'tipe' => 'sukses'];
        }
        break;

      // ============== DELETE ==============
      case 'hapus':
        $id_produksi = $_POST['id_produksi_hapus'];
        $sql = "DELETE FROM produksi WHERE id_produksi = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_produksi]);
        $_SESSION['notif'] = ['pesan' => 'Data produksi berhasil dihapus.', 'tipe' => 'sukses'];
        break;
    }
  } catch (PDOException $e) {
    $_SESSION['notif'] = ['pesan' => 'Terjadi kesalahan database: ' . $e->getMessage(), 'tipe' => 'error'];
  }
  // Redirect kembali ke halaman produksi untuk menampilkan data terbaru & notifikasi
  header("Location: Index.php?page=produksi");
  exit;
}

// =================================================================
// PENGAMBILAN DATA DARI DATABASE (READ)
// =================================================================

// Ambil semua data produksi dengan join ke tabel produk untuk mendapatkan nama produk
$sql_produksi = "SELECT prod.*, p.nama_produk 
                 FROM produksi prod 
                 JOIN produk p ON prod.id_produk = p.id_produk 
                 ORDER BY prod.tgl_produksi DESC";
$produksi_list = $pdo->query($sql_produksi)->fetchAll(PDO::FETCH_ASSOC);

// Ambil semua produk untuk opsi di form tambah
$produk_options = $pdo->query("SELECT id_produk, nama_produk FROM produk ORDER BY nama_produk ASC")->fetchAll(PDO::FETCH_ASSOC);

// Hitung total jumlah langsung dari database
$totals = $pdo->query("SELECT 
                        SUM(jumlah_produksi) as total_produksi,
                        SUM(jumlah_dikemas) as total_dikemas,
                        SUM(jumlah_reject) as total_reject
                      FROM produksi")->fetch(PDO::FETCH_ASSOC);

$total_produksi = $totals['total_produksi'] ?? 0;
$total_dikemas = $totals['total_dikemas'] ?? 0;
$total_reject = $totals['total_reject'] ?? 0;

?>

<main class="flex-1 bg-gray-100">
  <section class="p-6 overflow-x-auto space-y-6">

    <?php if (isset($_SESSION['notif'])): ?>
      <div class="mb-4 p-4 rounded-md text-white font-bold <?php echo $_SESSION['notif']['tipe'] === 'sukses' ? 'bg-green-500' : 'bg-red-500'; ?>">
        <?php echo htmlspecialchars($_SESSION['notif']['pesan']); ?>
      </div>
    <?php unset($_SESSION['notif']);
    endif; ?>

    <button id="btnTambahProduk" type="button" class="inline-flex items-center gap-2 rounded-md bg-[#3249b3] px-4 py-2 text-white text-sm font-normal hover:bg-[#2a3b8a] transition-colors">
      <i class="fas fa-plus"></i> Tambah Produk
    </button>

    <table class="w-full border border-gray-300 text-sm border-collapse bg-white">
      <thead>
        <tr class="bg-[#c3d1f0] text-center text-xs font-normal text-black">
          <th class="border border-gray-300 px-2 py-1 w-12">No.</th>
          <th class="border border-gray-300 px-2 py-1 w-20">ID Produk</th>
          <th class="border border-gray-300 px-2 py-1 w-48">Nama Produk</th>
          <th class="border border-gray-300 px-2 py-1 w-32">Tanggal Produksi</th>
          <th class="border border-gray-300 px-2 py-1 w-28">Jumlah Produksi</th>
          <th class="border border-gray-300 px-2 py-1 w-28">Jumlah Dikemas</th>
          <th class="border border-gray-300 px-2 py-1 w-28">Jumlah Reject</th>
          <th class="border border-gray-300 px-2 py-1 w-24">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-center text-xs text-black">
        <?php if (empty($produksi_list)): ?>
          <tr>
            <td colspan="8" class="border border-gray-300 px-2 py-4 text-center text-gray-500">
              Belum ada data produksi. Silakan tambahkan.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($produksi_list as $index => $item): ?>
            <tr>
              <td class="border border-gray-300 px-2 py-1 text-left pl-3"><?php echo $index + 1; ?>.</td>
              <td class="border border-gray-300 px-2 py-1"><?php echo htmlspecialchars($item["id_produk"]); ?></td>
              <td class="border border-gray-300 px-2 py-1 text-left pl-3"><?php echo htmlspecialchars($item["nama_produk"]); ?></td>
              <td class="border border-gray-300 px-2 py-1"><?php echo htmlspecialchars(date('d-m-Y', strtotime($item["tgl_produksi"]))); ?></td>
              <td class="border border-gray-300 px-2 py-1"><?php echo htmlspecialchars($item["jumlah_produksi"]); ?> kg</td>
              <td class="border border-gray-300 px-2 py-1"><?php echo htmlspecialchars($item["jumlah_dikemas"]); ?> kg</td>
              <td class="border border-gray-300 px-2 py-1"><?php echo htmlspecialchars($item["jumlah_reject"]); ?> kg</td>
              <td class="border border-gray-300 px-2 py-1 space-x-1">
                <button type="button" class="btnEdit bg-[#3249b3] text-white text-xs px-3 py-0.5 rounded hover:bg-[#2a3b8a] transition-colors"
                  data-id-produksi="<?php echo $item['id_produksi']; ?>"
                  data-id-produk="<?php echo $item['id_produk']; ?>"
                  data-nama-produk="<?php echo htmlspecialchars($item['nama_produk']); ?>"
                  data-tgl="<?php echo $item['tgl_produksi']; ?>"
                  data-jml-produksi="<?php echo $item['jumlah_produksi']; ?>"
                  data-jml-dikemas="<?php echo $item['jumlah_dikemas']; ?>"
                  data-jml-reject="<?php echo $item['jumlah_reject']; ?>">Edit</button>
                <button type="button" class="btnHapus bg-red-700 text-white text-xs px-3 py-0.5 rounded hover:bg-red-800 transition-colors"
                  data-id-produksi="<?php echo $item['id_produksi']; ?>">Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <table class="w-full max-w-xs border border-gray-300 border-collapse text-xs text-black bg-white">
      <thead>
        <tr class="bg-[#c6d3f2] text-center font-normal">
          <th class="border border-gray-300 px-2 py-1" colspan="2">Jumlah</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border border-gray-300 px-2 py-1 font-medium">Total Produksi</td>
          <td class="border border-gray-300 px-2 py-1 text-center"><?php echo $total_produksi; ?> kg</td>
        </tr>
        <tr>
          <td class="border border-gray-300 px-2 py-1 font-medium">Total Dikemas</td>
          <td class="border border-gray-300 px-2 py-1 text-center"><?php echo $total_dikemas; ?> kg</td>
        </tr>
        <tr>
          <td class="border border-gray-300 px-2 py-1 font-medium">Total Reject</td>
          <td class="border border-gray-300 px-2 py-1 text-center"><?php echo $total_reject; ?> kg</td>
        </tr>
      </tbody>
    </table>
  </section>
</main>

<div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <form action="" method="POST" class="w-80 bg-white p-6 rounded shadow-lg relative">
    <h2 class="text-black text-lg font-semibold mb-4">Input Produk Produksi</h2>
    <input type="hidden" name="action" value="tambah">

    <div class="flex flex-col mb-3">
      <label for="id_produk" class="mb-1 text-sm font-medium text-gray-700">Nama Produk</label>
      <select name="id_produk" id="id_produk" class="w-full px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600" required>
        <option value="" disabled selected>-- Pilih Produk --</option>
        <?php foreach ($produk_options as $option): ?>
          <option value="<?php echo $option['id_produk']; ?>"><?php echo htmlspecialchars($option['nama_produk']); ?> (ID: <?php echo $option['id_produk']; ?>)</option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="flex flex-col mb-3">
      <label for="tanggalProduksiTambah" class="mb-1 text-sm font-medium text-gray-700">Tanggal Produksi</label>
      <input id="tanggalProduksiTambah" name="tanggal_produksi" type="date" class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600" required />
    </div>

    <input type="number" name="jumlah_produksi" min="0" placeholder="Jumlah Produksi (kg)" class="w-full mb-3 px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600" required />
    <input type="number" name="jumlah_dikemas" min="0" placeholder="Jumlah Dikemas (kg)" class="w-full mb-3 px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600" required />
    <input type="number" name="jumlah_reject" min="0" placeholder="Jumlah Reject (kg)" class="w-full mb-3 px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600" required />

    <div class="text-red-500 text-xs mb-3 hidden error-message"></div>

    <button type="submit" name="submit" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 transition">Simpan</button>
    <button type="button" id="btnCloseTambah" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" aria-label="Close modal"><i class="fas fa-times"></i></button>
  </form>
</div>

<div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <form id="formEdit" action="" method="POST" class="w-80 bg-white p-6 rounded shadow-lg relative">
    <h1 class="text-black text-lg font-semibold mb-4">Edit Produk Produksi</h1>
    <input type="hidden" name="action" value="edit">
    <input type="hidden" name="id_produksi_edit" id="id_produksi_edit">

    <input type="text" id="editNamaProduk" placeholder="Nama Produk" class="w-full mb-3 px-3 py-2 bg-gray-200 text-gray-500 rounded border border-gray-300" readonly />

    <div class="flex flex-col mb-3">
      <label for="editTanggalProduksi" class="mb-1 text-sm font-medium text-gray-700">Tanggal Produksi</label>
      <input id="editTanggalProduksi" name="tanggal_produksi" type="date" class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600" required />
    </div>

    <input type="number" id="editJumlahProduksi" min="0" name="jumlah_produksi" placeholder="Jumlah Produksi (kg)" class="w-full mb-3 px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600" required />
    <input type="number" id="editJumlahDikemas" min="0" name="jumlah_dikemas" placeholder="Jumlah Dikemas (kg)" class="w-full mb-3 px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600" required />
    <input type="number" id="editJumlahReject" min="0" name="jumlah_reject" placeholder="Jumlah Reject (kg)" class="w-full mb-3 px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600" required />

    <div class="text-red-500 text-xs mb-3 hidden error-message"></div>

    <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 transition">Simpan Perubahan</button>
    <button type="button" id="btnCloseEdit" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" aria-label="Close modal"><i class="fas fa-times"></i></button>
  </form>
</div>

<div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="w-[320px] border border-gray-300 shadow-md p-6 bg-white rounded-md relative">
    <h2 class="font-semibold text-black mb-3 text-lg">Konfirmasi Hapus</h2>
    <p class="text-gray-700 mb-5 text-sm leading-relaxed">Apakah Anda yakin akan menghapus data produksi ini?</p>
    <form action="" method="POST" class="flex justify-end space-x-3">
      <input type="hidden" name="action" value="hapus">
      <input type="hidden" name="id_produksi_hapus" id="id_produksi_hapus">
      <button type="button" id="btnCancelHapus" class="border border-gray-400 text-black text-sm font-medium rounded px-4 py-2 hover:bg-gray-100">Batal</button>
      <button type="submit" class="bg-red-600 text-white text-sm font-medium rounded px-4 py-2 hover:bg-red-700">Ya, Hapus</button>
    </form>
    <button type="button" id="btnCloseHapus" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" aria-label="Close modal"><i class="fas fa-times"></i></button>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // --- Elemen Modal ---
    const modalTambah = document.getElementById('modalTambah');
    const modalEdit = document.getElementById('modalEdit');
    const modalHapus = document.getElementById('modalHapus');

    // --- Tombol Buka Modal ---
    const btnTambah = document.getElementById('btnTambahProduk');

    // --- Tombol Tutup & Batal ---
    const btnCloseTambah = document.getElementById('btnCloseTambah');
    const btnCloseEdit = document.getElementById('btnCloseEdit');
    const btnCloseHapus = document.getElementById('btnCloseHapus');
    const btnCancelHapus = document.getElementById('btnCancelHapus');

    // --- Fungsi Buka/Tutup Modal ---
    function openModal(modal) {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }

    function closeModal(modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }

    // --- Event Listener untuk Buka Modal ---
    btnTambah.addEventListener('click', () => openModal(modalTambah));

    // --- Event Listener untuk Tutup Modal ---
    btnCloseTambah.addEventListener('click', () => closeModal(modalTambah));
    btnCloseEdit.addEventListener('click', () => closeModal(modalEdit));
    btnCloseHapus.addEventListener('click', () => closeModal(modalHapus));
    btnCancelHapus.addEventListener('click', () => closeModal(modalHapus));

    [modalTambah, modalEdit, modalHapus].forEach(modal => {
      modal.addEventListener('click', e => {
        if (e.target === modal) closeModal(modal);
      });
    });

    // --- Event Listener untuk Tombol Edit ---
    document.querySelectorAll('.btnEdit').forEach(button => {
      button.addEventListener('click', (e) => {
        const data = e.target.dataset;
        document.getElementById('id_produksi_edit').value = data.idProduksi;
        document.getElementById('editNamaProduk').value = `${data.namaProduk} (ID: ${data.idProduk})`;
        document.getElementById('editTanggalProduksi').value = data.tgl;
        document.getElementById('editJumlahProduksi').value = data.jmlProduksi;
        document.getElementById('editJumlahDikemas').value = data.jmlDikemas;
        document.getElementById('editJumlahReject').value = data.jmlReject;
        openModal(modalEdit);
      });
    });

    // --- Event Listener untuk Tombol Hapus ---
    document.querySelectorAll('.btnHapus').forEach(button => {
      button.addEventListener('click', (e) => {
        const idProduksi = e.target.dataset.idProduksi;
        document.getElementById('id_produksi_hapus').value = idProduksi;
        openModal(modalHapus);
      });
    });

    // ======================================================
    // === FUNGSI VALIDASI KUANTITAS PRODUKSI (BARU) ===
    // ======================================================
    const validateQuantities = (modal) => {
      const produksiInput = modal.querySelector('[name="jumlah_produksi"]');
      const dikemasInput = modal.querySelector('[name="jumlah_dikemas"]');
      const rejectInput = modal.querySelector('[name="jumlah_reject"]');
      const saveButton = modal.querySelector('button[type="submit"]');
      const errorMessage = modal.querySelector('.error-message');

      const check = () => {
        const produksi = parseInt(produksiInput.value) || 0;
        const dikemas = parseInt(dikemasInput.value) || 0;
        const reject = parseInt(rejectInput.value) || 0;

        if ((dikemas + reject) > produksi) {
          errorMessage.textContent = 'Total dikemas & reject tidak boleh melebihi produksi.';
          errorMessage.classList.remove('hidden');
          saveButton.disabled = true;
          saveButton.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
          errorMessage.classList.add('hidden');
          saveButton.disabled = false;
          saveButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
      };

      [produksiInput, dikemasInput, rejectInput].forEach(input => {
        input.addEventListener('input', check);
      });
    };

    // Terapkan fungsi validasi pada kedua modal
    validateQuantities(modalTambah);
    validateQuantities(modalEdit);
  });
</script>