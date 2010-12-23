function disablefields() {


   var tableSelect =  document.getElementById("tableSelect");
   var NumberOfBus =  document.getElementById("NumberOfBus");
   var blankSelect = document.getElementById("blankSelect");


	  var selected=document.getElementById("tableSelect").options[document.getElementById("tableSelect").selectedIndex].value  
   
     if(document.getElementById("pref1").checked)
    {
        if(document.getElementById("diviserAnnonces") != null)
	  		 document.getElementById("diviserAnnonces").disabled=false;

	  	if(blankSelect != null)
	  		 blankSelect.disabled=false;     
			 
		 tableSelect.disabled=false;  
		 
       for(var i=1;i<=selected;i++)
       {
         var NumberOfBus =  document.getElementById("NumberOfBus"+i);
         NumberOfBus.disabled=false;
       }

    }
    else if(document.getElementById("pref0").checked)
    {
       if(document.getElementById("diviserAnnonces") != null)
	  		 document.getElementById("diviserAnnonces").disabled=true;
	     tableSelect.disabled=true;
	     blankSelect.disabled=true; 
       for(var i=1;i<=selected;i++)
       {
         var NumberOfBus =  document.getElementById("NumberOfBus"+i);
         NumberOfBus.disabled=true;
       }
     

    }

	else
	{
		tableSelect.disabled=true; 
	    blankSelect.disabled=true;  
	}
       
}





function getCheckedRadioValue(radio)
{    
	var res="no radio button checked";

	var i=-1;
	do  
	{
		i++;
	}
	while(i<radio.length && !(radio[i].checked))
	
	if(i!=radio.length)
	{
		res=radio[i].value;
	}
	
	return res;
}

function numbersonly(myfield, e, dec)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);

// control keys
if ((key==null) || (key==0) || (key==8) ||
    (key==9) || (key==13) || (key==27) )
   return true;

// numbers
else if ((("0123456789").indexOf(keychar) > -1))
   return true;

// decimal point jump
else if (dec && (keychar == "."))
   {
   myfield.form.elements[dec].focus();
   return false;
   }
else
   return false;
}


function AlphaAndVirgule(myfield, e, dec)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);

// control keys
if ((key==null) || (key==0) || (key==8) ||
    (key==9) || (key==13) || (key==27) )
   return true;

// numbers
else if ((("abcdefghijklmnopqrstuvwxyz,").indexOf(keychar) > -1))
   return true;

// decimal point jump
else if (dec && (keychar == "."))
   {
   myfield.form.elements[dec].focus();
   return false;
   }
else
   return false;
}

function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}


function insertJavascriptIntoHeader(script_filename) {

	
	var html_doc = document.getElementsByTagName('head').item(0);
    var js = document.createElement('script');
    js.setAttribute('language', 'javascript');
    js.setAttribute('type', 'text/javascript');
    js.setAttribute('src', script_filename);
    html_doc.appendChild(js);
    return false;
}



function innerHTMLDiviserAnnonces()
{
var tipobj=document.all? document.all["budgetFacultatif"] : document.getElementById? document.getElementById("budgetFacultatif") : "";
	 
if(document.getElementById("diviserAnnonces").checked)
	tipobj.innerHTML = '<strong>Obligatoire</strong>';
else
 	tipobj.innerHTML = 'Facultatif';	

}





//ça bug : impossible de cliquer sur une date dans le mois en cours , je lai disable ...
function dateStatus(date) {

// var today = new Date();


 //if (date.getTime() < today.getTime()) {
 //return true; // true says "disable"
 //} else {
 //return false; // leave other dates enabled
//} 

}


//  
//		var tempstotal_div = document.getElementById("tempstotal_div").innerHTML = ;
//		var totalkm_div = document.getElementById("kilometragealler").innerHTML = ;
//        tempstotal_div.innerHTML = 'Duree totale du voyage = '+tempstotal;
//        document.getElementById("kilometragealler").value = totalkm;
//
//
// 
//
