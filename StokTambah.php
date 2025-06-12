<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tambah Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
  <div class="bg-white rounded-md shadow-md p-6 w-72">
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
</body>
</html>