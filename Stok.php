<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Stok - Fahmi Food
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
 </head>
 <body class="bg-white font-sans">
  <div class="flex min-h-screen shadow-md">
   <!-- Sidebar -->
   <aside class="w-56 bg-white border-r border-gray-200 flex flex-col">
    <div class="p-6 flex flex-col items-center">
     <img alt="Placeholder logo image, square with text 'Logo Placeholder'" class="w-24 h-24 object-contain" height="100" src="https://storage.googleapis.com/a1aa/image/9dd33ecd-6ccf-45c4-5fab-a8ce6f2c13cf.jpg" width="100"/>
    </div>
    <nav class="flex flex-col gap-4 px-4 pb-6">
     <button class="w-full py-3 rounded border border-gray-300 shadow-sm text-center text-base font-normal text-black hover:shadow-md transition-shadow" type="button">
      Dashboard
     </button>
     <button class="w-full py-3 rounded border border-gray-300 shadow-sm text-center text-base font-normal text-black hover:shadow-md transition-shadow" type="button">
      Produksi
     </button>
     <button class="w-full py-3 rounded border border-[#2E49B0] bg-[#E3E6F7] text-center text-base font-normal text-gray-400 cursor-not-allowed" disabled="" type="button">
      Stok
     </button>
     <button class="w-full py-3 rounded border border-gray-300 shadow-sm text-center text-base font-normal text-black hover:shadow-md transition-shadow" type="button">
      Pekerja Lepas
     </button>
     <button class="w-full py-3 rounded border border-gray-300 shadow-sm text-center text-base font-normal text-black hover:shadow-md transition-shadow" type="button">
      Distribusi dan Permintaan
     </button>
     <button class="w-full py-3 rounded border border-gray-300 shadow-sm text-center text-base font-normal text-black hover:shadow-md transition-shadow" type="button">
      Laporan
     </button>
    </nav>
   </aside>
   <!-- Main content -->
   <main class="flex-1 flex flex-col">
    <header class="bg-[#2E49B0] text-white px-8 py-6 shadow-sm flex items-center">
     <h1 class="text-xl font-normal select-none">
      STOK
     </h1>
    </header>
    <section class="flex-1 p-6 bg-white">
     <form action="&lt;?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?&gt;" method="post">
      <button class="mb-4 inline-flex items-center gap-2 bg-[#2E49B0] text-white text-sm font-normal px-4 py-2 rounded shadow-sm hover:shadow-md transition-shadow" name="add_product" type="submit">
       <i class="fas fa-plus">
       </i>
       Tambah Produk
      </button>
     </form>
     <div class="overflow-x-auto shadow border border-gray-200 rounded">
      <table class="min-w-full border-collapse">
       <thead>
        <tr class="bg-[#C6D5F5] text-left text-sm font-normal text-black">
         <th class="px-4 py-2 border border-[#C6D5F5] w-14">
          No.
         </th>
         <th class="px-4 py-2 border border-[#C6D5F5] w-24">
          ID Poduk
         </th>
         <th class="px-4 py-2 border border-[#C6D5F5]">
          Nama Produk
         </th>
         <th class="px-4 py-2 border border-[#C6D5F5] w-28">
          Status Stok
         </th>
         <th class="px-4 py-2 border border-[#C6D5F5] w-28">
          Jumlah Stok
         </th>
         <th class="px-4 py-2 border border-[#C6D5F5] w-48 text-center">
          Aksi
         </th>
        </tr>
       </thead>
       <tbody>
        <?php
              // Example PHP array for productss
                $products = [
    [
        'id' => 'AG01',
        'name' => 'Agar-Agar Pelangi',
        'status' => 'Tersedia',
        'quantity' => '230 Kg',
    ],
];


              $no = 1;
              foreach ($products as $product) {
                echo '
        <tr class="text-sm text-black">
         ';
                echo '
         <td class="px-4 py-2 border border-gray-200">
          ' . $no++ . '.
         </td>
         ';
                echo '
         <td class="px-4 py-2 border border-gray-200">
          ' . htmlspecialchars($product['id']) . '
         </td>
         ';
                echo '
         <td class="px-4 py-2 border border-gray-200">
          ' . htmlspecialchars($product['name']) . '
         </td>
         ';
                echo '
         <td class="px-4 py-2 border border-gray-200">
          ' . htmlspecialchars($product['status']) . '
         </td>
         ';
                echo '
         <td class="px-4 py-2 border border-gray-200">
          ' . htmlspecialchars($product['quantity']) . '
         </td>
         ';
                echo '
         <td class="px-4 py-2 border border-gray-200 text-center flex justify-center gap-2">
          ';
                echo '
          <form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" class="inline" method="post">
           ';
                echo '
           <input name="edit_id" type="hidden" value="' . htmlspecialchars($product['id']) . '"/>
           ';
                echo '
           <button class="bg-[#2E49B0] text-white text-xs px-3 py-1 rounded hover:bg-[#243a8a] transition-colors" name="edit" type="submit">
            Edit
           </button>
           ';
                echo '
          </form>
          ';
                echo '
          <form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" class="inline" method="post">
           ';
                echo '
           <input name="delete_id" type="hidden" value="' . htmlspecialchars($product['id']) . '"/>
           ';
                echo '
           <button class="bg-red-600 text-white text-xs px-3 py-1 rounded hover:bg-red-700 transition-colors" name="delete" type="submit">
            Hapus
           </button>
           ';
                echo '
          </form>
          ';
                echo '
         </td>
         ';
                echo '
        </tr>
        ';
              }
              ?>
       </tbody>
      </table>
     </div>
    </section>
   </main>
  </div>
 </body>
</html>
