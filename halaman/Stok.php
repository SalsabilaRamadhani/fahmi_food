<?php include 'auth.php';
 
      if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
          header("Location: ../Index.php?page=stok");
          exit;
      }

      $stok_list = [
  [
    "id_produk" => "AG02",
    "nama_produk" => "Agar Pita",
    "status_stok" => "Sudah DIpacking",
    "jumlah" => 249
  ]];

?>

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
            <tr id="row-0">
              <td class="border border-gray-300 px-3 py-2 text-left">1.</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-id">AG02</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-nama">Agar Pita</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-status">Sudah DIpacking</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-jumlah">249 kg</td>
              <td class="border border-gray-300 px-3 py-2 text-left space-x-2">
                <button class="bg-blue-700 text-white text-xs px-3 py-1 rounded" type="button" onclick="openModal(0)">Edit</button>
                <button class="bg-red-700 text-white text-xs px-3 py-1 rounded" type="button" onclick="openDeleteModal(0)">Hapus</button>
              </td>
            </tr>
            <tr id="row-1">
              <td class="border border-gray-300 px-3 py-2 text-left">2.</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-id">AG02</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-nama">Agar Pita</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-status">Siap Dipacking</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-jumlah">249 kg</td>
              <td class="border border-gray-300 px-3 py-2 text-left space-x-2">
                <button class="bg-blue-700 text-white text-xs px-3 py-1 rounded" type="button" onclick="openModal(1)">Edit</button>
                <button class="bg-red-700 text-white text-xs px-3 py-1 rounded" type="button" onclick="openDeleteModal(1)">Hapus</button>
              </td>
            </tr>
            <tr id="row-2">
              <td class="border border-gray-300 px-3 py-2 text-left">3.</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-id">AG02</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-nama">Agar Pita</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-status">Reject</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-jumlah">1 kg</td>
              <td class="border border-gray-300 px-3 py-2 text-left space-x-2">
                <button class="bg-blue-700 text-white text-xs px-3 py-1 rounded" type="button" onclick="openModal(2)">Edit</button>
                <button class="bg-red-700 text-white text-xs px-3 py-1 rounded" type="button" onclick="openDeleteModal(2)">Hapus</button>
              </td>
            </tr>
            <tr id="row-3">
              <td class="border border-gray-300 px-3 py-2 text-left">4.</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-id">AG02</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-nama">Agar Pita</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-status">Siap Dikemas</td>
              <td class="border border-gray-300 px-3 py-2 text-left cell-jumlah">250 kg</td>
              <td class="border border-gray-300 px-3 py-2 text-left space-x-2">
                <button class="bg-blue-700 text-white text-xs px-3 py-1 rounded" type="button" onclick="openModal(3)">Edit</button>
                <button class="bg-red-700 text-white text-xs px-3 py-1 rounded" type="button" onclick="openDeleteModal(3)">Hapus</button>
              </td>
            </tr>
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
          <table class="w-full border border-gray-300 text-sm text-center">
            <thead>
              <tr class="bg-blue-200 text-black">
                <th class="border border-gray-300 px-3 py-2 w-12">No.</th>
                <th class="border border-gray-300 px-3 py-2">Status Stok</th>
                <th class="border border-gray-300 px-3 py-2">Total Jumlah Stok (kg)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="border border-gray-300 px-3 py-2">1.</td>
                <td class="border border-gray-300 px-3 py-2">Siap Dipacking</td>
                <td class="border border-gray-300 px-3 py-2">249 kg</td>
              </tr>
              <tr>
                <td class="border border-gray-300 px-3 py-2">2.</td>
                <td class="border border-gray-300 px-3 py-2">Sudah DIpacking</td>
                <td class="border border-gray-300 px-3 py-2">249 kg</td>
              </tr>
              <tr>
                <td class="border border-gray-300 px-3 py-2">3.</td>
                <td class="border border-gray-300 px-3 py-2">Reject</td>
                <td class="border border-gray-300 px-3 py-2">1 kg</td>
              </tr>
              <tr>
                <td class="border border-gray-300 px-3 py-2">4.</td>
                <td class="border border-gray-300 px-3 py-2">Siap Dikemas</td>
                <td class="border border-gray-300 px-3 py-2">250 kg</td>
              </tr>
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
              <option value="Siap Dikemas">Siap Dikemas</option>
              <option value="Siap Dipacking">Siap Dipacking</option>
              <option value="Sudah DIpacking">Sudah DIpacking</option>
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
    </main>
  </div>