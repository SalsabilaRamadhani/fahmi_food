<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fahmi Food Laporan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body class="bg-white font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 border-r border-gray-300 flex flex-col p-6 bg-white">
      <div class="mb-12 flex justify-center">
        <img src="assets/logo.png" alt="Logo Fahmi Food" class="max-h-24 object-contain" />
      </div>
      <nav class="flex flex-col space-y-4">
        <button
          type="button"
          class="w-full py-3 rounded border border-gray-300 shadow-sm text-black text-base font-normal hover:shadow-md transition-shadow"
        >
          Dashboard
        </button>
        <button
          type="button"
          class="w-full py-3 rounded border border-gray-300 shadow-sm text-black text-base font-normal hover:shadow-md transition-shadow"
        >
          Produksi
        </button>
        <button
          type="button"
          class="w-full py-3 rounded border border-gray-300 shadow-sm text-black text-base font-normal hover:shadow-md transition-shadow"
        >
          Stok
        </button>
        <button
          type="button"
          class="w-full py-3 rounded border border-gray-300 shadow-sm text-black text-base font-normal hover:shadow-md transition-shadow"
        >
          Pekerja Lepas
        </button>
        <button
          type="button"
          class="w-full py-3 rounded border border-gray-300 shadow-sm text-black text-base font-normal hover:shadow-md transition-shadow"
        >
          Distribusi dan Permintaan
        </button>
        <button
          type="button"
          disabled
          class="w-full py-3 rounded border border-[#2f49b7] bg-gray-300 text-gray-400 text-base font-normal cursor-not-allowed"
        >
          Laporan
        </button>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col">
      <header class="bg-[#2f49b7] text-white px-8 py-6 shadow-md">
        <h1 class="text-xl font-normal">LAPORAN</h1>
      </header>

      <section class="flex-1 p-6">
        <div class="flex flex-wrap items-center justify-between mb-4 gap-4">
          <div class="flex space-x-4">
            <select
              name="periode"
              aria-label="Periode"
              class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#2f49b7] focus:border-[#2f49b7]"
            >
              <option value="" disabled selected>Periode</option>
              <option value="harian">Harian</option>
              <option value="mingguan">Mingguan</option>
              <option value="bulanan">Bulanan</option>
            </select>
            <select
              name="kategori"
              aria-label="Kategori"
              class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#2f49b7] focus:border-[#2f49b7]"
            >
              <option value="semua" selected>Semua (default)</option>
              <option value="produksi">Produksi</option>
              <option value="stok">Stok</option>
              <option value="pekerja_lepas">Pekerja Lepas</option>
            </select>
          </div>
          <button
            type="button"
            class="bg-[#2f49b7] text-white text-sm px-4 py-2 rounded shadow hover:bg-[#243a8a] transition-colors"
          >
            Cetak Laporan
          </button>
        </div>

        <div class="overflow-x-auto shadow-md rounded border border-gray-200">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-blue-200 text-gray-800">
              <tr>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">No.</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Tanggal</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Jumlah Produksi</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Jumlah Dikemas</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Jumlah Reject</th>
                <th class="px-4 py-2 font-normal">Total Produksi</th>
              </tr>
            </thead>
            <tbody class="bg-white min-h-[300px]">
              <tr>
                <td colspan="6" class="py-20"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
</body>
</html>