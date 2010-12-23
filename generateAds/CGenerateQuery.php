<?php
 
 class CGenerateQuery {
 	
 	
 	var $arrayCityPostalCodeAndCountryForEtapes;
 	
 	var $arrayCityAndPostalCodeAndCountryForDepartAndArrivee;
 	
 	
 	public function getCityAndPostalCodeAndCountryForEtapes($limit) {
 		
 		
 		//Too long with DISTINCT(placename) -> dropped
 		$query = "SELECT placename,postalcode,countrycode from villeinfo ORDER BY RAND() LIMIT $limit";
  		$DAO = new CObjetBddDAO("villeinfo",$GLOBALS['mysql']);
  		$this->arrayCityPostalCodeAndCountryForEtapes =  $DAO->getByCustomQuery($query);
  
  
 	}

 	public function getCityAndPostalCodeAndCountryForDepartAndArrivee($limit=2) {
 		
 		
 		
 		$query = "SELECT placename,postalcode,countrycode from villeinfo ORDER BY RAND() LIMIT $limit";
  		$DAO = new CObjetBddDAO("villeinfo",$GLOBALS['mysql']);
  		$this->arrayCityAndPostalCodeAndCountryForDepartAndArrivee =  $DAO->getByCustomQuery($query);
  
  
 	}
 	 	
 }
 
 
 
 

  
?>
