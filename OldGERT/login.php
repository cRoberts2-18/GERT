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
    if (strtolower($row["Username"])== strtolower($uName) && $row["Password"] == $pWord){
      echo "true";
      session_start();
      $_SESSION["GERTloggedin"] = true;
      $_SESSION["Username"] = $row["Username"];
    exit;
    }
  }
} else {
  echo "0 results";
}

?>
