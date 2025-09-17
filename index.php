<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>

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

  <!-- FontAwesome 6 (Icons Work Properly) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body class="transition-colors duration-300 bg-white text-gray-900 dark:bg-darkBg dark:text-darkText">

  <!-- Desktop Header -->
  <header class="hidden md:flex justify-between items-center p-4 bg-gray-100 dark:bg-darkBg shadow transition duration-300">
    <nav>
      <ul class="flex gap-6">
        <li><a href="index.php" class="hover:text-orangeAccent transition duration-300">Home</a></li>
        <li><a href="about.php" class="hover:text-orangeAccent transition duration-300">About</a></li>
        <li><a href="profile.php" class="hover:text-orangeAccent transition duration-300">Profile</a></li>
        <li><a href="settings.php" class="hover:text-orangeAccent transition duration-300">Settings</a></li>
      </ul>
    </nav>
    <div class="flex gap-2 items-center">
      <!-- Login -->
      <a href="login.php" class="px-4 py-2 rounded transition duration-300"
         style="background-color: #282c34; color: #fd961a;">LOG IN</a>

      <!-- Register -->
      <a href="register.php" class="px-4 py-2 rounded transition duration-300 bg-[#fd961a] text-black dark:text-black">SIGN UP</a>

      <!-- Dark Mode Toggle -->
      <button onclick="toggleDarkMode()" id="themeToggle" class="ml-4 text-xl transition duration-300 hover:text-orangeAccent">
        <i class="fa-solid fa-moon"></i>
      </button>
    </div>
  </header>

  <!-- Mobile Header -->
  <div class="md:hidden flex justify-between items-center p-4 bg-gray-100 dark:bg-darkBg shadow transition duration-300">
    <div class="flex items-center gap-4">
      <!-- Mobile Dark Mode Toggle -->
      <button onclick="toggleDarkMode()" id="mobileThemeToggle" class="text-xl hover:text-orangeAccent transition duration-300">
        <i class="fa-solid fa-moon"></i>
      </button>

      <!-- Menu Toggle -->
      <button id="hamburger" onclick="display()" class="text-2xl">
        <i class="fa fa-bars"></i>
      </button>
      <button id="close" onclick="hide()" class="text-2xl hidden">
        <i class="fa fa-times"></i>
      </button>
    </div>
  </div>

  <!-- Mobile Nav -->
  <div class="mobile-nav hidden md:hidden flex-col items-center bg-gray-100 dark:bg-darkBg p-4 gap-4 transition duration-300">
    <a href="login.php" class="px-4 py-2 w-full text-center rounded transition duration-300"
       style="background-color: #282c34; color: #fd961a;">LOG IN</a>
    <a href="register.php" class="px-4 py-2 w-full text-center bg-[#fd961a] text-black rounded transition duration-300">SIGN UP</a>
    <ul class="w-full text-center space-y-2 mt-4">
      <li><a href="index.php" class="block hover:text-orangeAccent transition duration-300">Home</a></li>
      <li><a href="about.php" class="block hover:text-orangeAccent transition duration-300">About</a></li>
      <li><a href="profile.php" class="block hover:text-orangeAccent transition duration-300">Profile</a></li>
      <li><a href="settings.php" class="block hover:text-orangeAccent transition duration-300">Settings</a></li>
    </ul>
  </div>

  <!-- Background Section -->
  <div class="container1 bg-cover bg-center transition duration-300 w-full" style="background-image: url('./image/jumpers.jpg');
  background-repeat: no-repeat;
  background-size: 100% 100%;
   height: 460px;">
    <!-- Optional Background Content -->
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
    // Toggle mobile nav
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

    // Set current year
    document.getElementById("span").textContent = new Date().getFullYear();

    // Dark mode toggle logic
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

    // Apply saved theme on load
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
  </script>
</body>
</html>
