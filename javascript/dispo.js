

function type_trajet()
{

var typetrajetaller = document.getElementById("typetrajetaller");
var typetrajetAR = document.getElementById("typetrajetAR");
var kilometragealler = document.getElementById("kilometragealler");
var kilometrageretour = document.getElementById("kilometragealler");
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
var cpbox='';


    for (var j=1; j<=selected; j++)
      {
        textbox+= '<tr>Ville '+j+' :<input type="text" name="via_'+j+'" id="via_'+j+'">' +
        		       'cp '+j+' :<input type="text" name="cp_'+j+'" id="cp_'+j+'"></tr><br/>';

      }

  
 var_divtextbox.innerHTML = textbox; 

}


/*
 * Fonction � mettre dans voyage.js 
 * @return un objet date avec la date et l'heure de d�part
 */

 function getDateEtHeureDepart() {
 	var datedepart = document.getElementById("datedepart").value;
 	var date = new Date();
 	
 	date.setFullYear(datedepart.split('/')[2]); //ann�e
 	date.setMonth(datedepart.split('/')[1]-1); //mois
  	date.setDate(datedepart.split('/')[0]);	// jour
  	date.setHours(document.getElementById("heuredepart").options[document.getElementById("heuredepart").selectedIndex].value);
  	date.setMinutes(document.getElementById("minutesdepart").options[document.getElementById("minutesdepart").selectedIndex].value);

	return date;

 }
 
/*
 * Fonction � mettre dans voyage.js 
 * @return : set les parametres avec les nouvelles valeurs dans les inputs box
 * @arg : temps calcul� par google en secondes
  */
 function setDateEtHeureArrivee(temps_calcule) {
 	
    var datearrive;
    var date_string;
    
	datearrive = new Date(getDateEtHeureDepart().getTime()+temps_calcule*1000);
	
	if(datearrive.getDate() < 10) {
		date_string = "0"+datearrive.getDate()+'/';
	}
	else
	{
		date_string = datearrive.getDate()+'/';	
	}
	
	
	if((datearrive.getMonth()+1) < 10 ) {
		date_string = date_string+"0"+(datearrive.getMonth()+1); //on rajoute le chiffre 0 si le mois est <10 pour eviter les formats 12/2/2007 au lieu de 12/02/2007	
	}
	else
	{
	    date_string = date_string+(datearrive.getMonth()+1);	
	}
	
	date_string = date_string+'/'+datearrive.getFullYear();
	document.getElementById("datearrive").value = date_string;
	document.getElementById("minutesarrive").value = Math.round((datearrive.getMinutes())/5)*5;
	
	if(datearrive.getHours() < 10 ) {
		document.getElementById("heurearrive").value = "0"+datearrive.getHours();
 	}
 	else {	
 		document.getElementById("heurearrive").value = datearrive.getHours();
 	}
 
 }