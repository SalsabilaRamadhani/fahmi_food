<?php include 'auth.php';

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Location: ../Index.php?page=distribusi");
    exit;
}
?>

<section class="flex-1 p-8 bg-white relative z-10">
        <button
          id="openModalBtn"
          type="button"
          class="mb-4 inline-flex items-center gap-2 bg-[#2f49cc] text-white text-sm font-normal py-2 px-4 rounded-md shadow-md hover:shadow-lg transition"
        >
          <i class="fas fa-plus"></i>
          Input Pesanan
        </button>

        <div class="overflow-x-auto border border-gray-300 rounded-md shadow-sm">
          <table class="min-w-full border-collapse">
            <thead>
              <tr class="bg-blue-200 text-black text-sm font-normal">
                <th class="border border-gray-300 px-3 py-2 text-left w-12">No.</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-36">Distributor</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-36">Alamat</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-48">Produk</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-20">Jumlah</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-28">Tanggal</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-28">Status</th>
                <th class="border border-gray-300 px-3 py-2 text-left w-32">Aksi</th>
              </tr>
            </thead>
            <tbody id="ordersTableBody">
              <tr class="text-sm text-black">
                <td class="border border-gray-300 px-3 py-2 text-left align-top">1.</td>
                <td class="border border-gray-300 px-3 py-2 text-left align-top">Toko Jaya</td>
                <td class="border border-gray-300 px-3 py-2 text-left align-top">Semarang</td>
                <td class="border border-gray-300 px-3 py-2 text-left align-top">Agar-agar pita</td>
                <td class="border border-gray-300 px-3 py-2 text-left align-top">249 kg</td>
                <td class="border border-gray-300 px-3 py-2 text-left align-top">25-03-2025</td>
                <td class="border border-gray-300 px-3 py-2 text-left align-top">Diproses</td>
                <td class="border border-gray-300 px-3 py-2 text-left align-top space-x-2">
                  <button
                    type="button"
                    class="editBtn bg-blue-700 text-white text-xs px-3 py-1 rounded hover:bg-blue-800 transition"
                  >
                    Edit
                  </button>
                  <button
                    type="button"
                    class="deleteBtn bg-red-700 text-white text-xs px-3 py-1 rounded hover:bg-red-800 transition"
                  >
                    Hapus
                  </button>
                </td>
              </tr>
              <tr>
                <td class="border border-gray-300 px-3 py-2">&nbsp;</td>
                <td class="border border-gray-300 px-3 py-2"></td>
                <td class="border border-gray-300 px-3 py-2"></td>
                <td class="border border-gray-300 px-3 py-2"></td>
                <td class="border border-gray-300 px-3 py-2"></td>
                <td class="border border-gray-300 px-3 py-2"></td>
                <td class="border border-gray-300 px-3 py-2"></td>
                <td class="border border-gray-300 px-3 py-2"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <!-- Input Modal Overlay -->
      <div
        id="modalOverlay"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50"
      >
        <div class="w-full max-w-xs bg-white shadow-md rounded border border-gray-300 p-6 relative">
          <button
            id="closeModalBtn"
            class="absolute top-2 right-2 text-gray-600 hover:text-gray-900"
            aria-label="Close modal"
            type="button"
          >
            <i class="fas fa-times text-lg"></i>
          </button>
          <h2 class="text-black font-semibold text-lg mb-4">Input Pesanan</h2>
          <form id="orderForm" class="space-y-4" method="POST" action="">
            <input
              name="distributor"
              type="text"
              placeholder="Nama Distributor"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
            <input
              name="alamat"
              type="text"
              placeholder="Alamat Distributor"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
            <input
              name="produk"
              type="text"
              placeholder="Nama Produk"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
            <input
              name="jumlah"
              type="text"
              placeholder="Jumlah"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
            <input
              name="tanggal"
              type="date"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
            <select
              name="status"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-blue-600"
            >
              <option value="" disabled selected>Status</option>
              <option value="Diproses">Diproses</option>
              <option value="Dikirim">Dikirim</option>
              <option value="Selesai">Selesai</option>
            </select>
            <button
              type="submit"
              class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 transition"
            >
              Simpan
            </button>
          </form>
        </div>
      </div>

      <!-- Edit Modal Overlay -->
      <div
        id="editModalOverlay"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50"
      >
        <div class="w-full max-w-xs bg-white shadow-md rounded border border-gray-300 p-6 relative">
          <button
            id="closeEditModalBtn"
            class="absolute top-2 right-2 text-gray-600 hover:text-gray-900"
            aria-label="Close edit modal"
            type="button"
          >
            <i class="fas fa-times text-lg"></i>
          </button>
          <h1 class="text-black text-xl font-semibold mb-6">Edit Pesanan</h1>
          <form id="editOrderForm" class="space-y-4" method="POST" action="">
            <input
              type="text"
              name="nama_distributor"
              placeholder="Nama Distributor"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
            />
            <input
              type="text"
              name="alamat_distributor"
              placeholder="Alamat Distributor"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
            />
            <input
              type="text"
              name="nama_produk"
              placeholder="Nama Produk"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
            />
            <input
              type="text"
              name="jumlah"
              placeholder="Jumlah"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
            />
            <input
              type="date"
              name="tanggal"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
            />
            <select
              name="status"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm appearance-none bg-white focus:outline-none focus:ring-1 focus:ring-gray-400"
            >
              <option value="" disabled>Status</option>
              <option value="Diproses">Diproses</option>
              <option value="Dikirim">Dikirim</option>
              <option value="Selesai">Selesai</option>
            </select>
            <button
              type="submit"
              class="w-full bg-blue-700 text-white py-2 rounded-md text-center hover:bg-blue-800 transition"
            >
              Simpan
            </button>
          </form>
          <div id="editSuccessMsg" class="hidden mt-4 p-3 bg-green-100 text-green-800 rounded"></div>
        </div>
      </div>

      <!-- Delete Modal Overlay -->
      <div
        id="deleteModalOverlay"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50"
      >
        <div class="w-[280px] border border-gray-300 shadow-md p-5 bg-white rounded">
          <h2 class="font-semibold text-black mb-3 text-base">Hapus Data</h2>
          <p class="text-black mb-5 text-sm leading-relaxed">Apakah anda yakin akan menghapus data ini?</p>
          <div class="flex space-x-3 justify-end">
            <button
              id="confirmDeleteBtn"
              class="bg-[#B22222] text-white text-sm font-normal rounded px-4 py-2"
              type="button"
            >
              Hapus
            </button>
            <button
              id="cancelDeleteBtn"
              class="border border-gray-400 text-black text-sm font-normal rounded px-4 py-2"
              type="button"
            >
              Batal
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modalOverlay = document.getElementById('modalOverlay');
    const orderForm = document.getElementById('orderForm');
    const ordersTableBody = document.getElementById('ordersTableBody');

    const editModalOverlay = document.getElementById('editModalOverlay');
    const closeEditModalBtn = document.getElementById('closeEditModalBtn');
    const editOrderForm = document.getElementById('editOrderForm');
    const editSuccessMsg = document.getElementById('editSuccessMsg');

    const deleteModalOverlay = document.getElementById('deleteModalOverlay');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

    let rowToDelete = null;

    openModalBtn.addEventListener('click', () => {
      modalOverlay.classList.remove('hidden');
    });

    closeModalBtn.addEventListener('click', () => {
      modalOverlay.classList.add('hidden');
    });

    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) {
        modalOverlay.classList.add('hidden');
      }
    });

    closeEditModalBtn.addEventListener('click', () => {
      editModalOverlay.classList.add('hidden');
      editSuccessMsg.classList.add('hidden');
    });

    editModalOverlay.addEventListener('click', (e) => {
      if (e.target === editModalOverlay) {
        editModalOverlay.classList.add('hidden');
        editSuccessMsg.classList.add('hidden');
      }
    });

    cancelDeleteBtn.addEventListener('click', () => {
      deleteModalOverlay.classList.add('hidden');
      rowToDelete = null;
    });

    deleteModalOverlay.addEventListener('click', (e) => {
      if (e.target === deleteModalOverlay) {
        deleteModalOverlay.classList.add('hidden');
        rowToDelete = null;
      }
    });

    confirmDeleteBtn.addEventListener('click', () => {
      if (rowToDelete) {
        rowToDelete.remove();
        rowToDelete = null;
        deleteModalOverlay.classList.add('hidden');
        // Re-number rows
        const rows = ordersTableBody.querySelectorAll('tr');
        rows.forEach((row, idx) => {
          const firstCell = row.querySelector('td');
          if (firstCell) firstCell.textContent = (idx + 1) + '.';
        });
      }
    });

    // Handle form submission with AJAX to PHP backend for input
    orderForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const formData = new FormData(orderForm);

      const response = await fetch('', {
        method: 'POST',
        body: formData,
      });

      if (response.ok) {
        const result = await response.json();
        if (result.success) {
          const newRow = document.createElement('tr');
          newRow.classList.add('text-sm', 'text-black');

          const rowCount = ordersTableBody.querySelectorAll('tr').length;
          const newRowNumber = rowCount;

          newRow.innerHTML = `
            <td class="border border-gray-300 px-3 py-2 text-left align-top">${newRowNumber}.</td>
            <td class="border border-gray-300 px-3 py-2 text-left align-top">${result.data.distributor}</td>
            <td class="border border-gray-300 px-3 py-2 text-left align-top">${result.data.alamat}</td>
            <td class="border border-gray-300 px-3 py-2 text-left align-top">${result.data.produk}</td>
            <td class="border border-gray-300 px-3 py-2 text-left align-top">${result.data.jumlah}</td>
            <td class="border border-gray-300 px-3 py-2 text-left align-top">${result.data.tanggal}</td>
            <td class="border border-gray-300 px-3 py-2 text-left align-top">${result.data.status}</td>
            <td class="border border-gray-300 px-3 py-2 text-left align-top space-x-2">
              <button type="button" class="editBtn bg-blue-700 text-white text-xs px-3 py-1 rounded hover:bg-blue-800 transition">Edit</button>
              <button type="button" class="deleteBtn bg-red-700 text-white text-xs px-3 py-1 rounded hover:bg-red-800 transition">Hapus</button>
            </td>
          `;

          const emptyRow = ordersTableBody.querySelector('tr:last-child');
          if (
            emptyRow &&
            emptyRow.querySelectorAll('td').length === 8 &&
            emptyRow.textContent.trim() === ''
          ) {
            ordersTableBody.insertBefore(newRow, emptyRow);
          } else {
            ordersTableBody.appendChild(newRow);
          }

          orderForm.reset();
          modalOverlay.classList.add('hidden');
          attachEditDeleteListeners();
        } else {
          alert('Gagal menyimpan data.');
        }
      } else {
        alert('Terjadi kesalahan saat mengirim data.');
      }
    });

    // Attach edit and delete button listeners
    function attachEditDeleteListeners() {
      const editButtons = document.querySelectorAll('.editBtn');
      const deleteButtons = document.querySelectorAll('.deleteBtn');

      editButtons.forEach((btn) => {
        btn.removeEventListener('click', handleEditClick);
        btn.addEventListener('click', handleEditClick);
      });

      deleteButtons.forEach((btn) => {
        btn.removeEventListener('click', handleDeleteClick);
        btn.addEventListener('click', handleDeleteClick);
      });
    }

    function handleEditClick(e) {
      const tr = e.target.closest('tr');
      if (!tr) return;

      const cells = tr.querySelectorAll('td');
      editOrderForm.nama_distributor.value = cells[1].textContent.trim();
      editOrderForm.alamat_distributor.value = cells[2].textContent.trim();
      editOrderForm.nama_produk.value = cells[3].textContent.trim();
      editOrderForm.jumlah.value = cells[4].textContent.trim().replace(/[^\d]/g, '');
      editOrderForm.tanggal.value = cells[5].textContent.trim().split('-').reverse().join('-');
      const statusValue = cells[6].textContent.trim();

      Array.from(editOrderForm.status.options).forEach(option => {
        option.selected = option.value === statusValue;
      });

      editOrderForm.dataset.editingRowIndex = Array.from(ordersTableBody.children).indexOf(tr);

      editSuccessMsg.classList.add('hidden');
      editModalOverlay.classList.remove('hidden');
    }

    function handleDeleteClick(e) {
      const tr = e.target.closest('tr');
      if (!tr) return;
      rowToDelete = tr;
      deleteModalOverlay.classList.remove('hidden');
    }

    // Handle edit form submission
    editOrderForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const formData = new FormData(editOrderForm);

      const editingRowIndex = parseInt(editOrderForm.dataset.editingRowIndex, 10);
      if (isNaN(editingRowIndex)) {
        alert('Terjadi kesalahan saat mengedit data.');
        return;
      }

      const rows = ordersTableBody.querySelectorAll('tr');
      const row = rows[editingRowIndex];
      if (!row) {
        alert('Baris data tidak ditemukan.');
        return;
      }

      const cells = row.querySelectorAll('td');
      cells[1].textContent = formData.get('nama_distributor');
      cells[2].textContent = formData.get('alamat_distributor');
      cells[3].textContent = formData.get('nama_produk');
      cells[4].textContent = formData.get('jumlah');
      const dateVal = formData.get('tanggal');
      const dateParts = dateVal.split('-');
      cells[5].textContent = dateParts.length === 3 ? `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}` : dateVal;
      cells[6].textContent = formData.get('status');

      editSuccessMsg.textContent = 'Data pesanan berhasil diperbarui.';
      editSuccessMsg.classList.remove('hidden');

      setTimeout(() => {
        editModalOverlay.classList.add('hidden');
        editSuccessMsg.classList.add('hidden');
      }, 1500);
    });

    attachEditDeleteListeners();
  </script>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $distributor = htmlspecialchars($_POST['distributor'] ?? '');
    $alamat = htmlspecialchars($_POST['alamat'] ?? '');
    $produk = htmlspecialchars($_POST['produk'] ?? '');
    $jumlah = htmlspecialchars($_POST['jumlah'] ?? '');
    $tanggal = htmlspecialchars($_POST['tanggal'] ?? '');
    $status = htmlspecialchars($_POST['status'] ?? '');

    header('Content-Type: application/json');
    echo json_encode([
      'success' => true,
      'data' => [
        'distributor' => $distributor,
        'alamat' => $alamat,
        'produk' => $produk,
        'jumlah' => $jumlah,
        'tanggal' => $tanggal,
        'status' => $status,
      ],
    ]);
    exit;
  }
  ?>