<?php


// --- Dummy Data Produksi
$produksi = [
  ['id' => 'P001', 'produk' => 'Agar Pita', 'jumlah' => 100],
  ['id' => 'P002', 'produk' => 'Agar Polos', 'jumlah' => 80],
];
$totalProduksi = count($produksi);

// --- Dummy Data Stok
$stok = [
  ['status' => 'Siap Dipacking', 'jumlah' => 249],
  ['status' => 'Sudah DIpacking', 'jumlah' => 249],
  ['status' => 'Reject', 'jumlah' => 1],
  ['status' => 'Siap Dikemas', 'jumlah' => 250],
];

// --- Dummy Data Pekerja
$pekerja = [
  ['nama' => 'Ian Sopian', 'gaji' => 250000, 'status' => 'Dibayar'],
  ['nama' => 'Dinda', 'gaji' => 300000, 'status' => 'Belum Dibayar'],
];

$total_gaji = 0;
$total_dibayar = 0;
$total_belum = 0;
foreach ($pekerja as $p) {
  $total_gaji += $p['gaji'];
  if ($p['status'] == 'Dibayar') {
    $total_dibayar += $p['gaji'];
  } else {
    $total_belum += $p['gaji'];
  }
}
?>

<section class="p-6 space-y-8">

  <!-- Laporan Produksi -->
  <div>
    <h2 class="text-lg font-bold mb-3 text-blue-700">Laporan Produksi</h2>
    <table class="w-full border border-gray-300 text-sm">
      <thead class="bg-blue-200 text-black">
        <tr>
          <th class="border border-gray-300 px-3 py-2 text-left">Total Produksi</th>
          <th class="border border-gray-300 px-3 py-2 text-left">Jumlah Batch</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border border-gray-300 px-3 py-2">Produk Agar-agar</td>
          <td class="border border-gray-300 px-3 py-2"><?= $totalProduksi ?> batch</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Laporan Stok -->
  <div>
    <h2 class="text-lg font-bold mb-3 text-blue-700">Laporan Stok Produk</h2>
    <table class="w-full border border-gray-300 text-sm">
      <thead class="bg-blue-200 text-black">
        <tr>
          <th class="border border-gray-300 px-3 py-2">No.</th>
          <th class="border border-gray-300 px-3 py-2 text-left">Status Stok</th>
          <th class="border border-gray-300 px-3 py-2 text-left">Total (kg)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($stok as $i => $s): ?>
        <tr>
          <td class="border border-gray-300 px-3 py-2"><?= $i+1 ?>.</td>
          <td class="border border-gray-300 px-3 py-2"><?= $s['status'] ?></td>
          <td class="border border-gray-300 px-3 py-2"><?= $s['jumlah'] ?> kg</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Laporan Gaji Pekerja -->
  <div>
    <h2 class="text-lg font-bold mb-3 text-blue-700">Laporan Gaji Pekerja</h2>
    <table class="w-full border border-gray-300 text-sm">
      <thead class="bg-blue-200 text-black">
        <tr>
          <th class="border border-gray-300 px-3 py-2 text-left">Keterangan</th>
          <th class="border border-gray-300 px-3 py-2 text-left">Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border border-gray-300 px-3 py-2">Total Gaji</td>
          <td class="border border-gray-300 px-3 py-2">Rp. <?= number_format($total_gaji, 0, ',', '.') ?></td>
        </tr>
        <tr>
          <td class="border border-gray-300 px-3 py-2">Sudah Dibayar</td>
          <td class="border border-gray-300 px-3 py-2">Rp. <?= number_format($total_dibayar, 0, ',', '.') ?></td>
        </tr>
        <tr>
          <td class="border border-gray-300 px-3 py-2">Belum Dibayar</td>
          <td class="border border-gray-300 px-3 py-2">Rp. <?= number_format($total_belum, 0, ',', '.') ?></td>
        </tr>
      </tbody>
    </table>
  </div>

</section>
