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
        <h1 class="text-xl font-normal">Template</h1>
      </header>
      <!-- Content -->
      
    </main>
  </div>
</body>
</html>
