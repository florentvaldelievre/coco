function gmap_init() {
    	
	      if (GBrowserIsCompatible()) { 

	      	var selected=document.getElementById("nbEtapes").value;  	
		    var map;
		    var gdir;
		    var geocoder = null;
		    var addressMarker;
		    var waypoints;     
	       
	        waypoints = new Array();
	        
			var k=0;
			
			//alert(selected);
			
	        for( k; k<selected; k++) 
			{  	
				//alert(k);
				//alert(document.getElementById("ville_"+k).value+" "+document.getElementById("cp_"+k).value);
				waypoints.push(document.getElementById("ville_"+k).value+" "+document.getElementById("cp_"+k).value);
			}
	      
	
	       
		   document.getElementById("mapPanel").innerHTML = "<div id=\"maparea\" style=\"width:auto; height:200px;\"></div>";
	   	
			map = new GMap2(document.getElementById("maparea"));
	      	map.addControl(new GSmallMapControl());

			//map.addControl(new GMapTypeControl()); to add hybrid & co
	        gdir = new GDirections(map);

	        gdir.loadFromWaypoints(waypoints,  "fr");					
	        GEvent.addListener(gdir,"load", function() {
				

					
					var distance = gdir.getDistance().meters; 
	                var duree = gdir.getDuration().html; 
					document.getElementById("distance").value = Math.round(distance/1000);				
					document.getElementById("tempsTrajetValue").innerHTML = "environ " + duree;
					//setDateEtHeureArrivee(gdir.getDuration().seconds);	
					});
	
	
	    }
	    else
	    {
	    	alert("your browser isn't compatible with Google Maps")
	    }
   }
   
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

