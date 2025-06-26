<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Location: ../Index.php?page=laporan");
    exit;
}
?>

<section class="flex-1 p-6">
        <div class="flex flex-wrap items-center justify-between mb-4 gap-4">
          <div class="flex space-x-4">
            <select
              id="periode-select"
              name="periode"
              aria-label="Periode"
              class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#2f49b7] focus:border-[#2f49b7] font-bold"
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
              class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#2f49b7] focus:border-[#2f49b7] font-bold"
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
                <th class="px-4 py-2 border-r border-gray-300 font-bold">No.</th>
                <th class="px-4 py-2 border-r border-gray-300 font-bold">Tanggal</th>
                <th class="px-4 py-2 border-r border-gray-300 font-bold">Jumlah Produksi</th>
                <th class="px-4 py-2 border-r border-gray-300 font-bold">Jumlah Dikemas</th>
                <th class="px-4 py-2 border-r border-gray-300 font-bold">Jumlah Reject</th>
                <th class="px-4 py-2 font-bold">Total Produksi</th>
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