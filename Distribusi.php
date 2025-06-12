<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Distribusi dan Permintaan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    body {
      font-family: 'Roboto', sans-serif;
    }
  </style>
</head>
<body class="bg-white">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 border-r border-gray-300 flex flex-col p-6">
      <div class="mb-10 flex justify-center">
        <?php
          // Ganti 'logo.png' dengan path file logo Anda
          $logoPath = 'logo.png';
          if (file_exists($logoPath)) {
            echo '<img src="' . $logoPath . '" alt="Logo perusahaan, tempat untuk memasukkan foto logo" class="w-32 h-auto object-contain" />';
          } else {
            echo '<div class="w-32 h-32 border border-gray-300 flex items-center justify-center text-gray-400 text-center text-sm">Tempat memasukkan foto logo</div>';
          }
        ?>
      </div>
      <button class="mb-4 w-full py-3 rounded-lg border border-gray-300 shadow-sm text-center text-base text-black hover:shadow-md transition-shadow">
        Dashboard
      </button>
      <button class="mb-4 w-full py-3 rounded-lg border border-gray-300 shadow-sm text-center text-base text-black hover:shadow-md transition-shadow">
        Produksi
      </button>
      <button class="mb-4 w-full py-3 rounded-lg border border-gray-300 shadow-sm text-center text-base text-black hover:shadow-md transition-shadow">
        Stok
      </button>
      <button class="mb-4 w-full py-3 rounded-lg border border-gray-300 shadow-sm text-center text-base text-black hover:shadow-md transition-shadow">
        Pekerja Lepas
      </button>
      <button class="mb-4 w-full py-3 rounded-lg border border-gray-300 shadow-sm text-center text-base text-gray-500 bg-gray-300 cursor-not-allowed" disabled>
        Distribusi dan Permintaan
      </button>
      <button class="w-full py-3 rounded-lg border border-gray-300 shadow-sm text-center text-base text-black hover:shadow-md transition-shadow">
        Laporan
      </button>
    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col">
      <header class="bg-blue-700 text-white px-8 py-6 shadow-md">
        <h1 class="text-xl font-normal">DISTRIBUSI DAN PERMINTAAN</h1>
      </header>

      <section class="flex-1 p-6">
        <button
          class="mb-4 inline-flex items-center gap-2 bg-blue-700 text-white text-sm font-normal px-4 py-2 rounded shadow hover:bg-blue-800 transition-colors"
        >
          <i class="fas fa-plus"></i> Input Pesanan
        </button>

        <div class="overflow-x-auto border border-gray-300 rounded shadow-sm">
          <table class="min-w-full text-sm text-left">
            <thead class="bg-blue-200 text-gray-900">
              <tr>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">No.</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Nama Distributor</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Alamat</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Nama Produk</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Jumlah</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Tanggal</th>
                <th class="px-4 py-2 font-normal">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white min-h-[200px]">
              <tr>
                <td colspan="7" class="h-48"></td>
              </tr>
              <tr class="text-right">
                <td colspan="7" class="pr-4 space-x-2">
                  <button class="bg-blue-700 text-white text-xs px-3 py-1 rounded hover:bg-blue-800 transition-colors">Edit</button>
                  <button class="bg-blue-700 text-white text-xs px-3 py-1 rounded hover:bg-blue-800 transition-colors">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
</body>
</html>