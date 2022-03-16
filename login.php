<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "GERT";

$uName = $_POST['uName'];
$pWord = $_POST['pWord'];

$conn = new mysqli($servername, $username, $password, $dbname);
  
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
  
$sqlQueryDetails = "SELECT * FROM `Users`";
$result = $conn->query($sqlQueryDetails);

  
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo $row["Username"]. $row["Password"].$row["Email"].$row["UserID"].$uName.$pWord;
  }
} else {
  echo "0 results";
}

?>
