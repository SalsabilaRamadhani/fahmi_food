  <script>
    // Show modals
    function openAddModal() {
      document.getElementById('addModal').classList.remove('hidden');
    }
    function closeAddModal() {
      document.getElementById('addModal').classList.add('hidden');
    }
    function openEditModal(id, name, status) {
      document.getElementById('editModal').classList.remove('hidden');
      document.getElementById('edit_id_produk').value = id;
      document.getElementById('edit_nama_produk').value = name;
      const statusSelect = document.getElementById('edit_status_stok');
      for (let i = 0; i < statusSelect.options.length; i++) {
        statusSelect.options[i].selected = statusSelect.options[i].value === status;
      }
    }
    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }
    function openDeleteModal(id) {
      document.getElementById('deleteModal').classList.remove('hidden');
      document.getElementById('delete_id_produk').value = id;
    }
    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.add('hidden');
      document.getElementById('delete_id_produk').value = '';
    }
  </script>
<body class="bg-white font-sans p-6">
  <section class="max-w-4xl mx-auto">
    <button onclick="openAddModal()" class="mb-4 inline-flex items-center gap-2 bg-[#2E49B0] text-white text-sm font-normal px-4 py-2 rounded shadow-sm hover:shadow-md transition-shadow">
      <i class="fas fa-plus"></i> Tambah Produk
    </button>

    <div class="overflow-x-auto shadow border border-gray-200 rounded">
      <table class="min-w-full border-collapse">
        <thead>
          <tr class="bg-[#C6D5F5] text-left text-sm font-normal text-black">
            <th class="px-4 py-2 border border-[#C6D5F5] w-14">No.</th>
            <th class="px-4 py-2 border border-[#C6D5F5] w-24">ID Poduk</th>
            <th class="px-4 py-2 border border-[#C6D5F5]">Nama Produk</th>
            <th class="px-4 py-2 border border-[#C6D5F5] w-28">Status Stok</th>
            <th class="px-4 py-2 border border-[#C6D5F5] w-28">Jumlah Stok</th>
            <th class="px-4 py-2 border border-[#C6D5F5] w-48 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $products = [
              [
                'id' => 'AG01',
                'name' => 'Agar-Agar Pelangi',
                'status' => 'Approved',
                'quantity' => '230 Kg',
              ],
            ];
            $no = 1;
            foreach ($products as $product) {
              echo '<tr class="text-sm text-black">';
              echo '<td class="px-4 py-2 border border-gray-200">' . $no++ . '.</td>';
              echo '<td class="px-4 py-2 border border-gray-200">' . htmlspecialchars($product['id']) . '</td>';
              echo '<td class="px-4 py-2 border border-gray-200">' . htmlspecialchars($product['name']) . '</td>';
              echo '<td class="px-4 py-2 border border-gray-200">' . htmlspecialchars($product['status']) . '</td>';
              echo '<td class="px-4 py-2 border border-gray-200">' . htmlspecialchars($product['quantity']) . '</td>';
              echo '<td class="px-4 py-2 border border-gray-200 text-center flex justify-center gap-2">';
              echo '<button onclick="openEditModal(\'' . addslashes($product['id']) . '\', \'' . addslashes($product['name']) . '\', \'' . addslashes($product['status']) . '\')" class="bg-[#2E49B0] text-white text-xs px-3 py-1 rounded hover:bg-[#243a8a] transition-colors">Edit</button>';
              echo '<button onclick="openDeleteModal(\'' . addslashes($product['id']) . '\')" class="bg-[#B22222] text-white text-xs px-3 py-1 rounded hover:bg-[#7a1616] transition-colors">Hapus</button>';
              echo '</td>';
              echo '</tr>';
            }
          ?>
        </tbody>
      </table>
    </div>
  </section>

  <!-- Add Modal -->
  <div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40">
    <div class="bg-white rounded-md shadow-md p-6 w-full max-w-xs relative">
      <button onclick="closeAddModal()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold" aria-label="Close modal">&times;</button>
      <h2 class="font-semibold text-lg mb-4">Tambah Produk</h2>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="space-y-4">
        <input
          type="text"
          name="id_produk"
          placeholder="ID Produk"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
          required
        />
        <input
          type="text"
          name="nama_produk"
          placeholder="Nama Produk"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
          required
        />
        <select
          name="status_stok"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
          required
        >
          <option value="" disabled selected>Status Stok</option>
          <option value="available">Available</option>
          <option value="out_of_stock">Out of Stock</option>
        </select>
        <div class="relative">
          <input
            type="number"
            name="jumlah"
            placeholder="Jumlah"
            class="w-full pr-12 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
            required
            min="0"
            step="any"
          />
          <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm font-normal text-gray-900">Kg</span>
        </div>
        <button
          type="submit"
          class="w-full bg-blue-700 text-white py-2 rounded-md text-center text-sm font-normal"
        >
          Simpan
        </button>
      </form>
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_produk']) && isset($_POST['jumlah'])) {
          $id_produk = htmlspecialchars($_POST['id_produk']);
          $nama_produk = htmlspecialchars($_POST['nama_produk']);
          $status_stok = htmlspecialchars($_POST['status_stok']);
          $jumlah = htmlspecialchars($_POST['jumlah']);
          echo "<div class='mt-4 p-3 bg-green-100 text-green-800 rounded-md text-sm'>";
          echo "Produk berhasil disimpan:<br>";
          echo "ID Produk: $id_produk<br>";
          echo "Nama Produk: $nama_produk<br>";
          echo "Status Stok: $status_stok<br>";
          echo "Jumlah: $jumlah Kg";
          echo "</div>";
      }
      ?>
    </div>
  </div>

  <!-- Edit Modal -->
  <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="w-full max-w-xs bg-white shadow-md rounded border border-gray-300 p-6 relative">
      <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold" aria-label="Close modal">&times;</button>
      <h1 class="text-black text-xl font-semibold mb-6">Edit Stok</h1>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input
          type="text"
          id="edit_id_produk"
          name="id_produk"
          placeholder="ID Produk"
          class="w-full mb-4 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
          required
        />
        <input
          type="text"
          id="edit_nama_produk"
          name="nama_produk"
          placeholder="Nama Produk"
          class="w-full mb-4 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
          required
        />
        <select
          id="edit_status_stok"
          name="status_stok"
          class="w-full mb-6 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
          required
        >
          <option value="" disabled selected>Status Stok</option>
          <option value="Reject">Reject</option>
          <option value="Approved">Approved</option>
        </select>
        <div class="flex space-x-4">
          <button
            type="submit"
            class="bg-blue-700 text-white px-5 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-600"
          >
            Simpan
          </button>
          <button
            type="button"
            onclick="closeEditModal()"
            class="border border-gray-400 text-black px-5 py-2 rounded focus:outline-none focus:ring-2 focus:ring-gray-400"
          >
            Batal
          </button>
        </div>
      </form>
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_produk']) && isset($_POST['nama_produk']) && isset($_POST['status_stok'])) {
          $id_produk = htmlspecialchars($_POST['id_produk']);
          $nama_produk = htmlspecialchars($_POST['nama_produk']);
          $status_stok = htmlspecialchars($_POST['status_stok']);
          echo "<div class='mt-4 p-3 border border-green-500 rounded text-green-700 bg-green-100'>";
          echo "Data berhasil disimpan:<br>";
          echo "ID Produk: " . $id_produk . "<br>";
          echo "Nama Produk: " . $nama_produk . "<br>";
          echo "Status Stok: " . $status_stok;
          echo "</div>";
      }
      ?>
    </div>
  </div>

  <!-- Delete Modal -->
  <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-60">
    <div class="w-[280px] border border-gray-300 shadow-md p-5 bg-white rounded">
      <h2 class="font-semibold text-black mb-3 text-base">Hapus Data</h2>
      <p class="text-black mb-5 text-sm leading-relaxed">Apakah anda yakin akan menghapus data ini?</p>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="flex space-x-3 justify-end">
        <input type="hidden" id="delete_id_produk" name="delete_id" value="" />
        <button type="submit" name="confirm_delete" class="bg-[#B22222] text-white text-sm font-normal rounded px-4 py-2">Hapus</button>
        <button type="button" onclick="closeDeleteModal()" class="border border-gray-400 text-black text-sm font-normal rounded px-4 py-2">Batal</button>
      </form>
    </div>
  </div>