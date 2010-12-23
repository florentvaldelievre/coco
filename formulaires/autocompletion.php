<?php


    $params = array_values($_POST);
    $debut = $params[0];

$MAX_RETURN = 15;
  
    include_once("../libs/CObjetBddDAO.php");
 

  
  $query = "SELECT DISTINCT(placename),postalcode,countrycode from villeinfo where placename  LIKE '".$debut."%' LIMIT $MAX_RETURN";
  $DAO = new CObjetBddDAO("villeinfo",$GLOBALS['mysql']);

  $info_tr = $DAO->getByCustomQuery($query) or $profil=array();

  
$debut = strtolower($debut);
$liste = $info_tr;

if(!empty($liste)){
	echo "<ul class=\"autocomp\">";
		$i = 0;
		foreach ($liste as $element[0]) {
			  if ($i<$MAX_RETURN && substr(strtolower($element[0]->get("placename")), 0, strlen($debut))==$debut) {
			     	echo "<li>". $element[0]->get("placename") ." - ". $element[0]->get("postalcode") ."</li>"; 
			  }
		}
	echo "</ul>";
}
		 




function generateOptions($debut,$liste,$MAX_RETURN) {

     $i = 0;
      foreach ($liste as $element[0]) {
	
    echo "<infoVille>";

		        if ($i<$MAX_RETURN && substr(strtolower($element[0]->get("placename")), 0, strlen($debut))==$debut) {
		           
		            echo(utf8_encode("<ville>".$element[0]->get("placename")."</ville>"));
		            echo(utf8_encode("<codepostal>".$element[0]->get("postalcode")."</codepostal>"));
		            echo(utf8_encode("<pays>".$element[0]->get("countrycode")."</pays>"));
		            $i++;
		        }
		    echo "</infoVille>";
		
    }

}

//generateOptions($debut,$liste,$MAX_RETURN);
;
?>
