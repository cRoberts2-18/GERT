<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "GERT";

$username1 = $_POST['username'];

$conn = new mysqli($servername, $username, $password, $dbname);
  
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
  
$sqlQueryDetails = "SELECT * FROM `Users`";
$result = $conn->query($sqlQueryDetails);

  
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo $row["Username"]. $row["Password"].$row["Email"].$row["UserID"].$username ;
  }
} else {
  echo "0 results";
}

?>
