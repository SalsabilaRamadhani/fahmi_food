<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Location: ../Index.php?page=produksi");
    exit;
}

    // Data produk produksi
    $produksi = [
      [
        "id" => "AG01",
        "nama" => "Agar Pelangi",
        "tanggal" => "25-03-2025",
        "jumlah_produksi" => 250,
        "jumlah_dikemas" => 230,
        "jumlah_reject" => 20,
        "satuan" => "kg"
      ],
    ];

    // Hitung total jumlah produksi, dikemas, reject
    $total_produksi = 0;
    $total_dikemas = 0;
    $total_reject = 0;
    foreach ($produksi as $item) {
      $total_produksi += $item["jumlah_produksi"];
      $total_dikemas += $item["jumlah_dikemas"];
      $total_reject += $item["jumlah_reject"];
    }

    // Handle form submission for tambah produk
    $form_submitted = false;
    $form_data = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
      $form_submitted = true;
      $form_data = [
        "id_produk" => htmlspecialchars($_POST['id_produk']),
        "nama_produk" => htmlspecialchars($_POST['nama_produk']),
        "tanggal_produksi" => htmlspecialchars($_POST['tanggal_produksi']),
        "jumlah_produksi" => (int)$_POST['jumlah_produksi'],
        "jumlah_dikemas" => (int)$_POST['jumlah_dikemas'],
        "jumlah_reject" => (int)$_POST['jumlah_reject'],
      ];
    }
  ?>
 
    <!-- Main content -->
      <section class="p-6 overflow-x-auto">
        <button
          id="btnTambahProduk"
          type="button"
          class="mb-4 inline-flex items-center gap-2 rounded-md bg-[#3249b3] px-4 py-2 text-white text-sm font-normal hover:bg-[#2a3b8a] transition-colors"
        >
          <i class="fas fa-plus"></i> Tambah Produk
        </button>

        <table class="w-full border border-gray-300 text-sm border-collapse">
          <thead>
            <tr class="bg-[#c3d1f0] text-center text-xs font-normal text-black">
              <th class="border border-gray-300 px-2 py-1 w-12">No.</th>
              <th class="border border-gray-300 px-2 py-1 w-20">ID Produk</th>
              <th class="border border-gray-300 px-2 py-1 w-48">Nama Produk</th>
              <th class="border border-gray-300 px-2 py-1 w-32">Tanggal Produksi</th>
              <th class="border border-gray-300 px-2 py-1 w-28">Jumlah Produksi</th>
              <th class="border border-gray-300 px-2 py-1 w-28">Jumlah Dikemas</th>
              <th class="border border-gray-300 px-2 py-1 w-28">Jumlah Reject</th>
              <th class="border border-gray-300 px-2 py-1 w-24">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-center text-xs text-black">
            <?php
              $max_rows = 5;
              $count = count($produksi);
              for ($i = 0; $i < $max_rows; $i++) {
                if ($i < $count) {
                  $item = $produksi[$i];
                  echo '<tr data-index="'.$i.'">';
                  echo '<td class="border border-gray-300 px-2 py-1 text-left pl-3">' . ($i+1) . '.</td>';
                  echo '<td class="border border-gray-300 px-2 py-1">' . htmlspecialchars($item["id"]) . '</td>';
                  echo '<td class="border border-gray-300 px-2 py-1 text-left pl-3">' . htmlspecialchars($item["nama"]) . '</td>';
                  echo '<td class="border border-gray-300 px-2 py-1">' . htmlspecialchars($item["tanggal"]) . '</td>';
                  echo '<td class="border border-gray-300 px-2 py-1">' . $item["jumlah_produksi"] . ' ' . htmlspecialchars($item["satuan"]) . '</td>';
                  echo '<td class="border border-gray-300 px-2 py-1">' . $item["jumlah_dikemas"] . ' ' . htmlspecialchars($item["satuan"]) . '</td>';
                  echo '<td class="border border-gray-300 px-2 py-1">' . $item["jumlah_reject"] . ' ' . htmlspecialchars($item["satuan"]) . '</td>';
                  echo '<td class="border border-gray-300 px-2 py-1 space-x-1">';
                  echo '<button type="button" class="btnEdit bg-[#3249b3] text-white text-xs px-3 py-0.5 rounded hover:bg-[#2a3b8a] transition-colors">Edit</button>';
                  echo '<button type="button" class="btnHapus bg-red-700 text-white text-xs px-3 py-0.5 rounded hover:bg-red-800 transition-colors">Hapus</button>';
                  echo '</td>';
                  echo '</tr>';
                } else {
                  echo '<tr>';
                  for ($j = 0; $j < 8; $j++) {
                    echo '<td class="border border-gray-300 px-2 py-1">&nbsp;</td>';
                  }
                  echo '</tr>';
                }
              }
            ?>
          </tbody>
          <tfoot>
            <tr class="text-xs text-black text-center">
              <td class="border border-gray-300 px-2 py-1" colspan="4" style="text-align:right; padding-right: 0.75rem;">
                Jumlah
              </td>
              <td class="border border-gray-300 px-2 py-1"><?php echo $total_produksi . " kg"; ?></td>
              <td class="border border-gray-300 px-2 py-1"><?php echo $total_dikemas . " kg"; ?></td>
              <td class="border border-gray-300 px-2 py-1"><?php echo $total_reject . " kg"; ?></td>
              <td class="border border-gray-300 px-2 py-1">&nbsp;</td>
            </tr>
          </tfoot>
        </table>
      </section>

  <!-- Modal overlay for Tambah Produk -->
  <div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="w-72 bg-white p-6 rounded shadow-lg relative">
      <h2 class="text-black text-lg font-semibold mb-4">Input Produk</h2>
      <input
        type="text"
        name="id_produk"
        placeholder="ID Produk"
        class="w-full mb-3 px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
        required
      />
      <input
        type="text"
        name="nama_produk"
        placeholder="Nama Produk"
        class="w-full mb-3 px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
        required
      />
      <div class="flex flex-col mb-3">
        <label for="tanggalProduksiTambah" class="mb-1 text-sm font-medium text-gray-700">Tanggal Produksi</label>
        <input
          id="tanggalProduksiTambah"
          name="tanggal_produksi"
          type="date"
          class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
          required
        />
      </div>
      <input
        type="number"
        name="jumlah_produksi"
        placeholder="Jumlah Produksi"
        class="w-full mb-3 px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
        required
      />
      <input
        type="number"
        name="jumlah_dikemas"
        placeholder="Jumlah Dikemas"
        class="w-full mb-3 px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
        required
      />
      <input
        type="number"
        name="jumlah_reject"
        placeholder="Jumlah Reject"
        class="w-full mb-5 px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
        required
      />
      <button
        type="submit"
        name="submit"
        class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 transition"
      >
        Simpan
      </button>
      <button
        type="button"
        id="btnCloseTambah"
        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
        aria-label="Close modal"
      >
        <i class="fas fa-times"></i>
      </button>
    </form>
  </div>

  <!-- Modal overlay for Edit Produk -->
  <div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="max-w-xs mx-auto p-6 bg-white rounded shadow-lg relative">
      <h1 class="text-black text-xl font-semibold mb-6">Edit Produk</h1>
      <form id="formEdit" class="space-y-4">
        <input
          type="text"
          id="editIdProduk"
          placeholder="ID Produk"
          class="w-full px-3 py-2 rounded border border-gray-300 shadow-sm text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
          readonly
        />
        <input
          type="text"
          id="editNamaProduk"
          placeholder="Nama Produk"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
          required
        />
        <div class="flex flex-col">
          <label for="editTanggalProduksi" class="mb-1 text-sm font-medium text-gray-700">Tanggal Produksi</label>
          <input
            id="editTanggalProduksi"
            name="tanggalProduksi"
            type="date"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
            required
          />
        </div>
        <input
          type="number"
          id="editJumlahProduksi"
          placeholder="Jumlah Produksi"
          class="w-full px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
          required
        />
        <input
          type="number"
          id="editJumlahDikemas"
          placeholder="Jumlah Dikemas"
          class="w-full px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
          required
        />
        <input
          type="number"
          id="editJumlahReject"
          placeholder="Jumlah Reject"
          class="w-full px-3 py-2 rounded border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
          required
        />
        <button
          type="submit"
          class="w-full bg-blue-700 text-white py-2 rounded text-center"
        >
          Simpan
        </button>
      </form>
      <button
        type="button"
        id="btnCloseEdit"
        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
        aria-label="Close modal"
      >
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>

  <!-- Modal overlay for Hapus Data -->
  <div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="w-[280px] border border-gray-300 shadow-md p-5 bg-white rounded relative">
      <h2 class="font-semibold text-black mb-3 text-base">Hapus Data</h2>
      <p class="text-black mb-5 text-sm leading-relaxed">Apakah anda yakin akan menghapus data ini?</p>
      <div class="flex space-x-3">
        <button id="btnConfirmHapus" class="bg-[#B22222] text-white text-sm font-normal rounded px-4 py-2">Hapus</button>
        <button id="btnCancelHapus" class="border border-gray-400 text-black text-sm font-normal rounded px-4 py-2">Batal</button>
      </div>
      <button
        type="button"
        id="btnCloseHapus"
        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
        aria-label="Close modal"
      >
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>

  <?php if ($form_submitted): ?>
    <div class="fixed bottom-4 right-4 z-50 w-72 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg">
      <strong class="font-bold">Data Produk Disimpan:</strong><br />
      ID Produk: <?php echo $form_data['id_produk']; ?><br />
      Nama Produk: <?php echo $form_data['nama_produk']; ?><br />
      Tanggal Produksi: <?php echo $form_data['tanggal_produksi']; ?><br />
      Jumlah Produksi: <?php echo $form_data['jumlah_produksi']; ?><br />
      Jumlah Dikemas: <?php echo $form_data['jumlah_dikemas']; ?><br />
      Jumlah Reject: <?php echo $form_data['jumlah_reject']; ?><br />
    </div>
  <?php endif; ?>

  <script>
    const btnTambah = document.getElementById('btnTambahProduk');
    const modalTambah = document.getElementById('modalTambah');
    const btnCloseTambah = document.getElementById('btnCloseTambah');

    const modalEdit = document.getElementById('modalEdit');
    const btnCloseEdit = document.getElementById('btnCloseEdit');

    const modalHapus = document.getElementById('modalHapus');
    const btnCloseHapus = document.getElementById('btnCloseHapus');
    const btnCancelHapus = document.getElementById('btnCancelHapus');
    const btnConfirmHapus = document.getElementById('btnConfirmHapus');

    const editIdProduk = document.getElementById('editIdProduk');
    const editNamaProduk = document.getElementById('editNamaProduk');
    const editTanggalProduksi = document.getElementById('editTanggalProduksi');
    const editJumlahProduksi = document.getElementById('editJumlahProduksi');
    const editJumlahDikemas = document.getElementById('editJumlahDikemas');
    const editJumlahReject = document.getElementById('editJumlahReject');

    let rowToDelete = null;

    btnTambah.addEventListener('click', () => {
      modalTambah.classList.remove('hidden');
      modalTambah.classList.add('flex');
    });

    btnCloseTambah.addEventListener('click', () => {
      modalTambah.classList.add('hidden');
      modalTambah.classList.remove('flex');
    });

    modalTambah.addEventListener('click', (e) => {
      if (e.target === modalTambah) {
        modalTambah.classList.add('hidden');
        modalTambah.classList.remove('flex');
      }
    });

    btnCloseEdit.addEventListener('click', () => {
      modalEdit.classList.add('hidden');
      modalEdit.classList.remove('flex');
    });

    modalEdit.addEventListener('click', (e) => {
      if (e.target === modalEdit) {
        modalEdit.classList.add('hidden');
        modalEdit.classList.remove('flex');
      }
    });

    btnCloseHapus.addEventListener('click', closeHapusModal);
    btnCancelHapus.addEventListener('click', closeHapusModal);

    function closeHapusModal() {
      modalHapus.classList.add('hidden');
      modalHapus.classList.remove('flex');
      rowToDelete = null;
    }

    modalHapus.addEventListener('click', (e) => {
      if (e.target === modalHapus) {
        closeHapusModal();
      }
    });

    // Attach event listeners to all Edit buttons
    document.querySelectorAll('.btnEdit').forEach(button => {
      button.addEventListener('click', (e) => {
        const tr = e.target.closest('tr');
        const index = tr.getAttribute('data-index');
        // Get data from the row cells
        const cells = tr.querySelectorAll('td');
        // cells: 0=No,1=ID,2=Nama,3=Tanggal,4=Jml Produksi,5=Jml Dikemas,6=Jml Reject,7=Aksi
        editIdProduk.value = cells[1].textContent.trim();
        editNamaProduk.value = cells[2].textContent.trim();
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd for input[type=date]
        const dateParts = cells[3].textContent.trim().split('-');
        if (dateParts.length === 3) {
          editTanggalProduksi.value = `${dateParts[2]}-${dateParts[1].padStart(2,'0')}-${dateParts[0].padStart(2,'0')}`;
        } else {
          editTanggalProduksi.value = '';
        }
        // Remove unit (e.g. "250 kg") and parse number
        editJumlahProduksi.value = parseInt(cells[4].textContent.trim()) || '';
        editJumlahDikemas.value = parseInt(cells[5].textContent.trim()) || '';
        editJumlahReject.value = parseInt(cells[6].textContent.trim()) || '';

        modalEdit.classList.remove('hidden');
        modalEdit.classList.add('flex');
      });
    });

    // Optional: handle formEdit submission here or via server
    document.getElementById('formEdit').addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Simpan perubahan produk belum diimplementasikan.');
      modalEdit.classList.add('hidden');
      modalEdit.classList.remove('flex');
    });

    // Attach event listeners to all Hapus buttons
    document.querySelectorAll('.btnHapus').forEach(button => {
      button.addEventListener('click', (e) => {
        rowToDelete = e.target.closest('tr');
        modalHapus.classList.remove('hidden');
        modalHapus.classList.add('flex');
      });
    });

    btnConfirmHapus.addEventListener('click', () => {
      if (rowToDelete) {
        rowToDelete.remove();
        rowToDelete = null;
      }
      closeHapusModal();
    });
  </script>