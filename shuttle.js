function setTime(){
	var append=[];
	//appending the results generated dynamically
	var option,i;
	var date_length=date.length;
	for(i=0;i<date_length;i++)
	{
		var time=document.getElementById('time');
		if(date[i]==document.getElementById('date').value)
		{
			if(day[i]=='Mon' || day[i]=='Tue' || day[i]=='Wed' || day[i]=='Thu')
			{
			  var start=0;
			  if(day[i]==day[0]){
				var time_comp=[0,0800,0820,0840,0900,0920,0940,1000,1030,1100,1200,1300,1400,1500,1600,1700,1800,1830,1900,2000,2030,2100,2130,2200,2300,2301];
				start=list(time_comp);
			  }
			  
			  
			  //generate timings for mon to thursday for towards campus
			  append=[];
			  append.push('08:00','08:20','08:40','09:00','09:20','09:40','10:00','10:30','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','18:30','19:00','20:00','21:00','21:30','22:00','23:00','23:01');
		
				//to remove the previous list appended in time element
			  while(time.firstChild){
			    time.removeChild(time.firstChild);
			  }
				var len=append.length;
			  
				
				
			  for(i=start;i<len;i++)
			  {
			   option=document.createElement('option');
			   option.text=append[i];
			   option.value=append[i];
			   time.appendChild(option);
			  }
			}
			else if(day[i]=='Fri'){
				
				//to check current time and mark the start of list
			  var start=0;
			  if(day[i]==day[0]){
				var time_comp=[0,0800,0820,0840,0900,0920,0940,1000,1030,1100,1200,1300,1400,1500,1600,1700,1745,1800,1830,1900,2000,2030,2100,2130,2200,2300,2301];
				start=list(time_comp);
			  }
			  
				
				
				append=[];
				//generate timings for friday for towards campus
				append.push('08:00','08:20','08:40','09:00','09:20','09:40','10:00','10:30','11:00','12:00','13:00','14:00','15:00','16:00','17:00','17:45','18:00','18:30','19:00','20:00','20:30','21:00','21:30','22:00','23:00','23:01');
			
			  while(time.firstChild){
			    time.removeChild(time.firstChild);
			  }
			  var len=append.length;
			  
				
				
			  for(i=start;i<len;i++)
			  {
			   option=document.createElement('option');
			   option.text=append[i];
			   option.value=append[i];
			   time.appendChild(option);
			  }
			}
			else if(day[i]=='Sat'){
				
				//to check current time and produce list accordingly
			  var start=0;
			  if(day[i]==day[0]){
				var time_comp=[0,0800,0830,0900,0930,1000,1030,1100,1200,1300,1400,1500,1600,1700,1730,1800,1830,1900,1930,2000,2030,2100,2130,2200,2230,2300];
				start=list(time_comp);
			  }
			  
				
				//generate timings for saturday for towards campus
				append=[];
				append.push('08:00','08:30','09:00','09:30','10:00','10:30','11:00','12:00','13:00','14:00','15:00','16:00','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00');
				
				//to remove previous list
				while(time.firstChild){
				 time.removeChild(time.firstChild);
				}
				
				
				
				//to make new list 
				var len=append.length;
				
				for(i=start;i<len;i++)
				{
				 option=document.createElement('option');
				 option.text=append[i];
				 option.value=append[i];
				 time.appendChild(option);
				}
			}
			else if(day[i]=='Sun'){
				
				
				//to check current time and produce list accordingly
			  var start=0;
			  if(day[i]==day[0]){
				var time_comp=[0,0800,0830,0900,0930,1000,1030,1100,1200,1300,1400,1500,1600,1700,1730,1800,1830,1900,1930,2000,2030,2100,2130,2200,2230,2300];
				start=list(time_comp);
			  }
				
				
				
				//generate timings for sunday for towards campus
				append=[];
				append.push('08:00','08:30','09:00','09:30','10:00','10:30','11:00','12:00','13:00','14:00','15:00','16:00','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00');
				//to remove previous elements
				while(time.firstChild){
				 time.removeChild(time.firstChild);
				}
				
				
				
				//to append new list
				var len=append.length;
				for(i=start;i<len;i++)
				{
				 option=document.createElement('option');
				 option.text=append[i];
				 option.value=append[i];
				 time.appendChild(option);
				}
			}
		}	
		else
		continue;
	}
	
	
	//get the stats of seats with ajax request
	convert_time("no",1);
  }
  setTime();
  
  
  //towards jahangirpuri time controller
  function setTime2()
  {
	var append=[];
	var i;
	
	for(i=0;i<date.length;i++)
	{
		var option;
		var time=document.getElementById('time2');
		if(date[i]==document.getElementById('date2').value)
		{
			if(day[i]=='Mon' || day[i]=='Tue' || day[i]=='Wed' || day[i]=='Thu')
			{
				
			  var start=0;
			  if(day[i]==day[0]){
				var time_comp=[0,0700,0720,0740,0800,0820,0845,0900,0930,1000,1100,1200,1300,1400,1500,1610,1700,1720,1740,1800,1830,1900,1930,2000,2100,2200];
					start=list(time_comp);
			  }
				
				//towards jahangirpuri
				append=[];
				append.push('07:00','07:20','07:40','08:00','08:20','08:45','09:00','09:30','10:00','11:00','12:00','13:00','14:00','15:00','16:10','17:00','17:20','17:40','18:00','18:30','19:00','19:30','20:00','21:00','22:00');
				//to remove previous list
				while(time.firstChild){
				 time.removeChild(time.firstChild);
				}
				
				
				
				var len=append.length;
				//to append new list
				for(i=start;i<len;i++)
				{
					option=document.createElement('option');
					option.text=append[i];
					option.value=append[i];
					time.appendChild(option);
				}
				
			}
			else if(day[i]=='Fri'){
			
				
			  var start=0;
			  if(day[i]==day[0]){
				var time_comp=[0,0700,0720,0740,0800,0820,0845,0900,0930,1000,1100,1200,1300,1400,1500,1610,1700,1720,1740,1800,1820,1840,1900,1930,2000,2100,2200];
					start=list(time_comp);
			  }
			
			
			append=[];
			append.push('07:00','07:20','07:40','08:00','08:20','08:45','09:00','09:30','10:00','11:00','12:00','13:00','14:00','15:00','16:10','17:00','17:20','17:40','18:00','18:20','18:40','19:00','19:30','20:00','21:00','22:00');
			
			//to clear prev list
			while(time.firstChild){
			time.removeChild(time.firstChild);
			}
			//to append new list	
			var len=append.length;
			for(i=start;i<len;i++){
				option=document.createElement('option');
				option.text=append[i];
				option.value=append[i];
				time.appendChild(option);
			}
			
		    }
			else if(day[i]=='Sat'){
			
			 var start=0;
			  if(day[i]==day[0]){
				var time_comp=[0,0700,0730,0800,0830,0900,0930,1000,1030,1100,1130,1200,1230,1300,1400,1500,1600,1700,1800,1830,1900,1930,2000,2030,2100,2200];
					start=list(time_comp);
			  }
			
			
			append=[];
			append.push('07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','14:00','15:00','16:00','17:00','18:00','18:30','19:00','19:30','20:00','20:30','21:00','22:00');
			while(time.firstChild){
			time.removeChild(time.firstChild);
			}
				
			//to append new list
			var len=append.length;
			for(i=start;i<len;i++){
				option=document.createElement('option');
				option.text=append[i];
				option.value=append[i];
				time.appendChild(option);
			}
			
			}
			else if(day[i]=='Sun'){
				
				
			 var start=0;
			  if(day[i]==day[0]){
				var time_comp=[0,0700,0730,0800,0830,0900,0930,1000,1030,1100,1130,1200,1230,1300,1400,1500,1600,1700,1800,1830,1900,1930,2000,2030,2100,2200];
					start=list(time_comp);
			  }
			
				
				append=[];
				append.push('07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','14:00','15:00','16:00','17:00','18:00','18:30','19:00','19:30','20:00','20:30','21:00','22:00');
				
				while(time.firstChild){
				time.removeChild(time.firstChild);
				}
				
				//to append new list
			var len=append.length;
			for(i=start;i<len;i++){
				option=document.createElement('option');
				option.text=append[i];
				option.value=append[i];
				time.appendChild(option);
			}
			}
		}
		else
		continue;
	}
	
	//get the stats of seats with ajax request
	convert_time("no",2);
  }
  setTime2();
  
  
  var lis=[];
  //function to make list short based on server time
  function list(lis){
		var tlen=lis.length;
				var y;
				for(y=0;y<tlen-1;y++)
				{
					if(current_time>lis[y] && current_time<lis[y+1] && !(current_time>2301))
					return y;
					else if(current_time==lis[y] && current_time!=00)
						 return y-1;
			//no error handling as on error the list is empty by default			 
				}
  
  }
  var choose,book_arg,book="no";
  function convert_time(book_arg,choose){
  //:::::::::::::::::::::::::::::::::::::::::::::::::::
  document.getElementById('available').innerHTML=" ";
  document.getElementById('available2').innerHTML=" ";
  document.getElementById('waitlist').innerHTML=" ";
  document.getElementById('waitlist2').innerHTML=" ";
  
  
  var f,flen;
  flen=date.length;
  
  //assign on bases of choose 1 or 2 "date" so choose between forms
  var form_date,form_day;
  if(choose==1){
  form_date="date";
  form_day="day";
  var time=document.getElementById("time");
  document.getElementById("compare_t").value=time.value[0]+time.value[1]+time.value[3]+time.value[4];
  }
  else if(choose==2){
			form_date="date2";
			form_day="day2";
			var time2=document.getElementById("time2");
			document.getElementById("compare_t2").value=time2.value[0]+time2.value[1]+time2.value[3]+time2.value[4];
		}
  
  for(f=0;f<flen;f++){
	if(document.getElementById(form_date).value==date[f])
	{
		if(day[f]=='Mon' || day[f]=='Tue' || day[f]=='Wed' || day[f]=='Thu')
		document.getElementById(form_day).value='mon';
		else if(day[f]=='Fri')
				document.getElementById(form_day).value='fri';
			else if(day[f]=='Sat')	
					document.getElementById(form_day).value='sat';
				else if(day[f]=='Sun')
						document.getElementById(form_day).value='sun';
	}
	
  }
  
  //determining whether to book or to just check stats
  if(book_arg=="yes")
  book=book_arg;
  else
  book="no";
  if(choose==1)
  campus_send();
  else
  jahangir_send();
	
  
 }
 
 
 var xhr=null,xhr2=null;
 
 //AJAX form dynamics ::[towards jahangirpuri]::
 function campus_send(){
	//::manipulate book::
	
	 try{
		xhr=new XMLHttpRequest();
	}catch(e){
		//for i.e.
		xhr=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//for form 1, towards campus
	var t=document.getElementById('time').value;
	var d=document.getElementById('date').value;
	var dy=document.getElementById('day').value;
	var ct=document.getElementById('compare_t').value;
	
	
	var url="register.php?campus="+t+"&date="+d+"&day="+dy+"&compare_t="+ct+"&do="+book;
	
	xhr.onreadystatechange=handler;
	xhr.open("GET",url,true);
	xhr.send(null);
	
	
 }
 function handler()
 {
	if(xhr.readyState==4){
		if(xhr.status==200)
		{
			var response=eval("("+ xhr.responseText +")");//converting to an object ::JSON 
			document.getElementById('booking').innerHTML=response.booking;//hidden
			document.getElementById('book_status').innerHTML=response.booking;
			document.getElementById('available').innerHTML=response.available;
			document.getElementById('waitlist').innerHTML=response.waitlist;
			
			
			if(response.waitlist!=0)
			{
			 document.getElementById('book_status').style.color="red";
			 //document.getElementById('book_status').innerHTML="Waitlist number "+response.waitlist;
			 document.getElementById('book_status').innerHTML="Waitlist";
			}
			if(response.booking=='exists')
			{
				document.getElementById('book_status').style.color="red";
				document.getElementById('book_status').innerHTML="Multiple entries not allowed";
			}
			if(book=="yes")
			jconfirm();
		}
		else
		console.log('Problem in connecting, please check your network statos not 200 handler 1 to campus');
	}
 }convert_time("no",1);
 //url :: register.php?campus=16%3A00&date=14-07-2015&day=mon&compare_t=1600
 
 
 //AJAX form dynamics ::[towards campus]::
 function jahangir_send(){
	//::manipulate book::
	
	 try{
		xhr2=new XMLHttpRequest();
	}catch(e){
		//for i.e.
		xhr2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//for form 1, towards campus
	var t=document.getElementById('time2').value;
	var d=document.getElementById('date2').value;
	var dy=document.getElementById('day2').value;
	var ct=document.getElementById('compare_t2').value;
	
	
	var parker="no";
	//for parker people
	if(document.getElementById("parker").checked)
	parker="yes";
	var url="register2.php?jahangirpuri="+t+"&date2="+d+"&day2="+dy+"&compare_t2="+ct+"&do="+book+"&parker="+parker;
	
	xhr2.onreadystatechange=handler2;
	xhr2.open("GET",url,true);
	xhr2.send(null);
	
	
 }
 function handler2()
 {
	if(xhr2.readyState==4){
		if(xhr2.status==200)
		{
			var response=eval("("+ xhr2.responseText +")");//converting to an object ::JSON 
			document.getElementById('booking2').innerHTML=response.booking;//hidden
			document.getElementById('book_status').innerHTML=response.booking;
			document.getElementById('available2').innerHTML=response.available;
			document.getElementById('waitlist2').innerHTML=response.waitlist;
			
			
			document.getElementById('spin2').style.display="none";
			
			//for content(div) confirm page
			if(response.waitlist!=0)
			{
			 document.getElementById('book_status').style.color="red";
			 //document.getElementById('book_status').innerHTML="Waitlist number "+response.waitlist;
			 document.getElementById('book_status').innerHTML="Waitlist";
			} 
			
			if(response.booking=='exists')
			{
				document.getElementById('book_status').style.color="red";
				document.getElementById('book_status').innerHTML="Multiple entries not allowed";
			}
			//for going to confirm page after content has loaded
			if(book=="yes")
			cconfirm();
		}
		else
		console.log('Problem in connecting, please check your network::handler 2 status not 200 to jahan');
	}
 }convert_time("no",2);
 
 
 //next shuttle time
 //document.getElementById("next_val").innerHTML=document.getElementById("time").value;
 //document.getElementById("next_val2").innerHTML=document.getElementById("time2").value;