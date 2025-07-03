<?php
require_once('../libs/tcpdf/tcpdf.php');

$koneksi = new mysqli("localhost", "root", "", "salsa_db");

$kategori = $_GET['kategori'] ?? '';
$periode = $_GET['periode'] ?? '';
$tanggal = $_GET['tanggal'] ?? '';

function getTanggalAkhir($periode, $tanggal) {
    switch ($periode) {
        case 'harian': return date('Y-m-d', strtotime($tanggal . ' +1 day'));
        case 'mingguan': return date('Y-m-d', strtotime($tanggal . ' +7 days'));
        case 'bulanan': return date('Y-m-t', strtotime($tanggal));
        default: return $tanggal;
    }
}

$tgl_akhir = getTanggalAkhir($periode, $tanggal);

switch ($kategori) {
    case 'produksi':
        $query = "SELECT * FROM produksi WHERE tgl_produksi BETWEEN '$tanggal' AND '$tgl_akhir'";
        break;
    case 'stok':
        $query = "SELECT s.id_stok, s.id_produk, p.nama_produk, s.status_stok, s.jumlah
                  FROM stok s
                  JOIN produk p ON s.id_produk = p.id_produk
                  ORDER BY s.id_stok ASC";
        break;
    case 'pekerja_lepas':
        $query = "SELECT rl.*, pl.nama_pekerja FROM riwayat_gaji rl
                  JOIN pekerja_lepas pl ON rl.id_pekerja = pl.id_pekerja
                  WHERE rl.tanggal BETWEEN '$tanggal' AND '$tgl_akhir'";
        break;
    case 'distribusi':
        $query = "SELECT * FROM distribusi WHERE tgl_pesanan BETWEEN '$tanggal' AND '$tgl_akhir'";
        break;
    default:
        die("Kategori tidak valid");
}

$result = $koneksi->query($query);

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle("Laporan $kategori");
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 11);

$html = '
<style>
  table {
    border-collapse: collapse;
    width: 100%;
    font-size: 11pt;
  }
  th {
    background-color: #e0f2fe;
    color: #000;
    font-weight: bold;
    padding: 6px;
    border: 1px solid #333;
    text-align: left;
  }
  td {
    padding: 6px;
    border: 1px solid #333;
    vertical-align: top;
    white-space: normal;
    max-width: 200px;
  }
  tr:nth-child(even) {
    background-color: #f9f9f9;
  }
</style>
<h3 align="center">Laporan '.ucfirst($kategori).' - Periode: '.ucfirst($periode).'</h3>
<table><thead><tr>';

$no = 1;

if ($kategori === 'stok') {
    $html .= '<th>No</th><th>Id Stok</th><th>Id Produk</th><th>Nama Produk</th><th>Jumlah</th><th>Status</th></tr></thead><tbody>';
    while ($row = $result->fetch_assoc()) {
        $html .= "<tr>
            <td>$no</td>
            <td>{$row['id_stok']}</td>
            <td>{$row['id_produk']}</td>
            <td>{$row['nama_produk']}</td>
            <td>{$row['jumlah']} kg</td>
            <td>{$row['status_stok']}</td>
        </tr>";
        $no++;
    }
} elseif ($kategori === 'produksi') {
    $html .= '<th>No</th><th>Nama Produk</th><th>Jumlah</th><th>Tanggal</th></tr></thead><tbody>';
    while ($row = $result->fetch_assoc()) {
        $html .= "<tr>
            <td>$no</td>
            <td>{$row['nama_produk']}</td>
            <td>{$row['jumlah_produksi']}</td>
            <td>{$row['tgl_produksi']}</td>
        </tr>";
        $no++;
    }
} elseif ($kategori === 'pekerja_lepas') {
    $html .= '<th>No</th><th>Nama</th><th>Berat</th><th>Total</th><th>Tanggal</th></tr></thead><tbody>';
    while ($row = $result->fetch_assoc()) {
        $html .= "<tr>
            <td>$no</td>
            <td>{$row['nama_pekerja']}</td>
            <td>{$row['berat_barang_kg']} kg</td>
            <td>Rp ".number_format($row['total_gaji'], 0, ',', '.')."</td>
            <td>{$row['tanggal']}</td>
        </tr>";
        $no++;
    }
} elseif ($kategori === 'distribusi') {
    $html .= '<th>No</th><th>Distributor</th><th>Jumlah</th><th>Tanggal</th><th>Status</th></tr></thead><tbody>';
    while ($row = $result->fetch_assoc()) {
        $html .= "<tr>
            <td>$no</td>
            <td>{$row['nama_distributor']}</td>
            <td>{$row['jumlah_pesanan']}</td>
            <td>{$row['tgl_pesanan']}</td>
            <td>{$row['status_pengiriman']}</td>
        </tr>";
        $no++;
    }
}

$html .= '</tbody></table>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("laporan_{$kategori}.pdf", 'I');
