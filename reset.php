<!DOCTYPE html>
<html translate=no>
<link rel="stylesheet" href="GERT.css">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<title>GERT - Forgotten Password</title>
<header>
<h2 class="center">GERT: Global Emmissions Research Tool</h2>
</header>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "GERT";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
  
if($_GET['key'] && $_GET['reset'])
{
  $email=$_GET['key'];
  $pass=$_GET['reset'];
  $select="SELECT * FROM `Users`;";
  $result=$conn->query($select);
  while($row = $result->fetch_assoc()) {
    if(md5($row['Email'])==$email)
  {
    ?>
    <form class="form" method="post" action="GertHome.php">
    <input type="hidden" id="Email" name="email" value="<?php echo $row['Email'];?>">
    <a>Enter New password</a><br>
    <input class = "box" type="password" id='Password' name='Password'><br>
    <a>Confirm New password</a><br>
    <input class = "box" type="password" name='Confirm Password'><br>  
    <p></p><br>
    <input type="submit" id="Submit" name="submit_password">
    </form>
    <?php
  }
}
}
?>
</body>

<script>
    $(function() {
  $("#Submit").click(function () {
    var $pass = $("#Password").val();
    var $mail = $("#Email").val();
    $.ajax({
      method: "POST",
      url: "ResetPass.php",
      data: {email:$mail, pass:$pass}
      
    })
      .done(function(msg) {
        alert(msg);
        $("p").text("If the entered email is valid, a reset link will be sent shortly");
      })   
      .fail(function(msg){
        alert(msg);
      });
    });
 
});
  
  
 </script>

</html>
