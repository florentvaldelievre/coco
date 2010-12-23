
 
 
function createSeatPerBusSelectBox() {
	var tipobj=document.all? document.all["overwrite_bus"] : document.getElementById? document.getElementById("overwrite_bus") : "";
	var TabBus = [" ","7", "21", "35", "40", "49", "53", "55", "57", "59", "61", "63", "73"];
	var selected=document.getElementById("tableSelect").options[document.getElementById("tableSelect").selectedIndex].value;
	if(document.getElementById("nbr_bus_onpage")!= null)
		var nbr_bus_onpage=document.getElementById("nbr_bus_onpage").value;
	
	var bus='';

	for (var j=1; j<=selected; j++)
  
  	{
    	var numSelect=j-1;
		bus+='<SELECT name="nbrPlaceBus_'+numSelect+'" onchange="BusCount(this)" id="NumberOfBus'+numSelect+'">';
	    for(var i=0; i<TabBus.length; i++)
	    {
	        if(i==0)
	       	 	bus+='<OPTION VALUE="0">'+TabBus[i];
	        else
	       	    bus+='<OPTION VALUE='+TabBus[i]+'>'+TabBus[i];
	    }
	    bus+='</SELECT>';
	}

    tipobj.innerHTML = bus; 
	BusCount();
}

function BusCount() {
	var tipobj2=document.all? document.all["somme"] : document.getElementById? document.getElementById("somme") : "";
	var selected=document.getElementById("tableSelect").options[document.getElementById("tableSelect").selectedIndex].value;
	
    if(selected == 'noBus')
	{
		tipobj2.innerHTML="";
		return 0;	
	}
		   
	var somme=0;

    for( var k=0; k<selected; k++)
    {
		var v = parseInt(document.getElementById("NumberOfBus"+k).options[document.getElementById("NumberOfBus"+k).selectedIndex].value);
		if(!isNaN(v))
			somme = parseInt(somme) + v;
    }	
	tipobj2.innerHTML = "&nbsp;Total = <b>"+somme+"</b>";

	return somme; 
}

 


function init_googlemap() {

	Event.observe('CalculateRouting', 'click', function(e){ 
	 
		 gmap_init(); 		//init google maps
		 return false;
		 });		 		  
 }
      


function itemsAllerRetour() {
	
	return new Array("dateDepartR","dateArriveeR","heureDepartR","minutesDepartR","heureArriveeR","minutesArriveeR");
}

function itemsAllerOnly() {
	
	return new Array("dateDepart","dateArrivee","heureDepart","minutesDepart","heureArrivee","minutesArrivee");
}

function enableAndDisableFields()

{
	if(document.reservation.typeTransfertA.checked) {
		dojo.forEach(itemsAllerRetour(),function(item) {	
		
			disableAndGreyOut(item);
			
		});
	}
	else
	{
		
		dojo.forEach(itemsAllerRetour(),function(item) {
		//	alert(item);
			//alert(dijit.byId(item));	
			//enable(item);
			
		});
	}
}

function disableAndGreyOut(id)
{

	//dijit.byId(id).removeAttribute('enabled');
	dijit.byId(id).setAttribute('disabled', true);

}

function enable(id)
{

	//dijit.byId(id).removeAttribute('disabled');
	dijit.byId(id).setAttribute('disabled', false);

}