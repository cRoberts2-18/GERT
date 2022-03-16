<php>
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "GERT";

$conn = new mysqli($servername, $username, $password, $dbname);
  
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
  
$sqlQueryDetails = "SELECT * FROM `Users`;
$result = $conn->query($sqlQueryDetails);

  
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "Username: " . $row["Username"]. " - Password: " . $row["Password"]. "Email" . $row["Email"]. "id:" $row["UserID"].<br>";
  }
} else {
  echo "0 results";
}
$conn->close();
</php>
