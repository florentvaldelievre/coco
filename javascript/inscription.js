
function updateRadioCharge(elt)
{	
	if(elt.value == "francesansdpt")
	{
		document.getElementById("francesansdpt").disabled=false;
		document.getElementById("francesansdpt").className="bigmargin enabled";
		document.getElementById("francedpt").disabled=true;
		document.getElementById("francedpt").className="bigmargin disabled";
	}
	else if(elt.value == "francedpt")
	{
		document.getElementById("francedpt"). disabled =false;
		document.getElementById("francedpt").className="bigmargin enabled";
		document.getElementById("francesansdpt"). disabled =true;
		document.getElementById("francesansdpt").className="bigmargin disabled ";
	}
	else
	{
		document.getElementById("francesansdpt"). disabled =true;
		document.getElementById("francesansdpt").className="bigmargin disabled ";
		document.getElementById("francedpt"). disabled =true;
		document.getElementById("francedpt").className="bigmargin disabled ";
	}
}

function initDisableChargeText()
{
	if(document.getElementsByName("r_charge")[3].checked == true)
	{
		document.getElementById("francedpt"). disabled =false;
		document.getElementById("francedpt").className="bigmargin enabled";
		document.getElementById("francesansdpt"). disabled =true;
		document.getElementById("francesansdpt").className="bigmargin disabled ";
	}
	else if(document.getElementsByName("r_charge")[2].checked == true)
	{
		document.getElementById("francesansdpt"). disabled =false;
		document.getElementById("francesansdpt").className="bigmargin enabled";
		document.getElementById("francedpt"). disabled =true;
		document.getElementById("francedpt").className="bigmargin disabled ";
	}
	else
	{
		document.getElementById("francesansdpt"). disabled =true;
		document.getElementById("francesansdpt").className="bigmargin disabled ";
		document.getElementById("francedpt"). disabled =true;
		document.getElementById("francedpt").className="bigmargin disabled ";
	}
}

function AlphaAndVirguleAndNum(myfield, e, dec)
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
else if ((("0123456789,").indexOf(keychar) > -1))
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