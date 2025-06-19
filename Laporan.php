<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Laporan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
    <style>
    /* Overlay background */
    #modal-overlay {
      background-color: rgba(0, 0, 0, 0.4);
    }
  </style>
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
        <h1 class="text-xl font-normal">LAPORAN</h1>
      </header>

      <section class="flex-1 p-6">
        <div class="flex flex-wrap items-center justify-between mb-4 gap-4">
          <div class="flex space-x-4">
            <select
              id="periode-select"
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
              id="kategori-select"
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
            id="btn-cetak-laporan"
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

      <!-- Modal Overlay -->
      <div id="modal-overlay" class="hidden fixed inset-0 flex items-center justify-center z-50">
        <div class="w-72 bg-white shadow-md rounded border border-gray-300 p-5 relative">
          <h1 class="font-bold text-lg mb-4">Cetak Laporan</h1>
          <form action="process.php" method="POST" class="space-y-4" id="cetakForm">
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
                id="btn-batal"
                class="border border-gray-700 text-gray-700 px-5 py-2 rounded text-sm font-normal shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400"
              >
                Batal
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>

  <script>
    const btnCetak = document.getElementById('btn-cetak-laporan');
    const modalOverlay = document.getElementById('modal-overlay');
    const btnBatal = document.getElementById('btn-batal');
    const cetakForm = document.getElementById('cetakForm');

    btnCetak.addEventListener('click', () => {
      modalOverlay.classList.remove('hidden');
    });

    btnBatal.addEventListener('click', () => {
      modalOverlay.classList.add('hidden');
      cetakForm.reset();
    });

    // Optional: close modal on clicking outside the modal content
    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) {
        modalOverlay.classList.add('hidden');
        cetakForm.reset();
      }
    });
  </script>
</body>
</html>