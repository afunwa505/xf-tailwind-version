<?php 
include 'connect.php';
session_start();

$pwError = $pw2Error = "";

if (isset($_GET['code']) && isset($_GET['email'])) {
    $code = mysqli_real_escape_string($conn, $_GET['code']);
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $check = mysqli_query($conn, "SELECT * FROM resetpassword WHERE email = '$email' AND code = '$code'");

    if (mysqli_num_rows($check) != 1) {
        echo "<div class='text-red-500 text-center mt-10'>❌ Invalid or expired link.</div>";
        exit;
    }
}

// Handle form
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $pw  = mysqli_real_escape_string($conn, $_POST['reset_password1']); 
    $pw2 = mysqli_real_escape_string($conn, $_POST['reset_password2']); 

    if (empty($pw)) {
        $pwError = "Please enter a new password";
    } elseif (strlen($pw) < 5) {
        $pwError = "Password must be at least 5 characters long";
    } elseif (empty($pw2)) {
        $pw2Error = "Please confirm your password";
    } elseif ($pw !== $pw2) {
        $pw2Error = "Passwords do not match";
    } else {
        $hash = password_hash($pw, PASSWORD_DEFAULT);
        $query2 = mysqli_query($conn, "UPDATE register SET password = '$hash' WHERE email = '$email'");
        if ($query2) {
            header("location:login.php");
            exit;
        } else {
            echo "<div class='text-red-500 text-center mt-10'>❌ Failed to update password. Please try again.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>

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
  <header class="hidden md:flex fixed top-0 left-0 right-0 z-50 justify-between items-center p-4 bg-gray-100 dark:bg-darkBg shadow">
    <nav>
      <ul class="flex gap-6">
        <li><a href="index.php" class="hover:text-orangeAccent">Home</a></li>
        <li><a href="about.php" class="hover:text-orangeAccent">About</a></li>
        <li><a href="profile.php" class="hover:text-orangeAccent">Profile</a></li>
        <li><a href="settings.php" class="hover:text-orangeAccent">Settings</a></li>
      </ul>
    </nav>
    <div class="flex gap-2 items-center">
      <a href="login.php" class="px-4 py-2 rounded" style="background:#282c34; color:#fd961a;">LOG IN</a>
      <a href="register.php" class="px-4 py-2 rounded bg-orangeAccent text-black">SIGN UP</a>
      <button onclick="toggleDarkMode()" id="themeToggle" class="ml-4 text-xl hover:text-orangeAccent">
        <i class="fa-solid fa-moon"></i>
      </button>
    </div>
  </header>

  <!-- Mobile Header -->
  <div class="md:hidden fixed top-0 left-0 right-0 z-50 flex justify-between items-center p-4 bg-gray-100 dark:bg-darkBg shadow">
    <div class="flex items-center gap-4">
      <button onclick="toggleDarkMode()" id="mobileThemeToggle" class="text-xl hover:text-orangeAccent">
        <i class="fa-solid fa-moon"></i>
      </button>
      <button id="hamburger" onclick="display()" class="text-2xl"><i class="fa fa-bars"></i></button>
      <button id="close" onclick="hide()" class="text-2xl hidden"><i class="fa fa-times"></i></button>
    </div>
  </div>

  <!-- Mobile Nav -->
  <div class="mobile-nav hidden md:hidden flex-col items-center bg-gray-100 dark:bg-darkBg p-4 gap-4 mt-16">
    <a href="login.php" class="px-4 py-2 w-full text-center rounded" style="background:#282c34; color:#fd961a;">LOG IN</a>
    <a href="register.php" class="px-4 py-2 w-full text-center bg-orangeAccent text-black rounded">SIGN UP</a>
    <ul class="w-full text-center space-y-2 mt-4">
      <li><a href="index.php" class="block hover:text-orangeAccent">Home</a></li>
      <li><a href="about.php" class="block hover:text-orangeAccent">About</a></li>
      <li><a href="profile.php" class="block hover:text-orangeAccent">Profile</a></li>
      <li><a href="settings.php" class="block hover:text-orangeAccent">Settings</a></li>
    </ul>
  </div>

  <!-- Reset Password Form -->
  <div class="mt-28 max-w-md mx-auto p-6 bg-gray-100 dark:bg-[#333842] rounded shadow">
    <h2 class="text-xl font-bold mb-4">🔒 Reset Your Password</h2>
    <form action="" method="post" class="space-y-4">
      <!-- Password 1 -->
      <div class="relative">
        <input type="password" name="reset_password1" id="reset_password1" placeholder="Enter new password"
          class="w-full px-3 py-2 border rounded bg-white dark:bg-darkBg dark:text-darkText">
        <i class="fa fa-eye absolute right-3 top-3 cursor-pointer" id="togglePassword1"></i>
      </div>
      <div class="text-red-500 text-sm"><?php echo $pwError ?></div>

      <!-- Password 2 -->
      <div class="relative">
        <input type="password" name="reset_password2" id="reset_password2" placeholder="Re-type new password"
          class="w-full px-3 py-2 border rounded bg-white dark:bg-darkBg dark:text-darkText">
        <i class="fa fa-eye absolute right-3 top-3 cursor-pointer" id="togglePassword2"></i>
      </div>
      <div class="text-red-500 text-sm"><?php echo $pw2Error ?></div>

      <input type="submit" name="submit" value="Reset Password"
        class="w-full px-4 py-2 bg-orangeAccent text-darkBg font-bold rounded cursor-pointer">
    </form>
  </div>

  <!-- Footer -->
  <footer class="mt-10 bg-gray-100 dark:bg-darkBg text-center p-4 text-sm">
    <div>
      <a href="terms.php" class="hover:text-orangeAccent">Terms and Conditions</a>
    </div>
    <div class="year mt-2 text-gray-600 dark:text-gray-400">&copy; All Rights Reserved, <span id="span"></span></div>
  </footer>

  <script>
    // Mobile nav toggle
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

    // Dark mode toggle
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

    // Apply saved theme
    window.addEventListener('DOMContentLoaded', () => {
      document.getElementById("span").textContent = new Date().getFullYear();
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

    // Password visibility toggle
    document.getElementById("togglePassword1").addEventListener("click", function () {
      const input = document.getElementById("reset_password1");
      input.type = input.type === "password" ? "text" : "password";
      this.classList.toggle("fa-eye-slash");
    });
    document.getElementById("togglePassword2").addEventListener("click", function () {
      const input = document.getElementById("reset_password2");
      input.type = input.type === "password" ? "text" : "password";
      this.classList.toggle("fa-eye-slash");
    });
  </script>
</body>
</html>
