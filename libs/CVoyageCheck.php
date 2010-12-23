<?php
if(defined("__CVoyageCheck"))
    return;

define("__CVoyageCheck","");



class CVoyageCheck
{
    static $nbEscalesMax = 20;

	var $voyage;
	var $arg;
	var $erreurs = array();
	
	function __construct($voyage, $arg=null){
		
		$voyageClass  = get_class($voyage);
		$this->voyage = $voyage;
		$this->arg = $arg;
		$this->$voyageClass();
	}
	
	//global check methods
	
	function CVoyage()
	{
		switch($this->arg)
    	{
    		case 1:
    			
		    	$this->checkEscales();
		    	$this->checkEtapes();
		    	$this->checkTypeTransfert();
		    	$this->checkVoyageAller();
		    	$this->checkVoyageRetour();
		        break;
			
			case 2:
				$this->checkCapacite();
				$this->checkNbrBus();
				$this->checkPlacesParBus();
				$this->checkTypeTransfert();
				$this->checkCommentaires();
				$this->checkDiviserAnnonces();
		    	$this->checkBudget();
				break;
				
			case 3: break;
		
		
    	}
	}
	
	function CVoyageReponse()
	{
		$this->checkNbrBusStrict();
		$this->checkPlacesParBus();
		$this->checkTarifttc();
		
	}
	 
	 
	//unit check methods
	 
	function checkEscales()
	{
    	if($this->voyage->nbEscales > self::$nbEscalesMax) {
    		$this->erreurs['nbEscales'] = "Dépassement du nombre d'escales autorisé";
    	}
	}
	
	function checkEtapes()
	{
        for($i = 0; $i< $this->voyage->nbEtapes; $i++)
        {
        	if($this->voyage->villes[$i] == ""){
        		$this->erreurs["villes_$i"] = "Ville n°$i non renseignée";
        	} 
        	if($this->voyage->cps[$i] == ""){
        	 $this->erreurs["cps_$i"] = "Code Postal n°$i non renseignée";
        	}
        	if($this->voyage->pays[$i] == ""){
        		$this->erreurs["pays_$i"] = "Pays n°$i non renseignée" ;
        	}
        }
	}
	
	function checkTypeTransfert()
	{
		if(!isset($this->voyage->typeTransfert) || empty($this->voyage->typeTransfert)){
			$this->erreurs['typeTransfert'] = "Pas de type de transfert selectionné";
		}
	}
	
	function checkVoyageAller()
	{
        //dates
        if(!CheckDateFormation($this->voyage->dateDepart)){
        	$this->erreurs['dateDepart'] = "date de départ incorrecte";
        }
        if(!CheckDateFormation($this->voyage->dateArrivee)){
        	$this->erreurs['dateArrivee'] = "date d'arrivee incorrecte";
        }

        //heures
        if(!CheckHeure($this->voyage->heureDepart)){
        	$this->erreurs['heureDepart'] = "heure de départ incorrecte";
        }
        if(!CheckHeure($this->voyage->heureArrivee)){
        	$this->erreurs['heureArrivee'] = "heure d'arrivee incorrecte";
        }
        
        //Minutes
        if(!Checkminutes($this->voyage->minutesDepart)){
        	$this->erreurs['minutesDepart'] = "minutes de départ incorrecte ". Checkminutes($this->voyage->minutesDepart);
        }
        if(!Checkminutes($this->voyage->minutesArrivee)){
        	$this->erreurs['minutesArrivee'] = "minutes d'arrivee incorrecte";
        } 
	}
		 
		 
 	function checkVoyageRetour()
 	{
	    if($this->voyage->typeTransfert == 'ar')
	    {  
	        if(!CheckDateFormation($this->voyage->dateDepartR)){
	        	$this->erreurs['dateDepartR'] = "date de départ du retour incorrecte";;
	        }
	        if(!CheckDateFormation($this->voyage->dateArriveeR)){
	        	$this->erreurs['dateArriveeR'] = "date d'arrivee du retour incorrecte" ;
	        }
	                
	        if(!CheckHeure($this->voyage->heureDepartR)){
	        	$this->erreurs['heureDepartR'] = "heure de départ du retour incorrecte";;
	        }
	        if(!CheckHeure($this->voyage->heureArriveeR)){
	        	$this->erreurs['heureArriveeR'] = "heure d'arrivee du retour incorrecte" ;
	        }
	               
	        if(!Checkminutes($this->voyage->minutesDepartR)){
	        	$this->erreurs['minutesDepartR'] = "minutes de départ du retour incorrecte";;
	        }
	        if(!Checkminutes($this->voyage->minutesArriveeR)){
	        	$this->erreurs['minutesArriveeR'] = "minutes d'arrivee du retour incorrecte" ;
	        }
	    }		
	}
    		
