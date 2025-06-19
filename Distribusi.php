<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Distribusi dan Permintaan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body class="bg-white font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 border-r border-gray-300 flex flex-col p-6 bg-white">
      <div class="mb-12 flex justify-center">
        <?php
          $logoPath = 'assets/logo.png';
          if (file_exists($logoPath)) {
            echo '<img src="' . htmlspecialchars($logoPath) . '" alt="Logo perusahaan" class="max-h-24 object-contain" />';
          } else {
            echo '<div class="w-full h-24 flex items-center justify-center border border-gray-300 rounded text-gray-400 text-sm">Logo belum diupload</div>';
          }
        ?>
      </div>
      <?php $current = basename($_SERVER['PHP_SELF']); ?>
<nav class="flex flex-col space-y-4">
  <a href="Dashboard.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Dashboard.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Dashboard
  </a>
  <a href="Produksi.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Produksi.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Produksi
  </a>
  <a href="Stok.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Stok.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Stok
  </a>
  <a href="Pekerja.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Pekerja.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Pekerja Lepas
  </a>
  <a href="Distribusi.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Distribusi.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Distribusi dan Permintaan
  </a>
  <a href="Laporan.php"
     class="flex items-center justify-center w-full py-3 rounded border
     <?= $current == 'Laporan.php' ? 'bg-blue-200 border-blue-400 font-semibold' : 'border-gray-300' ?>
     shadow-sm text-black text-base font-normal transition-all
     hover:bg-blue-100 hover:border-blue-300">
    Laporan
  </a>
</nav>

    </aside>

    <!-- Main content -->
    <main class="flex-1 flex flex-col">
      <header class="bg-[#2f49b7] text-white px-8 py-6 shadow-md">
        <h1 class="text-xl font-normal">Distribusi dan Permintaan</h1>
      </header>
      <!-- Content -->
