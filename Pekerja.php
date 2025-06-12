<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pekerja Lepas</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body class="bg-white font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 border-r border-gray-300 flex flex-col items-center py-6 px-6 select-none">
      <div class="mb-12 text-center w-32 h-32">
        <?php
          // Ganti 'logo.png' dengan path file logo Anda
          $logoPath = 'logo.png';
          if (file_exists($logoPath)) {
            echo '<img src="' . htmlspecialchars($logoPath) . '" alt="Logo perusahaan" class="w-full h-full object-contain" />';
          } else {
            echo '<div class="w-full h-full flex items-center justify-center border border-gray-300 rounded text-gray-400 text-sm">Logo belum diupload</div>';
          }
        ?>
      </div>
      <nav class="w-full space-y-4">
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
          disabled
          class="w-full py-3 rounded border border-[#3b4ea1] bg-gray-300 text-gray-500 text-base font-normal cursor-not-allowed"
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
          class="w-full py-3 rounded border border-gray-300 shadow-sm text-black text-base font-normal hover:shadow-md transition-shadow"
        >
          Laporan
        </button>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col">
      <header class="bg-[#3b4ea1] text-white px-8 py-6 shadow-md">
        <h1 class="text-xl font-normal">PEKERJA LEPAS</h1>
      </header>

      <section class="flex flex-col p-6 flex-1">
        <div class="flex flex-col sm:flex-row sm:items-center mb-4">
          <button
            type="button"
            class="flex items-center gap-2 bg-[#3b4ea1] text-white text-sm font-normal px-4 py-2 rounded shadow-sm hover:shadow-md transition-shadow mb-3 sm:mb-0"
          >
            <i class="fas fa-plus"></i> Tambah Pekerja
          </button>
          <form class="flex flex-1 sm:justify-end max-w-md">
            <input
              type="text"
              placeholder=""
              class="border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#3b4ea1]"
            />
            <button
              type="submit"
              class="bg-[#3b4ea1] text-white px-4 py-2 rounded-r shadow-sm hover:shadow-md transition-shadow"
            >
              Cari
            </button>
          </form>
        </div>

        <div class="overflow-x-auto shadow border border-gray-300 rounded">
          <table class="min-w-full border-collapse">
            <thead>
              <tr class="bg-[#b9d0f2] text-black text-sm font-normal">
                <th class="border border-gray-300 px-3 py-2 text-left w-12">No.</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-36">Nama</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-36">Kontak</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-48">Alamat</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-28">Gaji</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-20">Ket.</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-36">Aksi</th>
              </tr>
            </thead>
            <tbody class="text-sm text-black font-normal">
              <tr>
                <td class="border border-gray-300 px-3 py-2">1.</td>
                <td class="border border-gray-300 px-3 py-2">Ian Sopian</td>
                <td class="border border-gray-300 px-3 py-2">081222666444</td>
                <td class="border border-gray-300 px-3 py-2">Wonosobo, 03/04</td>
                <td class="border border-gray-300 px-3 py-2">Rp.350.000</td>
                <td class="border border-gray-300 px-3 py-2">Dibayar</td>
                <td class="border border-gray-300 px-3 py-2 space-x-2">
                  <button
                    type="button"
                    class="bg-[#3b4ea1] text-white text-xs px-3 py-1 rounded shadow-sm hover:shadow-md transition-shadow"
                  >
                    Edit
                  </button>
                  <button
                    type="button"
                    class="bg-[#3b4ea1] text-white text-xs px-3 py-1 rounded shadow-sm hover:shadow-md transition-shadow"
                  >
                    Hapus
                  </button>
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