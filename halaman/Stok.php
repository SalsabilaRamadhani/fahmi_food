<?php
  // Start session at the very top before any output
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
 
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Location: ../Index.php?page=stok");
    exit;
}
?>

<script>
    function openModal(id = null) {
      const modal = document.getElementById('modal');
      modal.classList.remove('hidden');

      if (id !== null) {
        const row = document.getElementById('row-' + id);
        if (!row) return;

        const id_produk = row.querySelector('.cell-id').textContent.trim();
        const nama_produk = row.querySelector('.cell-nama').textContent.trim();
        const status_stok = row.querySelector('.cell-status').textContent.trim();
        const jumlah = row.querySelector('.cell-jumlah').textContent.trim().replace(' kg', '');

        document.getElementById('modal-title').textContent = 'Edit Produk';
        document.getElementById('id_produk').value = id_produk;
        document.getElementById('nama_produk').value = nama_produk;
        document.getElementById('status_stok').value = status_stok;
        document.getElementById('jumlah').value = jumlah;

        document.getElementById('edit_index').value = id;
      } else {
        document.getElementById('modal-title').textContent = 'Tambah Produk';
        document.getElementById('id_produk').value = '';
        document.getElementById('nama_produk').value = '';
        document.getElementById('status_stok').value = '';
        document.getElementById('jumlah').value = '';
        document.getElementById('edit_index').value = '';
      }
    }
    function closeModal() {
      document.getElementById('modal').classList.add('hidden');
    }
    function openDeleteModal(id) {
      const delModal = document.getElementById('delete-modal');
      delModal.classList.remove('hidden');
      document.getElementById('delete_index').value = id;
    }
    function closeDeleteModal() {
      document.getElementById('delete-modal').classList.add('hidden');
      document.getElementById('delete_index').value = '';
    }
  </script>

<?php
  // Data produk stok awal
  if (!isset($_SESSION['produk'])) {
    $_SESSION['produk'] = [
        ["no" => 1, "id" => "AG02", "nama" => "Agar Pita", "status" => "Sudah Dikemas", "jumlah" => 249],
        ["no" => 2, "id" => "AG02", "nama" => "Agar Pita", "status" => "Approve", "jumlah" => 249],
        ["no" => 3, "id" => "AG02", "nama" => "Agar Pita", "status" => "Reject", "jumlah" => 1],
        ["no" => 4, "id" => "AG02", "nama" => "Agar Pita", "status" => "Siap Dikemas", "jumlah" => 250],
    ];
  }

  // Handle form submission for add or edit
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $id_produk = htmlspecialchars($_POST['id_produk']);
    $nama_produk = htmlspecialchars($_POST['nama_produk']);
    $status_stok = htmlspecialchars($_POST['status_stok']);
    $jumlah = (int)$_POST['jumlah'];
    $edit_index = isset($_POST['edit_index']) && $_POST['edit_index'] !== '' ? (int)$_POST['edit_index'] : null;

    if ($edit_index !== null && isset($_SESSION['produk'][$edit_index])) {
      $_SESSION['produk'][$edit_index]['id'] = $id_produk;
      $_SESSION['produk'][$edit_index]['nama'] = $nama_produk;
      $_SESSION['produk'][$edit_index]['status'] = $status_stok;
      $_SESSION['produk'][$edit_index]['jumlah'] = $jumlah;
    } else {
      $_SESSION['produk'][] = [
        "no" => count($_SESSION['produk']) + 1,
        "id" => $id_produk,
        "nama" => $nama_produk,
        "status" => $status_stok,
        "jumlah" => $jumlah
      ];
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }

  // Handle delete request from modal
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_submit'])) {
    $delIndex = isset($_POST['delete_index']) ? (int)$_POST['delete_index'] : null;
    if ($delIndex !== null && isset($_SESSION['produk'][$delIndex])) {
      array_splice($_SESSION['produk'], $delIndex, 1);
      foreach ($_SESSION['produk'] as $k => $v) {
        $_SESSION['produk'][$k]['no'] = $k + 1;
      }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }

  $produk = $_SESSION['produk'];

  // Hitung jumlah stok per status
  $stokStatus = [];
  foreach ($produk as $item) {
      if (!isset($stokStatus[$item['status']])) {
          $stokStatus[$item['status']] = 0;
      }
      $stokStatus[$item['status']] += $item['jumlah'];
  }
