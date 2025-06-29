<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Location: ../Index.php?page=pekerja");
    exit;
}
?>

<!-- Main content -->
      <section class="flex flex-col p-6 space-y-4 overflow-x-auto relative z-10">
        <div
          class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-4 sm:space-y-0"
        >
          <button
            id="openTambahModalBtn"
            class="flex items-center bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded shadow hover:bg-blue-800 transition duration-150"
            type="button"
          >
            <i class="fas fa-plus mr-2"></i>Tambah Pekerja
          </button>
          <form class="flex flex-1 max-w-lg">
            <input
              class="flex-grow border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
              type="text"
              placeholder=""
            />
            <button
              class="bg-blue-700 text-white px-5 py-2 rounded-r shadow hover:bg-blue-800 transition duration-150"
              type="submit"
            >
              Cari
            </button>
          </form>
        </div>
        <table class="min-w-full border border-gray-300 text-sm text-left">
          <thead class="bg-blue-200 text-gray-900">
            <tr>
              <th class="border border-gray-300 px-3 py-2 w-12">No.</th>
              <th class="border border-gray-300 px-3 py-2 w-36">Nama</th>
              <th class="border border-gray-300 px-3 py-2 w-36">Kontak</th>
              <th class="border border-gray-300 px-3 py-2 w-48">Alamat</th>
              <th class="border border-gray-300 px-3 py-2 w-28">Gaji</th>
              <th class="border border-gray-300 px-3 py-2 w-28">
                <div>Status<br />Pembayaran</div>
              </th>
              <th class="border border-gray-300 px-3 py-2 w-36">Aksi</th>
            </tr>
          </thead>
          <tbody id="pekerjaTableBody">
            <tr>
              <td class="border border-gray-300 px-3 py-2 align-top">1.</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Ian Sopian</td>
              <td class="border border-gray-300 px-3 py-2 align-top">081222666444</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Wonosobo, 03/04</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Rp. 250.000</td>
              <td class="border border-gray-300 px-3 py-2 align-top">Dibayar</td>
              <td class="border border-gray-300 px-3 py-2 align-top space-x-2">
                <button
                  class="editBtn bg-blue-700 text-white text-xs px-3 py-1 rounded hover:bg-blue-800 transition"
                  type="button"
                >
                  Edit
                </button>
                <button
                  class="deleteBtn bg-red-600 text-white text-xs px-3 py-1 rounded hover:bg-red-700 transition"
                  type="button"
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
              <td class="border border-gray-300 px-3 py-2 align-top space-x-2">
                <button
                  class="editBtn bg-blue-700 text-white text-xs px-3 py-1 rounded hover:bg-blue-800 transition"
                  type="button"
                >
                  Edit
                </button>
                <button
                  class="deleteBtn bg-red-600 text-white text-xs px-3 py-1 rounded hover:bg-red-700 transition"
                  type="button"
                >
                  Hapus
                </button>
              </td>
            </tr>
            <tr>
              <td class="border border-gray-300 px-3 py-2 align-top"></td>
              <td class="border border-gray-300 px-3 py-2 align-top"></td>
              <td class="border border-gray-300 px-3 py-2 align-top"></td>
              <td class="border border-gray-300 px-3 py-2 align-top"></td>
              <td class="border border-gray-300 px-3 py-2 align-top"></td>
              <td class="border border-gray-300 px-3 py-2 align-top"></td>
              <td class="border border-gray-300 px-3 py-2 align-top"></td>
            </tr>
          </tbody>
        </table>
        <table class="min-w-full border border-gray-300 text-sm text-left bg-blue-200">
          <thead>
            <tr>
              <th class="border border-gray-300 px-3 py-1 text-center" colspan="2">
                Total
              </th>
            </tr>
          </thead>
          <tbody class="bg-white" id="totalTableBody">
            <tr>
              <td class="border border-gray-300 px-3 py-1 w-48">Gaji Pekerja</td>
              <td class="border border-gray-300 px-3 py-1" id="totalGaji">Rp. 550.000</td>
            </tr>
            <tr>
              <td class="border border-gray-300 px-3 py-1">Dibayar</td>
              <td class="border border-gray-300 px-3 py-1" id="totalDibayar">Rp. 250.000</td>
            </tr>
            <tr>
              <td class="border border-gray-300 px-3 py-1">Belum Dibayar</td>
              <td class="border border-gray-300 px-3 py-1" id="totalBelumDibayar">Rp. 300.000</td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- Modal Overlay for Tambah Pekerja -->
      <div
        id="tambahPekerjaModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50"
      >
        <div class="w-72 p-6 border border-gray-300 shadow-md bg-white rounded">
          <h2 class="font-bold text-lg mb-4">Tambah Pekerja</h2>
          <form id="tambahPekerjaForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
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
            <div class="flex space-x-4">
              <button
                type="submit"
                name="submit"
                class="bg-blue-700 text-white px-5 py-2 rounded text-sm"
              >
                Simpan
              </button>
              <button
                type="button"
                id="cancelTambahPekerja"
                class="border border-gray-700 text-gray-700 px-5 py-2 rounded text-sm"
              >
                Batal
              </button>
            </div>
          </form>
          <div id="successMsg" class="mt-4 text-green-600 text-sm hidden"></div>
        </div>
      </div>

      <!-- Modal Overlay for Edit Pekerja -->
      <div
        id="editPekerjaModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50"
      >
        <div class="w-[320px] border border-gray-300 shadow-md p-5 bg-white rounded relative">
          <button
            id="closeEditModalBtn"
            class="absolute top-2 right-2 text-gray-600 hover:text-gray-900"
            aria-label="Close edit modal"
            type="button"
          >
            <i class="fas fa-times text-lg"></i>
          </button>
          <?php
          $tarifPerKg = 2500;
          $beratBarang = 0;
          $totalGaji = 0;
          $keterangan = "";
          $nama = "";
          $alamat = "";
          $kontak = "";
          $tanggal = "";

          if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_submit'])) {
            $nama = htmlspecialchars($_POST['nama'] ?? '');
            $alamat = htmlspecialchars($_POST['alamat'] ?? '');
            $kontak = htmlspecialchars($_POST['kontak'] ?? '');
            $tanggal = htmlspecialchars($_POST['tanggal'] ?? '');
            $beratBarang = floatval($_POST['berat'] ?? 0);
            $keterangan = $_POST['keterangan'] ?? "";

            $totalGaji = $beratBarang * $tarifPerKg;
          }
          ?>
          <form
            id="editForm"
            method="POST"
            class="w-full"
            autocomplete="off"
            novalidate
          >
            <h2 class="text-2xl font-bold mb-4">Edit</h2>

            <input
              type="text"
              name="nama"
              placeholder="Nama"
              value="<?php echo $nama; ?>"
              class="w-full mb-3 px-3 py-2 border border-gray-300 rounded text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600 focus:text-black"
              required
            />

            <input
              type="text"
              name="alamat"
              placeholder="Alamat"
              value="<?php echo $alamat; ?>"
              class="w-full mb-3 px-3 py-2 border border-gray-300 rounded text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600 focus:text-black"
              required
            />

            <input
              type="text"
              name="kontak"
              placeholder="Kontak"
              value="<?php echo $kontak; ?>"
              class="w-full mb-3 px-3 py-2 border border-gray-300 rounded text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600 focus:text-black"
              required
            />

            <div class="relative mb-3">
              <input
                type="date"
                name="tanggal"
                placeholder="Masukkan Tanggal"
                value="<?php echo $tanggal; ?>"
                class="w-full px-3 py-2 border border-gray-300 rounded text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600 focus:text-black"
                required
              />
              <i
                class="fas fa-calendar-alt absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                aria-hidden="true"
              ></i>
            </div>

            <div class="flex mb-3 border border-gray-300 rounded overflow-hidden">
              <input
                type="number"
                step="any"
                min="0"
                name="berat"
                placeholder="Berat Barang"
                value="<?php echo $beratBarang > 0 ? $beratBarang : ''; ?>"
                class="flex-grow px-3 py-2 text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600 focus:text-black"
                required
              />
              <span
                class="border-l border-gray-300 px-3 py-2 text-gray-700 select-none"
                >Kg</span
              >
            </div>

            <div class="mb-1 flex justify-between text-sm">
              <span class="text-gray-900 font-normal">Tarif per Kg</span>
              <span class="text-gray-900 font-normal">Rp. 2.500</span>
            </div>
            <div class="mb-4 flex justify-between text-sm">
              <span class="text-gray-900 font-normal">Total Gaji</span>
              <span class="text-gray-900 font-normal">
                Rp. <?php echo number_format($totalGaji, 0, ',', '.'); ?>
              </span>
            </div>

            <select
              name="keterangan"
              class="w-full mb-4 px-3 py-2 border border-gray-300 rounded text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600 focus:text-black"
              required
            >
              <option disabled <?php echo $keterangan === "" ? "selected" : ""; ?>>Keterangan</option>
              <option value="Belum Dibayar" <?php echo $keterangan === "Belum Dibayar" ? "selected" : ""; ?>>Belum Dibayar</option>
              <option value="Dibayar" <?php echo $keterangan === "Dibayar" ? "selected" : ""; ?>>Dibayar</option>
            </select>

            <div class="flex gap-3">
              <button
                type="submit"
                name="edit_submit"
                class="flex-grow bg-blue-700 text-white py-2 rounded text-sm"
              >
                Simpan
              </button>
              <button
                type="button"
                id="cancelEditBtn"
                class="flex-grow border border-gray-400 py-2 rounded text-sm"
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
    const openTambahModalBtn = document.getElementById("openTambahModalBtn");
    const tambahPekerjaModal = document.getElementById("tambahPekerjaModal");
    const cancelTambahPekerja = document.getElementById("cancelTambahPekerja");
    const tambahPekerjaForm = document.getElementById("tambahPekerjaForm");
    const successMsg = document.getElementById("successMsg");

    const editPekerjaModal = document.getElementById("editPekerjaModal");
    const closeEditModalBtn = document.getElementById("closeEditModalBtn");
    const cancelEditBtn = document.getElementById("cancelEditBtn");
    const editForm = document.getElementById("editForm");
    const pekerjaTableBody = document.getElementById("pekerjaTableBody");
    const totalGajiEl = document.getElementById("totalGaji");
    const totalDibayarEl = document.getElementById("totalDibayar");
    const totalBelumDibayarEl = document.getElementById("totalBelumDibayar");

    openTambahModalBtn.addEventListener("click", () => {
      tambahPekerjaModal.classList.remove("hidden");
      successMsg.classList.add("hidden");
      tambahPekerjaForm.reset();
    });

    cancelTambahPekerja.addEventListener("click", () => {
      tambahPekerjaModal.classList.add("hidden");
      successMsg.classList.add("hidden");
    });

    tambahPekerjaForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const formData = new FormData(tambahPekerjaForm);

      // Add new row to table
      const newRow = document.createElement("tr");
      newRow.classList.add("text-sm", "text-black");

      // Calculate gaji from dummy value or 0 (you can adjust logic)
      // For demo, set gaji to Rp. 0
      const gaji = "Rp. 0";
      const status = "Belum Dibayar";

      // Get current row count for numbering
      const rowCount = pekerjaTableBody.querySelectorAll("tr").length;
      const newRowNumber = rowCount;

      newRow.innerHTML = `
        <td class="border border-gray-300 px-3 py-2 text-left align-top">${newRowNumber}.</td>
        <td class="border border-gray-300 px-3 py-2 text-left align-top">${formData.get("nama")}</td>
        <td class="border border-gray-300 px-3 py-2 text-left align-top">${formData.get("kontak")}</td>
        <td class="border border-gray-300 px-3 py-2 text-left align-top">${formData.get("alamat")}</td>
        <td class="border border-gray-300 px-3 py-2 text-left align-top">${gaji}</td>
        <td class="border border-gray-300 px-3 py-2 text-left align-top">${status}</td>
        <td class="border border-gray-300 px-3 py-2 text-left align-top space-x-2">
          <button class="editBtn bg-blue-700 text-white text-xs px-3 py-1 rounded hover:bg-blue-800 transition" type="button">Edit</button>
          <button class="deleteBtn bg-red-600 text-white text-xs px-3 py-1 rounded hover:bg-red-700 transition" type="button">Hapus</button>
        </td>
      `;

      // Insert before empty row or append
      const emptyRow = pekerjaTableBody.querySelector("tr:last-child");
      if (
        emptyRow &&
        emptyRow.querySelectorAll("td").length === 7 &&
        emptyRow.textContent.trim() === ""
      ) {
        pekerjaTableBody.insertBefore(newRow, emptyRow);
      } else {
        pekerjaTableBody.appendChild(newRow);
      }

      tambahPekerjaModal.classList.add("hidden");
      successMsg.classList.add("hidden");
      tambahPekerjaForm.reset();

      updateTotals();
      attachEditDeleteListeners();
    });

    // Edit modal open/close
    closeEditModalBtn.addEventListener("click", () => {
      editPekerjaModal.classList.add("hidden");
    });
    cancelEditBtn.addEventListener("click", () => {
      editPekerjaModal.classList.add("hidden");
    });

    // Attach edit and delete button listeners
    function attachEditDeleteListeners() {
      const editButtons = document.querySelectorAll(".editBtn");
      const deleteButtons = document.querySelectorAll(".deleteBtn");

      editButtons.forEach((btn) => {
        btn.removeEventListener("click", handleEditClick);
        btn.addEventListener("click", handleEditClick);
      });

      deleteButtons.forEach((btn) => {
        btn.removeEventListener("click", handleDeleteClick);
        btn.addEventListener("click", handleDeleteClick);
      });
    }

    function handleEditClick(e) {
      const tr = e.target.closest("tr");
      if (!tr) return;

      // Fill form with current row data
      const cells = tr.querySelectorAll("td");
      editForm.nama.value = cells[1].textContent.trim();
      editForm.kontak.value = cells[2].textContent.trim();
      editForm.alamat.value = cells[3].textContent.trim();

      // For berat and tanggal, we don't have data in table, so clear or set default
      editForm.berat.value = "";
      editForm.tanggal.value = "";
      editForm.keterangan.value = cells[5].textContent.trim();

      // Store the row being edited
      editForm.dataset.editingRowIndex = Array.from(pekerjaTableBody.children).indexOf(tr);

      // Show modal
      editPekerjaModal.classList.remove("hidden");
    }

    function handleDeleteClick(e) {
      const tr = e.target.closest("tr");
      if (!tr) return;
      tr.remove();
      updateRowNumbers();
      updateTotals();
    }

    // Update row numbers after delete
    function updateRowNumbers() {
      const rows = pekerjaTableBody.querySelectorAll("tr");
      rows.forEach((row, idx) => {
        const firstCell = row.querySelector("td");
        if (firstCell) firstCell.textContent = idx + 1 + ".";
      });
    }

    // Update totals based on table data
    function updateTotals() {
      let totalGaji = 0;
      let totalDibayar = 0;
      let totalBelumDibayar = 0;

      const rows = pekerjaTableBody.querySelectorAll("tr");
      rows.forEach((row) => {
        const cells = row.querySelectorAll("td");
        if (cells.length < 7) return;
        const gajiText = cells[4].textContent.trim().replace(/[^\d]/g, "");
        const gaji = parseInt(gajiText) || 0;
        const status = cells[5].textContent.trim();

        totalGaji += gaji;
        if (status === "Dibayar") {
          totalDibayar += gaji;
        } else if (status === "Belum Dibayar") {
          totalBelumDibayar += gaji;
        }
      });

      totalGajiEl.textContent = "Rp. " + totalGaji.toLocaleString("id-ID");
      totalDibayarEl.textContent = "Rp. " + totalDibayar.toLocaleString("id-ID");
      totalBelumDibayarEl.textContent = "Rp. " + totalBelumDibayar.toLocaleString("id-ID");
    }

    // Handle edit form submission
    editForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const editingRowIndex = parseInt(editForm.dataset.editingRowIndex, 10);
      if (isNaN(editingRowIndex)) {
        alert("Terjadi kesalahan saat mengedit data.");
        return;
      }

      const rows = pekerjaTableBody.querySelectorAll("tr");
      const row = rows[editingRowIndex];
      if (!row) {
        alert("Baris data tidak ditemukan.");
        return;
      }

      const cells = row.querySelectorAll("td");
      cells[1].textContent = editForm.nama.value.trim();
      cells[2].textContent = editForm.kontak.value.trim();
      cells[3].textContent = editForm.alamat.value.trim();

      // Calculate gaji from berat * tarifPerKg (2500)
      const berat = parseFloat(editForm.berat.value) || 0;
      const tarifPerKg = 2500;
      const gaji = berat * tarifPerKg;
      cells[4].textContent = "Rp. " + gaji.toLocaleString("id-ID");

      cells[5].textContent = editForm.keterangan.value;

      updateTotals();
      editPekerjaModal.classList.add("hidden");
    });

    attachEditDeleteListeners();
    updateTotals();
  </script>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Handle tambah pekerja form submission here if needed
    // For demo, no server-side processing is done
  }
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_submit'])) {
    // Handle edit form submission here if needed
    // For demo, no server-side processing is done
  }
  ?>