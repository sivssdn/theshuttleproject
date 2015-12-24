<?php
	session_start();
	
	$error=0;
	/*******
	
	 if the form is submitted then proceed to validation and then redirect
	 
	 else clean the db and insert into report.xlsx
	 *******/
	 
	if(isset($_POST['uname']) && isset($_POST['upass']))
	{
		$uname=htmlspecialchars($_POST['uname']);
		$upass=htmlspecialchars($_POST['upass']);
		if($uname=="ashoka" && $upass=="Ashoka@123")
		{
			$_SESSION['id']='ashoka';
			header('Location: admin.php');
			exit;
		}
		//hashing password
		$upass=hash('sha512',$upass);
		$db=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
		$data=$db->prepare("SELECT name,id FROM users WHERE id='{$uname}' AND pass='{$upass}' LIMIT 1;");
		$data->execute();
		$result=$data->fetch();
		
		if(count($result)==1)
		$error=1;
		else
		{
			$_SESSION['id']=$result['id']; //id can be :::: email ::::too
			$_SESSION['name']=$result['name'];
			
			//echo $session['id'];
			//echo $session['name'];
		}	
		$db=null;
	}
	
		//if the user clicks back button after reaching book.php
		if(isset($_SESSION['id']) && isset($_SESSION['name']))
		header('Location: book.php');
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
	width:100%;
	overflow:hidden;
	}
	body{
	background-color:black;
	background-image:url('login.jpg');
	background-size:100% 100%;
	background-repeat:no-repeat;
	font-family: "Times New Roman", Times, serif;
	}
	::selection{
	 background:rgba(255,51,51,1);
	}
	::-moz-selection{
	  background:rgba(255,51,51,1);
	}
	#logo{
	height:40%;
	display:block;
	margin:auto;
	margin-top:6%;
	}
	#log,#log1{
	height:10%;
	width:20%;
	background-color:rgba(0,33,58,1);
	display:block;
	border-radius:8%;
	margin:auto;
	color:#ffffff;
	font-size:5vh;
	
	box-shadow:0px 0px 5px 2px rgba(0,191,243,1);
	cursor:pointer;
	
	}
	@-webkit-keyframes effect{
	from{background-color:#ffffff;opacity:1;}
	to{background-color:rgba(57,181,63,1);opacity:0;}
	}
	@-moz-keyframes effect{
	from{background-color:#ffffff;opacity:1;}
	to{background-color:rgba(57,181,63,1);opacity:0;}
	}
	@-webkit-keyframes slide{
	from{height:0%;}
	to{height:20%;}
	}
	@-moz-keyframes slide{
	from{height:0%;}
	to{height:20%;}
	}
	#log1{
	line-height:140%;
	margin-top:-3%;
	display:none;
	height:6%;
	width:16%;
	border-radius:0%;
	text-align:center;
	background-color:rgba(39,125,43,1);
	box-shadow:0px 0px 5px 2px rgba(0,255,0,1);
	font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;
	font-size:4vh;
	}
	#log:hover #circle{
	transition:all 1s;
	background-color:rgba(0,143,187,1);
	color:rgba(0,0,0,1);
	box-shadow:0px 0px 5px 2px rgba(0,191,243,1);
	}
	#log1:hover{
	background-color:rgba(51,181,63,1);
	}
	#circle{
	height:80%;
	width:20%;
	margin-top:2%;
	margin-left:10%;
	color:#000000;
	line-height:140%;
	font-size:6vh;
	font-weight:bold;
	display:inline-block;
	border-radius:100%;
	background-color:rgba(0,33,58,1);
	border:1px solid rgba(0,191,243,1);
	text-align:center;
	color:rgba(0,191,243,1);
	box-shadow:0px 0px 5px 1px rgba(0,191,243,1);
	}
	#cast,#cast1{
	font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
	color:#ffffff;
	display:inline-block;
	
	position:absolute;
	bottom:2%;
	}
	#cast1{
	right:2%;
	}
	#margin{
	margin-left:20%;
	margin-top:-40%;
	font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;
	display:inline-block;
	}
	#uname,#upass{
	display:block;
	margin:auto;
	width:16%;
	height:20%;
	border-radius:0%;
	font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
	font-size:1.2vw;
	box-shadow:0px 0px 5px 1px rgba(0,191,243,1);
	}
	#out{
	height:10%;
	width:10%;
	color:#ffffff;
	display:none;
	margin-left:64%;
	font-size:2.8vw;
	position:absolute;
	}
	@-webkit-keyframes appear{
	from{opacity:1;font-size:1vw;}
	to{opacity:0;font-size:3vw;}
	}
	input:focus{
	outline:none;
	}
	
	@media only screen and (min-width:100px) and (max-width:640px)
	{
	 body{
	 background-size:cover;
	 }
	 #log{
	 width:60%;
	 margin-top:8%;
	 }
	 #log1{
	 width:60%;
	 }
	 #uname,#upass{
	 width:60%;
	 font-size:4vw;
	 }
	 #out{
	 display:none;
	 margin-top:-2%;
	 }
	 #cast{
	 display:none;
	 }
	 #cast1{
	 font-size:3.4vw;
	 }
	}
	/*For iphone*/
	@media only screen and (min-width:640px) and (max-width:768px){
	 body{
	 background-size:cover;
	 }
	 #log{
	 width:40%;
	 margin-top:8%;
	 }
	 #log1{
	 width:40%;
	 }
	 #uname,#upass{
	 width:40%;
	 font-size:3vw;
	 }
	 #out{
	 display:none;
	 margin-top:-2%;
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
	 #log{
	 width:40%;
	 margin-top:8%;
	 }
	 #log1{
	 width:40%;
	 }
	 #uname,#upass{
	 width:40%;
	 font-size:2.5vw;
	 }
	 #out{
	 display:none;
	 margin-top:-2%;
	 }
	 #cast{
	 display:none;
	 }
	 #cast1{
	 font-size:2.5vw;
	 }
	}
	@media only screen and (min-width:1024px) and (max-width:1280px){
	 #log{
	 width:28%;
	 margin-top:2%;
	 }
	 #log1{
	 width:28%;
	 }
	 #uname,#upass{
	 width:28%;
	 font-size:1.8vw;
	 }
	 #out{
	 display:none;
	 margin-top:-3%;
	 margin-left:-2%;
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
 <body bgcolor="red">
	
	<img src="logo.png" id="logo">
	<br><br>
	<div id="log" onclick="effect()">
	  <span id="margin">LOGIN </span>
	  <div id="circle">></div>
	</div>
	<br>
		<form id="user" style="display:none;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="text" id="uname" name="uname" placeholder="User ID" autofocus onkeypress="key(event)">
			<div id="out">A</div>
			<br>
			<input type="password" id="upass" name="upass" placeholder="Password">
		</form>
	<br>
	<div id="log1" style="display:none;" onclick="submit()">
	SUBMIT
	</div>
	
	<div id="cast">
		ASHOKA UNIVERSITY SHUTTLE BOOKING SERVICE
	</div>
	
	<div id="cast1">
		DEVELOPED BY SANAT AND PARAS
	</div>
	
 <script>
 var log=document.getElementById('log');
 var user=document.getElementById('user');
 function effect(){
  log.style.WebkitAnimation="effect 0.5s linear";
  log.style.MozAnimation="effect 0.5s linear";
  setTimeout(function(){
  log.style.display="none";
  document.getElementById('log1').style.display="block";
  user.style.display="block";
  user.style.WebkitAnimation="slide 0.5s linear";
  user.style.MozAnimation="slide 0.5s linear";
	setTimeout(function(){
	user.style.height="20%";
	},500);
  },
  500
  );
 }
 function submit(){
 document.getElementById("user").submit();
 }
 var out=document.getElementById('out');
 function key(e){
 //document.getElementById('out').style.WebkitAnimation="";
 out.style.display="block";
 out.innerHTML=String.fromCharCode(e.which);
 
 out.style.WebkitAnimation="appear 1s linear";
 setTimeout(function(){
	out.style.display="none";
	out.style.WebkitAnimation="";
	
 },1000);
 }
 <?php
	if($error==1)
	{
		echo "effect();";
		echo "document.getElementById('uname').style.color='red';";
		echo "document.getElementById('uname').style.boxShadow='0px 0px 5px 2px red';";
		echo "document.getElementById('uname').placeholder='Wrong username or password';";
		echo "document.getElementById('upass').style.color='red';";
		echo "document.getElementById('upass').style.boxShadow='0px 0px 5px 2px red';";
	}	
	
 ?>
 </script>
 </body>
</html>