<section class="flex-1 p-6">
        <button
          id="openInputModalBtn"
          class="mb-4 inline-flex items-center gap-2 bg-blue-700 text-white text-sm font-normal px-4 py-2 rounded shadow hover:bg-blue-800 transition-colors"
        >
          <i class="fas fa-plus"></i> Input Pesanan
        </button>

        <div class="overflow-x-auto border border-gray-300 rounded shadow-sm">
          <table class="min-w-full text-sm text-left">
            <thead class="bg-blue-200 text-gray-900">
              <tr>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">No.</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Nama Distributor</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Alamat</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Nama Produk</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Jumlah</th>
                <th class="px-4 py-2 border-r border-gray-300 font-normal">Tanggal</th>
                <th class="px-4 py-2 font-normal">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white min-h-[200px]">
              <tr>
                <td colspan="7" class="h-48"></td>
              </tr>
              <tr class="text-right">
                <td colspan="7" class="pr-4 space-x-2">
                  <button id="editBtn" class="bg-blue-700 text-white text-xs px-3 py-1 rounded hover:bg-blue-800 transition-colors">Edit</button>
                  <button id="deleteBtn" class="text-white text-xs px-3 py-1 rounded transition-colors" style="background-color:#B22222;" onmouseover="this.style.backgroundColor='#8B1A1A'" onmouseout="this.style.backgroundColor='#B22222'">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <!-- Input Modal Overlay -->
      <div id="inputModalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-md shadow-lg w-full max-w-xs p-6 relative">
          <button id="closeInputModalBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-lg font-bold">&times;</button>
          <h2 class="text-black font-semibold text-lg mb-4">Input Pengiriman</h2>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4" id="inputForm">
            <input
              type="text"
              name="nama_distributor"
              placeholder="Nama Distributor"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
            />
            <input
              type="text"
              name="nama_produk"
              placeholder="Nama Produk"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
            />
            <input
              type="number"
              name="jumlah"
              placeholder="Jumlah"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
              min="1"
            />
            <div class="relative">
              <input
                type="date"
                name="tanggal"
                placeholder="Tanggal"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 appearance-none"
                required
              />
              <i
                class="fas fa-calendar-alt absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                aria-hidden="true"
              ></i>
            </div>
            <button
              type="submit"
              class="w-full bg-blue-700 text-white py-2 rounded-md text-center"
            >
              Simpan
            </button>
          </form>
          <div id="inputFormMessage" class="mt-4 p-3 border border-green-500 rounded bg-green-50 text-green-700 text-sm hidden"></div>
        </div>
      </div>

      <!-- Edit Modal Overlay -->
      <div id="editModalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white shadow-lg rounded-md p-6 w-80 relative">
          <button id="closeEditModalBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-lg font-bold">&times;</button>
          <h2 class="text-black text-lg font-semibold mb-6">Edit Pengiriman</h2>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="space-y-4" id="editForm">
            <input
              type="text"
              name="nama_distributor"
              placeholder="Nama Distributor"
              class="w-full border border-gray-300 rounded-md py-2 px-3 text-gray-500 placeholder-gray-400 shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
              required
            />
            <input
              type="text"
              name="nama_produk"
              placeholder="Nama Produk"
              class="w-full border border-gray-300 rounded-md py-2 px-3 text-gray-500 placeholder-gray-400 shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
              required
            />
            <input
              type="number"
              name="jumlah"
              placeholder="Jumlah"
              class="w-full border border-gray-300 rounded-md py-2 px-3 text-gray-500 placeholder-gray-400 shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
              required
            />
            <div class="relative">
              <input
                type="date"
                name="tanggal"
                placeholder="Tanggal"
                class="w-full border border-gray-300 rounded-md py-2 px-3 text-gray-500 placeholder-gray-400 shadow-sm focus:outline-none focus:ring-1 focus:ring-gray-400 appearance-none"
                required
              />
              <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-7H3v7a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
            <div class="flex space-x-3 pt-2">
              <button
                type="submit"
                class="bg-blue-700 text-white text-sm font-normal rounded-md py-2 px-6"
              >
                Simpan
              </button>
              <button
                type="button"
                id="cancelEditBtn"
                class="border border-gray-900 text-black text-sm font-normal rounded-md py-2 px-6"
              >
                Batal
              </button>
            </div>
          </form>
          <div id="editFormMessage" class="mt-6 p-4 border border-gray-300 rounded-md bg-gray-50 text-gray-800 text-sm hidden"></div>
        </div>
      </div>

      <!-- Delete Modal Overlay -->
      <div id="deleteModalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="w-[280px] border border-gray-300 shadow-md p-5 bg-white rounded-md relative">
          <button id="closeDeleteModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-lg font-bold">&times;</button>
          <h2 class="font-semibold text-black mb-3 text-base">Hapus Data</h2>
          <p class="text-black mb-5 text-sm leading-relaxed">Apakah anda yakin akan menghapus data ini?</p>
          <div class="flex space-x-3">
            <button id="confirmDeleteBtn" class="bg-[#B22222] text-white text-sm font-normal rounded px-4 py-2">Hapus</button>
            <button id="cancelDeleteBtn" class="border border-gray-400 text-black text-sm font-normal rounded px-4 py-2">Batal</button>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Modal elements
    const openInputModalBtn = document.getElementById('openInputModalBtn');
    const closeInputModalBtn = document.getElementById('closeInputModalBtn');
    const inputModalOverlay = document.getElementById('inputModalOverlay');
    const inputForm = document.getElementById('inputForm');
    const inputFormMessage = document.getElementById('inputFormMessage');

    const editBtn = document.getElementById('editBtn');
    const editModalOverlay = document.getElementById('editModalOverlay');
    const closeEditModalBtn = document.getElementById('closeEditModalBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const editForm = document.getElementById('editForm');
    const editFormMessage = document.getElementById('editFormMessage');

    const deleteBtn = document.getElementById('deleteBtn');
    const deleteModalOverlay = document.getElementById('deleteModalOverlay');
    const closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    // Open Input Modal
    openInputModalBtn.addEventListener('click', () => {
      inputModalOverlay.classList.remove('hidden');
      inputModalOverlay.classList.add('flex');
      inputFormMessage.classList.add('hidden');
      inputForm.reset();
    });

    // Close Input Modal
    closeInputModalBtn.addEventListener('click', () => {
      inputModalOverlay.classList.add('hidden');
      inputModalOverlay.classList.remove('flex');
      inputFormMessage.classList.add('hidden');
      inputForm.reset();
    });

    // Close Input Modal on outside click
    inputModalOverlay.addEventListener('click', (e) => {
      if (e.target === inputModalOverlay) {
        closeInputModalBtn.click();
      }
    });

    // Open Edit Modal
    editBtn.addEventListener('click', () => {
      editModalOverlay.classList.remove('hidden');
      editModalOverlay.classList.add('flex');
      editFormMessage.classList.add('hidden');
      editForm.reset();
    });

    // Close Edit Modal
    closeEditModalBtn.addEventListener('click', () => {
      editModalOverlay.classList.add('hidden');
      editModalOverlay.classList.remove('flex');
      editFormMessage.classList.add('hidden');
      editForm.reset();
    });
    cancelEditBtn.addEventListener('click', () => {
      closeEditModalBtn.click();
    });

    // Close Edit Modal on outside click
    editModalOverlay.addEventListener('click', (e) => {
      if (e.target === editModalOverlay) {
        closeEditModalBtn.click();
      }
    });

    // Open Delete Modal
    deleteBtn.addEventListener('click', () => {
      deleteModalOverlay.classList.remove('hidden');
      deleteModalOverlay.classList.add('flex');
    });

    // Close Delete Modal
    closeDeleteModalBtn.addEventListener('click', () => {
      deleteModalOverlay.classList.add('hidden');
      deleteModalOverlay.classList.remove('flex');
    });
    cancelDeleteBtn.addEventListener('click', () => {
      closeDeleteModalBtn.click();
    });

    // Close Delete Modal on outside click
    deleteModalOverlay.addEventListener('click', (e) => {
      if (e.target === deleteModalOverlay) {
        closeDeleteModalBtn.click();
      }
    });

    // Confirm Delete button action (example: just close modal here)
    confirmDeleteBtn.addEventListener('click', () => {
      // Here you can add your delete logic (e.g., AJAX call)
      alert('Data telah dihapus.');
      closeDeleteModalBtn.click();
    });

    // Handle Input Form submission with AJAX
    inputForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(inputForm);
      fetch('<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        inputFormMessage.innerHTML = `
          Data berhasil disimpan:<br>
          Nama Distributor: ${formData.get('nama_distributor')}<br>
          Nama Produk: ${formData.get('nama_produk')}<br>
          Jumlah: ${formData.get('jumlah')}<br>
          Tanggal: ${formData.get('tanggal')}
        `;
        inputFormMessage.classList.remove('hidden');
        inputForm.reset();
      })
      .catch(() => {
        inputFormMessage.innerHTML = 'Terjadi kesalahan saat menyimpan data.';
        inputFormMessage.classList.remove('bg-green-50');
        inputFormMessage.classList.add('bg-red-50', 'border-red-500', 'text-red-700');
        inputFormMessage.classList.remove('hidden');
      });
    });

    // Handle Edit Form submission with AJAX
    editForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(editForm);
      fetch('<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        editFormMessage.innerHTML = `
          <strong>Data yang dikirim:</strong><br>
          Nama Distributor: ${formData.get('nama_distributor')}<br>
          Nama Produk: ${formData.get('nama_produk')}<br>
          Jumlah: ${formData.get('jumlah')}<br>
          Tanggal: ${formData.get('tanggal')}
        `;
        editFormMessage.classList.remove('hidden');
        editForm.reset();
      })
      .catch(() => {
        editFormMessage.innerHTML = 'Terjadi kesalahan saat menyimpan data.';
        editFormMessage.classList.remove('bg-gray-50');
        editFormMessage.classList.add('bg-red-50', 'border-red-500', 'text-red-700');
        editFormMessage.classList.remove('hidden');
      });
    });
  </script>
</body>
</html>