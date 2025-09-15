<?php
include "connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
}

$firstnameErr = $lastnameErr = $usernameErr = $passwordErr = $emailErr = "";

if (isset($_POST['update'])) {
    $id = $_SESSION['id'];

    $firstname = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastname  = mysqli_real_escape_string($conn, $_POST['lastName']);
    $username  = mysqli_real_escape_string($conn, strtolower($_POST['userName']));
    $password  = mysqli_real_escape_string($conn, $_POST['password']);
    $hash      = password_hash($password, PASSWORD_DEFAULT);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "UPDATE register SET 
        firstname = '$firstname',
        lastname  = '$lastname',
        username  = '$username',
        password  = '$hash',
        email     = '$email'
        WHERE id=$id";

    // Validation
    if (empty($firstname)) {
        $firstnameErr = "Please enter your first name";
    } elseif (empty($lastname)) {
        $lastnameErr = "Please enter your last name";
    } elseif (empty($username)) {
        $usernameErr = "Please enter your username";
    } elseif (empty($password)) {
        $passwordErr = "Please choose a password";
    } elseif (strlen($password) <= 4) {
        $passwordErr = "Password must be at least 5 characters";
    } elseif (empty($email)) {
        $emailErr = "Please enter your email address";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "The email address is not correct";
    } elseif (mysqli_query($conn, $query)) {
        header("location:login.php");
    } else {
        echo "<div class='alert error'>❌ Something went wrong. Please try again.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            darkBg: '#282c34',
            darkText: '#fefefe',
            orangeAccent: '#fd961a',
          }
        }
      }
    };
  </script>

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body class="transition-colors duration-300 bg-white text-gray-900 dark:bg-darkBg dark:text-darkText">

  <!-- Desktop Header -->
  <header class="hidden md:flex fixed top-0 left-0 right-0 z-50 justify-between items-center p-4 bg-gray-100 dark:bg-darkBg shadow transition duration-300">
    <nav>
      <ul class="flex gap-6">
        <li><a href="index.php" class="hover:text-orangeAccent transition duration-300">Home</a></li>
        <li><a href="about.php" class="hover:text-orangeAccent transition duration-300">About</a></li>
        <li><a href="profile.php" class="hover:text-orangeAccent transition duration-300">Profile</a></li>
        <li><a href="settings.php" class="text-orangeAccent font-semibold">Settings</a></li>
      </ul>
    </nav>
    <div class="flex gap-2 items-center">
      <a href="login.php" class="px-4 py-2 rounded transition duration-300"
         style="background-color:#282c34; color:#fd961a;">LOG IN</a>
      <a href="register.php" class="px-4 py-2 rounded transition duration-300 bg-[#fd961a] text-black">SIGN UP</a>

      <!-- Dark Mode Toggle -->
      <button onclick="toggleDarkMode()" id="themeToggle" class="ml-4 text-xl transition duration-300 hover:text-orangeAccent">
        <i class="fa-solid fa-moon"></i>
      </button>
    </div>
  </header>

  <!-- Mobile Header -->
  <div class="md:hidden fixed top-0 left-0 right-0 z-50 flex justify-between items-center p-4 bg-gray-100 dark:bg-darkBg shadow transition duration-300">
    <div class="flex items-center gap-4">
      <button onclick="toggleDarkMode()" id="mobileThemeToggle" class="text-xl hover:text-orangeAccent transition duration-300">
        <i class="fa-solid fa-moon"></i>
      </button>
      <button id="hamburger" onclick="display()" class="text-2xl">
        <i class="fa fa-bars"></i>
      </button>
      <button id="close" onclick="hide()" class="text-2xl hidden">
        <i class="fa fa-times"></i>
      </button>
    </div>
  </div>

  <!-- Mobile Nav -->
  <div class="mobile-nav hidden md:hidden flex-col items-center bg-gray-100 dark:bg-darkBg p-4 gap-4 transition duration-300 mt-16">
    <a href="login.php" class="px-4 py-2 w-full text-center rounded transition duration-300"
       style="background-color:#282c34; color:#fd961a;">LOG IN</a>
    <a href="register.php" class="px-4 py-2 w-full text-center bg-[#fd961a] text-black rounded transition duration-300">SIGN UP</a>
    <ul class="w-full text-center space-y-2 mt-4">
      <li><a href="index.php" class="block hover:text-orangeAccent transition duration-300">Home</a></li>
      <li><a href="about.php" class="block hover:text-orangeAccent transition duration-300">About</a></li>
      <li><a href="profile.php" class="block hover:text-orangeAccent transition duration-300">Profile</a></li>
      <li><a href="settings.php" class="block text-orangeAccent font-semibold">Settings</a></li>
    </ul>
  </div>

  <!-- Settings Form -->
  <div class="mt-28 max-w-md mx-auto p-6 bg-gray-100 dark:bg-[#333842] rounded shadow">
    <h2 class="text-xl font-semibold mb-4">⚙️ Update Your Settings</h2>
    <form action="settings.php" method="post" class="space-y-4">

      <input type="text" name="firstName" placeholder="Change First Name"
             class="w-full px-3 py-2 border rounded bg-white dark:bg-darkBg dark:text-darkText">
      <div class="text-red-500 text-sm"><?php echo $firstnameErr ?></div>

      <input type="text" name="lastName" placeholder="Change Last Name"
             class="w-full px-3 py-2 border rounded bg-white dark:bg-darkBg dark:text-darkText">
      <div class="text-red-500 text-sm"><?php echo $lastnameErr ?></div>

      <input type="text" name="userName" placeholder="Change Username"
             class="w-full px-3 py-2 border rounded bg-white dark:bg-darkBg dark:text-darkText">
      <div class="text-red-500 text-sm"><?php echo $usernameErr ?></div>

      <!-- Password with Eye -->
      <div class="relative">
        <input type="password" name="password" id="password" placeholder="Change Password"
               class="w-full px-3 py-2 border rounded bg-white dark:bg-darkBg dark:text-darkText">
        <i class="fa fa-eye absolute right-3 top-3 cursor-pointer" id="togglePassword"></i>
      </div>
      <div class="text-red-500 text-sm"><?php echo $passwordErr ?></div>

      <input type="email" name="email" placeholder="Change Email"
             class="w-full px-3 py-2 border rounded bg-white dark:bg-darkBg dark:text-darkText">
      <div class="text-red-500 text-sm"><?php echo $emailErr ?></div>

      <input type="submit" name="update" value="Update"
             class="w-full px-4 py-2 bg-orangeAccent text-darkBg font-bold rounded cursor-pointer">
    </form>
  </div>

  <!-- Footer -->
  <footer class="footer mt-10 bg-gray-100 dark:bg-darkBg text-center p-4 text-sm transition duration-300">
    <div>
      <a href="terms.php" class="hover:text-orangeAccent transition duration-300">Terms and Conditions</a>
    </div>
    <div class="year mt-2 text-gray-600 dark:text-gray-400 transition duration-300">
      &copy; All Rights Reserved, <span id="span"></span>
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    function display() {
      document.querySelector('.mobile-nav').classList.remove('hidden');
      document.getElementById('hamburger').classList.add('hidden');
      document.getElementById('close').classList.remove('hidden');
    }
    function hide() {
      document.querySelector('.mobile-nav').classList.add('hidden');
      document.getElementById('hamburger').classList.remove('hidden');
      document.getElementById('close').classList.add('hidden');
    }

    document.getElementById("span").textContent = new Date().getFullYear();

    function toggleDarkMode() {
      const html = document.documentElement;
      const themeIcon = document.getElementById('themeToggle')?.querySelector('i');
      const mobileIcon = document.getElementById('mobileThemeToggle')?.querySelector('i');

      if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        themeIcon?.classList.replace('fa-sun', 'fa-moon');
        mobileIcon?.classList.replace('fa-sun', 'fa-moon');
      } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        themeIcon?.classList.replace('fa-moon', 'fa-sun');
        mobileIcon?.classList.replace('fa-moon', 'fa-sun');
      }
    }

    window.addEventListener('DOMContentLoaded', () => {
      const theme = localStorage.getItem('theme');
      const html = document.documentElement;
      const themeIcon = document.getElementById('themeToggle')?.querySelector('i');
      const mobileIcon = document.getElementById('mobileThemeToggle')?.querySelector('i');

      if (theme === 'dark') {
        html.classList.add('dark');
        themeIcon?.classList.replace('fa-moon', 'fa-sun');
        mobileIcon?.classList.replace('fa-moon', 'fa-sun');
      }
    });

    // Password eye toggle
    document.getElementById("togglePassword").addEventListener("click", function () {
      const input = document.getElementById("password");
      input.type = input.type === "password" ? "text" : "password";
      this.classList.toggle("fa-eye-slash");
    });
  </script>
</body>
</html>
