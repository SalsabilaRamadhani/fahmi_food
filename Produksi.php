<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Produksi - Fahmi Food</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body class="bg-white font-sans">
  <div class="flex min-h-screen shadow-md">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-300 flex flex-col">
      <div class="p-6 border-b border-gray-300 flex justify-center items-center">
        <!-- PHP code to display logo image -->
        <?php
          // Replace 'logo.png' with your actual logo file path
          $logoPath = 'logo.png';
          if (file_exists($logoPath)) {
            echo '<img src="' . $logoPath . '" alt="Logo perusahaan Fahmi Food" class="max-w-full max-h-20 object-contain" />';
          } else {
            echo '<div class="text-gray-400 text-center text-sm">Logo belum diupload</div>';
          }
        ?>
      </div>
      <nav class="flex flex-col space-y-4 p-4">
        <button
          type="button"
          class="w-full py-3 rounded border border-gray-300 shadow-sm text-black text-base font-normal hover:bg-gray-50"
        >
          Dashboard
        </button>
        <button
          type="button"
          disabled
          class="w-full py-3 rounded border border-gray-300 bg-[#d1d9f7] text-[#9ca3af] text-base font-normal cursor-not-allowed"
        >
          Produksi
        </button>
        <button
          type="button"
          class="w-full py-3 rounded border border-gray-300 shadow-sm text-black text-base font-normal hover:bg-gray-50"
        >
          Stok
        </button>
        <button
          type="button"
          class="w-full py-3 rounded border border-gray-300 shadow-sm text-black text-base font-normal hover:bg-gray-50"
        >
          Pekerja Lepas
        </button>
        <button
          type="button"
          class="w-full py-3 rounded border border-gray-300 shadow-sm text-black text-base font-normal hover:bg-gray-50"
        >
          Distribusi dan Permintaan
        </button>
        <button
          type="button"
          class="w-full py-3 rounded border border-gray-300 shadow-sm text-black text-base font-normal hover:bg-gray-50"
        >
          Laporan
        </button>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col">
      <header class="bg-[#2e49b0] p-6">
        <h1 class="text-white text-xl font-normal">PRODUKSI</h1>
      </header>

      <section class="p-6 flex flex-col space-y-4">
        <button
          type="button"
          class="inline-flex items-center space-x-2 bg-[#2e49b0] text-white text-sm font-normal px-3 py-2 rounded max-w-max"
        >
          <i class="fas fa-plus"></i>
          <span>Tambah</span>
        </button>

        <table class="w-full border border-gray-300 text-sm">
          <thead>
            <tr class="bg-[#c3d0f0] text-left text-gray-800">
              <th class="px-3 py-2 border border-gray-300 w-12">No.</th>
              <th class="px-3 py-2 border border-gray-300 w-28">ID Produk</th>
              <th class="px-3 py-2 border border-gray-300">Nama Produk</th>
              <th class="px-3 py-2 border border-gray-300 w-40">Tanggal Produksi</th>
              <th class="px-3 py-2 border border-gray-300 w-40">Jumlah Produksi</th>
              <th class="px-3 py-2 border border-gray-300 w-24">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="px-3 py-2 border border-gray-300"></td>
              <td class="px-3 py-2 border border-gray-300">AG01</td>
              <td class="px-3 py-2 border border-gray-300">Agar Pelangi</td>
              <td class="px-3 py-2 border border-gray-300"></td>
              <td class="px-3 py-2 border border-gray-300"></td>
              <td class="px-3 py-2 border border-gray-300 flex space-x-2 justify-end">
                <button
                  type="button"
                  class="bg-[#2e49b0] text-white text-xs px-3 py-1 rounded"
                >
                  Edit
                </button>
                <button
                  type="button"
                  class="bg-[#c8102e] text-white text-xs px-3 py-1 rounded"
                >
                  Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>