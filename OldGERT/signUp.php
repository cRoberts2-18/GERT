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

$Maxresult = mysqli_query($conn, "SELECT MAX(UserID) FROM `Users`");
$row = mysqli_fetch_array($Maxresult);
$MaxID = $row[0]+1;

$sqlQueryDetails = "SELECT * FROM `Users`";

$sqlInsert = "INSERT INTO `Users` (`Username`, `Password`, `Email`, `UserID`) VALUES ('$uName', '$pWord', '$email', '$MaxID');";
$result = $conn->query($sqlQueryDetails);

//username check valid - 4 - 12 characters - no special
if(strlen($uName) < 4 || strlen($uName) > 12){
  echo("The Chosen Username is not 4 - 12 characters long");
  exit();
}
if(preg_match("[\W]" , $uName)){
  echo("This Username has illegal characters.\n Only Letters, Numbers and underscores are allowed");
  exit();
}

//password check valid - 8 - 16 characters 1 special 1 capital 1 number  

if(strlen($pWord) < 8 || strlen($pWord) > 16){
  echo("The Chosen Password is not 8 - 16 characters long");
  exit();
}

if(!(preg_match("/[A-Z]/" , $pWord) && preg_match("/[a-z]/" , $pWord) && preg_match("/[0-9]/" , $pWord) && preg_match("/[\W]/" , $pWord))){
  echo("Passwords Does not meet the criteria. Passwords must contain: \n 1 Special character , 1 Lowercase, 1 Upper case letter and 1 Number");
  exit();
}

//email check
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo("This email is not a valid email address");
      exit();
   }

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
    
    if ($conn->query($sqlInsert) === TRUE) {
      echo "user created";
    }
    else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}
else{
echo "The password you have re-entered does not match" ;
}

?>
