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
<script src="Scripts/notify.js"></script>
<script type="text/javascript">

  function SignUp() {
    window.location.href = 'GertSignUp.html';
  }
  function notifyMessage(msg,styles){
             $.notify(msg,{
             className: styles,
             globalPosition: 'bottom center'
                    
             });
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
          window.location.href = 'GertHome.php';
        }
        else{
          notifyMessage("Invalid username or password", "error");
        }
      })   
      .fail(function(msg){
        alert("Error");
      });
    });
 
});
    
$(window).keypress(function(e) {
    if(e.which == 13) {
        var $uName = $("#username").val(); 
        var $pWord = $("#password").val();
        $.ajax({
      method: "POST",
      url: "login.php",
      data: {uName:$uName , pWord:$pWord}
      
    })
      .done(function(msg) {
        if(msg == "true"){
          window.location.href = 'GertHome.php';
        }
        else{
          notifyMessage("Invalid username or password", "error");
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
<input class="buttonstyle" type=button id = "Submit" value = "Submit">
<button class="buttonstyle" type = button onclick="SignUp()" value = "Sign Up">Sign Up</button>
</form>
</body>



  
  
</html>
