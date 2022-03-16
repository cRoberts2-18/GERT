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
echo $result;
</php>
