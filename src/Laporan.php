<?php
$koneksi = new mysqli("localhost", "root", "", "salsa_ff");

// ===== Default Value =====
$kategori = $_GET['kategori'] ?? 'semua';
$periode = $_GET['periode'] ?? 'bulanan';
$tanggal = $_GET['tanggal'] ?? date('Y-m-01');
$data = [];
$bulan_ini = date('Y-m-01');
$bulan_akhir = date('Y-m-t');

// ===== Fungsi =====
function getTanggalAkhir($periode, $tanggal) {
    switch ($periode) {
        case 'harian': return date('Y-m-d', strtotime($tanggal . ' +1 day'));
        case 'mingguan': return date('Y-m-d', strtotime($tanggal . ' +7 days'));
        case 'bulanan': return date('Y-m-t', strtotime($tanggal));
        default: return $tanggal;
    }
}

// ===== QUERY SUMMARY “SEMUA” =====
function getSummary($koneksi, $tanggal, $end) {
    $summary = [];

    // Produksi
    $res = $koneksi->query("SELECT COUNT(*) as total_data, IFNULL(SUM(jumlah_produksi),0) as total_kg 
                            FROM produksi WHERE tgl_produksi BETWEEN '$tanggal' AND '$end'");
    $summary['produksi'] = $res->fetch_assoc();

    // Stok tersedia
    $res = $koneksi->query("SELECT IFNULL(SUM(jumlah_stok),0) as stok_tersedia 
                            FROM stok WHERE status_stok IN ('Tersedia', 'Siap dikemas') AND jumlah_stok > 0");
    $summary['stok'] = $res->fetch_assoc();

    // Distribusi
    $res = $koneksi->query("SELECT COUNT(DISTINCT d.id_distribusi) as total_pesanan, IFNULL(SUM(dd.jumlah_kg),0) as kg_terdistribusi 
                        FROM distribusi d
                        LEFT JOIN distribusi_detail dd ON d.id_distribusi = dd.id_distribusi
                        WHERE d.tanggal_distribusi BETWEEN '$tanggal' AND '$end'");
    $summary['distribusi'] = $res->fetch_assoc();


    // Gaji
    $res = $koneksi->query("SELECT IFNULL(SUM(total_gaji),0) as total_gaji FROM riwayat_gaji 
                            WHERE tanggal BETWEEN '$tanggal' AND '$end'");
    $summary['gaji'] = $res->fetch_assoc();

    // Pekerja
    $res = $koneksi->query("SELECT COUNT(*) as total_pekerja FROM pekerja_lepas");
    $summary['pekerja'] = $res->fetch_assoc();

    // Jadwal
    $res = $koneksi->query("SELECT COUNT(*) as total_jadwal FROM jadwal WHERE tanggal BETWEEN '$tanggal' AND '$end'");
    $summary['jadwal'] = $res->fetch_assoc();

    return $summary;
}

if ($kategori == 'semua') {
    $periode_now = getTanggalAkhir($periode, $tanggal);
    $summary = getSummary($koneksi, $tanggal, $periode_now);
} elseif ($kategori == 'jadwal') {
    $end = getTanggalAkhir($periode, $tanggal);
    $query = "SELECT * FROM jadwal WHERE tanggal BETWEEN '$tanggal' AND '$end' ORDER BY tanggal ASC";
    $data = [];
    $result = $koneksi->query($query);
    while ($row = $result->fetch_assoc()) $data[] = $row;
} else if ($kategori && $periode && $tanggal) {
    $end = getTanggalAkhir($periode, $tanggal);
    switch ($kategori) {
        case 'produksi':
            $query = "SELECT pr.id_produksi, p.nama_produk, pr.jumlah_produksi, pr.tgl_produksi
                      FROM produksi pr
                      JOIN produk p ON pr.id_produk = p.id_produk
                      WHERE pr.tgl_produksi BETWEEN '$tanggal' AND '$end'";
            break;
        case 'stok':
            $query = "SELECT s.id_stok, s.id_produk, p.nama_produk, s.status_stok, s.jumlah_stok, s.id_produksi, s.id_admin
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
            $query = "SELECT d.*, 
                        GROUP_CONCAT(CONCAT(pd.id_produk, ': ', pr.nama_produk, ' ', pd.jumlah_kg, 'kg') SEPARATOR '; ') AS detail_produk
                      FROM distribusi d
                      LEFT JOIN distribusi_detail pd ON d.id_distribusi = pd.id_distribusi
                      LEFT JOIN produk pr ON pd.id_produk = pr.id_produk
                      WHERE d.tanggal_distribusi BETWEEN '$tanggal' AND '$end'
                      GROUP BY d.id_distribusi";
            break;
        default:
            $query = "";
    }

    if (!empty($query)) {
        $result = $koneksi->query($query);
        while ($row = $result->fetch_assoc()) $data[] = $row;
    }
}
?>

<main class="flex-1 bg-gray-100 p-6">
  <section class="bg-white p-6 rounded-md shadow-md">
    <form method="GET" class="flex flex-wrap gap-4 items-end mb-6">
      <input type="hidden" name="page" value="laporan">
      <div class="flex flex-col">
        <label class="text-sm font-medium text-gray-600">Kategori</label>
        <select name="kategori" required class="border border-gray-300 px-3 py-2 rounded w-56" onchange="this.form.submit()">
          <option value="semua" <?= $kategori == 'semua' ? 'selected' : '' ?>>Semua</option>
          <option value="produksi" <?= $kategori == 'produksi' ? 'selected' : '' ?>>Produksi</option>
          <option value="stok" <?= $kategori == 'stok' ? 'selected' : '' ?>>Stok</option>
          <option value="pekerja_lepas" <?= $kategori == 'pekerja_lepas' ? 'selected' : '' ?>>Pekerja Lepas</option>
          <option value="distribusi" <?= $kategori == 'distribusi' ? 'selected' : '' ?>>Distribusi</option>
          <option value="jadwal" <?= $kategori == 'jadwal' ? 'selected' : '' ?>>Jadwal</option>
        </select>
      </div>
      <div class="flex flex-col">
        <label class="text-sm font-medium text-gray-600">Periode</label>
        <select name="periode" required class="border border-gray-300 px-3 py-2 rounded w-56" onchange="this.form.submit()">
          <option value="harian" <?= $periode == 'harian' ? 'selected' : '' ?>>Harian</option>
          <option value="mingguan" <?= $periode == 'mingguan' ? 'selected' : '' ?>>Mingguan</option>
          <option value="bulanan" <?= $periode == 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
        </select>
      </div>
      <div class="flex flex-col">
        <label class="text-sm font-medium text-gray-600">Tanggal Awal</label>
        <input type="date" name="tanggal" value="<?= $tanggal ?>" required class="border border-gray-300 px-3 py-2 rounded w-56" onchange="this.form.submit()">
      </div>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-1">
        Lihat Laporan
      </button>
    </form>

    <?php if ($kategori == 'semua'): ?>
      <div>
        <h3 class="text-lg font-bold mb-3 text-gray-700">Ringkasan Bulan Ini</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
          <div class="bg-blue-100 p-4 rounded shadow">
            <strong>Total Produksi:</strong><br><?= number_format($summary['produksi']['total_kg']) ?> Kg (<?= $summary['produksi']['total_data'] ?> data)
          </div>
          <div class="bg-yellow-100 p-4 rounded shadow">
            <strong>Stok Tersedia:</strong><br><?= number_format($summary['stok']['stok_tersedia']) ?> Kg
          </div>
          <div class="bg-green-100 p-4 rounded shadow">
            <strong>Distribusi:</strong><br><?= number_format($summary['distribusi']['kg_terdistribusi']) ?> Kg (<?= $summary['distribusi']['total_pesanan'] ?> pesanan)
          </div>
          <div class="bg-purple-100 p-4 rounded shadow">
            <strong>Total Gaji Dibayarkan:</strong><br>Rp <?= number_format($summary['gaji']['total_gaji'], 0, ',', '.') ?>
          </div>
          <div class="bg-gray-100 p-4 rounded shadow">
            <strong>Total Pekerja Lepas:</strong><br><?= $summary['pekerja']['total_pekerja'] ?> Orang
          </div>
          <div class="bg-pink-100 p-4 rounded shadow">
            <strong>Jumlah Jadwal:</strong><br><?= $summary['jadwal']['total_jadwal'] ?> Kegiatan
          </div>
        </div>
      </div>
    <?php elseif ($kategori == 'jadwal'): ?>
      <div>
        <h3 class="text-lg font-bold mb-3 text-gray-700">Jadwal Kegiatan</h3>
        <div class="overflow-x-auto bg-white rounded shadow">
          <table class="min-w-full border text-sm text-left">
            <thead class="bg-blue-200 text-gray-900">
              <tr>
                <th class="border border-gray-300 px-3 py-2">No.</th>
                <th class="border border-gray-300 px-3 py-2">Tanggal</th>
                <th class="border border-gray-300 px-3 py-2">Waktu</th>
                <th class="border border-gray-300 px-3 py-2">Jenis Kegiatan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data as $index => $d): ?>
                <tr>
                  <td class="border border-gray-300 px-3 py-2"><?= $index + 1 ?>.</td>
                  <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars(date('d-m-Y', strtotime($d['tanggal']))) ?></td>
                  <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars(substr($d['waktu_mulai'],0,5)) ?> - <?= htmlspecialchars(substr($d['waktu_selesai'],0,5)) ?></td>
                  <td class="border border-gray-300 px-3 py-2"><?= htmlspecialchars($d['jenis_kegiatan']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php elseif ($data): ?>
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
      </div>
    <?php elseif ($kategori): ?>
      <p class="mt-4 italic text-center text-gray-500">Data tidak ditemukan untuk kategori dan periode tersebut.</p>
    <?php endif; ?>
  </section>
</main>
