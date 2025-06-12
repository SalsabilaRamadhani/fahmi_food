<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Stok</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body class="bg-white flex items-center justify-center min-h-screen p-4">
  <div class="w-full max-w-xs bg-white shadow-md rounded border border-gray-300 p-6">
    <h1 class="text-black text-xl font-semibold mb-6">Edit Stok</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <input
        type="text"
        name="id_produk"
        placeholder="ID Produk"
        class="w-full mb-4 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
        required
      />
      <input
        type="text"
        name="nama_produk"
        placeholder="Nama Produk"
        class="w-full mb-4 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
        required
      />
      <select
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
          type="reset"
          class="border border-gray-400 text-black px-5 py-2 rounded focus:outline-none focus:ring-2 focus:ring-gray-400"
        >
          Batal
        </button>
      </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
</body>
</html>