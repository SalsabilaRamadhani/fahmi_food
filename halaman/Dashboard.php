<php? 
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Location: ../Index.php?page=dashboard");
    exit;
}
?>

<style>
    .clickable-card {
      cursor: pointer;
    }
    .clickable-row:hover {
      background-color: #f3f4f6;
    }
    /* Scrollable tbody with max height */
    .scrollable-tbody {
      display: block;
      max-height: 8rem; /* about 2 rows height */
      overflow-y: auto;
    }
    /* Make thead and tbody rows align */
    table thead, table tbody tr {
      display: table;
      width: 100%;
      table-layout: fixed;
    }
    table tbody {
      display: block;
    }
  </style>
      <!-- Content -->
      <section class="flex-1 p-8 space-y-8 flex flex-col items-center">
        <div class="flex flex-wrap gap-8 justify-center w-full max-w-7xl items-center">
          <!-- Pesanan card with total from Distribusi.php -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='halaman/Distribusi.php';"
            onkeypress="if(event.key==='Enter'){window.location.href='halaman/Distribusi.php';}"
            class="bg-white shadow-md p-6 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 14rem; max-width: 14rem;"
            aria-label="Pesanan, total permintaan, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-4">PESANAN</h2>
            <div class="text-5xl font-normal text-center">
              <?php
                $totalPesanan = 400; // example static value
                echo $totalPesanan;
              ?>
              <span class="text-xl font-normal ml-1">Kg</span>
            </div>
          </div>

          <!-- Jadwal Harian card with scrollable tbody -->
          <div
            class="bg-white shadow-md p-8 flex-1 max-w-4xl min-w-[24rem] rounded"
          >
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-[#2e49b0] font-semibold text-lg select-none">JADWAL HARIAN</h2>
              <button id="openFormBtn" aria-label="Add new schedule" class="text-black hover:text-gray-700 text-2xl font-bold leading-none">
                <i class="fas fa-plus cursor-pointer"></i>
              </button>
            </div>
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
              <tbody class="scrollable-tbody">
                <tr class="border-b border-gray-200 clickable-row" tabindex="0" role="link" aria-label="2025-03-24, 07.30 to 01.00, Produksi">
                  <td class="py-4 px-4">2025-03-24</td>
                  <td class="py-4 px-4">07.30 - 01.00</td>
                  <td class="py-4 px-4">Produksi</td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-pencil-alt cursor-pointer editBtn" tabindex="0" role="button" aria-label="Edit schedule 2025-03-24 Produksi"></i>
                  </td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-trash cursor-pointer deleteBtn" tabindex="0" role="button" aria-label="Delete schedule 2025-03-24 Produksi"></i>
                  </td>
                </tr>
                <tr class="border-b border-gray-200 clickable-row" tabindex="0" role="link" aria-label="2025-03-24, 19.30 to 11.00, Pengemasan">
                  <td class="py-4 px-4">2025-03-24</td>
                  <td class="py-4 px-4">19.30 - 11.00</td>
                  <td class="py-4 px-4">Pengemasan</td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-pencil-alt cursor-pointer editBtn" tabindex="0" role="button" aria-label="Edit schedule 2025-03-24 Pengemasan"></i>
                  </td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-trash cursor-pointer deleteBtn" tabindex="0" role="button" aria-label="Delete schedule 2025-03-24 Pengemasan"></i>
                  </td>
                </tr>
                <tr class="border-b border-gray-200 clickable-row" tabindex="0" role="link" aria-label="2025-03-25, 08.00 to 12.00, Distribusi">
                  <td class="py-4 px-4">2025-03-25</td>
                  <td class="py-4 px-4">08.00 - 12.00</td>
                  <td class="py-4 px-4">Distribusi</td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-pencil-alt cursor-pointer editBtn" tabindex="0" role="button" aria-label="Edit schedule 2025-03-25 Distribusi"></i>
                  </td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-trash cursor-pointer deleteBtn" tabindex="0" role="button" aria-label="Delete schedule 2025-03-25 Distribusi"></i>
                  </td>
                </tr>
                <tr class="border-b border-gray-200 clickable-row" tabindex="0" role="link" aria-label="2025-03-26, 13.00 to 17.00, Produksi">
                  <td class="py-4 px-4">2025-03-26</td>
                  <td class="py-4 px-4">13.00 - 17.00</td>
                  <td class="py-4 px-4">Produksi</td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-pencil-alt cursor-pointer editBtn" tabindex="0" role="button" aria-label="Edit schedule 2025-03-26 Produksi"></i>
                  </td>
                  <td class="py-4 px-4 w-10 text-center">
                    <i class="fas fa-trash cursor-pointer deleteBtn" tabindex="0" role="button" aria-label="Delete schedule 2025-03-26 Produksi"></i>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="flex flex-wrap gap-8 justify-center w-full max-w-7xl">
          <!-- Gaji Pekerja Lepas card with total from Pekerja.php -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='halaman/Pekerja.php';"
            onkeypress="if(event.key==='Enter'){window.location.href='halaman/Pekerja.php';}"
            class="bg-white shadow-md w-72 p-8 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 18rem;"
            aria-label="Gaji Pekerja Lepas, total gaji, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-3">GAJI PEKERJA LEPAS</h2>
            <div class="text-4xl font-normal leading-none">
              <?php
                $totalGaji = "2.000.000"; // example static value
                echo $totalGaji;
              ?>
            </div>
          </div>

          <!-- Produksi card with total from Produksi.php -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='halaman/Produksi.php';"
            onkeypress="if(event.key==='Enter'){window.location.href='halaman/Produksi.php';}"
            class="bg-white shadow-md w-56 p-8 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 14rem;"
            aria-label="Produksi, total produksi, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-3">PRODUKSI</h2>
            <div class="text-5xl font-normal leading-none flex items-center">
              <?php
                $totalProduksi = 400; // example static value
                echo $totalProduksi;
              ?>
              <span class="text-xl font-normal ml-1">Kg</span>
            </div>
          </div>

          <!-- Stok Harian card with total from Stok.php -->
          <div
            role="button"
            tabindex="0"
            onclick="window.location.href='halaman/Stok.php';"
            onkeypress="if(event.key==='Enter'){window.location.href='halaman/Stok.php';}"
            class="bg-white shadow-md w-56 p-8 flex flex-col justify-between rounded clickable-card select-none"
            style="min-width: 14rem;"
            aria-label="Stok Harian, total stok, click to open menu"
          >
            <h2 class="text-[#2e49b0] font-semibold text-lg mb-3">STOK HARIAN</h2>
            <div class="text-5xl font-normal leading-none flex items-center">
              <?php
                $totalStok = 400; // example static value
                echo $totalStok;
              ?>
              <span class="text-xl font-normal ml-1">Kg</span>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>

  <!-- Modal overlay and Add/Edit form container -->
  <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <form id="jadwalForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="bg-white shadow-md rounded-md p-6 w-72 relative" aria-modal="true" role="dialog" aria-labelledby="formTitle">
      <h2 id="formTitle" class="text-black font-semibold text-lg mb-4">Input Jadwal</h2>
      <input
        type="date"
        name="tanggal"
        required
        class="w-full mb-4 px-3 py-2 border border-gray-300 rounded-md text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
        aria-label="Tanggal"
      />
      <div class="w-full mb-4 flex space-x-2">
        <input
          type="time"
          name="jam_mulai"
          required
          class="flex-1 px-3 py-2 border border-gray-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
          aria-label="Jam mulai"
        />
        <span class="flex items-center text-gray-500 select-none">-</span>
        <input
          type="time"
          name="jam_selesai"
          required
          class="flex-1 px-3 py-2 border border-gray-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
          aria-label="Jam selesai"
        />
      </div>
      <select
        name="jenis_kegiatan"
        required
        class="w-full mb-4 px-3 py-2 border border-gray-300 rounded-md text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
        aria-label="Jenis Kegiatan"
      >
        <option value="" disabled selected>Jenis Kegiatan</option>
        <option value="Produksi">Produksi</option>
        <option value="Pengemasan">Pengemasan</option>
        <option value="Distribusi">Distribusi</option>
      </select>
      <div class="flex space-x-4">
        <button
          type="submit"
          name="submit"
          class="bg-blue-700 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600"
        >
          Simpan
        </button>
        <button
          type="button"
          id="cancelBtn"
          class="border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400"
        >
          Batal
        </button>
      </div>
    </form>
  </div>

  <!-- Delete confirmation dialog -->
  <div id="deleteDialog" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="w-[280px] border border-gray-300 shadow-md p-5 bg-white rounded-md">
      <h2 class="font-semibold text-black mb-3 text-base">Hapus Data</h2>
      <p class="text-black mb-5 text-sm leading-relaxed">Apakah anda yakin akan menghapus data ini?</p>
      <div class="flex space-x-3">
        <button id="confirmDeleteBtn" class="bg-[#B22222] text-white text-sm font-normal rounded px-4 py-2">Hapus</button>
        <button id="cancelDeleteBtn" class="border border-gray-400 text-black text-sm font-normal rounded px-4 py-2">Batal</button>
      </div>
    </div>
  </div>

  <script>
    const openFormBtn = document.getElementById('openFormBtn');
    const modalOverlay = document.getElementById('modalOverlay');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('jadwalForm');
    const formTitle = document.getElementById('formTitle');

    const deleteDialog = document.getElementById('deleteDialog');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

    let rowToDelete = null;

    // Open Add form
    openFormBtn.addEventListener('click', () => {
      formTitle.textContent = 'Input Jadwal';
      form.reset();
      form.tanggal.removeAttribute('value');
      form.jam_mulai.removeAttribute('value');
      form.jam_selesai.removeAttribute('value');
      form.jenis_kegiatan.value = '';
      modalOverlay.classList.remove('hidden');
    });

    // Close modal
    cancelBtn.addEventListener('click', () => {
      modalOverlay.classList.add('hidden');
      form.reset();
    });

    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) {
        modalOverlay.classList.add('hidden');
        form.reset();
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !modalOverlay.classList.contains('hidden')) {
        modalOverlay.classList.add('hidden');
        form.reset();
      }
      if (e.key === 'Escape' && !deleteDialog.classList.contains('hidden')) {
        deleteDialog.classList.add('hidden');
        rowToDelete = null;
      }
    });

    // Edit buttons
    const editButtons = document.querySelectorAll('.editBtn');
    editButtons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const row = btn.closest('tr');
        const tanggal = row.children[0].textContent.trim();
        const waktu = row.children[1].textContent.trim();
        const jenis = row.children[2].textContent.trim();

        let jamMulai = '', jamSelesai = '';
        const waktuParts = waktu.split('-').map(s => s.trim());
        if (waktuParts.length === 2) {
          jamMulai = waktuParts[0].replace('.', ':');
          jamSelesai = waktuParts[1].replace('.', ':');
        }

        formTitle.textContent = 'Edit Jadwal';
        form.tanggal.value = tanggal;
        form.jam_mulai.value = jamMulai;
        form.jam_selesai.value = jamSelesai;
        form.jenis_kegiatan.value = jenis;

        modalOverlay.classList.remove('hidden');
      });

      btn.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          btn.click();
        }
      });
    });

    // Delete buttons
    const deleteButtons = document.querySelectorAll('.deleteBtn');
    deleteButtons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        rowToDelete = btn.closest('tr');
        deleteDialog.classList.remove('hidden');
      });

      btn.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          btn.click();
        }
      });
    });

    // Confirm delete
    confirmDeleteBtn.addEventListener('click', () => {
      if (rowToDelete) {
        rowToDelete.remove();
        rowToDelete = null;
      }
      deleteDialog.classList.add('hidden');
    });

    // Cancel delete
    cancelDeleteBtn.addEventListener('click', () => {
      deleteDialog.classList.add('hidden');
      rowToDelete = null;
    });

    // Close delete dialog on clicking outside
    deleteDialog.addEventListener('click', (e) => {
      if (e.target === deleteDialog) {
        deleteDialog.classList.add('hidden');
        rowToDelete = null;
      }
    });
  </script>