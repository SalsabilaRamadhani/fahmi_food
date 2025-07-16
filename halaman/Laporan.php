<?php
$koneksi = new mysqli("localhost", "root", "", "salsa_db");

$kategori = $_GET['kategori'] ?? null;
$periode = $_GET['periode'] ?? null;
$tanggal = $_GET['tanggal'] ?? null;
$data = [];

function getTanggalAkhir($periode, $tanggal) {
    switch ($periode) {
        case 'harian': return date('Y-m-d', strtotime($tanggal . ' +1 day'));
        case 'mingguan': return date('Y-m-d', strtotime($tanggal . ' +7 days'));
        case 'bulanan': return date('Y-m-t', strtotime($tanggal));
        default: return $tanggal;
    }
}

if ($kategori && $periode && $tanggal) {
    $end = getTanggalAkhir($periode, $tanggal);
    switch ($kategori) {
        case 'produksi':
            $query = "SELECT pr.id_produksi, p.nama_produk AS nama_produk, pr.jumlah_produksi AS jumlah, pr.tgl_produksi AS tanggal 
          FROM produksi pr 
          JOIN produk p ON pr.id_produk = p.id_produk 
          WHERE pr.tgl_produksi BETWEEN '$tanggal' AND '$end'";
          break;
        case 'stok':
            $query = "SELECT s.id_stok, s.id_produk, p.nama_produk, s.status_stok, s.jumlah, s.id_admin
                      FROM stok s 
                      JOIN produk p ON s.id_produk = p.id_produk
                      ORDER BY s.id_stok ASC";
            break;
        case 'pekerja_lepas':
            $query = "SELECT rl.*, pl.nama_pekerja 
                      FROM riwayat_gaji rl
                      JOIN pekerja_lepas pl ON rl.id_pekerja = pl.id_pekerja
                      WHERE rl.tanggal BETWEEN '$tanggal' AND '$end'";
            break;
        case 'distribusi':
            $query = "SELECT * FROM distribusi WHERE tgl_pesanan BETWEEN '$tanggal' AND '$end'";
            break;
        default:
            $query = "";
    }

    if ($query !== "") {
        $result = $koneksi->query($query);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
}
?>

<main class="flex-1 bg-gray-100 p-6">
  <section class="bg-white p-6 rounded-md shadow-md">

    <form method="GET" class="flex flex-wrap gap-4 items-end mb-6">
      <input type="hidden" name="page" value="laporan">

      <div class="flex flex-col">
        <label class="text-sm font-medium text-gray-600">Kategori</label>
        <select name="kategori" required class="border border-gray-300 px-3 py-2 rounded w-56">
          <option value="">-- Pilih --</option>
          <option value="produksi" <?= $kategori == 'produksi' ? 'selected' : '' ?>>Produksi</option>
          <option value="stok" <?= $kategori == 'stok' ? 'selected' : '' ?>>Stok</option>
          <option value="pekerja_lepas" <?= $kategori == 'pekerja_lepas' ? 'selected' : '' ?>>Pekerja Lepas</option>
          <option value="distribusi" <?= $kategori == 'distribusi' ? 'selected' : '' ?>>Distribusi</option>
        </select>
      </div>

      <div class="flex flex-col">
        <label class="text-sm font-medium text-gray-600">Periode</label>
        <select name="periode" required class="border border-gray-300 px-3 py-2 rounded w-56">
          <option value="">-- Pilih --</option>
          <option value="harian" <?= $periode == 'harian' ? 'selected' : '' ?>>Harian</option>
          <option value="mingguan" <?= $periode == 'mingguan' ? 'selected' : '' ?>>Mingguan</option>
          <option value="bulanan" <?= $periode == 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
        </select>
      </div>

      <div class="flex flex-col">
        <label class="text-sm font-medium text-gray-600">Tanggal Awal</label>
        <input type="date" name="tanggal" value="<?= $tanggal ?>" required class="border border-gray-300 px-3 py-2 rounded w-56">
      </div>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-1">
        Lihat Laporan
      </button>
    </form>

    <?php if ($data): ?>
      <div>
        <h3 class="text-lg font-bold mb-3 text-gray-700">Hasil Laporan: <?= ucfirst($kategori) ?></h3>

        <div class="overflow-x-auto bg-white rounded shadow">
          <table class="min-w-full border text-sm text-left">
            <thead class="bg-blue-200 text-gray-900">
              <tr>
                <th class="border border-gray-300 px-3 py-2">No.</th>
                <?php foreach(array_keys($data[0]) as $col): ?>
                  <th class="border border-gray-300 px-3 py-2">
                    <?= htmlspecialchars(ucwords(str_replace('_', ' ', $col))) ?>
                  </th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data as $index => $d): ?>
                <tr class="hover:bg-blue-50">
                  <td class="border border-gray-300 px-3 py-2"><?= $index + 1 ?>.</td>
                  <?php foreach($d as $val): ?>
                    <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($val) ?></td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <form method="GET" action="laporan/laporan_pdf.php" target="_blank" class="mt-4">
          <input type="hidden" name="kategori" value="<?= $kategori ?>">
          <input type="hidden" name="periode" value="<?= $periode ?>">
          <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
          <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">
            Cetak PDF
          </button>
        </form>
      </div>
    <?php elseif ($kategori): ?>
      <p class="mt-4 italic text-center text-gray-500">Data tidak ditemukan untuk kategori dan periode tersebut.</p>
    <?php endif; ?>
  </section>
</main>
