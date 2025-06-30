<style>
    /* Custom scrollbar for sidebar */
    ::-webkit-scrollbar {
      width: 6px;
    }
    ::-webkit-scrollbar-thumb {
      background-color: rgba(100, 100, 100, 0.3);
      border-radius: 3px;
    }
    /* Overlay styles */
    #overlay, #addWorkerOverlay, #editWorkerOverlay, #deleteOverlay {
      background-color: rgba(0, 0, 0, 0.5);
    }
    /* Delete dialog as layer */
    #deleteDialog {
      background-color: white;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      border-radius: 0.375rem; /* rounded */
      border: 1px solid #d1d5db; /* gray-300 */
      padding: 1.25rem; /* p-5 */
      width: 280px;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 110;
      display: none;
    }
  </style>
  <script>
    let currentEditRow = null;

    function openGajiLayer() {
      document.getElementById('overlay').classList.remove('hidden');
      document.getElementById('gajiLayer').classList.remove('hidden');
      dimMainContent(true);
    }
    function closeGajiLayer() {
      document.getElementById('overlay').classList.add('hidden');
      document.getElementById('gajiLayer').classList.add('hidden');
      dimMainContent(false);
    }

    function openDeleteDialog() {
      document.getElementById('deleteOverlay').classList.remove('hidden');
      document.getElementById('deleteDialog').style.display = 'block';
      dimMainContent(true);
    }
    function closeDeleteDialog() {
      document.getElementById('deleteOverlay').classList.add('hidden');
      document.getElementById('deleteDialog').style.display = 'none';
      dimMainContent(false);
    }

    function openAddWorker() {
      document.getElementById('addWorkerOverlay').classList.remove('hidden');
      document.getElementById('addWorkerDialog').classList.remove('hidden');
      dimMainContent(true);
    }
    function closeAddWorker() {
      document.getElementById('addWorkerOverlay').classList.add('hidden');
      document.getElementById('addWorkerDialog').classList.add('hidden');
      dimMainContent(false);
    }

    function openEditWorker(row) {
      currentEditRow = row;
      // Get data from the row
      const cells = row.querySelectorAll('td');
      const nama = cells[1].textContent.trim();
      const kontak = cells[2].textContent.trim();
      const alamat = cells[3].textContent.trim();

      // Set values in the edit form
      document.getElementById('editNama').value = nama;
      document.getElementById('editKontak').value = kontak;
      document.getElementById('editAlamat').value = alamat;

      document.getElementById('editWorkerOverlay').classList.remove('hidden');
      document.getElementById('editWorkerDialog').classList.remove('hidden');
      dimMainContent(true);
    }
    function closeEditWorker() {
      document.getElementById('editWorkerOverlay').classList.add('hidden');
      document.getElementById('editWorkerDialog').classList.add('hidden');
      dimMainContent(false);
      currentEditRow = null;
      document.getElementById('editWorkerMessage').classList.add('hidden');
    }

    function parseRupiah(str) {
      return Number(str.replace(/[^0-9,-]+/g,"").replace(",","."));
    }

    function formatRupiah(num) {
      return "Rp. " + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function updateTotals() {
      const rows = document.querySelectorAll("#dataTable tbody tr");
      let totalGaji = 0;
      let totalDibayar = 0;
      let totalBelumDibayar = 0;

      rows.forEach(row => {
        const gajiText = row.querySelector("td:nth-child(5)").textContent.trim();
        const statusText = row.querySelector("td:nth-child(6)").textContent.trim();

        if(gajiText){
          const gaji = parseRupiah(gajiText);
          totalGaji += gaji;
          if(statusText === "Dibayar"){
            totalDibayar += gaji;
          } else if(statusText === "Belum Dibayar"){
            totalBelumDibayar += gaji;
          }
        }
      });

      document.getElementById("totalGaji").textContent = formatRupiah(totalGaji);
      document.getElementById("totalDibayar").textContent = formatRupiah(totalDibayar);
      document.getElementById("totalBelumDibayar").textContent = formatRupiah(totalBelumDibayar);
    }

    document.addEventListener("DOMContentLoaded", () => {
      updateTotals();

      // Attach edit button event listeners dynamically
      document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', function() {
          const row = this.closest('tr');
          openEditWorker(row);
        });
      });

      // Attach delete button event listeners dynamically
      document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', function() {
          openDeleteDialog();
        });
      });
    });

    // Handle form submission for Add Worker dialog (simulate PHP behavior)
    document.addEventListener('submit', function(e) {
      if(e.target && e.target.id === 'addWorkerForm') {
        e.preventDefault();
        const nama = e.target.nama.value.trim();
        const kontak = e.target.kontak.value.trim();
        const alamat = e.target.alamat.value.trim();
        if(nama && kontak && alamat){
          const msg = document.getElementById('addWorkerMessage');
          msg.innerHTML = `Data berhasil disimpan: <br>Nama: ${nama}<br>Kontak: ${kontak}<br>Alamat: ${alamat}`;
          msg.classList.remove('hidden');
          e.target.reset();
        }
      }
      if(e.target && e.target.id === 'editWorkerForm') {
        e.preventDefault();
        if(!currentEditRow) return;
        const nama = e.target.nama.value.trim();
        const kontak = e.target.kontak.value.trim();
        const alamat = e.target.alamat.value.trim();
        if(nama && kontak && alamat){
          // Update the table row with new values
          const cells = currentEditRow.querySelectorAll('td');
          cells[1].textContent = nama;
          cells[2].textContent = kontak;
          cells[3].textContent = alamat;

          const msg = document.getElementById('editWorkerMessage');
          msg.innerHTML = `Data berhasil disimpan: <br>Nama: ${nama}<br>Kontak: ${kontak}<br>Alamat: ${alamat}`;
          msg.classList.remove('hidden');
        }
      }
    });

    // Add effect to dim main content when any modal/dialog is open
    function dimMainContent(dim) {
      const mainContent = document.getElementById('mainContent');
      if(dim) {
        mainContent.classList.add('opacity-50', 'pointer-events-none');
      } else {
        mainContent.classList.remove('opacity-50', 'pointer-events-none');
      }
    }
  </script>
      <!-- Content -->
      <section id="mainContent" class="flex-1 p-8 overflow-auto transition-opacity duration-300">
        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 mb-4">
          <button
            class="flex items-center gap-2 bg-[#2f4ea1] text-white text-sm font-normal px-4 py-2 rounded shadow-sm hover:shadow-md transition-shadow mb-4 md:mb-0"
            type="button"
            onclick="openAddWorker()"
          >
            <i class="fas fa-plus"></i> Tambah Pekerja
          </button>
          <form class="flex flex-1 max-w-md" onsubmit="return false;">
            <input
              type="text"
              placeholder=""
              class="flex-grow border border-gray-300 rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#2f4ea1]"
            />
            <button
              type="submit"
              class="bg-[#2f4ea1] text-white px-6 py-2 rounded-r shadow-sm hover:shadow-md transition-shadow"
            >
              Cari
            </button>
          </form>
        </div>

        <table id="dataTable" class="w-full border border-gray-300 text-sm text-left">
          <thead class="bg-[#bdd4f2] text-xs text-gray-900">
            <tr>
              <th class="border border-gray-300 px-3 py-2 w-12">No.</th>
              <th class="border border-gray-300 px-3 py-2 w-36">Nama</th>
              <th class="border border-gray-300 px-3 py-2 w-36">Kontak</th>
              <th class="border border-gray-300 px-3 py-2 w-44">Alamat</th>
              <th class="border border-gray-300 px-3 py-2 w-28">Gaji</th>
              <th class="border border-gray-300 px-3 py-2 w-28">
                <div>Status</div>
                <div>Pembayaran</div>
              </th>
              <th class="border border-gray-300 px-3 py-2 w-44">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border border-gray-300 px-3 py-2 align-top">1.</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Ian Sopian</td>
              <td class="border border-gray-300 px-3 py-2 align-top">081222666444</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Wonosobo, 03/04</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Rp. 250.000</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Dibayar</td>
              <td class="border border-gray-300 px-3 py-2 align-top space-x-1 flex items-center">
                <button
                  class="bg-[#2f4ea1] text-white text-xs font-normal px-2 py-1 rounded shadow-sm hover:shadow-md transition-shadow inline-flex items-center gap-1 order-1"
                  type="button"
                  onclick="openGajiLayer()"
                >
                  <i class="fas fa-plus"></i> Gaji
                </button>
                <button
                  class="bg-[#2f4ea1] text-white text-xs font-normal px-3 py-1 rounded shadow-sm hover:shadow-md transition-shadow order-2"
                  type="button"
                  class="editBtn"
                  onclick="openEditWorker(this.closest('tr'))"
                >
                  Edit
                </button>
                <button
                  class="bg-red-700 text-white text-xs font-normal px-3 py-1 rounded shadow-sm hover:shadow-md transition-shadow order-3"
                  type="button"
                  class="deleteBtn"
                  onclick="openDeleteDialog()"
                >
                  Hapus
                </button>
              </td>
            </tr>
            <tr>
              <td class="border border-gray-300 px-3 py-2 align-top">2.</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Dinda</td>
              <td class="border border-gray-300 px-3 py-2 align-top">081566667777</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Wonosobo, 03/04</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Rp. 300.000</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Belum Dibayar</td>
              <td class="border border-gray-300 px-3 py-2 align-top space-x-1 flex items-center">
                <button
                  class="bg-[#2f4ea1] text-white text-xs font-normal px-2 py-1 rounded shadow-sm hover:shadow-md transition-shadow inline-flex items-center gap-1 order-1"
                  type="button"
                  onclick="openGajiLayer()"
                >
                  <i class="fas fa-plus"></i> Gaji
                </button>
                <button
                  class="bg-[#2f4ea1] text-white text-xs font-normal px-3 py-1 rounded shadow-sm hover:shadow-md transition-shadow order-2"
                  type="button"
                  class="editBtn"
                  onclick="openEditWorker(this.closest('tr'))"
                >
                  Edit
                </button>
                <button
                  class="bg-red-700 text-white text-xs font-normal px-3 py-1 rounded shadow-sm hover:shadow-md transition-shadow order-3"
                  type="button"
                  class="deleteBtn"
                  onclick="openDeleteDialog()"
                >
                  Hapus
                </button>
              </td>
            </tr>
            <tr>
              <td class="border border-gray-300 px-3 py-2 align-top">&nbsp;</td>
              <td class="border border-gray-300 px-3 py-2 align-top">&nbsp;</td>
              <td class="border border-gray-300 px-3 py-2 align-top">&nbsp;</td>
              <td class="border border-gray-300 px-3 py-2 align-top">&nbsp;</td>
              <td class="border border-gray-300 px-3 py-2 align-top">&nbsp;</td>
              <td class="border border-gray-300 px-3 py-2 align-top">&nbsp;</td>
              <td class="border border-gray-300 px-3 py-2 align-top">&nbsp;</td>
            </tr>
          </tbody>
        </table>

        <table class="w-full border border-gray-300 text-xs mt-2">
          <thead>
            <tr class="bg-[#bdd4f2] text-gray-900">
              <th class="border border-gray-300 px-3 py-1 text-center" colspan="2">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border border-gray-300 px-3 py-1 w-1/2">Gaji Pekerja</td>
              <td id="totalGaji" class="border border-gray-300 px-3 py-1 w-1/2">Rp. 550.000</td>
            </tr>
            <tr>
              <td class="border border-gray-300 px-3 py-1">Dibayar</td>
              <td id="totalDibayar" class="border border-gray-300 px-3 py-1">Rp. 250.000</td>
            </tr>
            <tr>
              <td class="border border-gray-300 px-3 py-1">Belum Dibayar</td>
              <td id="totalBelumDibayar" class="border border-gray-300 px-3 py-1">Rp. 300.000</td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- Overlay for Gaji Layer -->
      <div
        id="overlay"
        class="hidden fixed inset-0 z-40"
        onclick="closeGajiLayer()"
        aria-hidden="true"
      ></div>

      <!-- Gaji Layer -->
      <div
        id="gajiLayer"
        class="hidden fixed inset-0 z-50 flex items-center justify-center p-6"
        aria-modal="true"
        role="dialog"
        aria-labelledby="gajiTitle"
      >
        <div class="max-w-xs w-full border border-gray-300 rounded shadow-sm p-5 bg-white relative" onclick="event.stopPropagation()">
          <h2 id="gajiTitle" class="font-bold text-lg mb-4">Tambah Gaji</h2>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="space-y-4">
            <div>
              <div class="relative">
                <input
                  type="date"
                  name="tanggal"
                  placeholder="Masukkan Tanggal"
                  class="w-full border border-gray-300 rounded px-3 py-2 text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400"
                  required
                />
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              </div>
            </div>
            <div class="flex space-x-2">
              <input
                type="text"
                name="berat_barang"
                placeholder="Berat Barang"
                class="flex-grow border border-gray-300 rounded px-3 py-2 text-gray-500 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400"
                required
              />
              <div class="border border-gray-300 rounded px-3 py-2 flex items-center text-gray-700 select-none">Kg</div>
            </div>
            <div class="flex justify-between items-center text-gray-700 text-sm">
              <span>Tarif per Kg</span>
              <span>Rp. 2.500</span>
            </div>
            <div class="flex justify-between items-center text-gray-700 text-sm mb-1">
              <span>Total Gaji</span>
              <input
                type="text"
                name="total_gaji"
                value="Rp. 250.000"
                class="border border-gray-300 rounded px-3 py-1 text-gray-700 text-right w-32 focus:outline-none focus:ring-1 focus:ring-gray-400"
                required
              />
            </div>
            <select name="keterangan" class="w-full border border-gray-300 rounded px-3 py-2 text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400" required>
              <option value="" disabled selected>Keterangan</option>
              <option value="Belum Dibayar">Belum Dibayar</option>
              <option value="Dibayar">Dibayar</option>
            </select>
          </form>
          <button
            type="button"
            onclick="closeGajiLayer()"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
            aria-label="Close"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Overlay for Delete Dialog -->
      <div
        id="deleteOverlay"
        class="hidden fixed inset-0 z-105"
        onclick="closeDeleteDialog()"
        aria-hidden="true"
      ></div>

      <!-- Delete Dialog as Layer -->
      <div
        id="deleteDialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deleteTitle"
        onclick="event.stopPropagation()"
      >
        <h2 id="deleteTitle" class="font-semibold text-black mb-3 text-base">Hapus Data</h2>
        <p class="text-black mb-5 text-sm leading-relaxed">Apakah anda yakin akan menghapus data ini?</p>
        <div class="flex space-x-3">
          <button class="bg-[#B22222] text-white text-sm font-normal rounded px-4 py-2" onclick="alert('Data dihapus (simulasi)'); closeDeleteDialog();">Hapus</button>
          <button class="border border-gray-400 text-black text-sm font-normal rounded px-4 py-2" onclick="closeDeleteDialog()">Batal</button>
        </div>
      </div>

      <!-- Overlay for Add Worker Dialog -->
      <div
        id="addWorkerOverlay"
        class="hidden fixed inset-0 z-70"
        onclick="closeAddWorker()"
        aria-hidden="true"
      ></div>

      <!-- Add Worker Dialog -->
      <div
        id="addWorkerDialog"
        class="hidden fixed inset-0 z-80 flex items-center justify-center p-6"
        aria-modal="true"
        role="dialog"
        aria-labelledby="addWorkerTitle"
      >
        <div class="w-72 p-6 border border-gray-300 shadow-md bg-white relative" onclick="event.stopPropagation()">
          <button
            type="button"
            onclick="closeAddWorker()"
            aria-label="Close"
            class="absolute top-3 right-3 text-gray-700 hover:text-gray-900 text-lg font-bold"
          >
            &times;
          </button>
          <h2 id="addWorkerTitle" class="font-bold text-lg mb-4">Tambah Pekerja</h2>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="addWorkerForm">
            <input
              type="text"
              name="nama"
              placeholder="Nama"
              class="w-full mb-4 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
            />
            <input
              type="text"
              name="kontak"
              placeholder="Kontak"
              class="w-full mb-4 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
            />
            <input
              type="text"
              name="alamat"
              placeholder="Alamat"
              class="w-full mb-6 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
            />
            <div class="flex justify-center">
              <button
                type="submit"
                name="submit"
                class="bg-blue-700 text-white px-10 py-2 rounded text-sm w-36 text-center"
              >
                Simpan
              </button>
            </div>
          </form>
          <div id="addWorkerMessage" class="mt-4 text-green-600 text-sm hidden"></div>
        </div>
      </div>

      <!-- Overlay for Edit Worker Dialog -->
      <div
        id="editWorkerOverlay"
        class="hidden fixed inset-0 z-90"
        onclick="closeEditWorker()"
        aria-hidden="true"
      ></div>

      <!-- Edit Worker Dialog -->
      <div
        id="editWorkerDialog"
        class="hidden fixed inset-0 z-100 flex items-center justify-center p-6"
        aria-modal="true"
        role="dialog"
        aria-labelledby="editWorkerTitle"
      >
        <div class="w-72 p-6 border border-gray-300 shadow-md bg-white relative" onclick="event.stopPropagation()">
          <button
            type="button"
            onclick="closeEditWorker()"
            aria-label="Close"
            class="absolute top-3 right-3 text-gray-700 hover:text-gray-900 text-lg font-bold"
          >
            &times;
          </button>
          <h2 id="editWorkerTitle" class="font-bold text-lg mb-4">Edit Pekerja</h2>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="editWorkerForm">
            <input
              type="text"
              id="editNama"
              name="nama"
              placeholder="Nama"
              class="w-full mb-4 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
            />
            <input
              type="text"
              id="editKontak"
              name="kontak"
              placeholder="Kontak"
              class="w-full mb-4 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
            />
            <input
              type="text"
              id="editAlamat"
              name="alamat"
              placeholder="Alamat"
              class="w-full mb-6 px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
            />
            <div class="flex justify-center">
              <button
                type="submit"
                name="submit"
                class="bg-blue-700 text-white px-10 py-2 rounded text-sm w-36 text-center"
              >
                Simpan
              </button>
            </div>
          </form>
          <div id="editWorkerMessage" class="mt-4 text-green-600 text-sm hidden"></div>
        </div>
      </div>