<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Terms and Conditions</title>

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
      <a href="register.php" class="px-4 py-2 rounded transition duration-300 bg-[#fd961a] text-[#282c34]">SIGN UP</a>

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
    <a href="register.php" class="px-4 py-2 w-full text-center bg-[#fd961a] text-[#282c34] rounded transition duration-300">SIGN UP</a>
    <ul class="w-full text-center space-y-2 mt-4">
      <li><a href="index.php" class="block hover:text-orangeAccent transition duration-300">Home</a></li>
      <li><a href="about.php" class="block hover:text-orangeAccent transition duration-300">About</a></li>
      <li><a href="profile.php" class="block hover:text-orangeAccent transition duration-300">Profile</a></li>
      <li><a href="settings.php" class="block hover:text-orangeAccent transition duration-300">Settings</a></li>
    </ul>
  </div>

  <!-- Terms Content -->
  <main class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-bold mb-6">Terms and Conditions</h1>
    <p class="mb-4">Welcome to X-File. These Terms and Conditions govern your use of our file upload and storage services.  By accessing or using our website, you agree to comply with these terms. Please read them carefully before proceeding. </p>

    <p class="mb-4">
        1. Acceptance of Terms:
        By using our website, you acknowledge that you have read, understood, and agreed to be bound by these Terms and Conditions, as well as our Privacy Policy. If you do not agree with any part of these terms, please do not access or use our services.
            </p>
                
              <p class="mb-4">
                2. Use of Services:  <br />
            a. Eligibility: You must be of age certified by your country to use a computer device or to access the internet or have the legal capacity to enter into a contract to use our services. By using our website, you represent and warrant that you meet these requirements.
            </p>

              <p class="mb-4">
                b. User Accounts: To access certain features of our website, you may need to create a user account. You are responsible for maintaining the confidentiality of your account information, including your username and password. You agree to be solely responsible for all activities that occur under your account. 
            </p>

              <p class="mb-4">
                c. Prohibited Activities: You agree not to use our services for any unlawful or unauthorized purposes, including but not limited to uploading or sharing files that infringe upon the intellectual property rights of others, contain viruses or malware, or promote hate speech or violence. You are solely responsible for the files you upload and share.
            </p>

             <p class="mb-4">
                d. Storage Limitations: We may impose storage limitations on your account to ensure fair and efficient use of our services. We reserve the right to delete or remove files that exceed these limits or violate our terms.
            </p>

             <p class="mb-4">
                1. Intellectual Property: <br />
            a. Ownership: We retain all ownership rights to our website, including its design, content, and underlying technology. You may not copy, modify, distribute, or reproduce any part of our website without our prior written consent.
            </p>

             <p class="mb-4">
                 b. User Content: By uploading files to our website, you grant us a non-exclusive, worldwide, royalty-free license to use, reproduce, modify, and distribute such content for the sole purpose of providing our services. You represent and warrant that you have the necessary rights to grant us this license.
            </p>

             <p class="mb-4">
                1. Privacy: <br />
            We respect your privacy and handle your personal information in accordance with our Privacy Policy. By using our services, you consent to the collection, use, and disclosure of your information as described in our Privacy Policy
            </p>

            <p class="mb-4">
                2. Disclaimer of Warranties: <br />
            a. Our services are provided on an "as is" and "as available" basis. We make no warranties or representations, express or implied, regarding the reliability, accuracy, or availability of our website.
            </p>

            <p class="mb-4">
                b. We do not guarantee the 100% security of your files, and you acknowledge and agree that you upload and share files at your own risk.
            </p>

            <p class="mb-4">
                1. Limitation of Liability: <br />
            a. To the extent permitted by applicable laws, we shall not be liable for any direct, indirect, incidental, consequential, or special damages arising out of or in connection with the use or inability to use our services.
            </p>

            <p class="mb-4">
                  b. In no event shall our total liability exceed the amount you have paid, if any, for the use of our services in the past 12 months.
            </p>

                <p class="mb-4">
                  1. Indemnification: <br />
            You agree to indemnify and hold us harmless from any claims, losses, damages, liabilities, costs, and expenses (including attorney's fees) arising out of or in connection with your use of our services, your violation of these Terms and Conditions, or your infringement of any rights of a third party.
            </p>

                <p class="mb-4">
                      2. Modification of Terms: <br />
            We reserve the right to modify these Terms and Conditions at any time. Any changes will be effective upon posting on our website. It is your responsibility to review these terms periodically for updates. Continued use of our services after any modifications constitutes your acceptance of the revised terms.
            </p>

                <p class="mb-4">
                     3. Governing Law and Jurisdiction: <br />
            These Terms and Conditions shall be governed by and construed in accordance with the laws of Jurisdiction. Any disputes arising out of or in connection with these terms shall be subject to the exclusive jurisdiction of the courts in Jurisdiction.
            </p>

            <p class="mb-4">
                If you have any questions or concerns regarding these Terms and Conditions, please contact us.
            </p>

    <p class="mt-6">Last updated: <span id="span"></span></p>
  </main>

  <!-- Footer -->
  <footer class="footer mt-10 bg-gray-100 dark:bg-darkBg text-center p-4 text-sm transition duration-300">
    <div>
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

    // Set current year
    document.querySelectorAll("#span").forEach(el => el.textContent = new Date().getFullYear());

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

    // Apply saved theme
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
