<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body>
  <div class="max-w-xs mx-auto mt-10 p-4 border border-gray-300 shadow-sm">
    <h1 class="font-extrabold text-lg mb-3">Edit</h1>
    <form method="POST" action="">
      <label for="nama" class="text-blue-700 text-sm mb-1 inline-block">Nama</label>
      <span class="text-blue-700 text-sm ml-2">Ian Sopian</span>
      <input
        type="text"
        id="tanggal"
        name="tanggal"
        placeholder="Masukkan Tanggal"
        class="w-full mt-2 mb-3 px-2 py-1 border border-gray-300 rounded text-gray-500 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600"
      />
      <label class="font-semibold text-sm mb-1 block">Berat Barang</label>
      <div class="flex mb-2">
        <input
          type="text"
          name="berat"
          class="flex-grow border border-gray-300 rounded-l px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-600"
        />
        <div
          class="border border-gray-300 border-l-0 rounded-r px-3 py-1 text-sm flex items-center"
        >
          Kg
        </div>
      </div>
      <div class="flex justify-between text-sm border-b border-gray-300 pb-1 mb-1">
        <span>Tarif per Kg</span>
        <span>Rp. 2.500</span>
      </div>
      <div class="flex justify-between text-sm border-b border-gray-300 pb-1 mb-3">
        <span>Total Gaji</span>
        <span>Rp. 350.000</span>
      </div>
      <select
        name="keterangan"
        class="w-full mb-4 border border-gray-300 rounded px-2 py-1 text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-600"
      >
        <option disabled selected>Keterangan</option>
        <option value="sudah dibayar">sudah dibayar</option>
        <option value="belum dibayar">belum dibayar</option>
      </select>
      <div class="flex space-x-4">
        <button
          type="submit"
          class="bg-blue-700 text-white px-4 py-1 rounded text-sm"
        >
          Simpan
        </button>
        <button
          type="button"
          class="border border-gray-400 px-4 py-1 rounded text-sm"
          onclick="window.history.back()"
        >
          Batal
        </button>
      </div>
    </form>
  </div>
</body>
</html>