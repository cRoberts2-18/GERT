<?php
session_start();
if(isset($_SESSION["GERTloggedin"]) && $_SESSION["GERTloggedin"] !== true){
	header("location: GertLogin.php");
	exit;
}
else if(isset($_SESSION["GERTloggedin"])!== true){
	header("location: GertLogin.php");
	exit;
}
?>
<html translate="no">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	var map = L.map('map').setView([51.505, -0.09], 13);
	</script>
<head>
<link rel="stylesheet" href="GERT.css">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">#
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" 
       integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
<title>GERT - Home</title>
</head>
<header>
<h2 class="right">GERT<h2>
<div class="navbar">
  <optionL href="#home">Home</optionL>
  <div class="dropdown">
    <button class="dropbtn">File
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">Save Search</a>
      <a href="#">Load Search</a>
	  <a href="#">View My Searches</a>
    </div>
  </div> 
  <div class="dropdown">
    <button class="dropbtn">Search 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">New Search</a>
      <a href="#">Example Searches</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Settings 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">General</a>
      <a href="#">Accessibility</a>
      
    </div>
  </div> 
  <div class="dropdown">
    <button class="dropbtn">Help 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">Getting Started</a>
      <a href="#">Data explanations</a>
      <a href="#">Help</a>
    </div>
  </div>
  <optionR id="SignOut">Sign Out</optionR>
  <optionR id="Profile"><?php echo $_SESSION["Username"] ?></optionR>	
</div>
</header>

<body>

<div id="mySidebar" class="sidebar">
  <a href="#">button to open analytics</a>
  <a href="#">=============</a>
  <a href="#">Here we will be displaying data</a>
  <a href="#">it will be able to be filtered here too</a>
 
</div>

<div id="main">
  <button class="openbtn" id="sideButton" onclick="openNav()"><i class="fa fa-caret-right"></i></button>
	<div id="map">
	</div>
</body>




<script>
$(function() {
  $("#SignOut").click(function () {
	  $.ajax({
  		url: 'GERTLogout.php',
  		success: function(data) {
			 window.location.href = 'GertLogin.php';
    		}
});
});
});
  
/* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.getElementById("sideButton").innerHTML="<i class=\"fa fa-caret-left\"></i>";
  document.getElementById("sideButton").setAttribute( "onClick", "javascript: closeNav();" );
}

/* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
  document.getElementById("sideButton").innerHTML="<i class=\"fa fa-caret-right\"></i>";
  document.getElementById("sideButton").setAttribute( "onClick", "javascript: openNav();" );
}
</script>
</html>
