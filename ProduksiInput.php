<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Input Pengiriman</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex justify-center items-center min-h-screen p-4">
  <form class="w-full max-w-xs bg-white shadow-lg p-6">
    <h2 class="text-black text-lg font-semibold mb-4">Input Pengiriman</h2>
    <input 
      type="text" 
      placeholder="ID Produk" 
      class="w-full mb-4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-gray-500 text-sm" 
    />
    <input 
      type="text" 
      placeholder="Nama Produk" 
      class="w-full mb-4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-gray-500 text-sm" 
    />
    <input 
      type="date" 
      placeholder="Tanggal Prouksi" 
      class="w-full mb-4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-gray-500 text-sm" 
      aria-label="Tanggal Prouksi"
    />
    <input 
      type="text" 
      placeholder="Jumlah Produksi" 
      class="w-full mb-6 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-gray-500 text-sm" 
    />
    <button 
      type="submit" 
      class="w-full bg-blue-700 text-white text-sm py-2 rounded-md"
    >
      Simpan
    </button>
  </form>
</body>
</html>