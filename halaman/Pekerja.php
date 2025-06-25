<!-- Konten -->
<section class="flex flex-col p-6 flex-1">
  <div class="flex flex-col sm:flex-row sm:items-center mb-4">
    <button
      type="button"
      class="flex items-center gap-2 bg-[#3b4ea1] text-white text-sm font-normal px-4 py-2 rounded shadow-sm hover:shadow-md transition-shadow mb-3 sm:mb-0"
      onclick="openAddModal()"
    >
      <i class="fas fa-plus"></i> Tambah Pekerja
    </button>
    <form class="flex flex-1 justify-end max-w-full sm:max-w-md relative">
      <input
        type="text"
        placeholder=""
        class="w-full border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#3b4ea1]"
      />
      <button
        type="submit"
        class="absolute right-0 top-0 bottom-0 bg-[#3b4ea1] text-white px-4 py-2 rounded-r shadow-sm hover:shadow-md transition-shadow"
      >
        Cari
      </button>
    </form>
  </div>

  <div class="overflow-x-auto shadow border border-gray-300 rounded">
    <table class="min-w-full border-collapse">
      <thead>
        <tr class="bg-[#b9d0f2] text-black text-sm font-normal">
          <th class="border border-gray-300 px-3 py-2 text-left w-12">No.</th>
          <th class="border border-gray-300 px-3 py-2 text-left w-36">Nama</th>
          <th class="border border-gray-300 px-3 py-2 text-left w-36">Kontak</th>
          <th class="border border-gray-300 px-3 py-2 text-left w-48">Alamat</th>
          <th class="border border-gray-300 px-3 py-2 text-left w-28">Gaji</th>
          <th class="border border-gray-300 px-3 py-2 text-left w-20">Ket.</th>
          <th class="border border-gray-300 px-3 py-2 text-left w-36">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-sm text-black font-normal">
        <tr>
          <td class="border border-gray-300 px-3 py-2">1.</td>
          <td class="border border-gray-300 px-3 py-2">Ian Sopian</td>
          <td class="border border-gray-300 px-3 py-2">081222666444</td>
          <td class="border border-gray-300 px-3 py-2">Wonosobo, 03/04</td>
          <td class="border border-gray-300 px-3 py-2">Rp.350.000</td>
          <td class="border border-gray-300 px-3 py-2">Dibayar</td>
          <td class="border border-gray-300 px-3 py-2 space-x-2">
            <button
              type="button"
              class="bg-[#3b4ea1] text-white text-xs px-3 py-1 rounded shadow-sm hover:shadow-md transition-shadow"
              onclick="openEditModal()"
            >
              Edit
            </button>
            <button
              type="button"
              class="text-white text-xs px-3 py-1 rounded shadow-sm hover:shadow-md transition-shadow"
              style="background-color: #B22222;"
              onclick="openDeleteModal()"
            >
              Hapus
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- Modal Tambah -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white max-w-xs w-full mx-4 p-6 rounded shadow-lg relative">
    <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-900" onclick="closeAddModal()">
      <i class="fas fa-times text-lg"></i>
    </button>
    <h1 class="font-semibold text-xl mb-3">Tambah Pekerja</h1>
    <form method="POST" action="">
      <label class="text-blue-700 text-base mb-1 block">Nama</label>
      <input type="text" name="nama" class="w-full mb-3 px-2 py-1 border border-gray-300 rounded text-gray-700 text-base" required />
      
      <label class="text-blue-700 text-base mb-1 block">Tanggal</label>
      <input type="date" name="tanggal" class="w-full mb-3 px-2 py-1 border border-gray-300 rounded text-base" required />
      
      <label class="text-base mb-1 block">Berat Barang (Kg)</label>
      <input type="number" name="berat" step="0.01" class="w-full mb-3 px-2 py-1 border border-gray-300 rounded text-base" required />
      
      <label class="text-base mb-1 block">Tarif per Kg (Rp.)</label>
      <input type="number" name="tarif" step="100" class="w-full mb-3 px-2 py-1 border border-gray-300 rounded text-base" required />
      
      <label class="text-base mb-1 block">Keterangan</label>
      <select name="keterangan" class="w-full mb-4 border border-gray-300 rounded px-2 py-1 text-base" required>
        <option disabled selected>Pilih Keterangan</option>
        <option value="sudah dibayar">Sudah Dibayar</option>
        <option value="belum dibayar">Belum Dibayar</option>
      </select>
      
      <div class="flex space-x-4">
        <button type="submit" class="bg-blue-700 text-white px-4 py-1 rounded text-base">Simpan</button>
        <button type="reset" class="border border-gray-400 px-4 py-1 rounded text-base">Reset</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white max-w-xs w-full mx-4 p-6 rounded shadow-lg relative">
    <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-900" onclick="closeEditModal()">
      <i class="fas fa-times text-lg"></i>
    </button>
    <h1 class="font-semibold text-xl mb-3">Edit</h1>
    <form method="POST" action="">
      <div class="flex justify-between items-center mb-1">
        <label class="text-blue-700 text-base">Nama</label>
        <span class="text-blue-700 text-base">Ian Sopian</span>
      </div>
      <input type="date" name="tanggal" class="w-full mb-3 px-2 py-1 border border-gray-300 rounded text-base" />

      <label class="text-base mb-1 block">Berat Barang</label>
      <div class="flex mb-2">
        <input type="text" name="berat" class="flex-grow border border-gray-300 rounded-l px-2 py-1 text-base" />
        <div class="border border-gray-300 border-l-0 rounded-r px-3 py-1 text-base flex items-center">Kg</div>
      </div>

      <div class="flex justify-between text-base border-b border-gray-300 pb-1 mb-1">
        <span>Tarif per Kg</span>
        <span>Rp. 2.500</span>
      </div>
      <div class="flex justify-between text-base border-b border-gray-300 pb-1 mb-3">
        <span>Total Gaji</span>
        <span>Rp. 350.000</span>
      </div>

      <select name="keterangan" class="w-full mb-4 border border-gray-300 rounded px-2 py-1 text-base">
        <option disabled selected>Keterangan</option>
        <option value="sudah dibayar">Sudah Dibayar</option>
        <option value="belum dibayar">Belum Dibayar</option>
      </select>

      <div class="flex space-x-4">
        <button type="submit" class="bg-blue-700 text-white px-4 py-1 rounded text-base">Simpan</button>
        <button type="button" class="border border-gray-400 px-4 py-1 rounded text-base" onclick="closeEditModal()">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="w-[280px] border border-gray-300 shadow-md p-5 bg-white rounded">
    <h2 class="font-semibold text-black mb-3 text-base">Hapus Data</h2>
    <p class="text-black mb-5 text-sm leading-relaxed">Apakah anda yakin akan menghapus data ini?</p>
    <div class="flex space-x-3">
      <button class="bg-[#B22222] text-white text-sm font-normal rounded px-4 py-2" onclick="closeDeleteModal()">Hapus</button>
      <button class="border border-gray-400 text-black text-sm font-normal rounded px-4 py-2" onclick="closeDeleteModal()">Batal</button>
    </div>
  </div>
</div>

<!-- Modal JS -->
<script>
  function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  }
  function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }
  function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  }
  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }
  function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  }
  function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }
</script>
