<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-white">
  <form class="border border-gray-300 p-6 w-72" action="#" method="POST">
    <h2 class="text-center text-black mb-4 text-sm font-normal">LOGIN</h2>
    <label class="block text-xs text-black mb-1" for="username">Username</label>
    <input
      id="username"
      name="username"
      type="text"
      placeholder="Masukkan Username"
      class="w-full text-xs text-gray-500 border border-gray-300 rounded px-2 py-1 mb-3 focus:outline-none focus:ring-1 focus:ring-blue-600"
    />
    <label class="block text-xs text-black mb-1" for="password">Password</label>
    <input
      id="password"
      name="password"
      type="password"
      placeholder="Masukkan Password"
      class="w-full text-xs text-gray-500 border border-gray-300 rounded px-2 py-1 mb-4 focus:outline-none focus:ring-1 focus:ring-blue-600"
    />
    <button
      type="submit"
      class="w-full bg-blue-700 text-white text-xs rounded px-3 py-1.5 hover:bg-blue-800"
    >
      Login
    </button>
  </form>
</body>
</html>