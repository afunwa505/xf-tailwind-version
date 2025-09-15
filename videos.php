<?php 
include 'connect.php'; 
session_start();
if(!isset($_SESSION['username'])){
    header("location:login.php");
}

$targetDir = "db-videos/"; 
$statusMsg = "";

// ✅ Handle upload
if(isset($_POST["submit"])){
    $id = "";
    $user_id = $_SESSION['id'] ?? "";
    if(!empty($_FILES["file"]["name"]) && $user_id){ 
        $fileName = basename($_FILES["file"]["name"]); 
        $targetFilePath = $targetDir . $fileName; 
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 

        $allowTypes = ['mp4']; 
        if(in_array($fileType, $allowTypes)){ 
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                $insert = "INSERT INTO video (id,video,user_id) VALUES ('".$id."','".$fileName."','".$user_id."')";
                $result = mysqli_query($conn,$insert);
                if($result){ 
                    header("Location: videos.php");
                    exit();
                }
            }
        }
    }
}

// ✅ Handle delete
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    mysqli_query($conn,"DELETE FROM video WHERE id='$id'");
    header("Location: videos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Videos</title>
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body class="transition-colors duration-300 bg-white text-gray-900 dark:bg-darkBg dark:text-darkText min-h-screen">

  <!-- Fixed Header -->
  <header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center p-4 bg-gray-100 dark:bg-darkBg shadow transition">
    <nav>
      <ul class="flex gap-6">
        <li><a href="index.php" class="hover:text-orangeAccent transition">Home</a></li>
        <li><a href="about.php" class="hover:text-orangeAccent transition">About</a></li>
        <li><a href="profile.php" class="hover:text-orangeAccent transition">Profile</a></li>
        <li><a href="settings.php" class="hover:text-orangeAccent transition">Settings</a></li>
      </ul>
    </nav>
    <div class="flex gap-2 items-center">
      <?php if(!isset($_SESSION['username'])): ?>
        <a href="login.php" class="px-4 py-2 rounded" style="background-color:#282c34; color:#fd961a;">LOG IN</a>
        <a href="register.php" class="px-4 py-2 rounded bg-[#fd961a] text-black">SIGN UP</a>
      <?php endif; ?>
      <button onclick="toggleDarkMode()" id="themeToggle" class="ml-4 text-xl hover:text-orangeAccent transition">
        <i class="fa-solid fa-moon"></i>
      </button>
    </div>
  </header>

  <!-- Fixed Upload Form -->
  <div class="fixed top-16 left-0 w-full z-40 bg-white dark:bg-gray-800 p-4 shadow">
    <form action="" method="post" enctype="multipart/form-data" class="max-w-lg mx-auto flex flex-col md:flex-row gap-3 items-center">
      <input type="file" name="file" class="flex-1 text-sm text-gray-700 dark:text-darkText file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-black hover:file:bg-gray-300">
      <input type="submit" name="submit" value="Upload" class="bg-[#282c34] text-[#fd961a] hover:opacity-90 font-semibold px-6 py-2 rounded cursor-pointer">
    </form>
  </div>

  <!-- Videos List -->
  <main class="pt-[180px] p-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <?php
      if(isset($_SESSION['id'])){
        $sql = "SELECT * FROM video WHERE user_id='".$_SESSION['id']."' ORDER BY id DESC";
        $query = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_object($query)){
          $videoURL = 'db-videos/'.htmlspecialchars($row->video);
          echo "
          <div class='bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex flex-col gap-3'>
            <video controls class='w-full h-64 rounded'>
              <source src='".$videoURL."' type='video/mp4'>
            </video>
            <div class='flex justify-between'>
              <a href='".$videoURL."' download class='bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded transition'>Download</a>
              <a href='videos.php?id=".$row->id."' onclick='return confirmDelete()' class='bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded transition'>Delete</a>
            </div>
          </div>";
        }
      }
      ?>
    </div>
  </main>

  <footer class="mt-10 bg-gray-100 dark:bg-darkBg text-center p-4 text-sm">
    <div><a href="terms.php" class="hover:text-orangeAccent transition">Terms and Conditions</a></div>
    <div class="year mt-2 text-gray-600 dark:text-gray-400">&copy; <span id="span"></span></div>
  </footer>

  <script>
    // Confirm delete
    function confirmDelete() {
      return confirm("Are you sure you want to delete this video?");
    }

    // Year
    document.getElementById("span").textContent = new Date().getFullYear();

    // Dark mode toggle
    function toggleDarkMode() {
      const html = document.documentElement;
      const themeIcon = document.getElementById('themeToggle')?.querySelector('i');
      if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        themeIcon?.classList.replace('fa-sun', 'fa-moon');
      } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        themeIcon?.classList.replace('fa-moon', 'fa-sun');
      }
    }
    window.addEventListener('DOMContentLoaded', () => {
      const theme = localStorage.getItem('theme');
      const html = document.documentElement;
      const themeIcon = document.getElementById('themeToggle')?.querySelector('i');
      if (theme === 'dark') {
        html.classList.add('dark');
        themeIcon?.classList.replace('fa-moon', 'fa-sun');
      }
    });
  </script>
</body>
</html>
