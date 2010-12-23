<?php
function checkuser($userid1, $userid2)
{
	if($userid1 == $userid2)
	{
		return true;
	}
	else 
	{
		return false; 	
	}
	
}

function isTransporteur($typeUser)
{
	if($typeUser == "transporteur")
		return true;
	else
		return false;
}


function isUtilisateur($typeUser)
{
	if($typeUser == "client")
		return true;
	else
		return false;
}

function formatdate($date,$delimiter)
{
	$dateArr = explode($delimiter, $date);
	$dateStr = $dateArr[0] ."h". $dateArr[1];
	return $dateStr;
}

/*
 * @param : date 25/10/2007
 * @return : date 2007-10-25
 */
function formatDateFrToUS($datefr) {
	 return implode('-',array_reverse  (explode('/',$datefr))); 
}

function formatDateUsToFR($dateus) {
  return implode('/',array_reverse(explode('-',$dateus))); 
}
function getMarqueurPage($pageArr)
{
	$pageStr = "";
	$first = true;
	foreach($pageArr as $key => $value)
	{
		if($first)
		{
			$first = false;
		}
		else
		{
			$pageStr .= '_amp_';
		}
		$pageStr .= $key ."_eq_". $value;
	}
	
	return $pageStr;
}

function reconstruireUrl($strUrl)
{
	$resUrl = str_replace('_amp_','&',$strUrl);
	$resUrl = str_replace('_eq_','=',$resUrl);
	return $resUrl;
}

function viewFormError($strError)
{
	if(isset($strError))
     {
        return "<img src=\"images/icon_err.gif\">$strError</img>";
     }
}

function getCoutriesNames()
{
	$coutriesNames = Array("Votre choix","Albanie","Allemagne","Andore","Arménie","Autriche","Belgique","Biélorussie","Bosnie et Hér.","Bulgarie","Chypre","Croatie","Dannemark","Espagne","Estonie","Féroé","France","Géorgie","Gibraltar","Gr. Bretagne","Gréce","Hongrie","Irlande","Italie","Lituanie","Luxembourg","Létonie","Malte","Maroc","Moldavie","Monaco","Norvége","Pays Bas","Pologne","Portugal","Roumanie","Russie","Rép. Tchéque","Slovaquie","Suisse","Suéde","Ukraine","Yougoslavie");
    return $coutriesNames;                                  
}

function getCoutriesCodes()
{
	$coutriesCodes = Array("","AL","DE","AD","AM","AT","BE","BY","BA","BG","CY","HR","DK","ES","EE","FO","FR","GE","GI","GB","GR","HU","IE","IT","LT","LU","LE","MT","MA","MD","MC","NO","NL","PL","PT","RO","RU","CZ","SK","CH","SE","UA","YU");
    return $coutriesCodes;
}

function getTypeBusName()
{
	$typebus = array('Scolaire' => 'Scolaire', 'Excursion' => 'Excursion', 'GT' => 'Grand Tourisme');
	return $typebus;
}
	

function getIndiceOfdCountryName($countryName)
{
	$out = array_search($countryName,getCoutriesNames());
	if($out === false) {
		return null;
	}
	else {
		return $out;
	}

}

function getIndiceOfdCountryCode($countryCode)
{
	$out = array_search($countryCode,getCoutriesCodes());
	if($out === false) {
		return null;
	}
	else {
		return $out;
	}

}

function dbug($v, $k=""){
	echo "<span>dbug </span>";
	echo "<br /><em> $k : $v </em><br />";
}


function getListOfDptsWithCommaSeparated($dpts) {
	
	$i=1;
	foreach($dpts as $key => $value)
	{
		
		if(count($dpts) == $i)
			$res .= $value->get("iddepartement");
		else
			$res .= $value->get("iddepartement").",";
		$i++;
	}
	
	return $res;
}


function checkEmail($email) {
        if(eregi("^[_A-Za-z0-9.-]+[^.]@[^.][A-Za-z0-9.-]{2,}[.][a-z]{2,4}$",$email))
        {
           return false;
        }
    return true;
}

function wrapWord($chaine, $taille) {
	
	return wordwrap($chaine, $taille, "\n", 1);

}

function isExpired($reponsetr) {
	if(strtotime(getExpirationDateInGnuFormat($reponsetr)) < strtotime(date("Y/m/d H:i:s")))
		return true;
	else
		return false;
}

function getExpirationDate($reponsetr) {
	return date("d/m/Y H:i:s",strtotime("+".EXPIRATION_DATE." day",strtotime($reponsetr->get("datereponse"))));
}

function getExpirationDateInGnuFormat($reponsetr) {
	
	return date("Y/m/d H:i:s",strtotime("+".EXPIRATION_DATE." day",strtotime($reponsetr->get("datereponse"))));
}

function createBus() {
	
		echo "<label id=\"nbrbus\">Nombre de bus</label>";
		echo "<select name=\"bus\" onchange=\"createSeatPerBusSelectBox()\" id=\"tableSelect\">";
				 for($i=0; $i<count(getNbrBusArray()); $i++)
			        echo "<option value=".getNbrBusArray($i).">".getNbrBusArray($i)."</option>"; 
		echo "</select>";	
		echo "<div/>";
		echo "<label name=\"placesparbus\" id=\"placesparbus\">Place par bus</label>";
		
		echo "<span name=\"overwrite_bus\" id=\"overwrite_bus\">
			 <select id=\"blankSelect\"  name=\"blankSelect\"></select>
			 </span>";
		echo "<span id=\"somme\"></span>";
}



function createPreference() {


          foreach(getPreferenceArray() as $key => $value) {
           
	            if($key==$_POST['preference'])
	             	echo "<input type=\"radio\" name=\"preference\"  checked=\"checked\" id=\"pref$key\" onClick=\"disablefields()\"  value=".$key.">$value";
	            else
	                echo "<input type=\"radio\" name=\"preference\" onClick=\"disablefields()\"  id=\"pref$key\" value=".$key.">$value";
	      }  
}





function getPreference($demandetr) {
	
	          foreach(getPreferenceArray() as $key => $value) {
           
	            if($key==$demandetr->get("preferencebus"))
	             	echo "<input type=\"radio\" name=\"preference\"  checked=\"checked\" id=\"pref$key\" onClick=\"disablefields()\"  value=".$key.">$value";
	            else
	                echo "<input type=\"radio\" name=\"preference\" onClick=\"disablefields()\"  id=\"pref$key\" value=".$key.">$value";
	      }  
	
}


function getNbrBusArray($index=null) {

	$nbrBus = array("Spécifier","1", "2", "3", "4", "5", "6", "7", "8" ,"9", "10");
	
	if(isset($index))
		return $nbrBus[$index];
	else
		return $nbrBus;

}	


function getSeatPerBusArray($index=null) {

	$seatPerBus  = array(" ","7", "21", "35", "40", "49", "53", "55", "57", "59", "61", "63", "73");
    
	if(isset($index))
		return $seatPerBus[$index];
	else
		return $seatPerBus;

}	


function getPreferenceArray($index=null) {
	
$pref = array("0" => "Non","1" => "Oui");
	
	if(isset($index))
		return $pref[$index];
	else
		return $pref;	
	
}

function getTypeCarArray($index=null) {
	
	   $typecar = array("Scolaire","Excursion","GT" );

	 	if(isset($index))
		return $typecar[$index];
	else
		return $typecar;	  
}


function getAmplitude($heuredepart,$heurearrivee) {
		
	return  date("G",strtotime($heurearrivee)-strtotime($heuredepart));
	
}


?>