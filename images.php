<?php 
include 'connect.php'; 
session_start();
if(!isset($_SESSION['username'])){
    header("location:login.php");
    exit();
}

$statusMsg = ''; 
$targetDir = "db-img/"; 

// Upload handler
if(isset($_POST["submit"])){
    $id = "";
    $user_id = $_SESSION['id'] ?? "";
    if(!empty($_FILES["file"]["name"]) && $user_id){ 
        $fileName = basename($_FILES["file"]["name"]); 
        $targetFilePath = $targetDir . $fileName; 
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 

        $allowTypes = ['JPG','jpg','PNG','JPEG','GIF','png','jpeg','gif']; 
        if(in_array($fileType, $allowTypes)){ 
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                $sql = "INSERT INTO image (id, image, user_id) VALUES ('".$id."','".$fileName."','".$user_id."')";
                $result = mysqli_query($conn,$sql);

                if($result){ 
                    header("Location: images.php?upload=success");
                    exit();
                }else{ 
                    $statusMsg = "File upload failed, please try again."; 
                }  
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file."; 
            } 
        }else{ 
            $statusMsg = 'Only JPG, JPEG, PNG, & GIF allowed.'; 
        } 
    }else{ 
        $statusMsg = 'Please select a file to upload.'; 
    } 
}

// Delete handler
if(isset($_GET['id'])){
    $id = $_GET['id'];
    mysqli_query($conn,"DELETE FROM image WHERE id='$id'");
    header("location:images.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Images</title>

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
<body class="transition-colors duration-300 bg-white text-gray-900 dark:bg-darkBg dark:text-darkText min-h-screen">

  <!-- Desktop Header -->
  <header class="hidden md:flex justify-between items-center p-4 bg-gray-100 dark:bg-darkBg shadow transition duration-300 fixed top-0 left-0 w-full z-50">
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
        <a href="login.php" class="px-4 py-2 rounded bg-darkBg text-orangeAccent">LOG IN</a>
        <a href="register.php" class="px-4 py-2 rounded bg-orangeAccent text-black">SIGN UP</a>
      <?php endif; ?>
       <!-- ✅ Logout -->
    <a href="logout.php" class="px-4 py-2 w-full text-center rounded transition duration-300 bg-red-600 text-white hover:bg-red-700">LOG OUT</a>
      <button onclick="toggleDarkMode()" id="themeToggle" class="ml-4 text-xl hover:text-orangeAccent transition">
        <i class="fa-solid fa-moon"></i>
      </button>
    </div>
  </header>

  <!-- Mobile Header -->
  <div class="md:hidden flex justify-between items-center p-4 bg-gray-100 dark:bg-darkBg shadow fixed top-0 left-0 w-full z-50">
    <div class="flex items-center gap-4">
      <button onclick="toggleDarkMode()" id="mobileThemeToggle" class="text-xl hover:text-orangeAccent transition">
        <i class="fa-solid fa-moon"></i>
      </button>
      <button id="hamburger" onclick="display()" class="text-2xl"><i class="fa fa-bars"></i></button>
      <button id="close" onclick="hide()" class="text-2xl hidden"><i class="fa fa-times"></i></button>
    </div>
  </div>

  <!-- Mobile Nav -->
  <div class="mobile-nav hidden md:hidden flex-col items-center bg-gray-100 dark:bg-darkBg p-4 gap-4 mt-14">
    <!-- ✅ Logout -->
    <a href="logout.php" class="px-4 py-2 w-full text-center rounded transition duration-300 bg-red-600 text-white hover:bg-red-700">LOG OUT</a>
    <ul class="w-full text-center space-y-2 mt-4">
      <li><a href="index.php" class="block hover:text-orangeAccent">Home</a></li>
      <li><a href="about.php" class="block hover:text-orangeAccent">About</a></li>
      <li><a href="profile.php" class="block hover:text-orangeAccent">Profile</a></li>
      <li><a href="settings.php" class="block hover:text-orangeAccent">Settings</a></li>
    </ul>
  </div>

  <!-- Upload Form -->
  <div class="mt-24 p-6">
    <form action="" method="post" enctype="multipart/form-data" class="max-w-lg mx-auto flex flex-col md:flex-row gap-3 items-center">
      <input type="file" name="file" class="flex-1 text-sm text-gray-700 dark:text-darkText file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-black hover:file:bg-gray-300">
      <input type="submit" name="submit" value="Upload" class="bg-darkBg text-orangeAccent hover:opacity-90 font-semibold px-6 py-2 rounded cursor-pointer">
    </form>
    <?php if($statusMsg): ?>
      <p class="text-center text-red-500 mt-2"><?php echo $statusMsg ?></p>
    <?php endif; ?>
  </div>

  <!-- Images Grid -->
  <main class="p-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
      <?php
      if(isset($_SESSION['id'])){
          $sql = "SELECT * FROM image WHERE user_id='".$_SESSION['id']."' ORDER BY id DESC";
          $query = mysqli_query($conn,$sql);
          while($row = mysqli_fetch_object($query)){
              $imageURL = 'db-img/'.htmlspecialchars($row->image);
              echo "
              <div class='bg-white dark:bg-gray-700 p-2 rounded-lg shadow'>
                <img class='w-full h-40 object-cover rounded-lg' src='".$imageURL."' alt='Uploaded Image'>
                <div class='flex justify-between mt-2'>
                  <a href='".$imageURL."' download class='bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded transition'>Download</a>
                  <a href='images.php?id=".$row->id."' onclick='return confirmDelete()' class='bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded transition'>Delete</a>
                </div>
              </div>";
          }
      }
      ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer mt-10 bg-gray-100 dark:bg-darkBg text-center p-4 text-sm">
    <div><a href="terms.php" class="hover:text-orangeAccent transition">Terms and Conditions</a></div>
    <div class="year mt-2 text-gray-600 dark:text-gray-400">&copy; <span id="span"></span></div>
  </footer>

  <!-- Scripts -->
  <script>
    function confirmDelete() {
      return confirm("Are you sure you want to delete this image?");
    }

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
