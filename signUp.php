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
$sqlInsert = "INSERT INTO Users (".$uName.",".$password.","$email."7)";
VALUES ('John', 'Doe', 'john@example.com')";
$result = $conn->query($sqlQueryDetails);
$usernameMatch = false;
$emailMatch = false;
if($pWord == $pWordCheck){
  if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    if($email == $row['Email']){
      $emailMatch = true;
    }
    if(strtolower($uName) == strtolower($row['Username'])){
      $usernameMatch = true;
    }
  }
    if($emailMatch){
     echo "emailMatch";
    }
    else{
      if($usernameMatch){
         echo "usernameMatch";
      }
    }
  }
  if(!$emailMatch && !$usernameMatch){
    
    if ($conn->query($sqlInsert) === true) {
      echo "user created";
    }
  }
}
else{
echo "passwordNotMatch" ;
}

?>
