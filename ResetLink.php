<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "GERT";

$email = $_POST['email'];

$conn = new mysqli($servername, $username, $password, $dbname);
  
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$select=mysql_query("SELECT * FROM `Users` WHERE `Email` = '$email';");
if(mysql_num_rows($select)==1)
  {
  echo $row['Email'];   
}



?>
