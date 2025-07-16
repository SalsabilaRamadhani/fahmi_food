<?php
session_start();

// Perbaikan logika login:
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

if (!isset($_SESSION['username']) && ($page !== 'login' || $_SERVER['REQUEST_METHOD'] !== 'POST')) {
    header("Location: Login.php?page=login");
    exit();
}

// Daftar halaman
$halaman = [
  'login'     => 'Login.php',
  'dashboard' => 'halaman/Dashboard.php',
  'produksi'  => 'halaman/Produksi.php',
  'stok'      => 'halaman/Stok.php',
  'pekerja'   => 'halaman/Pekerja.php',
  'distribusi'=> 'halaman/Distribusi.php',
  'laporan'   => 'halaman/Laporan.php',
  'riwayat_gaji' => 'halaman/RiwayatGaji.php',
];

$logoPath = 'assets/logo.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= ucfirst($page) ?> - Fahmi Food</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-white font-sans">

<?php if ($page !== 'login'): ?>
<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="w-52 border-r border-gray-300 flex flex-col p-4 bg-white sticky top-0 h-screen">
    <div class="mb-10 flex justify-center">
      <?php if (file_exists($logoPath)) {
        echo '<img src="' . htmlspecialchars($logoPath) . '" alt="Logo perusahaan" class="max-h-20 w-16 object-contain" />';
      } else {
        echo '<div class="w-full h-20 flex items-center justify-center border border-gray-300 rounded text-gray-400 text-sm">Logo belum diupload</div>';
      } ?>
    </div>
    <nav class="flex flex-col space-y-3 text-sm">
      <?php
      $menuItems = [
        'dashboard' => 'Dashboard',
        'produksi' => 'Produksi',
        'stok' => 'Stok',
        'pekerja' => 'Pekerja Lepas',
        'distribusi' => 'Distribusi dan Permintaan',
        'laporan' => 'Laporan',
      ];

      foreach ($menuItems as $key => $label) {
        $isActive = ($page === $key) ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300';
        echo "<a href='Index.php?page=$key' class='text-center py-2 rounded border $isActive shadow-sm text-black transition-all hover:bg-blue-100 hover:border-blue-300'>$label</a>";
      }
      ?>
      <a href="Logout.php" class="text-center py-2 rounded border border-red-300 shadow-sm text-red-600 transition-all hover:bg-red-100 hover:border-red-400">Logout</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 flex flex-col">
    <header class="sticky top-0 bg-[#2f49b7] text-white px-8 py-6 shadow-md z-40">
      <h1 class="text-xl font-normal"><?= ucfirst($page) ?></h1>
    </header>

    <div class="p-8 overflow-y-auto">
      <?php
      if (array_key_exists($page, $halaman)) {
        include $halaman[$page];
      } else {
        echo "<p class='text-red-500'>Halaman tidak ditemukan.</p>";
      }
      ?>
    </div>
  </main>
</div>
<?php else: ?>
  <?php include $halaman[$page]; ?>
<?php endif; ?>

</body>
</html>
