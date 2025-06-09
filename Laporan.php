<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fahmi Food Laporan Fullscreen with Logo Placeholder</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
  <style>
    /* Custom font sizes and line heights to match exactly */
    .text-judul {
      font-size: 14px;
      line-height: 1.2;
    }
    .text-table-header {
      font-size: 11px;
      line-height: 1.2;
    }
    .btn {
      font-size: 11px;
      line-height: 1.2;
    }
  </style>
</head>
<body class="bg-white h-screen w-screen overflow-hidden flex">
  <!-- Main Content Area -->
  <div class="flex-1 flex border border-gray-300 shadow-sm max-w-full">
    <!-- Left Sidebar -->
    <div class="w-48 border-r border-gray-300 bg-white flex flex-col">
      <div>
        <div class="flex items-center justify-center p-4 border-b border-gray-300">
          <!-- Logo placeholder box -->
          <div class="w-24 h-20 bg-gray-200 border border-gray-300 rounded flex items-center justify-center select-none">
            <span class="text-gray-400 text-sm">Logo Placeholder</span>
          </div>
        </div>
        <button
          class="w-[calc(100%-32px)] py-2 text-[13px] font-normal border border-gray-300 rounded-md mt-4 ml-4 hover:bg-gray-100 transition flex items-center justify-center"
          type="button"
        >
          Dashboard
        </button>
        <button
          class="w-[calc(100%-32px)] py-2 text-[13px] font-normal border border-gray-300 rounded-md mt-2 ml-4 hover:bg-gray-100 transition flex items-center justify-center"
          type="button"
        >
          Produksi
        </button>
        <button
          class="w-[calc(100%-32px)] py-2 text-[13px] font-normal border border-gray-300 rounded-md mt-2 ml-4 hover:bg-gray-100 transition flex items-center justify-center"
          type="button"
        >
          Stok
        </button>
        <button
          class="w-[calc(100%-32px)] py-2 text-[13px] font-normal border border-gray-300 rounded-md mt-2 ml-4 hover:bg-gray-100 transition flex items-center justify-center"
          type="button"
        >
          Pekerja Lepas
        </button>
        <button
          class="w-[calc(100%-32px)] py-2 text-[13px] font-normal border border-gray-300 rounded-md mt-2 ml-4 hover:bg-gray-100 transition flex items-center justify-center"
          type="button"
        >
          Distribusi dan Permintaan
        </button>
      </div>
      <div class="mb-4">
        <button
          class="w-[calc(100%-32px)] py-2 text-[13px] font-normal border border-gray-300 rounded-md mt-2 ml-4 bg-gray-300 text-gray-600 cursor-not-allowed flex items-center justify-center"
          type="button"
          disabled
        >
          Laporan
        </button>
      </div>
    </div>
    <!-- Right Content -->
    <div class="flex-1 bg-white flex flex-col">
      <div
        class="bg-[#3B4DB7] text-white text-[20px] font-normal px-6 py-3 flex items-center"
        style="height: 70px;"
      >
        LAPORAN
      </div>
      <div class="p-4 flex-grow flex flex-col">
        <div class="flex items-center space-x-3 mb-3">
          <select
            aria-label="Periode"
            class="border border-gray-300 rounded text-[12px] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#3B4DB7]"
          >
            <option>Periode</option>
          </select>
          <select
            aria-label="Kategori"
            class="border border-gray-300 rounded text-[12px] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#3B4DB7]"
          >
            <option>Kategori</option>
          </select>
          <div class="ml-auto">
            <button
              class="bg-[#3B4DB7] text-white text-[11px] font-normal px-3 py-1 rounded hover:bg-[#2a3a9e] transition"
              type="button"
            >
              Cetak Laporan
            </button>
          </div>
        </div>
        <div class="overflow-x-auto border border-gray-300 rounded shadow-sm h-full">
          <table class="w-full text-[11px] border-collapse">
            <thead class="bg-[#D7E1FA] text-[#3B4DB7]">
              <tr>
                <th class="border border-gray-300 px-2 py-1 text-left w-10">No.</th>
                <th class="border border-gray-300 px-2 py-1 text-left w-24">Tanggal</th>
                <th class="border border-gray-300 px-2 py-1 text-left w-28">Jumlah Produksi</th>
                <th class="border border-gray-300 px-2 py-1 text-left w-28">Jumlah Dikemas</th>
                <th class="border border-gray-300 px-2 py-1 text-left w-28">Jumlah Reject</th>
                <th class="border border-gray-300 px-2 py-1 text-left w-28">Total Produksi</th>
              </tr>
            </thead>
            <tbody class="h-48">
              <tr>
                <td class="border border-gray-300 px-2 py-1 h-48" colspan="6"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>