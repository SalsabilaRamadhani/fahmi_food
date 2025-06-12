<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Input Pengiriman</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body class="bg-white flex items-center justify-center min-h-screen p-4">
  <div class="w-full max-w-xs border border-gray-300 rounded-md shadow-md p-6">
    <h2 class="text-black font-semibold text-lg mb-4">Input Pengiriman</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">
      <input
        type="text"
        name="nama_distributor"
        placeholder="Nama Distributor"
        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
        required
      />
      <input
        type="text"
        name="nama_produk"
        placeholder="Nama Produk"
        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
        required
      />
      <input
        type="number"
        name="jumlah"
        placeholder="Jumlah"
        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
        required
        min="1"
      />
      <div class="relative">
        <input
          type="date"
          name="tanggal"
          placeholder="Tanggal"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 appearance-none"
          required
        />
        <i
          class="fas fa-calendar-alt absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
          aria-hidden="true"
        ></i>
      </div>
      <button
        type="submit"
        class="w-full bg-blue-700 text-white py-2 rounded-md text-center"
      >
        Simpan
      </button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_distributor = htmlspecialchars($_POST['nama_distributor']);
        $nama_produk = htmlspecialchars($_POST['nama_produk']);
        $jumlah = (int)$_POST['jumlah'];
        $tanggal = htmlspecialchars($_POST['tanggal']);

        echo '<div class="mt-4 p-3 border border-green-500 rounded bg-green-50 text-green-700 text-sm">';
        echo "Data berhasil disimpan:<br>";
        echo "Nama Distributor: " . $nama_distributor . "<br>";
        echo "Nama Produk: " . $nama_produk . "<br>";
        echo "Jumlah: " . $jumlah . "<br>";
        echo "Tanggal: " . $tanggal;
        echo '</div>';
    }
    ?>
  </div>
</body>
</html>