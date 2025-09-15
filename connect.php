
<?php

$servername = "localhodt";
$username = "root";
$password = "";
$database = "xf";
$conn = mysqli_connect("localhost","root","","xf");
if($conn === false){
    die("Error occurred" .mysqli_connect_error());
}
?>