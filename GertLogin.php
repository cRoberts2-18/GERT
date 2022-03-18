<?php
session_start();
if(isset($_SESSION["GERTloggedin"]) && $_SESSION["GERTloggedin"] === true){
    header("location: GertHome.php");
    exit;
}
?>

<!DOCTYPE html>
<html translate="no">
<link rel="stylesheet" href="GERT.css">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<title>GERT - Login</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  function SignUp() {
    window.location.href = 'GertSignUp.html';
  }
  

$(function() {
  $("#Submit").click(function () {
    var $uName = $("#username").val(); 
    var $pWord = $("#password").val(); 
    $.ajax({
      method: "POST",
      url: "login.php",
      data: {uName:$uName , pWord:$pWord}
      
    })
      .done(function(msg) {
        if(msg == "true"){
          alert("test");
          window.location.href = 'GertHome.php';
        }
        if(msg == "false"){
          alert("incorrect username or password");
        }
      })   
      .fail(function(msg){
        alert("Error");
      });
    });
 
});
    
$("#s").keypress(function(e) {
    if(e.which == 13) {
        $.ajax({
      method: "POST",
      url: "login.php",
      data: {uName:$uName , pWord:$pWord}
      
    })
      .done(function(msg) {
        if(msg == "true"){
          alert("test");
          window.location.href = 'GertHome.php';
        }
        if(msg == "false"){
          alert("incorrect username or password");
        }
      })   
      .fail(function(msg){
        alert("Error");
      });
    
    }
});
    
</script>
  
  
<header>
<h2 class="center">GERT: Global Emmissions Research Tool</h2>
</header>
  
<body>
<form class="form">User Login<br><br>
<label for="username">Username:</label><br>
<input type="text" id="username" name="username" placeholder="Enter name" class = "box"><br>
<label for="password">Password:</label><br>
<input type="password" id="password" name="password" placeholder="Enter password" class = "box"><br>
<a href="GertResetPassword.html">Forgot Password?</a><br>
<button class="buttonstyle" id = "Submit" value = "Submit">Submit</button>
<button class="buttonstyle" type = button onclick="SignUp()" value = "Sign Up">Sign Up</button>
</form>
</body>



  
  
</html>
