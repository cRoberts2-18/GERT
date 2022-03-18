<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "GERT";

$email = $_POST['email'];
$uName = $_POST['uName'];
$pWord = $_POST['pWord'];
$pWordCheck = $_POST['pWordCheck'];

$conn = new mysqli($servername, $username, $password, $dbname);
  
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
  
$sqlQueryDetails = "SELECT * FROM `Users`";
$result = $conn->query($sqlQueryDetails);

  
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
  
  }
echo "working" ;
?>
