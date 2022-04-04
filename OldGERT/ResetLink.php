<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "GERT";

$Email = $_POST['email'];
$conn = new mysqli($servername, $username, $password, $dbname);
  
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$select="SELECT * FROM `Users` WHERE `Email` = '$Email';";
$result=$conn->query($select);
if(mysqli_num_rows($result)==1)
  {
  while($row = $result->fetch_assoc())
    {
      $email=md5($row['Email']);
      $pass=md5($row['Password']);
    }
    $link="http://18.169.22.165/GERT/OldGERT/reset.php?key=".$email."&reset=".$pass;
    
    
    $mail = new PHPMailer;
    $mail->setFrom('gertool31@gmail.com');
    $mail->addAddress($Email);
    $mail->Subject = 'Password Reset';
    $mail->Body = "Click the link to reset your password: ".$link;
    $mail->IsSMTP();
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'ssl://smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Port = 465;
    //Set your existing gmail address as user name  
    $mail->Username = 'gertool31@gmail.com';

  //Set the password of your gmail address here
  $mail->Password = 'Gert_123';
  if(!$mail->send()) {
    echo 'Email is not sent.';
    echo 'Email error: ' . $mail->ErrorInfo;
} else {
    echo 'Email has been sent.';
}
}
?>
