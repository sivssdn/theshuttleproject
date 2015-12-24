<?php
//head template for add shuttle pages
?>
<!DOCTYPE HTML>
<html>
 <head>
	<title>Shuttle.ashoka</title>
	<link rel="shortcut icon" type="image/x-icon" href="AshokaFavicon.png" >
	<meta name="viewport" content="width=device-width,initial-scale=1">
 </head>
 <style>
	html,body{
	height:100%;
	width:100%;
	}
	body{
	background-image:url('bg.jpg');
	background-repeat:no-repeat;
	background-size:101% 105%;
	background-attachment:fixed;
	color:white;
	font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
	overflow:auto;
	}
	#logo{
	height:20%;
	margin-left:1%;
	display:inline-block;
	vertical-align:middle;
	}
	h3{
	height:5%;
	width:40%;
	font-size:2vw;
	display:block;
	float:right;
	top:0%;
	text-align:right;
	position:relative;
	right:45%;
	color:rgba(255,255,255,1);
	font-weight:bold;
	font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;
	}
	
	
	table{
	margin-left:12%;
	width:70%;
	color:white;
	text-align:center;
	font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
	}
	#table{
	height:20%;
	}
	#th{
	height:50%;
	color:#ffffff;
	background-color:#000000;
	}
	th{
	height:50%;
	border:1px solid #ffffff;
	}
	#head{
	height:50%;
	}
	td{
	height:50%;
	border-bottom:1px solid #ffffff;
	padding:0.6%;
	}
	#large td{
	border-left:1px solid #ffffff;
	}
	#large{
	border-right:1px solid #ffffff;
	}
	input[type='number']{
	width:10%;
	}
	.down{
	background-color:rgba(11,37,74,0);
	border:none;
	font-size:1vw;
	color:rgba(0,255,0,1);
	text-decoration:underline;
	cursor:pointer;
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
	.out{
	background-color:rgba(11,37,74,0);
	border:none;
	color:rgba(0,191,243,1);
	font-size:1.4vw;
	text-decoration:underline;
	cursor:pointer;
	position:absolute;
	right:0%;
	top:2%;
	}
	.footer{
	position:fixed;
	width:100%;
	bottom:0%;
	background-color:rgba(0,7,15,1);
	color:white;
	font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
	}
	</style>
 <body>
	<img src="logo.png" id="logo">
	<form method="post" action="logout.php">
	 <input type="submit" class="out" name="logout" value="Sign out!">
	</form>
	
	
	<h3>
	 Shuttle towards campus
	</h3>
	
