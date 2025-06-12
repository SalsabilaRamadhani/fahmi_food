<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Pengiriman</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen p-4">
  <div class="bg-white shadow-lg rounded-md p-6 w-72">
    <h1 class="text-black text-lg font-semibold mb-6">Edit Pengiriman</h1>
    <form class="space-y-4">
      <input
        type="text"
        placeholder="ID Produk"
        class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 shadow-sm"
      />
      <input
        type="text"
        placeholder="Nama Produk"
        class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 shadow-sm"
      />
      <input
        type="date"
        placeholder="Tanggal Produksi"
        class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 shadow-sm"
      />
      <input
        type="text"
        placeholder="Jumlah Produksi"
        class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 shadow-sm"
      />
      <div class="flex space-x-3 pt-2">
        <button
          type="submit"
          class="bg-blue-700 text-white px-5 py-2 rounded-md text-sm font-normal"
        >
          Simpan
        </button>
        <button
          type="button"
          class="border border-black text-black px-5 py-2 rounded-md text-sm font-normal"
        >
          Batal
        </button>
      </div>
    </form>
  </div>
</body>
</html>