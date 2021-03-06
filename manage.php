<?php
session_start();
if(!isset($_SESSION['id']))
header("Location:index.php");
//echo "<span style='color:white;'>";
//if any cancel request is made 
	$date_today=date("Y-m-d");
if(isset($_POST['d']) && isset($_POST['t']) && isset($_POST['s']))
{
	$date=htmlspecialchars($_POST['d']);
	$time=htmlspecialchars($_POST['t']);
	$table=htmlspecialchars($_POST['s']);
	$add_shuttle_day=date('D',strtotime("{$date}"));
	$add_shuttle_day=strtolower($add_shuttle_day);
	switch($add_shuttle_day)
	{
		case 'mon':$add_shuttle_day='monday';
					break;
		case 'tue':$add_shuttle_day='tuesday';
					break;
		case 'wed':$add_shuttle_day='wednesday';
					break;
		case 'thu':$add_shuttle_day='thursday';
					break;
		case 'fri':$add_shuttle_day='friday';
					break;
		case 'sat':$add_shuttle_day='saturday';
					break;
		case 'sun':$add_shuttle_day='sunday';			
					break;
	}
	
	
	$b_cancel=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
	$b_cancel->beginTransaction();
	
	if($table=='waitlist' || $table=='waitlist2')
	{
		$b_cancel->exec("DELETE FROM `{$table}` WHERE `email` LIKE '{$_SESSION['id']}' AND `time` LIKE '{$time}' AND `date`='{$date}' LIMIT 1;");
	}
	else if($table=='people')
		{
			
			
			$data=$b_cancel->prepare("SELECT count(serial) FROM waitlist WHERE date='{$date_today}' OR date>'{$date_today}';");
			$data->execute();
			$result=$data->fetch();
			$c=count($result);
			//echo "<span style='color:red;'>{$c}";
			
			//if wailist exists (then transfer it to confirmed status)
			if($result[0]>0)
			{
			 //delete from people(confirm entry)
			 $b_cancel->exec("DELETE FROM people WHERE `email` LIKE '{$_SESSION['id']}' AND `time` LIKE '{$time}' AND `date`='{$date}' LIMIT 1;");
			 
			 //transfer one entry from waitlist to people
			 $transfer=$b_cancel->prepare("SELECT name,email,date,time FROM waitlist WHERE date='{$date_today}' OR date>'{$date_today}';");
			 $transfer->execute();
			 $first_row=$transfer->fetch();
			 //echo "<span style='color:red;'>{$first_row['email']} {$first_row['name']} {$first_row['date']} {$first_row['time']}";
			 $b_cancel->exec("INSERT INTO `people` (`serial`, `name`, `email`, `date`, `time`, `status`) VALUES (NULL, '{$first_row['name']}', '{$first_row['email']}', '{$first_row['date']}', '{$first_row['time']}', 'CONFIRMED');");
			 
			 //delete entry from waitlist
			 $b_cancel->exec("DELETE FROM waitlist WHERE `name` LIKE '{$first_row['name']}' AND `email` LIKE '{$first_row['email']}' AND `date`='{$first_row['date']}' AND `time` LIKE '{$first_row['time']}' LIMIT 1;"); 
			 
			 
			 //know the current value at row and column
				$seats_present=$b_cancel->prepare("SELECT `{$column}` from `addshuttle_towardscampus` WHERE `days` LIKE '{$add_shuttle_day}';");
				$seats_present->execute();
				$seats_count=$seats_present->fetch();
				//update with +1
				$b_cancel->exec("UPDATE `addshuttle_towardscampus` SET `{$column}`={$seats_count[0]}+1 WHERE `days`='{$add_shuttle_day}';");
			}
			else
			{
				//if waitlist doesn't exists
				$dtable=date('D',strtotime("{$_POST['d']}"));
				$dtable=strtolower($dtable);
				
				//prepare table name
					if($dtable=='tue' || $dtable=='wed' || $dtable=='thu')
					$dtable='mon';
				$dtable=$dtable.'tocampus';
				//echo $dtable;
				
				//delete from people (confirmed)
				$b_cancel->exec("DELETE FROM people WHERE `email` LIKE '{$_SESSION['id']}' AND `time` LIKE '{$time}' AND `date`='{$date}' LIMIT 1;");
				
				//decrease 1 from the table to make 1 seat available
				
				//prepare row name from where deletion is to be performed
				$row=htmlspecialchars($_POST['d']);
				$row=$row[8].$row[9];
				//echo "<br>".$row;
				$column=htmlspecialchars($_POST['t']);
				
				//in case time is 9:00 instead of 09:00
				if($column[1]==':')
				$column='0'.$column[0].$column[1].$column[2].$column[3];
				
				//echo "<br>".$column;
				
				
				
				//know the current value at row and column from montocampus(type)
				//updation needs to be done at both tables
				$value=$b_cancel->prepare("SELECT `{$column}` FROM {$dtable} WHERE `serial`={$row};");
				$value->execute();
				$result_val=$value->fetch();
				
				$result_val[0]--;
				$b_cancel->exec("UPDATE `{$dtable}` SET `{$column}`={$result_val[0]} WHERE `serial`={$row};");
				//echo $result_val[0];
				
				//::::::----- paras -----::::CAUTION :: error prone area
				
				//know the current value at row and column
				$seats_present=$b_cancel->prepare("SELECT `{$column}` from `addshuttle_towardscampus` WHERE `days` LIKE '{$add_shuttle_day}';");
				$seats_present->execute();
				$seats_count=$seats_present->fetch();
				//update with +1
				$b_cancel->exec("UPDATE `addshuttle_towardscampus` SET `{$column}`={$seats_count[0]}+1 WHERE `days`='{$add_shuttle_day}';");
			}
		}
		else if($table=='people2')
			{
				$data=$b_cancel->prepare("SELECT count(serial) FROM waitlist2 WHERE date='{$date_today}' OR date>'{$date_today}';");
				$data->execute();
				$result=$data->fetch();
				$c=count($result);
				//echo counting wailist
				//echo "<span style='color:red;'>{$c}";
			
				//if wailist exists
				if($result[0]>0)
				{
				//delete from people(confirm entry)
				$b_cancel->exec("DELETE FROM people2 WHERE `email` LIKE '{$_SESSION['id']}' AND `time` LIKE '{$time}' AND `date`='{$date}' LIMIT 1;");
			 
				//transfer one entry from waitlist to people
				$transfer=$b_cancel->prepare("SELECT name,email,date,time FROM waitlist2 WHERE date='{$date_today}' OR date>'{$date_today}';");
				$transfer->execute();
				$first_row=$transfer->fetch();
				
				//echo row ::
				//echo "<span style='color:red;'>{$first_row['email']} {$first_row['name']} {$first_row['date']} {$first_row['time']}";
				
				$b_cancel->exec("INSERT INTO `people2` (`serial`, `name`, `email`, `date`, `time`, `status`) VALUES (NULL, '{$first_row['name']}', '{$first_row['email']}', '{$first_row['date']}', '{$first_row['time']}', 'CONFIRMED');");
			 
				//delete entry from waitlist
				$b_cancel->exec("DELETE FROM waitlist2 WHERE `name` LIKE '{$first_row['name']}' AND `email` LIKE '{$first_row['email']}' AND `date`='{$first_row['date']}' AND `time` LIKE '{$first_row['time']}' LIMIT 1;"); 
				
				//know the current value at row and column
				$seats_present=$b_cancel->prepare("SELECT `{$column}` from `addshuttle_towardsjahangir` WHERE `days` LIKE '{$add_shuttle_day}';");
				$seats_present->execute();
				$seats_count=$seats_present->fetch();
				//update with +1
				$b_cancel->exec("UPDATE `addshuttle_towardsjahangir` SET `{$column}`={$seats_count[0]}+1 WHERE `days`='{$add_shuttle_day}';");
				}
				else
				{
				//if waitlist doesn't exists
				$dtable=date('D',strtotime("{$_POST['d']}"));
				$dtable=strtolower($dtable);
				
				
				//echo $dtable;
				
				//delete from people (confirmed)
				$b_cancel->exec("DELETE FROM people2 WHERE `email` LIKE '{$_SESSION['id']}' AND `time` LIKE '{$time}' AND `date`='{$date}' LIMIT 1;");
				
				//decrease 1 from the table to make 1 seat available
				
				//prepare row name from where deletion is to be performed
				$row=htmlspecialchars($_POST['d']);
				$row=$row[8].$row[9];
				//echo "<br>".$row;
				$column=htmlspecialchars($_POST['t']);
				
				//in case time is 9:00 instead of 09:00
				if($column[1]==':')
				$column='0'.$column[0].$column[1].$column[2].$column[3];
				
				//echo "<br>".$column;
				
					//prepare table name
					if($dtable=='tue' || $dtable=='wed' || $dtable=='thu')
					$dtable='mon';
					$dtable=$dtable.'tojahangir';
				//UPDATE `addshuttle_towardsjahangir` SET `{$campus_time}`={$seats_count[0]}-1 WHERE `days`='{$add_shuttle_day}
				//know the current value at row and column
				$value=$b_cancel->prepare("SELECT `{$column}` FROM {$dtable} WHERE `serial`={$row};");
				$value->execute();
				$result_val=$value->fetch();
				
				$result_val[0]--;
				
				//:::::::::::::::error prone area, careful:::::::::::::::::::::::::::::::::::::::
				$b_cancel->exec("UPDATE `{$dtable}` SET `{$column}`={$result_val[0]} WHERE `serial`={$row};");
				//echo $result_val[0];
				
				
				//know the current value at row and column
				$seats_present=$b_cancel->prepare("SELECT `{$column}` from `addshuttle_towardsjahangir` WHERE `days` LIKE '{$add_shuttle_day}';");
				$seats_present->execute();
				$seats_count=$seats_present->fetch();
				//update with +1
				$b_cancel->exec("UPDATE `addshuttle_towardsjahangir` SET `{$column}`={$seats_count[0]}+1 WHERE `days`='{$add_shuttle_day}';");
				}
			}
	
	$b_cancel->commit();
	$b_cancel=null;
	
}
	

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
	height:2vw;
	color:#ffffff;
	background-color:#000000;
	}
	th{
	height:2vw;
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
	.green,.orange{
	color:green;
	font-weight:bold;
	}
	.orange{
	color:orange;
	}
	a{
	cursor:pointer;
	text-decoration:underline;
	color:rgba(0,191,243,1);
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
	#amanage{
	color:#ffffff;
	text-decoration:none;
	}
	#manage:hover{
	box-shadow:0px 0px 7px 2px rgba(0,191,243,1);
	}
	.h_image{
	 height:150%;
	}
	/*android*/
	@media only screen and (min-width:100px) and (max-width:480px){
	 html,body{
	 background-size:cover;
	 }
	 #logo{
	  position:relative;
	  float:left;
	 }
	 h3{
	  font-size:3vw;
	  right:10%;
	 }
	 #name{
	 display:none;
	 }
	 #manage{
	  height:5%;
	  width:22%;
	  font-size:2.5vw;
	  line-height:250%;
	  float:right;
	  left:18%;
	  margin-top:-12%;
	  position:relative;
	 }
	 .out{
	  position:relative;
	  float:right;
	  display:block;
	  margin-top:16%;
	  font-size:3.5vw;
	 }
	 .h_image{
	  height:10vw;
	 }
	 table{
	  font-size:3vw;
	  width:80%;
	 }
	 #head{
	  font-size:4vw;
	 }
	 #large td,#large{
	  border:none;
	 }
	 td{
	  border:none;
	 }
	 #cast{
	 display:none;
	 }
	 #cast1{
	  font-size:4vw;
	  margin-right:5%;
	 }
	}
	
	@media only screen and (min-width:480px) and (max-width:640px){
	 html,body{
	 background-size:cover;
	 }
	 #logo{
	  position:relative;
	  float:left;
	 }
	 h3{
	  font-size:3vw;
	  right:20%;
	 }
	 #name{
	 display:none;
	 }
	 #manage{
	  height:5%;
	  width:22%;
	  font-size:2.5vw;
	  line-height:250%;
	  float:right;
	  left:18%;
	  position:relative;
	 }
	 .out{
	  position:relative;
	  float:right;
	  display:block;
	  margin-top:15%;
	  font-size:3.5vw;
	 }
	 .h_image{
	  height:10vw;
	 }
	 table{
	  font-size:3vw;
	  width:80%;
	 }
	 #head{
	  font-size:4vw;
	 }
	 #large td,#large{
	  border:none;
	 }
	 td{
	  border:none;
	 }
	 #cast{
	 display:none;
	 }
	 #cast1{
	  font-size:4vw;
	  margin-right:5%;
	 }
	}
	/*For iphone*/
	@media only screen and (min-width:640px) and (max-width:768px){
	 html,body{
	 background-size:cover;
	 }
	 #logo{
	  position:relative;
	  float:left;
	 }
	 h3{
	  font-size:3vw;
	  right:20%;
	 }
	 #name{
	  display:none;
	 }
	 #manage{
	  height:5%;
	  width:22%;
	  font-size:2.5vw;
	  line-height:250%;
	  float:right;
	  left:55%;
	  position:relative;
	 }
	 .out{
	  position:relative;
	  float:right;
	  display:block;
	  margin-top:10%;
	  font-size:3.5vw;
	 }
	 .h_image{
	  height:9vw;
	 }
	 table{
	  font-size:3vw;
	  width:80%;
	 }
	 #head{
	  font-size:3.5vw;
	 }
	 #large td,#large{
	  border:none;
	 }
	 td{
	  border:none;
	 }
	 #cast{
	 display:none;
	 }
	 #cast1{
	  font-size:3.5vw;
	  margin-right:5%;
	 }
	}
	
	/*high windows phone*/
	@media only screen and (min-width:768px) and (max-width:1024px){
	
	 html,body{
	 background-size:cover;
	 }
	 #logo{
	  position:relative;
	  float:left;
	 }
	 h3{
	  font-size:3vw;
	  right:20%;
	 }
	 #name{
	  display:none;
	 }
	 #manage{
	  height:5%;
	  width:22%;
	  font-size:2.5vw;
	  line-height:200%;
	  float:right;
	  left:54%;
	  position:relative;
	 }
	 .out{
	  position:relative;
	  float:right;
	  display:block;
	  margin-top:10%;
	  font-size:3vw;
	 }
	 .h_image{
	  height:9vw;
	 }
	 table{
	  font-size:2vw;
	  width:80%;
	 }
	 #head{
	  font-size:3vw;
	 }
	 
	 #large td,#large{
	  border:none;
	 }
	 td{
	  border:none;
	 }
	 #cast{
	 display:none;
	 }
	 #cast1{
	  font-size:3vw;
	  margin-right:5%;
	 }
	}
	/*ipad*/
	@media only screen and (min-width:1024px) and (max-width:1280px){
	 
	 html,body{
	 background-size:cover;
	 }
	 #logo{
	  position:relative;
	  float:left;
	 }
	 h3{
	  font-size:3vw;
	  right:24%;
	 }
	 #name{
	  position:relative;
	  display:inline-block;
	  left:8%;
	 }
	 #manage{
	  height:5%;
	  width:22%;
	  font-size:2vw;
	  line-height:180%;
	  float:right;
	  left:48%;
	  top:10%;
	  position:relative;
	 }
	 .out{
	  position:relative;
	  float:right;
	  display:block;
	  margin-top:8%;
	  font-size:2vw;
	 }
	 .h_image{
	  height:7vw;
	 }
	 table{
	  font-size:2vw;
	  width:80%;
	 }
	 #head{
	  font-size:2vw;
	 }
	 
	 #large td,#large{
	  border:none;
	 }
	 td{
	  border:none;
	 }
	 #cast{
	 display:none;
	 }
	 #cast1{
	  font-size:2vw;
	  margin-right:5%;
	 }
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
	 MANAGE BOOKINGS
	</h3>
	<div id="manage">
	 <a id="amanage" href="book.php">NEW BOOKINGS</a>
	</div>
	<br><br><br><br><br><br><br><br><br><br>
	<!--     Table for jahangirpuri->campus      -->
	
	<table id="table">
		<tr id="th">
			<th colspan="4"><img style="margin-top:1%;" src="j2c.png" class="h_image"></th>
		</tr>
		
		<tr id="head">
			<td style="padding-left:2%;">DATE</td>
			<td style="padding-left:2%;">TIME</td>
			<td style="padding-left:2%;">STATUS</td>
			<td> ACTION</td>
		</tr>
		
		
	</table>
	
	<table id="large">
		<?php
		
			$count=0;
			$cancel=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
			
			 $data=$cancel->prepare("SELECT `date`,`time` FROM people WHERE email LIKE '{$_SESSION['id']}' AND (date='{$date_today}' OR date>'{$date_today}');");
			 $data->execute();
			 $confirm_result=$data->fetchAll();
			
			 //fetch all confirmed bookings belonging to email
			foreach($confirm_result as $print)
			{
				$count=$count+1;
				echo "<tr>";
				echo "<td id='d{$count}'>"; 	echo $print['date']; 	echo "</td>";
				echo "<td id='t{$count}'>"; 	echo $print['time']; 	echo "</td>";
				echo "<td class='green'>"; 	echo "CONFIRMED<input type='hidden' id='s{$count}' value='people'>"; 	echo "</td>";
				echo "<td class='can'>"; 	 	echo "</td>";
				echo "</tr>";
			}
			//fetch waitlist
			$data=$cancel->prepare("SELECT `date`,`time` FROM waitlist WHERE email LIKE '{$_SESSION['id']}' AND (date='{$date_today}' OR date>'{$date_today}');");
			$data->execute();
			$waitlist_result=$data->fetchAll();
			
			foreach($waitlist_result as $print)
			{
				$count=$count+1;
				echo "<tr>";
				echo "<td id='d{$count}'>"; 	echo $print['date']; 	echo "</td>";
				echo "<td id='t{$count}'>"; 	echo $print['time']; 	echo "</td>";
				echo "<td class='orange'>"; 	echo "WAITLIST<input type='hidden' id='s{$count}' value='waitlist'>"; 	echo "</td>";
				echo "<td class='can'>"; 	 	echo "</td>";
				echo "</tr>";
			}
		//$cancel=null;
		?>
	</table>

	
		<!--     Table for campus->jahangirpuri        -->
		<table id="table" style="margin-top:4%;">
		<tr id="th">
			<th colspan="4"><img style="margin-top:0.8%;" src="c2j.png" class="h_image"></th>
		</tr>
		
		<tr id="head">
			<td style="padding-left:2%;"> DATE</td>
			<td style="padding-left:2%;"> TIME</td>
			<td style="padding-left:2%;"> STATUS</td>
			<td> ACTION</td>
		</tr>
		
		
	</table>
	<table id="large">
		<?php
			//$cancel=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
			
			 $data=$cancel->prepare("SELECT `date`,`time` FROM people2 WHERE email LIKE '{$_SESSION['id']}' AND (date='{$date_today}' OR date>'{$date_today}');");
			 $data->execute();
			 $confirm_result=$data->fetchAll();
			
			 //fetch all confirmed bookings belonging to email
			foreach($confirm_result as $print)
			{
				$count=$count+1;
				echo "<tr>";
				echo "<td id='d{$count}'>"; 	echo $print['date']; 	echo "</td>";
				echo "<td id='t{$count}'>"; 	echo $print['time']; 	echo "</td>";
				echo "<td class='green'>"; 	echo "CONFIRMED<input type='hidden' id='s{$count}' value='people2'>"; 	echo "</td>";
				echo "<td class='can'>"; 	 	echo "</td>";
				echo "</tr>";
			}
			//fetch waitlist
			$data=$cancel->prepare("SELECT `date`,`time` FROM waitlist2 WHERE email LIKE '{$_SESSION['id']}' AND (date='{$date_today}' OR date>'{$date_today}');");
			$data->execute();
			$waitlist_result=$data->fetchAll();
			
			foreach($waitlist_result as $print)
			{
				$count=$count+1;
				echo "<tr>";
				echo "<td id='d{$count}'>"; 	echo $print['date']; 	echo "</td>";
				echo "<td id='t{$count}'>"; 	echo $print['time']; 	echo "</td>";
				echo "<td class='orange' >"; 	echo "WAITLIST <input type='hidden' id='s{$count}' value='waitlist2'>"; 	echo "</td>";
				echo "<td class='can'>"; 					echo "</td>";
				echo "</tr>";
			}
		$cancel=null;
		?>
	</table>
	<br><br>
	<form id="f1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<input type="text" id="d" name="d" value="<?php if(isset($_POST['d'])) echo $_POST['d']; ?>" hidden>
	<input type="text" id="t" name="t" value="<?php if(isset($_POST['t'])) echo $_POST['t']; ?>" hidden>
	<input type="text" id="s" name="s" value="<?php if(isset($_POST['s'])) echo $_POST['s']; ?>" hidden>
	</form>
	
	<div class='footer'>
	<div id="cast">
		ASHOKA UNIVERSITY SHUTTLE BOOKING SERVICE
	</div>
	
	<div id="cast1">
		DEVELOPED BY SANAT AND PARAS
	</div>
	</div>
	<script>
	window.onload=function(){
	var length=document.getElementsByClassName('can').length,i,e;
	for(i=0;i<length;i++)
	document.getElementsByClassName('can')[i].innerHTML="<a onclick='sub(id)' id='"+(i+1)+"'>CANCEL</a>";
	}
	function sub(e){
	
	document.getElementById('d').value=document.getElementById('d'+e).innerHTML;
	document.getElementById('t').value=document.getElementById('t'+e).innerHTML;
	document.getElementById('s').value=document.getElementById('s'+e).value;
	
	document.getElementById('f1').submit();
	
	}
	</script>
 </body>
</html>
