<?php
session_start();
if(!isset($_SESSION['id']))
header("Location:index.php");

require('add_head.php');


//when form is submitted making an update request
	
	if(isset($_POST['submit']))
	{
		$date_today=date("Y-m-d");
		$utime=$_POST['time'];
		$uwait=$_POST['wait'];
		$increaseto=$_POST['increaseto'];
		//connecting to addshuttle_towardscampus table
		$db=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");	
		//connecting to waitlist table
		$waitlist=new PDO("mysql:host=localhost;dbname=shuttle","root","server");
		$people=new PDO("mysql:host=localhost;dbname=shuttle","root","server");
		$db->exec("UPDATE `shuttle`.`addshuttle_towardsjahangir` SET `{$utime}` = '{$increaseto}' WHERE `addshuttle_towardsjahangir`.`days` LIKE '{$_SESSION['day']}';");
		
		for($i=0; $i<$uwait; $i++)
		{
		//transfer one entry from waitlist to people
			 $transfer=$waitlist->prepare("SELECT name,email,date,time FROM waitlist2 WHERE date='{$date_today}' AND time LIKE '{$utime}';");
			 $transfer->execute();
			 $first_row=$transfer->fetch();
			 
			 //update confirmed bookings
			 $people->exec("INSERT INTO `people2` (`serial`, `name`, `email`, `date`, `time`, `status`) VALUES (NULL, '{$first_row['name']}', '{$first_row['email']}', '{$first_row['date']}', '{$first_row['time']}', '{$first_row['status']}');");
			 
			 //delete entry from waitlist
			 $waitlist->exec("DELETE FROM waitlist2 WHERE `name` LIKE '{$first_row['name']}' AND `email` LIKE '{$first_row['email']}' AND `date`='{$first_row['date']}' AND `time` LIKE '{$first_row['time']}' LIMIT 1;"); 
		
		}
		//to reset column value to 12
		$col=$db->prepare("describe addshuttle_towardsjahangir;");
		$col->execute();
		$rescol=$col->fetchAll(PDO::FETCH_COLUMN);
		foreach($rescol as $valcol)
		{
			if($valcol != $utime)
			{
				//check value at position to make sure its not zero// we are not touching zero values
				$seats_present=$db->prepare("SELECT `{$valcol}` from addshuttle_towardsjahangir WHERE `days` LIKE '{$_SESSION['day']}';");
				$seats_present->execute();
				$seats_count=$seats_present->fetch();
				if($seats_count[0]!=0)
				{
					$db->exec("UPDATE `shuttle`.`addshuttle_towardsjahangir` SET `{$valcol}` = '12' WHERE `addshuttle_towardscampus`.`days` LIKE '{$_SESSION['day']}';");
				}
				
			}
			else if($valcol==$utime)
					break;
		}
		$people=null;
		$waitlist=null;
		$db=null;
	}	
	
	
?>
	
	<table id="table">
		<tr id="th">
			<th colspan="4"><img style="margin-top:1%;" src="j2c.png" height="60"></th>
		</tr>
		
		<tr id="head">
			<td>TIME</td>
			<td>STATUS</td>
			<td>ACTION</td>
		</tr>
	</table>	
	<table id="large">
			<?php
				$today=strtolower(date('D'));
				function print_table()
				{

				$today_date=date("Y-m-d");
				//connecting to table people to get number of booked seats
				$people=new PDO("mysql:host=localhost;dbname=shuttle","root","server");
				
				//connecting to table waitlist to get number of waitlist
				$waitlist=new PDO("mysql:host=localhost;dbname=shuttle","root","server");
				
				//for fetching timings for today from addshuttle_towardscampus table
				$db=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
				$db->beginTransaction();
				
				
					//fetching timings from addshuttle_towardscampus table.
					$mon=$db->prepare("describe addshuttle_towardsjahangir;");
					$mon->execute();
					$result=$mon->fetchAll(PDO::FETCH_COLUMN);
					foreach(array_slice($result,2) as $res)
					{		//::::::::::change time here 18:30
							//getting count of booked seats
							$seats_booked=$people->prepare("SELECT count(serial) FROM people2 WHERE `time` LIKE '{$res}' AND `date`='{$today_date}';");
							$seats_booked->execute();
							$seats_total=$seats_booked->fetch();
							
							//getting count of waitlistss
							$waitlist_booked=$waitlist->prepare("SELECT count(serial) FROM waitlist2 WHERE `time` LIKE '{$res}' AND `date`='{$today_date}';");
							$waitlist_booked->execute();
							$waitlist_total=$waitlist_booked->fetch();
							
							//to get number of seats currently granted at a particular time from addshuttle_towardscampus table
							$seats_present=$db->prepare("SELECT `{$res}` from addshuttle_towardsjahangir WHERE `days` LIKE '{$_SESSION['day']}';");
							$seats_present->execute();
							$seats_count=$seats_present->fetch();
						
						//check if the value is not 0, shuttle will be deployed, print it on table to facilitate increase/ decrease in seats
						if($seats_count[0]!=0)
						{
							echo "<form action='{$_SERVER['PHP_SELF']}' method='POST'>";
							echo "<tr>";
							echo "<td> &nbsp; &nbsp; ".$res." &nbsp; &nbsp; &nbsp; </td>";
							echo "<td>  &nbsp;  &nbsp;".$seats_total[0]." B  &nbsp; &nbsp; </td>";
							echo "<td> &nbsp;  &nbsp;".$waitlist_total[0]." W/L  &nbsp; &nbsp; </td>";
							echo "<td><input type='number' min='12' name='increaseto' value='{$seats_count[0]}'> <input type='submit' class='down' value='UPDATE' name='submit'></td>";
							echo "</tr>";
							echo "<input type='text' name='time' value='{$res}' hidden>"; //for getting column name as time
							echo "<input type='text' name='wait' value='{$waitlist_total[0]}' hidden>"; //helping in updating from the waitlist page
							
							echo "</form>";
						}	
					}
					
					
				$db->commit();
				$waitlist=null;
				$people=null;
				$db=null;
				}
				
				if($today=='mon')
				{
					$_SESSION['day']='monday';
					print_table();
				}
				else if($today=='tue')
				{
					$_SESSION['day']='tuesday';
					print_table();
				}
				else if($today=='wed')
				{
					$_SESSION['day']='wednesday';
					print_table();
				}
				else if($today=='thu')
				{
					$_SESSION['day']='thursday';
					print_table();
				}
				else if($today=='fri')
				{
					$_SESSION['day']='friday';
					print_table();
				}
				else if($today=='sat')
				{
					$_SESSION['day']='saturday';
					print_table();
				}
				else if($today=='sun')
				{
					$_SESSION['day']='sunday';
					print_table();
				}
				
			?>
			
		
	</table>
	<br>
	
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
