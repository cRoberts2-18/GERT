<?php
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
  while($row=mysql_fetch_array($select))
    {
      $email=md5($row['Email']);
      $pass=md5($row['Password']);
    }
    $link="<a href='www.samplewebsite.com/reset.php?key=".$email."&reset=".$pass."'>Click To Reset password</a>";
    require_once('phpmail/PHPMailerAutoload.php');
    /*$mail = new PHPMailer();
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    // enable SMTP authentication
    $mail->SMTPAuth = true;                  
    // GMAIL username
    $mail->Username = "gertool31@gmail.com";
    // GMAIL password
    $mail->Password = "Gert_123";
    $mail->SMTPSecure = "ssl";  
    // sets GMAIL as the SMTP server
    $mail->Host = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port = "465";
    $mail->From='gertool31@gmail.com';
    $mail->FromName='GERT';
    $mail->AddAddress($email, $email);
    $mail->Subject  =  'Reset Password';
    $mail->IsHTML(true);
    $mail->Body    = 'Click On This Link to Reset Password '.$link.'';
    if($mail->Send())
    {
      echo "Check Your Email and Click on the link sent to your email";
    }
    else
    {
      echo "Mail Error - >".$mail->ErrorInfo;
    }*/
  echo $email;
  echo $pass;
}
else{echo "lmao";}



?>
