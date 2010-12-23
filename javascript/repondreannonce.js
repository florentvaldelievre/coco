

function PlaceParBusDisabled() {
 var tipobj=document.all? document.all["placeparbus"] : document.getElementById? document.getElementById("placeparbus") : "";       
 var selected=document.getElementById("tableSelect").options[document.getElementById("tableSelect").selectedIndex].value;
 var bus='';    
 
 
 bus+='<SELECT name="NumberOfBus" id="NumberOfBus" disabled="disabled">';
 bus+='<OPTION VALUE="0" >'+'A spécifier';
 bus+='</SELECT>';  
 tipobj.innerHTML = bus; 
return selected;
}