<?php
	session_start();
	if($_SESSION['id']!='ashoka')
	header('Location:index.php');
	
	//for generating report in excel
	if(isset($_POST['report']))
	{
				require_once($_SERVER['DOCUMENT_ROOT'].'/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
				$obj=PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/report/people.xlsx");
							//for auto download excel file
			header("Content-Type: application/vnd.ms-excel;charset=utf-8");
			header("Content-Disposition: attachment;filename=people.xlsx");
			header('Cache-Control: max-age=0');
			//header("Expires: 0");
			//header("Cache-control: must-revalidate,post-check=0,pre-check=0");
			//header("Cache-control: private",false);

				
				$db=new PDO("mysql:host=localhost;dbname=shuttle","root","server");
				
				//for people towards campus
				//CONFIRMED ENTRIES
				$data=$db->prepare("SELECT `name`,`email`,`date`,`time` FROM people;");
				$data->execute();
				$result=$data->fetchAll();
				
				$count=count($result);
				
				//enter into excel sheet of people who have confirmed entries
				$obj->setActiveSheetIndex(0);
				$highest_row=$obj->getActiveSheet()->getHighestRow()+1;
				 for($i=0;$i<$count;$i++)
				 {
					$highest_row+=1; //to get vertical columns
					$A='A'.$highest_row;
					$B='B'.$highest_row;
					$C='C'.$highest_row;
					$D='D'.$highest_row;
					$E='E'.$highest_row;
					
					$obj->getActiveSheet()->setCellValue("{$A}",$result[$i][0]);
					$obj->getActiveSheet()->setCellValue("{$B}",$result[$i][1]);
					$obj->getActiveSheet()->setCellValue("{$C}",$result[$i][2]);
					$obj->getActiveSheet()->setCellValue("{$D}",$result[$i][3]);
					$obj->getActiveSheet()->setCellValue("{$E}","CONFIRMED");
				}
				
				//for the waitlist of people towards campus
				$data=$db->prepare("SELECT `name`,`email`,`date`,`time` FROM WAITLIST;");
				$data->execute();
				$result=$data->fetchAll();
				
				$count=count($result);
				
				//enter into excel sheet of people who have waitlist entries
				$obj->setActiveSheetIndex(0);
				$highest_row=$obj->getActiveSheet()->getHighestRow()+1;
				 for($i=0;$i<$count;$i++)
				 {
					$highest_row+=1; //to get vertical columns
					$A='A'.$highest_row;
					$B='B'.$highest_row;
					$C='C'.$highest_row;
					$D='D'.$highest_row;
					$E='E'.$highest_row;
					
					$obj->getActiveSheet()->setCellValue("{$A}",$result[$i][0]);
					$obj->getActiveSheet()->setCellValue("{$B}",$result[$i][1]);
					$obj->getActiveSheet()->setCellValue("{$C}",$result[$i][2]);
					$obj->getActiveSheet()->setCellValue("{$D}",$result[$i][3]);
					$obj->getActiveSheet()->setCellValue("{$E}","WAITLIST");
				}
				
				
				//create writer to save into .xlsx file
				$objectWriter=PHPExcel_IOFactory::createWriter($obj,"Excel2007");
				$objectWriter->save($_SERVER['DOCUMENT_ROOT'].'/report/people.xlsx');
				
				//for people towards jahangirpuri
				$obj2=PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/report/people.xlsx");
				
				//CONFIRMED ENTRIES
				$data=$db->prepare("SELECT `name`,`email`,`date`,`time` FROM people2;");
				$data->execute();
				$result=$data->fetchAll();
				
				$count=count($result);
				
				//enter into excel sheet of people who have confirmed entries
				$obj2->setActiveSheetIndex(1);
				$highest_row=$obj2->getActiveSheet()->getHighestRow()+1;
				 for($i=0;$i<$count;$i++)
				 {
					$highest_row+=1; //to get vertical columns
					$A='A'.$highest_row;
					$B='B'.$highest_row;
					$C='C'.$highest_row;
					$D='D'.$highest_row;
					$E='E'.$highest_row;
					
					$obj2->getActiveSheet()->setCellValue("{$A}",$result[$i][0]);
					$obj2->getActiveSheet()->setCellValue("{$B}",$result[$i][1]);
					$obj2->getActiveSheet()->setCellValue("{$C}",$result[$i][2]);
					$obj2->getActiveSheet()->setCellValue("{$D}",$result[$i][3]);
					$obj2->getActiveSheet()->setCellValue("{$E}","CONFIRMED");
				}
				
				//for the waitlist of people towards jahangirpuri
				$data=$db->prepare("SELECT `name`,`email`,`date`,`time` FROM waitlist2;");
				$data->execute();
				$result=$data->fetchAll();
				
				$count=count($result);
				
				//enter into excel sheet of people who have waitlist entries
				
				//$highest_row=$obj2->getActiveSheet()->getHighestRow()+1;
				 for($i=0;$i<$count;$i++)
				 {
					$highest_row+=1; //to get vertical columns
					$A='A'.$highest_row;
					$B='B'.$highest_row;
					$C='C'.$highest_row;
					$D='D'.$highest_row;
					$E='E'.$highest_row;
					
					$obj2->getActiveSheet()->setCellValue("{$A}",$result[$i][0]);
					$obj2->getActiveSheet()->setCellValue("{$B}",$result[$i][1]);
					$obj2->getActiveSheet()->setCellValue("{$C}",$result[$i][2]);
					$obj2->getActiveSheet()->setCellValue("{$D}",$result[$i][3]);
					$obj2->getActiveSheet()->setCellValue("{$E}","WAITLIST");
				}
				$objectWriter=PHPExcel_IOFactory::createWriter($obj2,"Excel2007");
				$objectWriter->save($_SERVER['DOCUMENT_ROOT'].'/report/people.xlsx');
				$objectWriter->save('php://output');	
				
				$db=null;
				exit;
				//exit NECESSARY to avoid any errors after downloading
	}
	
?>
<!DOCTYPE html>
<html>
 <head>
	<title>Admin</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="AshokaFavicon.png" >
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
	overflow-x:hidden;
	}
	#logo{
	height:20%;
	float:right;
	right:1%;
	display:inline-block;
	vertical-align:middle;
	position:fixed;
	}
	table{
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
	.link{
	background-color:rgba(0,0,0,0);
	border:0px;
	cursor:pointer;
	font-size:1.2vw;
	color:rgba(0,255,0,1);
	position:fixed;
	float:right;
	margin-top:10%;
	right:0%;
	}
	.out{
	background-color:rgba(11,37,74,0);
	border:none;
	color:#ffffff;
	font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;
	font-size:1.4vw;
	text-decoration:underline;
	cursor:pointer;
	position:fixed;
	right:0%;
	top:28%;
	}
	.footer{
	position:fixed;
	width:100%;
	bottom:0%;
	background-color:rgba(0,7,15,1);
	}
	</style>
 </head>
 <body>
	<img src="logo.png" id="logo">
	<br>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="submit" name="report" value="EXPORT TO EXCEL" class="link">
	</form>
	<form method="post" action="logout.php">
	 <input type="submit" class="out" name="logout" value="Sign out!">
	</form>
	<br>
	<!--     Table for jahangirpuri->campus      -->
	
	<table id="table">
		<tr id="th">
			<th colspan="4"><img src="but3.png" height="40"></th>
		</tr>
		
		<tr id="head">
			<td style="padding-left:2%;">NAME</td>
			<td style="padding-left:2%;">EMAIL</td>
			<td style="padding-left:2%;">DATE</td>
			<td> TIME</td>
		</tr>
		
		
	</table>
	
	<table id="large">
	<?php
		$date_today=date("Y-m-d");
		$db=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
		//for confirmed entries
		$campus=$db->prepare("SELECT `serial`,`name`,`email`,`date`,`time` FROM people WHERE `date`='{$date_today}' ORDER BY `time` ASC;");
		$campus->execute();
		$print=$campus->fetchAll();
		 foreach($print as $row)
		 {
				echo "<tr>";
				echo "<td class='green'>"; 	echo $row['name']; 	echo "</td>";
				echo "<td>"; 	echo $row['email']; 	echo "</td>";
				echo "<td>"; 	echo $row['date']; 	echo "</td>";
				echo "<td>";	echo $row['time'];	 	echo "</td>";
				echo "</tr>";
		 }
		 /*
		 //for waitlist entries
		 $campus=$db->prepare("SELECT `serial`,`name`,`email`,`date`,`time` FROM waitlist WHERE `date`='{$date_today}' ORDER BY `serial` ASC;");
		 $campus->execute();
		 $print=$campus->fetchAll();
		  foreach($print as $row)
		  {
				echo "<tr>";
				echo "<td class='orange'>"; 	echo $row['name']; 	echo "</td>";
				echo "<td>"; 	echo $row['email']; 	echo "</td>";
				echo "<td>"; 	echo $row['date']; 	echo "</td>";
				echo "<td>";	echo $row['time'];	 	echo "</td>";
				echo "</tr>";
		  }
		*/
	?>
	
	</table>
	
	<br>
	<!--     Table for campus->jahangirpuri      -->
	
	<table id="table">
		<tr id="th">
			<th colspan="4"><img src="but2.png" height="40"></th>
		</tr>
		
		<tr id="head">
			<td style="padding-left:2%;">NAME</td>
			<td style="padding-left:2%;">EMAIL</td>
			<td style="padding-left:2%;">DATE</td>
			<td> TIME</td>
		</tr>
		
		
	</table>
	
	<table id="large">
	<?php
		$db=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
		//for confirmed entries
		$campus=$db->prepare("SELECT `serial`,`name`,`email`,`date`,`time` FROM people2 WHERE `date`='{$date_today}' ORDER BY `time` ASC;");
		$campus->execute();
		$print=$campus->fetchAll();
		 foreach($print as $row)
		 {
				echo "<tr>";
				echo "<td class='green'>"; 	echo $row['name']; 	echo "</td>";
				echo "<td>"; 	echo $row['email']; 	echo "</td>";
				echo "<td>"; 	echo $row['date']; 	echo "</td>";
				echo "<td>";	echo $row['time'];	 	echo "</td>";
				echo "</tr>";
		 }
		 /*
		 //for waitlist entries
		 $campus=$db->prepare("SELECT `serial`,`name`,`email`,`date`,`time` FROM waitlist2 WHERE `date`='{$date_today}' ORDER BY `serial` ASC;");
		 $campus->execute();
		 $print=$campus->fetchAll();
		  foreach($print as $row)
		  {
				echo "<tr>";
				echo "<td class='orange'>"; 	echo $row['name']; 	echo "</td>";
				echo "<td>"; 	echo $row['email']; 	echo "</td>";
				echo "<td>"; 	echo $row['date']; 	echo "</td>";
				echo "<td>";	echo $row['time'];	 	echo "</td>";
				echo "</tr>";
		  }*/
		$db=null;  
	?>
	</table>
	<br>
	
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
