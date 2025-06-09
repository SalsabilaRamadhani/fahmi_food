<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>Dashboard - Fahmi Food</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <style>
    ::-webkit-scrollbar {
      width: 6px;
    }
    ::-webkit-scrollbar-thumb {
      background-color: rgba(100, 116, 139, 0.5);
      border-radius: 3px;
    }
  </style>
 </head>
 <body class="bg-white font-sans text-gray-700">
  <div class="flex min-h-screen">
   <!-- Sidebar -->
   <aside class="w-[18%] min-w-[180px] border-r border-gray-300 flex flex-col items-start pt-4 space-y-5 select-none">
    <div class="w-full px-4 mb-4 flex justify-center">
     <img id="logo" alt="Fahmi Food" class="w-32 h-32 object-contain" src="assets/logo.png" />
    </div>
    <nav class="w-full space-y-4 px-8">
     <button class="w-full bg-gray-200 text-gray-600 rounded-md py-4 text-[14px] font-normal border border-gray-300 shadow-sm" type="button">Dashboard</button>
     <button class="w-full bg-white text-gray-700 rounded-md py-4 text-[14px] font-normal border border-gray-300" type="button">Produksi</button>
     <button class="w-full bg-white text-gray-700 rounded-md py-4 text-[14px] font-normal border border-gray-300" type="button">Stok</button>
     <button class="w-full bg-white text-gray-700 rounded-md py-4 text-[14px] font-normal border border-gray-300" type="button">Pekerja Lepas</button>
     <button class="w-full bg-white text-gray-700 rounded-md py-4 text-[14px] font-normal border border-gray-300" type="button">Distribusi dan Permintaan</button>
     <button class="w-full bg-white text-gray-700 rounded-md py-4 text-[14px] font-normal border border-gray-300" type="button">Laporan</button>
    </nav>
   </aside>

   <!-- Main content -->
   <main class="flex-1 flex flex-col">
    <!-- Header -->
    <header class="bg-[#3B4EAA] text-white px-8 py-6 text-[20px] font-normal select-none min-h-[128px] flex items-center">
     Dashboard
    </header>

    <!-- Content -->
    <section class="p-8">
     <div class="max-w-7xl mx-auto">
      <div class="flex gap-8 justify-center items-start">
       <!-- Pesanan card -->
       <button aria-label="Detail Pesanan" class="bg-white border border-gray-300 shadow-sm w-52 h-32 flex flex-col justify-center px-8 text-left hover:shadow-md transition-shadow mt-12" type="button">
        <div class="text-[#3B4EAA] font-semibold text-[14px] mb-2 select-text">PESANAN</div>
        <div class="flex items-baseline space-x-1 select-text">
         <span class="text-[40px] font-normal text-black">400</span>
         <span class="text-[18px] font-normal text-black">Kg</span>
        </div>
       </button>

       <!-- Jadwal Harian card -->
       <button aria-label="Detail Jadwal Harian" class="bg-white border border-gray-300 shadow-sm w-[520px] p-6 text-[12px] text-gray-700 text-left hover:shadow-md transition-shadow" type="button">
        <div class="text-[#3B4EAA] font-semibold text-[14px] mb-4 select-text">JADWAL HARIAN</div>
        <table class="w-full border-collapse">
         <thead>
          <tr>
           <th class="text-left font-bold pb-3 pr-4" style="width: 130px;">Tanggal</th>
           <th class="text-left font-bold pb-3 pr-4" style="width: 130px;">Waktu</th>
           <th class="text-left font-bold pb-3 pr-4" style="width: 130px;">Jenis Kegiatan</th>
           <th class="w-8"></th>
           <th class="w-8"></th>
          </tr>
         </thead>
         <tbody>
          <tr class="border-t border-gray-200">
           <td class="pt-3 pb-3 pr-4">2025-03-24</td>
           <td class="pt-3 pb-3 pr-4">07.30 - 01.00</td>
           <td class="pt-3 pb-3 pr-4">Produksi</td>
           <td class="pt-3 pb-3 pr-4 text-center cursor-pointer"><i class="fas fa-pencil-alt text-gray-600"></i></td>
           <td class="pt-3 pb-3 pr-4 text-center cursor-pointer"><i class="fas fa-trash-alt text-gray-600"></i></td>
          </tr>
          <tr class="border-t border-gray-200">
           <td class="pt-3 pb-3 pr-4">2025-03-24</td>
           <td class="pt-3 pb-3 pr-4">19.30 - 11.00</td>
           <td class="pt-3 pb-3 pr-4">Pengemasan</td>
           <td class="pt-3 pb-3 pr-4 text-center cursor-pointer"><i class="fas fa-pencil-alt text-gray-600"></i></td>
           <td class="pt-3 pb-3 pr-4 text-center cursor-pointer"><i class="fas fa-trash-alt text-gray-600"></i></td>
          </tr>
         </tbody>
        </table>
       </button>
      </div>

      <div class="flex gap-20 justify-center mt-10 max-w-[840px] mx-auto">
       <!-- Gaji Pekerja Lepas card -->
       <button aria-label="Detail Gaji Pekerja Lepas" class="bg-white border border-gray-300 shadow-sm w-72 h-32 flex flex-col justify-center px-10 text-left hover:shadow-md transition-shadow" type="button">
        <div class="text-[#3B4EAA] font-semibold text-[14px] mb-2 select-text">GAJI PEKERJA LEPAS</div>
        <div class="text-[24px] font-normal select-text">2.000.000</div>
       </button>

       <!-- Produksi card -->
       <button aria-label="Detail Produksi" class="bg-white border border-gray-300 shadow-sm w-72 h-32 flex flex-col justify-center px-10 text-left hover:shadow-md transition-shadow" type="button">
        <div class="text-[#3B4EAA] font-semibold text-[14px] mb-2 select-text">PRODUKSI</div>
        <div class="flex items-baseline space-x-1 select-text">
         <span class="text-[40px] font-normal text-black">400</span>
         <span class="text-[18px] font-normal text-black">Kg</span>
        </div>
       </button>

       <!-- Stok Harian card -->
       <button aria-label="Detail Stok Harian" class="bg-white border border-gray-300 shadow-sm w-72 h-32 flex flex-col justify-center px-10 text-left hover:shadow-md transition-shadow" type="button">
        <div class="text-[#3B4EAA] font-semibold text-[14px] mb-2 select-text">STOK HARIAN</div>
        <div class="flex items-baseline space-x-1 select-text">
         <span class="text-[40px] font-normal text-black">400</span>
         <span class="text-[18px] font-normal text-black">Kg</span>
        </div>
       </button>
      </div>
     </div>
    </section>
   </main>
  </div>
 </body>
</html>