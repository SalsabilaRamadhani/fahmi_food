<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
  <style>
    /* Custom scrollbar for sidebar if needed */
    ::-webkit-scrollbar {
      width: 6px;
    }
    ::-webkit-scrollbar-thumb {
      background-color: rgba(100, 116, 139, 0.5);
      border-radius: 3px;
    }
  </style>
</head>
<body class="bg-white font-sans">
  <div class="flex min-h-screen shadow-md">
    <!-- Sidebar -->
    <aside class="w-64 border-r border-gray-300 flex flex-col">
      <div class="flex flex-col items-center justify-center py-8 border-b border-gray-300">
        <?php
          // Path to your logo image
          $logoPath = 'https://placehold.co/120x120/png?text=Logo+Placeholder';
          // You can replace the above URL with your actual logo path or upload logic
        ?>
        <img src="<?php echo $logoPath; ?>" alt="Logo placeholder image for company logo" class="w-28 h-28 object-contain" />
      </div>
      <nav class="flex flex-col space-y-3 px-4 py-6">
        <button
          class="w-full rounded-md bg-gray-200 border border-gray-400 text-gray-600 py-3 text-center text-base shadow-sm hover:shadow-md transition-shadow"
          aria-current="page"
        >
          Dashboard
        </button>
        <button
          class="w-full rounded-md border border-gray-300 text-black py-3 text-center text-base hover:bg-gray-50 transition"
        >
          Produksi
        </button>
        <button
          class="w-full rounded-md border border-gray-300 text-black py-3 text-center text-base hover:bg-gray-50 transition"
        >
          Stok
        </button>
        <button
          class="w-full rounded-md border border-gray-300 text-black py-3 text-center text-base hover:bg-gray-50 transition"
        >
          Pekerja Lepas
        </button>
        <button
          class="w-full rounded-md border border-gray-300 text-black py-3 text-center text-base hover:bg-gray-50 transition"
        >
          Distribusi dan Permintaan
        </button>
        <button
          class="w-full rounded-md border border-gray-300 text-black py-3 text-center text-base hover:bg-gray-50 transition"
        >
          Laporan
        </button>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col">
      <!-- Header -->
      <header class="bg-[#2e49b0] text-white px-8 py-6 shadow-sm">
        <h1 class="text-lg font-normal">Dashboard</h1>
      </header>

      <!-- Content -->
      <section class="flex-1 p-8 space-y-8">
        <div class="flex flex-wrap gap-8">
          <!-- Pesanan card -->
          <div
            class="bg-white shadow-md w-48 p-6 flex flex-col justify-between"
            style="min-width: 12rem;"
          >
            <h2 class="text-[#2e49b0] font-semibold text-base mb-2 select-none">PESANAN</h2>
            <div class="text-4xl font-normal leading-none flex items-center">
              400<span class="text-lg font-normal ml-1 select-none">Kg</span>
            </div>
          </div>

          <!-- Jadwal Harian card -->
          <div
            class="bg-white shadow-md p-6 flex-1 max-w-3xl min-w-[20rem]"
          >
            <h2 class="text-[#2e49b0] font-semibold text-base mb-4 select-none">JADWAL HARIAN</h2>
            <table class="w-full text-sm text-left text-black">
              <thead>
                <tr>
                  <th class="font-normal">Tanggal</th>
                  <th class="font-normal">Waktu</th>
                  <th class="font-normal">Jenis Kegiatan</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr class="border-t border-gray-200">
                  <td class="py-1">2025-03-24</td>
                  <td class="py-1">07.30 - 01.00</td>
                  <td class="py-1">Produksi</td>
                  <td class="py-1 w-6 text-center">
                    <i class="fas fa-pencil-alt cursor-pointer"></i>
                  </td>
                  <td class="py-1 w-6 text-center">
                    <i class="fas fa-trash cursor-pointer"></i>
                  </td>
                </tr>
                <tr class="border-t border-gray-200">
                  <td class="py-1">2025-03-24</td>
                  <td class="py-1">19.30 - 11.00</td>
                  <td class="py-1">Pengemasan</td>
                  <td class="py-1 w-6 text-center">
                    <i class="fas fa-pencil-alt cursor-pointer"></i>
                  </td>
                  <td class="py-1 w-6 text-center">
                    <i class="fas fa-trash cursor-pointer"></i>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="flex flex-wrap gap-8">
          <!-- Gaji Pekerja Lepas card -->
          <div
            class="bg-white shadow-md w-64 p-6 flex flex-col justify-between"
            style="min-width: 16rem;"
          >
            <h2 class="text-[#2e49b0] font-semibold text-base mb-2 select-none">GAJI PEKERJA LEPAS</h2>
            <div class="text-3xl font-normal leading-none select-none">2.000.000</div>
          </div>

          <!-- Produksi card -->
          <div
            class="bg-white shadow-md w-48 p-6 flex flex-col justify-between"
            style="min-width: 12rem;"
          >
            <h2 class="text-[#2e49b0] font-semibold text-base mb-2 select-none">PRODUKSI</h2>
            <div class="text-4xl font-normal leading-none flex items-center">
              400<span class="text-lg font-normal ml-1 select-none">Kg</span>
            </div>
          </div>

          <!-- Stok Harian card -->
          <div
            class="bg-white shadow-md w-48 p-6 flex flex-col justify-between"
            style="min-width: 12rem;"
          >
            <h2 class="text-[#2e49b0] font-semibold text-base mb-2 select-none">STOK HARIAN</h2>
            <div class="text-4xl font-normal leading-none flex items-center">
              400<span class="text-lg font-normal ml-1 select-none">Kg</span>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>