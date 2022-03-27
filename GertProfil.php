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
<script src="Scripts/notify.js"></script>
<style>
#map {
	position: absolute;
	top:102px;
	left:0;
	height: 85%;
	width: 100%;
	z-index:0;
	opacity: .99;
}
</style>
<head>
<link rel="stylesheet" href="GERT.css">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
      integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
      crossorigin=""
    />

    <script
      src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
      integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
      crossorigin=""
    ></script>
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
  <div class="dropdown" style="float: right;">
    <button class="dropbtn"><?php echo $_SESSION["Username"] ?> 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content" style="position:absolute; right:0;">
      <a href="#">My Profile</a>
      <a id="SignOut" href="#">Sign Out</a>
      
    </div>
  </div>	
</div>
</header>

<body>

<div id="mySidebar" class="sidebar" style="width:250px; left:250px;">
  <a href="#">button to open analytics</a>
  <a href="#">=============</a>
  <a href="#">Here we will be displaying data</a>
  <a href="#">it will be able to be filtered here too</a>
 
</div>

<div id="main">
  <button class="openbtn" id="sideButton" onclick="openNav()"><i class="fa fa-caret-right"></i></button>
  
	
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
