

function getNumberOfBusModif() {
var tipobj=document.all? document.all["placeparbus"] : document.getElementById? document.getElementById("placeparbus") : "";
var TabBus = [" ","7", "21", "35", "40", "49", "53", "55", "57", "59", "61", "63", "73"];
var selected=document.getElementById("tableSelect").options[document.getElementById("tableSelect").selectedIndex].value;
var nbr_bus_onpage=document.getElementById("nbr_bus_onpage").value
var bus='';
     //si le nombre de bus selectionn� est inferieur a ceux deja sur la page
 if(nbr_bus_onpage=="")
 {
      for (var j=1; j<=selected; j++)
      {
        bus+='<SELECT name="NumberOfBus'+j+'" onchange="BusCount(this)" id="NumberOfBus'+j+'">';
        for(var i=0; i<TabBus.length; i++)
        {

            if(i==0)
            {
            bus+='<OPTION VALUE="0">'+TabBus[i];
            }
            else
            {
            bus+='<OPTION VALUE='+TabBus[i]+'>'+TabBus[i];
            }
        }
        bus+='</SELECT>';
    }

    tipobj.innerHTML = bus; 
 
 }
 

 else if(selected < nbr_bus_onpage)
  {
  document.getElementById("erase_bus").innerHTML = "";
   for (var j=1; j<=selected; j++)
      {
        bus+='<SELECT name="NumberOfBus'+j+'" onchange="BusCount(this)" id="NumberOfBus'+j+'">';
        for(var i=0; i<TabBus.length; i++)
        {

            if(i==0)
            {
            bus+='<OPTION VALUE="0">'+TabBus[i];
            }
            else
            {
            bus+='<OPTION VALUE='+TabBus[i]+'>'+TabBus[i];
            }
        }
        bus+='</SELECT>';
    }

    tipobj.innerHTML = bus; 
  }

 else if(selected > nbr_bus_onpage )
  {

   for (var j=1; j<=(selected-nbr_bus_onpage); j++)
    {
            nbrbus=parseInt(j) + parseInt(nbr_bus_onpage);
            bus+='<SELECT name="NumberOfBus'+nbrbus+'" onchange="BusCount(this)" id="NumberOfBus'+nbrbus+'">';
        for(var i=0; i<TabBus.length; i++)
        {
            if(i==0)
            {
            bus+='<OPTION VALUE="0">'+TabBus[i];
            }
            else
            {
            bus+='<OPTION VALUE='+TabBus[i]+'>'+TabBus[i];
            }
        }
        bus+='</SELECT>';
    }
    tipobj.innerHTML = bus;
    return selected;
  }
}

  function BusCount() {
var tipobj2=document.all? document.all["somme"] : document.getElementById? document.getElementById("somme") : "";
var selected=document.getElementById("tableSelect").options[document.getElementById("tableSelect").selectedIndex].value;
    var somme=0;
    for( var k=1; k<=selected; k++)
    {
    somme = parseInt(somme) + parseInt(document.getElementById("NumberOfBus"+k).options[document.getElementById("NumberOfBus"+k).selectedIndex].value);
    }
 tipobj2.innerHTML = "&nbsp;Total = <b>"+somme+"</b>";
 return somme; 
}

function PlaceParBusDisabled() {
 var tipobj=document.all? document.all["placeparbus"] : document.getElementById? document.getElementById("placeparbus") : "";       
 var selected=document.getElementById("tableSelect").options[document.getElementById("tableSelect").selectedIndex].value;
 var bus='';    
 
 
 bus+='<br/><label for="placeparbus">Places par bus :</label>&nbsp;<SELECT name="NumberOfBus" id="NumberOfBus" disabled="disabled">';
 bus+='<OPTION VALUE="0" >'+'A spécifier';
 bus+='</SELECT>';  
 tipobj.innerHTML = bus; 
return selected;
}



function disablefieldsmodif() {


   var tableSelect =  document.getElementById("tableSelect");
   var NumberOfBus =  document.getElementById("NumberOfBus");

     
     if(document.getElementById("typebusoui").checked)
    {
       var selected=document.getElementById("tableSelect").options[document.getElementById("tableSelect").selectedIndex].value  
       tableSelect.disabled=false;       
       for(var i=1;i<=selected;i++)
       {
       
         var NumberOfBus =  document.getElementById("NumberOfBus"+i);
         NumberOfBus.disabled=false;
       }

    }
    else if(document.getElementById("typebusnon").checked) 
    {
       var selected=document.getElementById("tableSelect").options[document.getElementById("tableSelect").selectedIndex].value  
       tableSelect.disabled=true;
       for(var i=1;i<=selected;i++)
       {
       
         var NumberOfBus =  document.getElementById("NumberOfBus"+i);
         NumberOfBus.disabled=true;
       }

    }
    else
    {
    
      tableSelect.disabled=true;
      
    }
    
}

