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



function type_trajet()
{

var typetrajetaller = document.getElementById("typetrajetaller");
var typetrajetAR = document.getElementById("typetrajetAR");
var kilometragealler = document.getElementById("kilometragealler");
var datedepartR =  document.getElementById("datedepartR");
var heuredepartR =  document.getElementById("heuredepartR");
var minutesdepartR =  document.getElementById("minutesdepartR");
var heurearriveR =  document.getElementById("heurearriveR");
var minutesarriveR =  document.getElementById("minutesarriveR");
var datearriveR =  document.getElementById("datearriveR");
var doublageretouroui =  document.getElementById("doublageretouroui");
var doublageretournon =  document.getElementById("doublageretournon");
var BusSurPlaceoui = document.getElementById("BusSurPlaceoui");
var BusSurPlacenon = document.getElementById("BusSurPlacenon");

    if (typetrajetaller.checked==true) {

        datedepartR.disabled=true;
        heuredepartR.disabled=true;
        minutesdepartR.disabled=true;
        datearriveR.disabled=true;
        heurearriveR.disabled=true;
        minutesarriveR.disabled=true;
        kilometrageretour.disabled=true;
        doublageretouroui.disabled=true;
        doublageretournon.disabled=true;
        BusSurPlaceoui.disabled=true;
        BusSurPlacenon.disabled=true;

        }
        else if(typetrajetAR.checked==true)
        {
        datedepartR.disabled=false;
        heuredepartR.disabled=false;
        minutesdepartR.disabled=false;
        datearriveR.disabled=false;
        heurearriveR.disabled=false;
        minutesarriveR.disabled=false;
        kilometrageretour.disabled=false;
        doublageretouroui.disabled=false;
        doublageretournon.disabled=false;
        BusSurPlaceoui.disabled=false;
        BusSurPlacenon.disabled=false;
        }

}

