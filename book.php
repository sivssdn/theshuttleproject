<?php
session_start();
if(!isset($_SESSION['id']))
header("Location:index.php");	
?>
<!DOCTYPE HTML>
<html>
 <head>
	<title>Shuttle.ashoka</title>
	<link rel="shortcut icon" type="image/x-icon" href="AshokaFavicon.png" >
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link href="shuttle.css" rel='stylesheet' type='text/css'>
	
 </head>
 <body>
	<img src="logo.png" id="logo">	
	<div id="name">
	Hi <?php echo $_SESSION['name']; ?>! 
	</div>
	<br>
	<div id="manage">
	 <a id="amanage" href="manage.php">MANAGE BOOKINGS</a>
	</div>
	
	<form method="post" action="logout.php">
	 <input type="submit" class="out" name="logout" value="Sign out!">
	</form>
	
	<!--Main content body-->
	<br>
	<div id="nav">
		<span id="heading">BOOK A SEAT FOR :</span>
		<br>
		<img src="but2.png" id="cj" onclick="cam()">
		<br>
		<img src="but3.png" id="jc" onclick="jan()">
	</div>
	<!--content over-->
	
	<!--Campus to jahangirpuri div-->
	<div id="div_cj" style="display:none;">
		<img src="c2j.png" class="place">
		
		<br>
		
		<img src="date.png" class="cll">
		<select name="date2" id="date2" onchange="setTime2(this)">
			
		</select>
		
		<img src="time.png" class="cl" >
		<select name="jahangirpuri" id="time2" onchange="convert_time('no',2);">
				
		</select>
		
		<br>
		<span id="avlbl1">AVAILABILITY :</span>
		<output id="available2"></output>
		<span id="avlbl" style="margin-left:1%;">seats</span>
		
		
		<span id="avlbl" style="margin-left:4%;">WAITLIST :</span>
		<output id="waitlist2"></output>
		<span id="avlbl" style="margin-left:1%;">people</span>
		<br>
		 <div class="parker">
		  <input type="checkbox" id="parker" value="yes">
		  <label for="parker">Pick me from Parker</label>
		 </div> 
		
		<img src="but5.png" id="book" onclick="convert_time('yes',2);spinner();" onmouseover="button(this.id)" onmouseout="buttonr(this.id)">
		<img src="75.gif" id="spin" height="30">
		<!--hidden functions-->
		<input hidden type="text" value="" name="day2" id="day2">
	
		<input hidden type="text" value="" name="compare_t2" id="compare_t2"><br>
		<output id="booking2" hidden></output>
		
	</div>
	
	<!--From jahangirpuri to campus div-->
	
	
	<div id="div_jc" style="display:none;">
		<img src="j2c.png" class="place">
		
		<br>
		<img src="date.png" class="cll">
		
		<select name="date" id="date" onchange="setTime(this)">
			
		</select>
		<img src="time.png" class="cl">
		
		<select name="campus" id="time" onchange="convert_time('no',1);">
				
		</select>
		<br>
		<span id="avlbl1">AVAILABILITY :</span>
		<output id="available"> </output>
		<span id="avlbl" style="margin-left:1%;">seats</span>
		
		
		<span id="avlbl" style="margin-left:4%;">WAITLIST :</span>
		<output id="waitlist"> </output>
		<span id="avlbl" style="margin-left:1%;">people </span>
		<img src="but5.png" id="book1" onclick="convert_time('yes',1);spinner2();" onmouseover="button(this.id)" onmouseout="buttonr(this.id)">
		<img src="75.gif" id="spin2" height="30">
		<br>
		
		<!--hidden functions-->
		<input hidden type="text" value="" name="day" id="day">

		<input hidden type="text" value="" name="compare_t" id="compare_t">
		
		<output id="booking" hidden></output>
		
	</div>
	
	
	
	<!--CONFIRMATION PAGE-->
	<div id="confirm" style="display:none;">
	 <span id="pleasant">Have a safe and pleasant trip!</span>
	 <span id="book_text">YOUR BOOKING STATUS : </span>
	 <span id="book_status">CONFIRMED</span><br><br>
	 <a href="<?php echo $_SERVER['PHP_SELF']; ?>"><img src="newbook.png" height="80" id="new_book"></a>
	</div>
	
	
	
	<div id="cast">
		ASHOKA UNIVERSITY SHUTTLE BOOKING SERVICE
	</div>
	
	<div id="cast1">
		DEVELOPED BY SANAT AND PARAS
	</div>
 </body>
 <script src="effects.js"> </script>
 <?php
		//to analyse date and produce select field accordingly
		 
		$date=array(date('d-m-Y'),date('d-m-Y',strtotime("+1 day")),date('d-m-Y',strtotime("+2 day")),date('d-m-Y',strtotime("+3 day")),date('d-m-Y',strtotime("+4 day")));
		$day=array(date('D'),date('D',strtotime("+1 day")),date('D',strtotime("+2 day")),date('D',strtotime("+3 day")),date('D',strtotime("+4 day")));
		//enter date and the day will be returned
		

		
		
		//echo date('D',strtotime("+2 day"));
		date_default_timezone_set("Asia/Kolkata");
		//$default=date_default_timezone_get();
			//echo "<br>{$default}<br>";echo "<br>".date("H-i-s");
		//define UTC Indian time zone
		
		
		
		
	?>
	<script>
  
  
  function setDate(){
  <?php
	//creating date list
		foreach($date as $item)
		{
			 
			echo "var option=document.createElement('option');\n";
			echo "option.text='{$item}';\n";
			echo "option.value='{$item}';\n";
			echo "document.getElementById('date').appendChild(option);\n";
			
			
		}
		
		foreach($date as $item)
		{
			 
			echo "var option=document.createElement('option');\n";
			echo "option.text='{$item}';\n";
			echo "option.value='{$item}';\n";
			echo "document.getElementById('date2').appendChild(option);\n";
			
			
		}
		
  ?>
  }
  setDate();
  
  <?php
		//prepare date for next 3 days
		$date=array(date('d-m-Y'),date('d-m-Y',strtotime("+1 day")),date('d-m-Y',strtotime("+2 day")),date('d-m-Y',strtotime("+3 day")),date('d-m-Y',strtotime("+4 day")));
		echo "var date=['{$date[0]}','{$date[1]}','{$date[2]}','{$date[3]}','{$date[4]}'];";
		
		
		
		//prepare day for next three days
		$day=array(date('D'),date('D',strtotime("+1 day")),date('D',strtotime("+2 day")),date('D',strtotime("+3 day")),date('D',strtotime("+4 day")));
		echo "\n var day=['{$day[0]}','{$day[1]}','{$day[2]}','{$day[3]}','{$day[4]}'];";
		
		//current time returned by server
		$current_time=date("Hi");
		echo "var current_time={$current_time};";
		?>
  
 </script>
 <script src="shuttle.js" ></script>
 
</html>