?>

    <!-- Main content -->
      <section class="p-6 overflow-x-auto">
        <button
          onclick="openModal()"
          class="mb-4 inline-flex items-center gap-2 bg-blue-700 text-white text-sm font-normal px-4 py-2 rounded"
          type="button"
        >
          <i class="fas fa-plus"></i> Tambah Produk
        </button>

        <table class="w-full border border-gray-300 text-sm text-center">
          <thead>
            <tr class="bg-blue-200 text-black">
              <th class="border border-gray-300 px-3 py-2 text-left">No.</th>
              <th class="border border-gray-300 px-3 py-2 text-left">ID Poduk</th>
              <th class="border border-gray-300 px-3 py-2 text-left">Nama Produk</th>
              <th class="border border-gray-300 px-3 py-2 text-left">Status Stok</th>
              <th class="border border-gray-300 px-3 py-2 text-left">Jumlah Stok</th>
              <th class="border border-gray-300 px-3 py-2 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($produk as $index => $item): ?>
            <tr id="row-<?= $index ?>">
              <td class="border border-gray-300 px-3 py-2 text-left"><?= $item['no'] ?>.</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-id"><?= htmlspecialchars($item['id']) ?></td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-nama"><?= htmlspecialchars($item['nama']) ?></td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-status"><?= htmlspecialchars($item['status']) ?></td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-jumlah"><?= $item['jumlah'] ?> kg</td>
              <td class="border border-gray-300 px-3 py-2 text-left space-x-2">
                <button class="bg-blue-700 text-white text-xs px-3 py-1 rounded" type="button" onclick="openModal(<?= $index ?>)">Edit</button>
                <button class="bg-red-700 text-white text-xs px-3 py-1 rounded" type="button" onclick="openDeleteModal(<?= $index ?>)">Hapus</button>
              </td>
            </tr>
            <?php endforeach; ?>
            <tr>
              <td class="border border-gray-300 px-3 py-2 text-left"></td>
              <td class="border border-gray-300 px-3 py-2 text-left"></td>
              <td class="border border-gray-300 px-3 py-2 text-left"></td>
              <td class="border border-gray-300 px-3 py-2 text-left"></td>
              <td class="border border-gray-300 px-3 py-2 text-left"></td>
              <td class="border border-gray-300 px-3 py-2 text-left"></td>
            </tr>
          </tbody>
        </table>

        <!-- Tabel jumlah stok menurut status -->
        <div class="mt-8">
          <h2 class="text-lg font-semibold mb-4 text-left">Jumlah Stok Menurut Status</h2>
          <table class="w-full border border-gray-300 text-sm text-left">
            <thead>
              <tr class="bg-blue-200 text-black">
                <th class="border border-gray-300 px-3 py-2">Status Stok</th>
                <th class="border border-gray-300 px-3 py-2">Total Jumlah Stok (kg)</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($stokStatus as $status => $total): ?>
              <tr>
                <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($status) ?></td>
                <td class="border border-gray-300 px-3 py-2"><?= $total ?> kg</td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>

  <!-- Modal Tambah/Edit Produk -->
  <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 shadow-md rounded w-72 relative">
      <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold" aria-label="Close modal">&times;</button>
      <h2 id="modal-title" class="text-black font-semibold text-lg mb-4">Tambah Produk</h2>
      <form action="" method="POST" class="flex flex-col">
        <input type="hidden" name="edit_index" id="edit_index" value="" />
        <input
          type="text"
          name="id_produk"
          id="id_produk"
          placeholder="ID Produk"
          class="w-full mb-4 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
          required
        />
        <input
          type="text"
          name="nama_produk"
          id="nama_produk"
          placeholder="Nama Produk"
          class="w-full mb-4 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
          required
        />
        <select
          name="status_stok"
          id="status_stok"
          class="w-full mb-4 px-3 py-2 border border-gray-300 rounded shadow-sm appearance-none bg-white focus:outline-none focus:ring-1 focus:ring-gray-400"
          required
        >
          <option disabled value="">Status Stok</option>
          <option value="Reject">Reject</option>
          <option value="Approve">Approve</option>
          <option value="Siap Dikemas">Siap Dikemas</option>
          <option value="Sudah Dikemas">Sudah Dikemas</option>
        </select>
        <input
          type="number"
          name="jumlah"
          id="jumlah"
          placeholder="Jumlah"
          class="w-full mb-6 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
          required
          min="0"
        />
        <button
          type="submit"
          name="submit"
          class="w-full bg-blue-700 text-white py-2 rounded focus:outline-none"
        >
          Simpan
        </button>
      </form>
    </div>
  </div>

  <!-- Modal Hapus Produk -->
  <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="w-[280px] border border-gray-300 shadow-md p-5 bg-white rounded relative">
      <button onclick="closeDeleteModal()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold" aria-label="Close delete modal">&times;</button>
      <h2 class="font-semibold text-black mb-3 text-base">Hapus Data</h2>
      <p class="text-black mb-5 text-sm leading-relaxed">Apakah anda yakin akan menghapus data ini?</p>
      <form action="" method="POST" class="flex space-x-3 justify-end">
        <input type="hidden" name="delete_index" id="delete_index" value="" />
        <button type="submit" name="delete_submit" class="bg-[#B22222] text-white text-sm font-normal rounded px-4 py-2">Hapus</button>
        <button type="button" onclick="closeDeleteModal()" class="border border-gray-400 text-black text-sm font-normal rounded px-4 py-2">Batal</button>
      </form>
    </div>
  </div>