<php? session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: Login.php");
  exit;
}
?> 

<!-- Content -->
      <section class="flex-1 p-8 space-y-8 flex flex-col items-center">
        <div class="flex flex-wrap gap-8 justify-center w-full max-w-7xl items-center">
          <!-- Pesanan card with horizontal table sized like produksi card, label removed inside number -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='halaman/Distribusi.php';"
            onkeypress="if(event.key==='Enter'){window.location.href='halaman/Distribusi.php';}"
            class="bg-white shadow-md p-6 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 14rem; max-width: 14rem;"
            aria-label="Pesanan, 400 Kg, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-4">PESANAN</h2>
            <div class="text-5xl font-normal text-center">
              400<span class="text-xl font-normal ml-1">Kg</span>
            </div>
          </div>

          <!-- Jadwal Harian card with clickable rows and bigger table, centered -->
          <div
            class="bg-white shadow-md p-8 flex-1 max-w-4xl min-w-[24rem] rounded"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-6 select-none">JADWAL HARIAN</h2>
            <table class="w-full text-base text-left text-black border border-gray-200 rounded">
              <thead>
                <tr class="border-b border-gray-300">
                  <th class="py-3 px-4 font-semibold">Tanggal</th>
                  <th class="py-3 px-4 font-semibold">Waktu</th>
                  <th class="py-3 px-4 font-semibold">Jenis Kegiatan</th>
                  <th class="py-3 px-4 font-semibold w-10"></th>
                  <th class="py-3 px-4 font-semibold w-10"></th>
                </tr>
              </thead>
              <tbody>
                <tr class="border-b border-gray-200 clickable-row" onclick="window.location.href='#produksi';" tabindex="0" role="link" aria-label="2025-03-24, 07.30 to 01.00, Produksi">
                  <td class="py-4 px-4">2025-03-24</td>
                  <td class="py-4 px-4">07.30 - 01.00</td>
                  <td class="py-4 px-4">Produksi</td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-pencil-alt cursor-pointer"></i>
                  </td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-trash cursor-pointer"></i>
                  </td>
                </tr>
                <tr class="border-b border-gray-200 clickable-row" onclick="window.location.href='#pengemasan-menu';" tabindex="0" role="link" aria-label="2025-03-24, 19.30 to 11.00, Pengemasan">
                  <td class="py-4 px-4">2025-03-24</td>
                  <td class="py-4 px-4">19.30 - 11.00</td>
                  <td class="py-4 px-4">Pengemasan</td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-pencil-alt cursor-pointer"></i>
                  </td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-trash cursor-pointer"></i>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="flex flex-wrap gap-8 justify-center w-full max-w-7xl">
          <!-- Gaji Pekerja Lepas card -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='halaman/Pekerja.php';"
            onkeypress="if(event.key==='Enter'){window.location.href='halaman/Pekerja.php';}"
            class="bg-white shadow-md w-72 p-8 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 18rem;"
            aria-label="Gaji Pekerja Lepas, 2.000.000, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-3">GAJI PEKERJA LEPAS</h2>
            <div class="text-4xl font-normal leading-none">2.000.000</div>
          </div>

          <!-- Produksi card -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='halaman/Produksi.php';"
            onkeypress="if(event.key==='Enter'){window.location.href='halaman/Produksi.php';}"
            class="bg-white shadow-md w-56 p-8 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 14rem;"
            aria-label="Produksi, 400 Kg, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-3">PRODUKSI</h2>
            <div class="text-5xl font-normal leading-none flex items-center">
              400<span class="text-xl font-normal ml-1">Kg</span>
            </div>
          </div>

          <!-- Stok Harian card -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='halaman/Stok.php';"
            onkeypress="if(event.key==='Enter'){window.location.href='halaman/Stok.php';}"
            class="bg-white shadow-md w-56 p-8 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 14rem;"
            aria-label="Stok Harian, 400 Kg, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-3">STOK HARIAN</h2>
            <div class="text-5xl font-normal leading-none flex items-center">
              400<span class="text-xl font-normal ml-1">Kg</span>
            </div>
          </div>
        </div>
      </section>