    function checkCapacite()
    {
    	if(!isset($this->voyage->capacite) || empty($this->voyage->capacite) || !is_numeric($this->voyage->capacite))
    	{
    		$this->erreurs['capacité'] = "nombre de voyageurs incorrect";
    	}
    	else if($this->voyage->nbrBus!='noBus' && $this->voyage->nbrSiegesTotal < $this->voyage->capacite)
    	{
    		$this->erreurs['capacité'] = "Le nombre nombre total de sièges est inférieur au nombre de voyageurs";
    	}
    }
        
    function checkNbrBus()
    {
    	if(!isset($this->voyage->nbrBus) || empty($this->voyage->nbrBus) || !is_numeric($this->voyage->nbrBus))
    	{
    		if($this->voyage->nbrBus != 'noBus')
    			$this->erreurs['nbrBus'] = "nombre de cars incorrect";
    	}	
    }
    
        
    function checkNbrBusStrict()
    {
    	if(!isset($this->voyage->nbrBus) || empty($this->voyage->nbrBus) || !is_numeric($this->voyage->nbrBus))
    	{
    			$this->erreurs['nbrBus'] = "nombre de cars incorrect";
    	}	
    }
    
    function checkPlacesParBus()
    {
    	for($i = 0; $i<count($this->voyage->placesParBus); $i++){
	    	if(!isset($this->voyage->placesParBus[$i]) || empty($this->voyage->placesParBus[$i]) || !is_numeric($this->voyage->placesParBus[$i]))
	    	{
	    		$numCar = $i + 1;
	    		$this->erreurs["placesParBus_$i"] = "nombre de sièges incorrect pour le car $numCar";
	    	}
    	}
    }
    
    function checkBudget()
    {
    	if(isset($this->voyage->budget) && !empty($this->voyage->budget) && !is_numeric($this->voyage->budget))
    	{
    		$this->erreurs['budget'] = "budget incorrect";
    	}
    }
    
    function checkCommentaires()
    {
  
    }
    
    function checkDiviserAnnonces()
    {

    	if($this->voyage->diviserAnnonces)
    	{
    		if(empty($this->voyage->budget))
    			$this->erreurs['diviserAnnonces1'] = "Vous devez spécifier un budget si vous diviser les annonces";
    			
    		 if($this->voyage->nbrBus == 'noBus')
    			$this->erreurs['diviserAnnonces2'] = "Vous devez spécifier un nombre de bus si vous diviser les annonces";
    			
    		if($this->voyage->nbrBus <= 1)
    			$this->erreurs['diviserAnnonces3'] = "Vous devez avoir au moins 2 bus pour diviser une annonce";
    	}
    	
    }
    
 
 	function checkSieges()
 	{
 		
 	}
 	
 	function checkTarifttc()
    {
    	if(!isset($this->voyage->tarifttc) || empty($this->voyage->tarifttc) || !is_numeric($this->voyage->tarifttc))
    	{
    			$this->erreurs['tarifttc'] = "tarif incorrect";
    	}	
    }
	
	
	
	
}
?>
