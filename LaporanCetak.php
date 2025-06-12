<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cetak Laporan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen p-4">
  <div class="w-72 bg-white shadow-md rounded border border-gray-300 p-5">
    <h1 class="font-bold text-lg mb-4">Cetak Laporan</h1>
    <form action="process.php" method="POST" class="space-y-4">
      <select
        name="tujuan_file"
        class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-blue-600"
        required
      >
        <option disabled selected>Tujuan File Tersimpan</option>
        <option value="local_disk_c">Simpan ke Local Disk C</option>
        <option value="local_disk_d">Simpan ke Local Disk D</option>
      </select>
      <select
        name="halaman"
        class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-blue-600"
        required
      >
        <option disabled selected>Halaman</option>
        <option value="cetak_semua_halaman">Cetak Semua Halaman</option>
        <option value="1_halaman_ini">1 Halaman Ini</option>
      </select>
      <select
        name="tata_letak"
        class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-blue-600"
        required
      >
        <option disabled selected>Tata Letak</option>
        <option value="landscape">Landscape</option>
        <option value="potrait">Potrait</option>
      </select>
      <div class="flex space-x-3">
        <button
          type="submit"
          class="bg-blue-700 text-white px-5 py-2 rounded text-sm font-normal shadow-sm hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600"
        >
          Simpan
        </button>
        <button
          type="button"
          onclick="window.location.reload()"
          class="border border-gray-700 text-gray-700 px-5 py-2 rounded text-sm font-normal shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400"
        >
          Batal
        </button>
      </div>
    </form>
  </div>
</body>
</html>