


function type_trajet()
{

var typetrajetaller = document.getElementById("typetrajetaller");
var typetrajetAR = document.getElementById("typetrajetAR");
var kilometragealler = document.getElementById("kilometragealler");
var doublageretouroui =  document.getElementById("doublageretouroui");
var doublageretournon =  document.getElementById("doublageretournon");
}






 var MaxBus=10;  
 function buildBus(MaxBus)
 { 
    var str; 
	for (var i=0; i<=MaxBus; i++)
     {
         if(i==0) {
         str+='<OPTION VALUE=" ">';
         }
         else
         {   
         str+='<OPTION VALUE='+i+'>'+i;
         }    
     }
     str+='</SELECT>'; 
     document.writeln(str);
 }





function PlaceParBusDisabled() {
 var tipobj=document.all? document.all["placeparbus"] : document.getElementById? document.getElementById("placeparbus") : "";       
 var selected=document.getElementById("tableSelect").options[document.getElementById("tableSelect").selectedIndex].value;   
 var bus='';    
 bus+='<br/><label for="placeparbus">Places par bus :</label><SELECT name="NumberOfBus" id="NumberOfBus" disabled="disabled">';
 bus+='<OPTION VALUE="0" >'+'A spécifier';
 bus+='</SELECT>';  
 tipobj.innerHTML = bus; 
return selected;   
}







function add_text_textbox()
{
var var_divtextbox=document.all? document.all["divtextbox"] : document.getElementById? document.getElementById("divtextbox") : "";
var var_divviapoint=document.all? document.all["divviapoint"] : document.getElementById? document.getElementById("divviapoint") : "";
var selected=document.getElementById("nbr_etape").options[document.getElementById("nbr_etape").selectedIndex].value;    
var viapoint='';
var textbox='';


    for (var j=1; j<=selected; j++)
      {
        textbox+= '<tr>Ville '+j+' :<input type="text" name="via_'+j+'" id="via_'+j+'"></tr><br/>';
 
      }

 viapoint += '<a href=javascript:startRouting(document.getElementById("villedepart").value,document.getElementById("via_'+selected+'").value,'+selected+')><img src="http://img.map24.com/map24/portal/fr-fr/dyna/btn_next0.png" border=0></a>';
   
  
 var_divtextbox.innerHTML = textbox; 
 var_divviapoint.innerHTML = viapoint; 
}



