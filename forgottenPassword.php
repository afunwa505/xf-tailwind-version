<?php
include 'connect.php';
session_start();

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$statusMsg = "";

if (isset($_POST['email'])) {
    $emailTo = trim($_POST['email']);

    // Check if email exists in register table
    $checkUser = mysqli_query($conn, "SELECT * FROM register WHERE email='$emailTo' LIMIT 1");

    if (mysqli_num_rows($checkUser) > 0) {
        $code = uniqid(true); 

        // Save reset request
        $query = mysqli_query($conn, "INSERT INTO resetPassword (code, email) VALUES('$code','$emailTo')");

        if (!$query) {
            $statusMsg = "❌ Database error, please try again.";
        } else {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();                                            
                $mail->Host       = 'smtp.gmail.com';                     
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = 'afunwaemmanuel505@gmail.com';         
                $mail->Password   = 'qfbzrwcilpsznjqe';                    
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
                $mail->Port       = 465;                                    

                $mail->setFrom('afunwaemmanuel505@gmail.com', 'Your Website');
                $mail->addAddress($emailTo);     

                $mail->isHTML(true);                                  
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "
                    <h2>Password Reset Request</h2>
                    <p>You requested to reset your password.</p>
                    <p>Click the link below to continue:</p>
                    <a href='http://localhost/xf/resetPassword.php?code=".$code."'>Reset Your Password</a>
                    <br><br>
                    <p>If you did not request this, please ignore this email.</p>
                ";
                $mail->AltBody = "Click here to reset your password: http://localhost/xf/resetPassword.php?code=".$code;

                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ]
                ];

                $mail->send();
                $statusMsg = "✅ Password reset link has been sent to your email.";
            } catch (Exception $e) {
                $statusMsg = "❌ Message could not be sent. Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        $statusMsg = "❌ No account found with that email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgotten Password</title>

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

  <!-- Header -->
  <header class="hidden md:flex fixed top-0 left-0 right-0 z-50 justify-between items-center p-4 bg-gray-100 dark:bg-darkBg shadow">
    <nav>
      <ul class="flex gap-6">
        <li><a href="index.php" class="hover:text-orangeAccent transition">Home</a></li>
        <li><a href="about.php" class="hover:text-orangeAccent transition">About</a></li>
        <li><a href="profile.php" class="hover:text-orangeAccent transition">Profile</a></li>
        <li><a href="settings.php" class="hover:text-orangeAccent transition">Settings</a></li>
      </ul>
    </nav>
    <div class="flex gap-2 items-center">
      <a href="login.php" class="px-4 py-2 rounded" style="background:#282c34;color:#fd961a;">LOG IN</a>
      <a href="register.php" class="px-4 py-2 rounded bg-[#fd961a] text-black">SIGN UP</a>
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
    <a href="login.php" class="px-4 py-2 w-full text-center rounded" style="background:#282c34;color:#fd961a;">LOG IN</a>
    <a href="register.php" class="px-4 py-2 w-full text-center bg-[#fd961a] text-black rounded">SIGN UP</a>
    <ul class="w-full text-center space-y-2 mt-4">
      <li><a href="index.php" class="block hover:text-orangeAccent transition">Home</a></li>
      <li><a href="about.php" class="block hover:text-orangeAccent transition">About</a></li>
      <li><a href="profile.php" class="block hover:text-orangeAccent transition">Profile</a></li>
      <li><a href="settings.php" class="block hover:text-orangeAccent transition">Settings</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <main class="pt-28 max-w-md mx-auto px-6">
    <h1 class="text-2xl font-bold text-center mb-6">Forgotten Password</h1>

    <?php if (!empty($statusMsg)): ?>
      <div id="alertBox" class="flex justify-between items-center bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span><?php echo $statusMsg; ?></span>
        <button onclick="document.getElementById('alertBox').remove();" class="text-lg font-bold">&times;</button>
      </div>
      <script>
        setTimeout(() => document.getElementById('alertBox')?.remove(), 5000);
      </script>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="bg-gray-100 dark:bg-[#333842] p-6 rounded shadow space-y-4">
      <input type="email" name="email" placeholder="Enter your Email"
             class="w-full px-4 py-2 rounded border border-gray-300 focus:ring focus:ring-orangeAccent dark:bg-darkBg dark:border-gray-600 dark:text-darkText" required>
      <input type="submit" name="submit" value="SEND"
             class="w-full px-4 py-2 bg-orangeAccent text-black font-semibold rounded cursor-pointer hover:opacity-90 transition">
    </form>
  </main>

  <!-- Footer -->
  <footer class="mt-10 bg-gray-100 dark:bg-darkBg text-center p-4 text-sm">
    <div><a href="terms.php" class="hover:text-orangeAccent transition">Terms and Conditions</a></div>
    <div class="mt-2 text-gray-600 dark:text-gray-400">&copy; All Rights Reserved, <span id="span"></span></div>
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
  </script>
</body>
</html>
