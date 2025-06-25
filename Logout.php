<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Logout Confirmation</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">
  <form action="Login.php" method="post" class="w-72 p-6 border border-gray-300 shadow-md bg-white">
    <h2 class="font-bold text-black text-lg mb-3">Logout</h2>
    <p class="text-black mb-6">Apakah anda yakin ingin keluar dari sistem?</p>
    <div class="flex space-x-3">
      <button type="submit" class="bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded">Keluar</button>
      <button type="button" onclick="history.back()" class="border border-gray-400 text-black text-sm font-normal px-4 py-2 rounded">Batal</button>
    </div>
  </form>
</body>
</html>