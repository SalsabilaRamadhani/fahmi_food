<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
  <form class="border border-gray-300 shadow-sm p-8 w-80" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <h2 class="text-center text-black mb-8 font-normal text-xl">LOGIN</h2>
    <label for="username" class="block text-blue-700 mb-1 text-sm font-medium">Username</label>
    <input
      id="username"
      name="username"
      type="text"
      placeholder="Masukkan Username"
      class="w-full mb-6 px-3 py-2 border border-gray-300 rounded-md text-gray-400 placeholder-gray-400 text-sm focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700"
      value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
      required
    />
    <label for="password" class="block text-blue-700 mb-1 text-sm font-medium">Password</label>
    <input
      id="password"
      name="password"
      type="password"
      placeholder="Masukkan Password"
      class="w-full mb-6 px-3 py-2 border border-gray-300 rounded-md text-gray-400 placeholder-gray-400 text-sm focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700"
      required
    />
    <button
      type="submit"
      class="block mx-auto bg-blue-700 text-white px-6 py-2 rounded-md text-sm"
    >
      Login
    </button>
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = htmlspecialchars($_POST['username']);
      $password = htmlspecialchars($_POST['password']);
      // Example simple validation (replace with real authentication logic)
      if ($username === "admin" && $password === "password") {
          echo '<p class="text-center mt-4 text-green-600 font-semibold">Login successful!</p>';
      } else {
          echo '<p class="text-center mt-4 text-red-600 font-semibold">Invalid username or password.</p>';
      }
  }
  ?>
</body>
</html>