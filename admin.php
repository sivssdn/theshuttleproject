<?php
	session_start();
	if($_SESSION['id']!='ashoka')
	header('Location:login.php');
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
	}
	#logo{
	height:20%;
	margin-left:1%;
	display:inline-block;
	vertical-align:middle;
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
	.head,.content{
	height:10%;
	width:40%;
	display:inline-block;
	background-color:#0B254a;
	font-size:2vw;
	line-height:240%;
	text-align:center;
	box-shadow:0px 0px 5px 1px rgba(0,191,243,1);
	margin-top:1%;
	margin-left:1%;
	}
	.link{
	font-size:1.2vw;
	color:rgba(0,255,0,1);
	text-decoration:underline;
	}
	#rep_i{
	height:10%;
	display:none;
	position:absolue;
	margin:auto;
	margin-top:2%;
	}
	.down{
	background-color:rgba(11,37,74,1);
	border:none;
	font-size:1vw;
	color:rgba(0,255,0,1);
	text-decoration:underline;
	cursor:pointer;
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
	input[type='number']{
	width:4vw;
	height:2vw;
	font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
	font-size:1.5vw;
	text-align:center;
	}
	</style>
 </head>
 <body>
	<img src="logo.png" id="logo">
	
	
	<form method="post" action="logout.php">
	 <input type="submit" class="out" name="logout" value="Sign out!">
	</form>
	<br><br><br><br>
	<!--Adding users-->
	<div class="head">
	 ADD USERS
	</div>
	<div class="content">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="900000">
			<input type="file" name="user_add" >
			<input type="submit" name="add" value="UPLOAD" onclick="show()"> 
			<a href="./add_user/shuttle.xlsx" class="link">Download</a>
		</form>
	
	
	</div>
	
	
	<!--DELETE USERS-->
	<div class="head">
	 DELETE USERS
	</div>
	<div class="content">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="900000">
			<input type="file" name="user_del" >
			<input type="submit" name="del" value="UPLOAD" onclick="show()">
			<a href="./del_user/shuttle.xlsx" class="link">Download</a>
		</form>
	</div>
	
	<div class="head">
	 GET REPORT
	</div>
	<div class="content">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="900000">
			<input type="file" name="user_rep" >
			
			<input type="submit" name="rep" value="UPLOAD">
			 
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="submit" onclick="show()" class="down" name='rep_link' value='MAKE'>	
				<a href='./report/report.xlsx' class="link">GET</a>
			</form>
			
		</form>
	</div>
	
	<div class="head">
	 PEOPLE 
	</div>
	<div class="content">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="900000">
			<input type="file" name="user_pep" >
			<input type="submit" name="pep" value="UPLOAD" onclick="show()">
			<a href="list.php" class="link">VIEW</a>
		</form>
	</div>
	<!--to add shuttles-->
	
	<div class="head">
	 ADD SHUTTLE
	</div>
	<div class="content">
		
		<a href="addjahangir.php" target="_blank" class="link">Towards jahangirpuri</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="addcampus.php" target="_blank" class="link">Towards Campus</a>	
	</div>
	
	
	
	
	
	<?php
	   //function redundant only for tutorial purposes
		
		//to extend execution time
		ini_set('max_execution_time',300);
			
		if(isset($_POST['add']))
		{
			//to extend execution time
			ini_set('max_execution_time',300);
			
			if(move_uploaded_file($_FILES['user_add']['tmp_name'],"./add_user/{$_FILES['user_add']['name']}"))
			{
				//echo "FILE UPLOAD SUCCESSFUL";
				//read excel file and add its contents to database
				require_once('.\PHPExcel-1.8\Classes\PHPExcel\IOFactory.php');
				$objPhpExcel=PHPExcel_IOFactory::load('.\add_user\shuttle.xlsx');
				foreach($objPhpExcel->getWorkSheetIterator() as $worksheet)
				{
					$highestrow=$worksheet->getHighestRow();
					$highestcol=$worksheet->getHighestColumn();
					$highestcolindex=PHPExcel_Cell::columnIndexFromString($highestcol);
					$db=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
					for($row=1;$row<=$highestrow;$row++)
					{
						echo "<br>";
						$data=array();
						for($col=0;$col<$highestcolindex;$col++)
						{
							$cell=$worksheet->getCellByColumnAndRow($col,$row);
							$val=$cell->getValue();
							$data[$col]=$val;
							
						}
						
						//enter data into db users
						if($row>1)
						{
							$hashed=hash('sha512',$data[2]);
							$db->exec("INSERT INTO `shuttle`.`users` (`serial`, `name`, `id`, `pass`) VALUES (NULL, '{$data[0]}', '{$data[1]}', '{$hashed}');");					
							echo $data[0]."  ".$data[1]." entered successfully";
						}	
							
					}
				}			$db=null;
				echo "<img src='ok.png' style='display:block;' id='rep_i'>";
			}
			else
			{
				error($_FILES['user_add']['error']);
			}
		}
		else if(isset($_POST['del']))
			{ //to perform deletion
			
				if(move_uploaded_file($_FILES['user_del']['tmp_name'],"./del_user/{$_FILES['user_del']['name']}"))
				
				{
					require_once('.\PHPExcel-1.8\Classes\PHPExcel\IOFactory.php');
					$objPhpExcel=PHPExcel_IOFactory::load(".\del_user\shuttle.xlsx");
					foreach($objPhpExcel->getWorkSheetIterator() as $worksheet)
					{
						$highestrow=$worksheet->getHighestRow();
						$highestcol=$worksheet->getHighestColumn();
						$highestcolindex=PHPExcel_Cell::columnIndexFromString($highestcol);
						for($row=1;$row<=$highestrow;$row++)
					 {
						echo "<br>";
						$data=array();
						for($col=0;$col<$highestcolindex;$col++)
						{
							$cell=$worksheet->getCellByColumnAndRow($col,$row);
							$val=$cell->getValue();
							$data[$col]=$val;
							
						}
						
						//enter data into db users
						if($row>1)
						{
							$db=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
							$db->exec("DELETE FROM `users` WHERE `id` LIKE '{$data[1]}' LIMIT 1;");
							$db=null;
							//echo $data[0]."  ".$data[1]." deleted successfully";
						}	
					 }
					 
					}
				echo "<img src='ok.png' style='display:block;' id='rep_i'>";	
				}
				else
				{ 
					error($_FILES['user_del']['error']);
				}
			}
		else if(isset($_POST['rep']))
			{ 
				//to handle report generation
	
				if(move_uploaded_file($_FILES['user_rep']['tmp_name'],"./report/{$_FILES['user_rep']['name']}"))
				{
				//UPLOADED
					echo "<img src='ok.png' style='display:block;' id='rep_i'>";
				}
				else
				error($_FILES['user_rep']['error']);
			}
		else if(isset($_POST['rep_link']))
			{
			
			
			 //to prepare excel data
			 $db=new PDO("mysql:host=localhost;dbname=shuttle;","root","server");
			 //for towards campus data
			 $mondtable=$db->prepare("describe montocampus;");
			 $fridtable=$db->prepare("describe fritocampus;");
			 $satdtable=$db->prepare("describe sattocampus;");
			 $sundtable=$db->prepare("describe suntocampus;");
		
			 //for excel sheet
			 require_once '.\PHPExcel-1.8\Classes\PHPExcel\IOFactory.php';
			 $obj=PHPExcel_IOFactory::load("./report/report.xlsx");
		
		
		for($i=1;$i<26;$i++)
		{
			
			$table=strtolower(date("D",strtotime("-{$i} day"))); //result::mon if today is tue
			$row=date("d",strtotime("-{$i} day"));   //result:1 if today is 19
			if($table=="mon" || $table=="tue" || $table=="wed" || $table=="thu")
			$table="mon";
			$table=$table."tocampus";
			
			//get the timings from table 
			if($table=="sattocampus")
			{
			$satdtable->execute();
			$timings=$satdtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table=="montocampus")
			{
				$mondtable->execute();
				$timings=$mondtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table=="fritocampus")
			{
				$fridtable->execute();
				$timings=$fridtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table="suntocampus")
			{
				$sundtable->execute();
				$timings=$sundtable->fetchAll(PDO::FETCH_COLUMN);
			}
			
			
			//get the data 
			
			$dataa=$db->prepare("SELECT * FROM {$table} WHERE `serial`={$row} LIMIT 1;");			 
			$dataa->execute();
			$result=$dataa->fetch();
			
			if($result[1]!='0000-00-00')
			{
			
				$loop=count($result)/2; //for the data
				$A='A';
		
				//if record exists
				
				
				$obj->setActiveSheetIndex(0); //set first sheet as active
				$highrow=$obj->getActiveSheet()->getHighestRow()+1;
			
				//loop through the cells in excel
				for($x=0;$x<$loop;$x++)
				{
					$time_cell=$A.$highrow;
					$cell=$A.($highrow+1);
					$obj->getActiveSheet()->setCellValue("{$time_cell}",$timings[$x]);
					$obj->getActiveSheet()->setCellValue("{$cell}",$result[$x]);
					$A++;
				}
			
				//$objectWriter=PHPExcel_IOFactory::createWriter($obj,"Excel2007");
				//$objectWriter->save('./report/report.xlsx');
				
				
			}
			else
			break;
		
			
			//echo $table;
		
		}
		$objectWriter=PHPExcel_IOFactory::createWriter($obj,"Excel2007");
		$objectWriter->save('./report/report.xlsx');
		//::::for data towards jahangirpuri::::
	
		$monjtable=$db->prepare("describe montojahangir;");
		$frijtable=$db->prepare("describe fritojahangir;");
		$satjtable=$db->prepare("describe sattojahangir;");
		$sunjtable=$db->prepare("describe suntojahangir;");
		
		//for excel sheet
		
		$obj2=PHPExcel_IOFactory::load("./report/report.xlsx");
		
		
		for($i=1;$i<26;$i++)
		{
			
			$table=strtolower(date("D",strtotime("-{$i} day"))); //result::mon if today is tue
			$row=date("d",strtotime("-{$i} day"));   //result:1 if today is 19
			if($table=="mon" || $table=="tue" || $table=="wed" || $table=="thu")
			$table="mon";
			$table=$table."tocampus";
			
			//get the timings from table 
			if($table=="sattojahangir")
			{
			$satjtable->execute();
			$timings=$satjtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table=="montojahangir")
			{
				$monjtable->execute();
				$timings=$monjtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table=="fritojahangir")
			{
				$frijtable->execute();
				$timings=$frijtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table="suntojahangir")
			{
				$sunjtable->execute();
				$timings=$sunjtable->fetchAll(PDO::FETCH_COLUMN);
			}
			
			
			//get the data 
			
			$dataa=$db->prepare("SELECT * FROM {$table} WHERE `serial`={$row} LIMIT 1;");
			 
			$dataa->execute();
			$result=$dataa->fetch();
			
			if($result[1]!='0000-00-00')
			{
			
				$loop=count($result)/2; //for the data
				$A='A';
		
				//if record exists
				
				
				$obj->setActiveSheetIndex(1); //set first sheet as active
				$highrow=$obj->getActiveSheet()->getHighestRow()+1;
			
				//loop through the cells in excel
				for($x=0;$x<$loop;$x++)
				{
					$time_cell=$A.$highrow;
					$cell=$A.($highrow+1);
					$obj->getActiveSheet()->setCellValue("{$time_cell}",$timings[$x]);
					$obj->getActiveSheet()->setCellValue("{$cell}",$result[$x]);
					$A++;
				}
			
				//$objectWriter=PHPExcel_IOFactory::createWriter($obj,"Excel2007");
				//$objectWriter->save('./report/report.xlsx');
				//echo "done";
				
			}
			else
			break;
		
			//echo $table;
			
		}	
		$objectWriter=PHPExcel_IOFactory::createWriter($obj,"Excel2007");
		$objectWriter->save('./report/report.xlsx');
		
		
		
		
		
		//::::::::clear data from table:::::::::
		for($i=1;$i<10;$i++)
		{
			
			$table=strtolower(date("D",strtotime("-{$i} day"))); //result::mon if today is tue
			$row=date("d",strtotime("-{$i} day"));   //result:1 if today is 19
			if($table=="mon" || $table=="tue" || $table=="wed" || $table=="thu")
			$table="mon";
			$table1=$table."tocampus";
			$table2=$table."tojahangir";	
			
			//get the timings from table  for towards campus
			if($table1=="sattocampus")
			{
			$satdtable->execute();
			$timings=$satdtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table1=="montocampus")
			{
				$mondtable->execute();
				$timings=$mondtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table1=="fritocampus")
			{
				$fridtable->execute();
				$timings=$fridtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table1="suntocampus")
			{
				$sundtable->execute();
				$timings=$sundtable->fetchAll(PDO::FETCH_COLUMN);
			}
			
			//get the data for towards campus
			$dataa=$db->prepare("SELECT * FROM {$table} WHERE `serial`={$row} LIMIT 1;");			 
			$dataa->execute();
			$result=$dataa->fetch();
			foreach($timings as $update)
			{
				if(!($update=='serial' || $update=='date'))
				$db->exec("UPDATE `shuttle`.`{$table1}` SET `{$update}` = '0' WHERE `{$table1}`.`serial` ={$row};");
			}
			//echo $update;
			$db->exec("UPDATE `shuttle`.`{$table1}` SET `date` = '0000-00-00' WHERE `{$table1}`.`serial` ={$row};");
		}
		
		//:::::::::::::
		//get the timings from table  for towards jahangirpuri
			if($table2=="sattojahangir")
			{
			$satdtable->execute();
			$timings=$satdtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table2=="montojahangir")
			{
				$mondtable->execute();
				$timings=$mondtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table2=="fritojahangir")
			{
				$fridtable->execute();
				$timings=$fridtable->fetchAll(PDO::FETCH_COLUMN);
			}
			else if($table1="suntojahangir")
			{
				$sundtable->execute();
				$timings=$sundtable->fetchAll(PDO::FETCH_COLUMN);
			}
			
			//get the data for towards campus
			$dataa=$db->prepare("SELECT * FROM {$table} WHERE `serial`={$row} LIMIT 1;");			 
			$dataa->execute();
			$result=$dataa->fetch();
			foreach($timings as $update)
			{
				if(!($update=='serial' || $update=='date'))
				$db->exec("UPDATE `shuttle`.`{$table1}` SET `{$update}` = '0' WHERE `{$table1}`.`serial` ={$row};");
			}
			//echo $update;
			$db->exec("UPDATE `shuttle`.`{$table1}` SET `date` = '0000-00-00' WHERE `{$table1}`.`serial` ={$row};");
		
		
		
		
		
		
		$db=null;
				echo "<img src='ok.png' style='display:block;' id='rep_i'>";
		}
		
		
		function error($code)
		{
					switch($code)
					{
					case 1: echo "<br><br>File size greater than PHP installation allows";break;
					case 2: echo "<br><br>File size greater than this form allows";break;
					case 3: echo "<br><br>Incomplete file upload, only part of the file was uploaded";break;
					case 4: echo "<br><br>No file chosen to upload";break;
					}
		}
	?>
	
	
	<img src='infinity.gif' style='display:none;' id='rep_i'>
	
	
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
 function show(){
	document.getElementById('rep_i').style.display="block";
 }
 </script>
</html>