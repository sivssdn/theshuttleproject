<?php
 session_start();
 date_default_timezone_set("Asia/Kolkata");
 header("Content-type:application/json");
 //program to register user for seats towards campus
 
 
 //variables to get the data from form
 $campus_time=$_GET['campus'];
 $compare_time=htmlspecialchars($_GET['compare_t']);
 $campus_date=htmlspecialchars($_GET['date']);
 $insert_at=$campus_date[0].$campus_date[1];
 $day=htmlspecialchars($_GET['day']);
 $table=$day."tocampus";
 $do=htmlspecialchars($_GET['do']);
 $status="CONFIRMED";
 
 $db=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
 
 //see if the form wants insert query (yes) or just want to check status($do==no)
 if($do=="yes")
 {
 //variables to print the output json
 $booking="Full";
 $available;
 $waitlist[0]=0;
 
 //database queries
 
 
 try{
    //check value in db at the specified time i.e., get total sets booked
	$db->beginTransaction();
	$data=$db->prepare("SELECT `{$campus_time}` FROM {$table} WHERE `serial`={$insert_at}; ");
	$data->execute();
	$result=$data->fetch();
	//print_r($result); echo "\n";
	
	//error check if the user is not selecting past time of today
	$past=strtolower(date("D"));
	if($past=="mon" || $past=="tue" || $past=="wed" || $past=="thu")
	$past="mon";
	
	/*
	//:::::::::::::::error to prevent booking on elapsed time::correction date(strtotime('date')==date('today's date'))
	if($day==$past && $compare_time<date("Hi"))
	$allow=0;
	else
	$allow=1;
	*/
	//to be changed with total number of seats	
	
	$allow=1;
	
	//to get number of seats available from addshuttle_towards campus
	$add_shuttle=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
	$date_d=$campus_date[6].$campus_date[7].$campus_date[8].$campus_date[9].'-'.$campus_date[3].$campus_date[4].'-'.$campus_date[0].$campus_date[1];
	$add_shuttle_day=date('D',strtotime("{$date_d}"));
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
	}
	$seats_present=$db->prepare("SELECT `{$campus_time}` from addshuttle_towardscampus WHERE `days` LIKE '{$add_shuttle_day}';");
	$seats_present->execute();
	$seats_count=$seats_present->fetch();
					
					
	$add_shuttle=null;
	//::[change]:: 2 to 12 for number of seats
	//if($result[$campus_time]<12 && $allow) translated as::
	//if($result[$campus_time]<$seats_count[0] && $allow) //fetch value at the specified timing from db
	if($seats_count[0]>0 && $allow)
	{
		
		//::[change]::[EMAIL]::in query::done
	
		//to check if the user has already booked a seat, Limit set to 1
		$date_db=$campus_date[6].$campus_date[7].$campus_date[8].$campus_date[9].'-'.$campus_date[3].$campus_date[4].'-'.$campus_date[0].$campus_date[1];
		
		$data=$db->prepare("SELECT count(serial) FROM people WHERE email LIKE '{$_SESSION['id']}' AND date='{$date_db}' AND time LIKE '{$campus_time}';");
		$data->execute();
		$total=$data->fetch();
		
	    //allowing only 2 entry per used  ::[change]::2 to total allowed seats
		if($total[0]<1 || $_SESSION['id']=="Admin sahab")
		{
			$db->exec("UPDATE `addshuttle_towardscampus` SET `{$campus_time}`={$seats_count[0]}-1 WHERE `days`='{$add_shuttle_day}';");
			$db->exec("UPDATE `{$table}` SET `{$campus_time}`={$result[$campus_time]}+1 WHERE `serial`={$insert_at};");
			//echo "\nUpdated value={$result[$campus_time]} at position = {$campus_time} and {$insert_at}";
			
			//prepare date in reverse order to be inserted into db
			$date_db=$campus_date[6].$campus_date[7].$campus_date[8].$campus_date[9].'-'.$campus_date[3].$campus_date[4].'-'.$campus_date[0].$campus_date[1];
		
			//inserting into db the status of booking
			$db->exec("INSERT INTO `shuttle`.`people` (`serial`, `name`, `email`, `date`, `time`, `status`) VALUES (Null, '{$_SESSION['name']}', '{$_SESSION['id']}', '{$date_db}', '{$campus_time}', '{$status}');");
			$booking="CONFIRMED";
			
			//::: changed from 12-1
			//$available=($seats_count[0]-1)-$result[$campus_time]; //to output seats remaining
			$available=$seats_count[0]-1;
		}
		else
		{
			$booking="exists";
			//$available=$result[$campus_time];
			$available=$seats_count[0];
		}
		
	}
	else if($allow)
	{
		//to say no seats are available,
		$available=0;
		
		//waitlist queries to insert and then check
		$list_db=new PDO("mysql:host=localhost;dbname=shuttle","root","server");
		
		$date_d=$campus_date[6].$campus_date[7].$campus_date[8].$campus_date[9].'-'.$campus_date[3].$campus_date[4].'-'.$campus_date[0].$campus_date[1];
		$list_db->exec("INSERT INTO `shuttle`.`waitlist` (`serial`, `name`, `email`, `date`, `time`, `status`) VALUES (NULL, '{$_SESSION['name']}', '{$_SESSION['id']}', '{$date_d}', '{$campus_time}', '{$status}');");
		
		
		//to check waitlist number
		$number=$list_db->prepare("SELECT count(serial) FROM waitlist WHERE `time` LIKE '{$campus_time}' AND `date`='{$date_d}';");
		$number->execute();
		$waitlist=$number->fetch();
		
		
	}
	/*
     else
     {
	   //when booked on the time that has already elapsed
	   $available=0;
	   $waitlist[0]=0;
	   $booking="Not allowed";
	 }*/	 
	$db->commit();
 }
 catch(PDOException $e){
    $e->getMessage();
 }
 
 
 
 
 print("{booking:'{$booking}',available:'{$available}',waitlist:'{$waitlist[0]}'}");
 }
 else if($do=="no"){
	
	
 
 try{
    
	//check value in db at the specified time i.e., get total sets booked
	/*
	//earlier way of checkinh from montocampus table...
	$data=$db->prepare("SELECT `{$campus_time}` FROM {$table} WHERE `serial`={$insert_at}; ");
	$data->execute();
	$result=$data->fetch();
	*/
	
	//to get number of seats available from addshuttle_towards campus
	$add_shuttle=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
	$date_d=$campus_date[6].$campus_date[7].$campus_date[8].$campus_date[9].'-'.$campus_date[3].$campus_date[4].'-'.$campus_date[0].$campus_date[1];
	$add_shuttle_day=date('D',strtotime("{$date_d}"));
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
	}
	$seats_present=$db->prepare("SELECT `{$campus_time}` from addshuttle_towardscampus WHERE `days` LIKE '{$add_shuttle_day}';");
	$seats_present->execute();
	$seats_count=$seats_present->fetch();
					
					
	$add_shuttle=null;
	
	//print_r($result); echo "\n";
	}catch(PDOException $e){
		$e->getMessage();
	}
	$seats_left=$seats_count[0]; //to be change with the change in number of seats
	
	if($seats_left==0)
	$available="Seats full";
	else
	$available="Available";
	
	//to count waitlist from waitlist table
	$list_db=new PDO("mysql:host=localhost;dbname=shuttle","root","server");
	$date_date=$campus_date[6].$campus_date[7].$campus_date[8].$campus_date[9].'-'.$campus_date[3].$campus_date[4].'-'.$campus_date[0].$campus_date[1];
	$number=$list_db->prepare("SELECT count(serial) FROM waitlist WHERE `time` LIKE '{$campus_time}' AND `date`='{$date_date}';");
	$number->execute();
	$waitlist=$number->fetch();
	

	$db=null;
	print("{booking:'{$available}',available:'{$seats_left}',waitlist:'{$waitlist[0]}'}");
 }
 ?>