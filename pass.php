<?php
session_start();
if(!isset($_SESSION['id']))
header("Location:login.php");
?>


<!DOCTYPE HTML>
<html>
 <head>
	<title>Shuttle.ashoka</title>
	<link rel="shortcut icon" type="image/x-icon" href="AshokaFavicon.png" >
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<style>
	html,body{
	height:100%;
	}
	body{
	background-image:url('bg.jpg');
	background-repeat:no-repeat;
	background-size:101% 105%;
	background-attachment:fixed;
	overflow:auto;
	}
	#logo{
	height:20%;
	float:left;
	left:1%;
	display:inline-block;
	vertical-align:middle;
	position:fixed;
	}
	#name,h3{
	height:5%;
	width:40%;
	font-size:2vw;
	color:#ffffff;
	display:block;
	position:fixed;
	float:right;
	top:4%;
	right:1%;
	text-align:right;
	}
	#name{
	font-family: Georgia,Times,Times New Roman,serif; 
	font-style:italic;
	color:rgba(189,215,238,1);
	}
	h3{
	position:relative;
	top:14%;
	right:45%;
	color:rgba(255,255,255,1);
	font-weight:bold;
	font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;
	}
	.footer{
	position:fixed;
	width:100%;
	bottom:0%;
	background-color:rgba(0,7,15,1);
	color:white;
	font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
	}
	#cast,#cast1{
	display:inline-block;
	}
	#cast{
	float:left;
	}
	#cast1{
	float:right;
	margin-right:2%;
	}
	#manage{
	width:16%;
	height:5%;
	line-height:200%;
	text-align:center;
	position:fixed;
	font-size:1.2vw;
	font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
	border:1px solid rgba(0,191,243,1);
	border-radius:8%;
	box-shadow:0px 0px 5px 1px rgba(0,191,243,1);
	float:right;
	right:1%;
	top:10%;
	}
	
	.out{
	background-color:rgba(11,37,74,0);
	border:none;
	color:#ffffff;
	font-size:1.4vw;
	font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;
	text-decoration:underline;
	cursor:pointer;
	position:fixed;
	right:1%;
	top:16%;
	}
	#amanage{
	color:#ffffff;
	text-decoration:none;
	}
	#manage:hover{
	box-shadow:0px 0px 7px 2px rgba(0,191,243,1);
	}
	#old,#new{
	display:block;
	margin:auto;
	
	width:16%;
	height:20%;
	border-radius:0%;
	font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
	font-size:1.2vw;
	box-shadow:0px 0px 5px 1px rgba(0,191,243,1);
	}
	#user{
	margin-top:14%;
	margin-left:-8%;
	}
	</style>
	
 </head>
 <body>
    <img src="logo.png" id="logo">
	<form method="post" action="logout.php">
	 <input type="submit" class="out" name="logout" value="Sign out!">
	</form>
	
	
	<div id="name">
	Hi <?php echo $_SESSION['name']; ?>! 
	</div>
	
	<h3>
	 CHANGE PASSWORD
	</h3>
	<div id="manage">
	 <a id="amanage" href="book.php">NEW BOOKINGS</a>
	</div>
	<br><br>
	
	<form id="user" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="password" id="old" name="old" placeholder="current password" autofocus onkeypress="key(event)">
			
			<br>
			<input type="password" id="new" name="new" placeholder="new password">
			
	</form>
	
	
	
	
	
	
	
	<div class='footer'>
	<div id="cast">
		ASHOKA UNIVERSITY SHUTTLE BOOKING SERVICE
	</div>
	
	<div id="cast1">
		DEVELOPED BY SANAT AND PARAS
	</div>
	</div>
 </body>
</html> 