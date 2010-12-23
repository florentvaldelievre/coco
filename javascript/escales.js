var currentEscale;
var initOk = 0;

function initEscale(nbEscaleArg)
{
	initOk = 1
	currentEscale = nbEscaleArg;
}
function ajouteEscale(idobj)
{
	if(initOk != 1){
		currentEscale = 1;
	}
	else{
		currentEscale++;
	}
	
	document.getElementById('etapeHeader').innerHTML = "<div class=\"subGroupFormHeader\">escales: </div>";
	
				//enhance inputbox

	var nbEscale = currentEscale;

			
	alterEtape(nbEscale,currentEscale+1);
	
	var countriesCodes = Array("","AL","DE","AD","AM","AT","BE","BY","BA","BG","CY","HR","DK","ES","EE","FO","FR","GE","GI","GB","GR","HU","IE","IT","LT","LU","LE","MT","MA","MD","MC","NO","NL","PL","PT","RO","RU","CZ","SK","CH","SE","UA","YU");	
	var countriesNames = Array("Votre choix","Albanie","Allemagne","Andore","Arménie","Autriche","Belgique","Biélorussie","Bosnie et Hér.","Bulgarie","Chypre","Croatie","Dannemark","Espagne","Estonie","Féroé","France","Géorgie","Gibraltar","Gr. Bretagne","Gréce","Hongrie","Irlande","Italie","Lituanie","Luxembourg","Létonie","Malte","Maroc","Moldavie","Monaco","Norvége","Pays Bas","Pologne","Portugal","Roumanie","Russie","Rép. Tchéque","Slovaquie","Suisse","Suéde","Ukraine","Yougoslavie");

    var defaultCountryCode = "FR";
	
	var strEtape = 	"";
	 
		strEtape +=	"<div class=\"locationEntry\"><div class=\"locationEntry-header\">";
	    strEtape +=	"<div class=\"locationEntry-villeLabel\">Ville</div >";
	    strEtape +=	"<div  class=\"locationEntry-zoneLabel\">Code Postal</div >";
	    strEtape +=	"<div  class=\"locationEntry-paysLabel\">Pays</div >";
	    strEtape +=	"</div>";
	    strEtape +=	"<div class=\"locationEntry-Input\">";
	    strEtape +=	"<input type=\"text\" name=\"ville_" + nbEscale + "\" id=\"ville_" + nbEscale + "\" value=\"\" title=\"Ville escale " + nbEscale + "\"  class=\"locationEntry-villeInput\" /> ";
	    strEtape +=	"<input type=\"text\" name=\"cp_" + nbEscale + "\"  id=\"cp_" + nbEscale + "\" value=\"\" title=\"Code postal escale " + nbEscale + "\" class=\"locationEntry-zoneInput\" /> ";
		strEtape +=	"<select name=\"pays_" + nbEscale + "\" id=\"pays_" + nbEscale + "\" class=\"locationEntry-paysInput\" >";
		

		for(var i = 0; i<countriesCodes.length ; i++)
		{
			if(countriesCodes[i] == defaultCountryCode )
			{
				strEtape += "<option value=\"" + countriesCodes[16] + "\" selected=\"selected\" >" + countriesNames[16] + "</option>";
			}
			else
			{
				strEtape += "<option value=\"" + countriesCodes[i] + ">" + countriesNames[i] + "</option>";
			}
			
		} 

		strEtape += "</select>";
        strEtape += "<div style=\"z-index: 100000;\" id=\"hintville_" + nbEscale + "\"></div>";
		strEtape += "</div>";               
		strEtape += "<script type=\"text/javascript\">";
	
		strEtape += "new Ajax.IOAutocompleter(\"ville_" + nbEscale + "\",\"cp_" + nbEscale + "\",\"hintville_" + nbEscale + "\",\"./formulaires/autocompletion.php\");";
	
		strEtape += "</script>";
		strEtape += "</div> ";
		
		var cible=document.createElement("div");
		document.getElementById(idobj).appendChild(cible);
		document.getElementById(idobj).lastChild.innerHTML = strEtape;

		//bug obscure insolvable
		//alert(currentEscale);
		//new dijit.form.TextBox({id: "ville_"+(nbEscale ) , name: "ville_"+(nbEscale ) , widgetid:"ville_"+(nbEscale )  }, dojo.byId("ville_"+(currentEscale)  ));


		//alert(document.getElementById("ville_"+currentEscale).value );
		document.getElementById("nbEscales").value++;
		document.getElementById("nbEtapes").value++;

		new Ajax.IOAutocompleter("ville_" + nbEscale + "","cp_" + nbEscale + "","hintville_" + nbEscale + "","./formulaires/autocompletion.php");
			

	   
}

function supprEscale(idobj)
{

		
	var nodeToRemove=document.getElementById(idobj).lastChild
	document.getElementById(idobj).removeChild(nodeToRemove);
	currentEscale--;
	document.getElementById("nbEscales").value--;
	document.getElementById("nbEtapes").value--;
	alterEtape(document.getElementById("nbEtapes").value,document.getElementById("nbEtapes").value - 1);
	
	if(currentEscale<=0){
		document.getElementById('etapeHeader').innerHTML = "";
		return;
	}

	
}

function alterEtape(num_before,num_after)
{
	document.getElementById("ville_"+num_before).name = "ville_"+(num_after);
	document.getElementById("ville_"+num_before).id = "ville_"+(num_after);
	document.getElementById("cp_"+num_before).name = "cp_"+(num_after);
	document.getElementById("cp_"+num_before).id = "cp_"+(num_after);
	document.getElementById("pays_"+num_before).name = "pays_"+(num_after);
	document.getElementById("pays_"+num_before).id = "pays_"+(num_after);
	document.getElementById("hintville_"+num_before).id = "hintville_"+(num_after);
}
