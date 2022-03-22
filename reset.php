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
if($_GET['key'] && $_GET['reset'])
{
  $email=$_GET['key'];
  $pass=$_GET['reset'];
  mysql_connect('localhost','root','');
  mysql_select_db('sample');
  $select=mysql_query("select email,password from user where md5(email)='$email' and md5(password)='$pass'");
  if(mysql_num_rows($select)==1)
  {
    ?>
    <form method="post" action="submit_new.php">
    <input type="hidden" name="email" value="<?php echo $email;?>">
    <p>Enter New password</p>
    <input type="password" name='password'>
    <input type="submit" name="submit_password">
    </form>
    <?php
  }
}
?>
</body>

<script>
  
  
  
 </script>

</html>
