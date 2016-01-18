<?php
 session_start();
 if(!isset($_SESSION['id']))
 header("Location:index.php");
 else if(isset($_POST['csubmit']))
 {
	$pass=htmlspecialchars($_POST['cpass']);
	$new_pass=hash('sha512',$pass);
	$db=new PDO("mysql:host=localhost;dbname=shuttle","root","server");
	 $db->exec("UPDATE `shuttle`.`users` SET `pass` = '{$new_pass}' WHERE `users`.`id` LIKE '{$_SESSION['id']}';");
	$db=null;
	require_once('logout.php');
 }
?>


<!DOCTYPE HTML>
<html>
 <head>
	<title>Shuttle.ashoka</title>
	<link rel="shortcut icon" type="image/x-icon" href="AshokaFavicon.png" >
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link href="manage.css" rel="stylesheet" type="text/css">
	<style>
	h3{
	 font-size:2.5vw;
	 right:38%;
	}
	
	#upass,#upass1{
	line-height:2em;
	display:block;
	margin:auto;
	width:20%;
	height:20%;
	border-radius:0%;
	font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
	font-size:1.2vw;
	box-shadow:0px 0px 5px 1px rgba(0,191,243,1);
	margin-top:18%;
	}
	#upass1{
	 margin-top:2%;
	}
	

	#log1{
	height:10%;
	width:20%;
	background-color:rgba(39,125,43,1);
	display:block;
	margin:auto;
	color:#ffffff;
	font-size:2.5vw;
	border:0px;
	box-shadow:0px 0px 5px 2px rgba(0,255,0,1);
	font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;
	cursor:pointer;
	}
	#log1:hover{
	background-color:rgba(51,181,63,1);
	}
	
	@media only screen and (min-width:100px) and (max-width:640px)
	{
	 body{
	 background-size:cover;
	 }
	 h3{

	  right:10%;
	  font-size:3vw;
	 }
	 #log1{
	 width:60%;
	 font-size:5vw;
	 }
	 #upass{
	  margin-top:40%;
	 }
	 #upass1,#upass{
	 width:40%;
	 font-size:4vw;
	 }
	 #cast{
	 display:none;
	 }
	 #cast1{
	 font-size:3.4vw;
	 }
	.out{
	 margin-top:12%;
	}
	#manage{
	margin-right:1%;	
	}
	}
	/*For iphone*/
	@media only screen and (min-width:640px) and (max-width:768px){
	 body{
	 background-size:cover;
	 }
	 #log1{
	 width:40%;
	 }
	 #upass1,#upass{
	 width:40%;
	 font-size:3vw;
	 }
	 #cast{
	 display:none;
	 }
	 #cast1{
	 font-size:3vw;
	 }
	}
	/*high windows phone*/
	@media only screen and (min-width:768px) and (max-width:1024px){
	 body{
	 background-size:cover;
	 }
	 h3{
	  font-size:3vw;
	  right:22%;
	 }
	 #log1{
	 font-size:4vw;
	 width:40%;
	 }
	 #upass{
	  margin-top:24%;
	 }
	 #upass1,#upass{
	 width:40%;
	 font-size:2.5vw;
	 }
	 #cast{
	 display:none;
	 }
	 #cast1{
	 font-size:2.5vw;
	 }
	}
	@media only screen and (min-width:1024px) and (max-width:1280px){
	 #log1{
	 width:28%;
	 }
	 h3{
	  right:28%;
	 }
	 #upass1,#upass{
	 width:28%;
	 font-size:1.8vw;
	 }
	 #cast{
	 display:inline-block;
	 }
	 #cast,#cast1{
	 font-size:1.8vw;
	 }
	}
	</style>
 </head>
 <body>
    <a href="index.php"><img src="logo.png" id="logo"></a>
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
	 <a id="amanage" href="book.php">NEW BOOKING</a>
	</div>
	<br><br><br><br>
	
	
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="submit_form();return false;" id="form">
		<input type="password" id="upass" placeholder="New Password">
		<input type="password" id="upass1" name="cpass" placeholder="Confirm Password">
		<br><br>
		<input type="submit" name="csubmit" value=" CHANGE " id="log1">
	
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
<script>
 var field1=document.getElementById('upass');
 var field2=document.getElementById('upass1');
 function submit_form(){
	if(field1.value==field2.value)
	{
		
		document.getElementById('form').submit();
	}
	else
	{
		field1.value="";
		field2.value="";
		field1.placeholder="Password mismatch";
		field2.placeholder="Please Type again";
		
		return false;
	}	
 }
</script>	
</html>
