<?php

if(defined("__CGisGestion"))
    return;

define("__CGisGestion","");


include_once("CGisDAO.php");


class CGisGestion {
	

	
	var $radius = 1; //100km
	
	var $lat;
	
	var $lon;
   
    var $gisDAO;

    var $mysql_res="";	
	
	
	
	
	public function __construct($mysql_res ) {

	    $this->mysql_res = $mysql_res;
		$this->gisDAO = new CgisDAO($mysql_res);	
}	
		
			
		//TO FIX , je ne comprends pas pkoi AND d.datedepart > ".formatDateFrToUS($current_datedepart) ne fonctionne pas...
	public function getNearestCitiesFromVilleArrive($iddemandetr, $current_datedepart) {	
		
		self::setLatAndLongFromIddemandetr($iddemandetr);
		
		$center = "GeomFromText('POINT(".$this->lat."	".$this->lon.")')";
		$bbox = "CONCAT('POLYGON((',
		X($center) - ".$this->radius.", ' ', Y($center) - ".$this->radius.", ',',
		X($center) + ".$this->radius.", ' ', Y($center) - ".$this->radius.", ',',
		X($center) + ".$this->radius.", ' ', Y($center) + ".$this->radius.", ',',
		X($center) - ".$this->radius.", ' ', Y($center) + ".$this->radius.", ',',
		X($center) - ".$this->radius.", ' ', Y($center) - ".$this->radius.", '))'
		)";
		
		//rajouter datedepart > datedepart de lannoncerepondu
		$query = "SELECT d.*, placename, postalcode, AsText(location) , 
				  SQRT(POW( ABS( X(location) - X($center)), 2) + POW( ABS(Y(location) - Y($center)), 2 )) AS distance 
				  FROM villeinfo v 
				  INNER JOIN etape et ON ( et.numetape = 0 AND et.ville = v.placename )
				  INNER JOIN demandetr d ON ( d.iddemandetr = et.iddemandetr AND d.dtag = \"newdemande\" AND d.iddemandetr <> $iddemandetr AND d.datedepart > ".formatDateFrToUS($current_datedepart)." ) 
				  WHERE Intersects( location, GeomFromText($bbox) )
				  AND  SQRT(POW( ABS( X(location) - X($center)), 2) + POW( ABS(Y(location) - Y($center)), 2 )) < ".$this->radius." ORDER BY distance;";
	
	   $res = $this->gisDAO->getByCustomQuery($query); 

		return $res;   			
	}
	
	
	public function getMaxEtapeNumber($iddemandetr) {
		
		$query = "	SELECT MAX(et.numetape) as villearrive_etape_number FROM etape et
					WHERE ( et.iddemandetr = $iddemandetr )";
		
		$res = $this->gisDAO->getByCustomQuery($query); 
		return $res[0]->get("villearrive_etape_number"); 				
	}

	
	
	
	public function setLatAndLongFromIddemandetr($iddemandetr) {
		
		$villearrive_etape_number = self::getMaxEtapeNumber($iddemandetr);
		
		$query = "SELECT lat, lon from etape et
			      INNER JOIN villeinfo v ON ( et.ville = v.placename )
				  WHERE et.iddemandetr = $iddemandetr AND et.numetape = $villearrive_etape_number";	
		
		$res = $this->gisDAO->getByCustomQuery($query); 
		$this->lat = $res[0]->get("lat");
		$this->lon = $res[0]->get("lon");	

	
	}

}
?>
