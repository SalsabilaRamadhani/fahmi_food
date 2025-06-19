<!DOCTYPE html>
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
</head>
<body class="bg-white font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 border-r border-gray-300 flex flex-col p-6 bg-white">
      <div class="mb-12 flex justify-center">
        <?php
          $logoPath = 'assets/logo.png';
          if (file_exists($logoPath)) {
            echo '<img src="' . htmlspecialchars($logoPath) . '" alt="Logo perusahaan" class="max-h-24 object-contain" />';
          } else {
            echo '<div class="w-full h-24 flex items-center justify-center border border-gray-300 rounded text-gray-400 text-sm">Logo belum diupload</div>';
          }
        ?>
      </div>
      <?php $current = basename($_SERVER['PHP_SELF']); ?>
<nav class="flex flex-col space-y-4">
  <a href="Dashboard.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Dashboard.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Dashboard
  </a>
  <a href="Produksi.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Produksi.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Produksi
  </a>
  <a href="Stok.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Stok.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Stok
  </a>
  <a href="Pekerja.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Pekerja.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Pekerja Lepas
  </a>
  <a href="Distribusi.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Distribusi.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Distribusi dan Permintaan
  </a>
  <a href="Laporan.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Laporan.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Laporan
  </a>
</nav>

    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col">
      <header class="bg-[#2f49b7] text-white px-8 py-6 shadow-md">
        <h1 class="text-xl font-normal">Dashboard</h1>
      </header>
      <!-- Content -->
      <section class="flex-1 p-8 space-y-8 flex flex-col items-center">
        <div class="flex flex-wrap gap-8 justify-center w-full max-w-7xl items-center">
          <!-- Pesanan card with horizontal table sized like produksi card, label removed inside number -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='#pesanan-menu';"
            onkeypress="if(event.key==='Enter'){window.location.href='#pesanan-menu';}"
            class="bg-white shadow-md p-6 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 14rem; max-width: 14rem;"
            aria-label="Pesanan, 400 Kg, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-4">PESANAN</h2>
            <div class="text-5xl font-normal text-center">
              400<span class="text-xl font-normal ml-1">Kg</span>
            </div>
          </div>

          <!-- Jadwal Harian card with clickable rows and bigger table, centered -->
          <div
            class="bg-white shadow-md p-8 flex-1 max-w-4xl min-w-[24rem] rounded"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-6 select-none">JADWAL HARIAN</h2>
            <table class="w-full text-base text-left text-black border border-gray-200 rounded">
              <thead>
                <tr class="border-b border-gray-300">
                  <th class="py-3 px-4 font-semibold">Tanggal</th>
                  <th class="py-3 px-4 font-semibold">Waktu</th>
                  <th class="py-3 px-4 font-semibold">Jenis Kegiatan</th>
                  <th class="py-3 px-4 font-semibold w-10"></th>
                  <th class="py-3 px-4 font-semibold w-10"></th>
                </tr>
              </thead>
              <tbody>
                <tr class="border-b border-gray-200 clickable-row" onclick="window.location.href='#produksi-menu';" tabindex="0" role="link" aria-label="2025-03-24, 07.30 to 01.00, Produksi">
                  <td class="py-4 px-4">2025-03-24</td>
                  <td class="py-4 px-4">07.30 - 01.00</td>
                  <td class="py-4 px-4">Produksi</td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-pencil-alt cursor-pointer"></i>
                  </td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-trash cursor-pointer"></i>
                  </td>
                </tr>
                <tr class="border-b border-gray-200 clickable-row" onclick="window.location.href='#pengemasan-menu';" tabindex="0" role="link" aria-label="2025-03-24, 19.30 to 11.00, Pengemasan">
                  <td class="py-4 px-4">2025-03-24</td>
                  <td class="py-4 px-4">19.30 - 11.00</td>
                  <td class="py-4 px-4">Pengemasan</td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-pencil-alt cursor-pointer"></i>
                  </td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-trash cursor-pointer"></i>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="flex flex-wrap gap-8 justify-center w-full max-w-7xl">
          <!-- Gaji Pekerja Lepas card -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='#gaji-pekerja-lepas-menu';"
            onkeypress="if(event.key==='Enter'){window.location.href='#gaji-pekerja-lepas-menu';}"
            class="bg-white shadow-md w-72 p-8 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 18rem;"
            aria-label="Gaji Pekerja Lepas, 2.000.000, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-3">GAJI PEKERJA LEPAS</h2>
            <div class="text-4xl font-normal leading-none">2.000.000</div>
          </div>

          <!-- Produksi card -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='#produksi-menu';"
            onkeypress="if(event.key==='Enter'){window.location.href='#produksi-menu';}"
            class="bg-white shadow-md w-56 p-8 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 14rem;"
            aria-label="Produksi, 400 Kg, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-3">PRODUKSI</h2>
            <div class="text-5xl font-normal leading-none flex items-center">
              400<span class="text-xl font-normal ml-1">Kg</span>
            </div>
          </div>

          <!-- Stok Harian card -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='#stok-harian-menu';"
            onkeypress="if(event.key==='Enter'){window.location.href='#stok-harian-menu';}"
            class="bg-white shadow-md w-56 p-8 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 14rem;"
            aria-label="Stok Harian, 400 Kg, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-3">STOK HARIAN</h2>
            <div class="text-5xl font-normal leading-none flex items-center">
              400<span class="text-xl font-normal ml-1">Kg</span>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
