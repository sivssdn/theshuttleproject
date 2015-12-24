function cam() {
    document.getElementById("nav").style.WebkitAnimation="go_l 1s linear";
	document.getElementById("nav").style.MozAnimation="go_l 1.1s linear";
   
   setTimeout(function() {
   document.getElementById("nav").style.display="none";
   document.getElementById("div_cj").style.WebkitAnimation="come_r .6s linear";
   document.getElementById("div_cj").style.MozAnimation="come_r .6s linear";
   document.getElementById("div_cj").style.display="inline-block";
   
   },900);
   //changed from 1000 in all places
   }
   //function to control slide right
function jan() {
   document.getElementById("nav").style.WebkitAnimation="go_r 1s linear";
   document.getElementById("nav").style.MozAnimation="go_r 1.1s linear";
   
   setTimeout(function() {
   document.getElementById("nav").style.display="none";
   document.getElementById("div_jc").style.WebkitAnimation="come_l .6s linear";
   document.getElementById("div_jc").style.MozAnimation="come_l .6s linear";
   document.getElementById("div_jc").style.display="inline-block";
   
   },900);
   
   }
   
   //function controlling slide of page jahangir->campus
function jconfirm() {
   document.getElementById('spin').style.display="none";
   
   document.getElementById("div_jc").style.WebkitAnimation="go_r 1s linear";
   document.getElementById("div_jc").style.MozAnimation="go_r 1s linear";
   
   setTimeout(function() {
   document.getElementById("div_jc").style.display="none";
   document.getElementById("confirm").style.WebkitAnimation="come_l .6s linear";
   document.getElementById("confirm").style.MozAnimation="come_l .6s linear";
   document.getElementById("confirm").style.display="inline-block";
   
   },900);
   

   }
   
   //function controlling slide of page campus->jahangir
function cconfirm() {
   document.getElementById('spin').style.display="none";
   
   document.getElementById("div_cj").style.WebkitAnimation="go_l 1s linear";
   document.getElementById("div_cj").style.MozAnimation="go_l 1s linear";
   
   setTimeout(function() {
   document.getElementById("div_cj").style.display="none";
   document.getElementById("confirm").style.WebkitAnimation="come_r .6s linear";
   document.getElementById("confirm").style.MozAnimation="come_r .6s linear";
   document.getElementById("confirm").style.display="inline-block";
   
   },900);
   

   }
   
   //spinner
function spinner() {
   document.getElementById('spin').style.display="inline-block";
   
   }
function spinner2() {
   document.getElementById('spin2').style.display="inline-block";
   }
   
   //to add hover function to book now button
   var id;
function button(id) {
   document.getElementById(id).src="but5o.png";
   }
function buttonr(id) {
   document.getElementById(id).src="but5.png";
   }