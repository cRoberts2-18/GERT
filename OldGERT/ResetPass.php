<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "GERT";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
  
$email = $_POST['email'];
$pWord = $_POST['pass'];

$sql = "UPDATE `Users` SET `Password`='".$pWord."' WHERE `Email` = '".$email."';";

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();

?>
