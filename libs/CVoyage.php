<?php

if(defined("__CVoyage"))
    return;

define("__CVoyage","");

include_once("libs/CalculDate.php");
include_once("libs/CItineraireGestion.php");
include_once("libs/CTransactionManager.php");
include_once("libs/CMessageBoxVue.php");
include_once("libs/CVoyageCheck.php");


class CVoyage
{
    
	var $erreurs;
	var $iddemandetr;
	var $idutilisateur;
	var $idcontact;

	var $typeVoyage;
    
	var $nbEscales = 0; 	
	var $nbEtapes = 2;
	var $villes = array();
	var $cps = array();
	var $pays = array();
	var $typeTransfert = 'a';
	var $distance;	
	var $dureestr;
	
	
	var $dateDepart;
	var $dateArrivee;
	var $dateDepartR;
	var $dateArriveeR;
	var $heureDepart;
	var $heureArrivee;
	var $heureDepartR;
	var $heureArriveeR;
	var $minutesDepart;
	var $minutesArrivee;
	var $minutesDepartR;
	var $minutesArriveeR;
	
	
	var $datedepartFormated; // d/m/Y H:i:00
	var $datearriveeFormated;	
	
	var $immobilisation;
	var $doublage;

	var $capacite;
	var $nbrBus;
	var $placesParBus = array();
	var $typeBus;
	var $commentaires;
	var $budget;
	var $diviserAnnonces;
	var $nbrSiegesTotal;
	
	var $dtag;
	
	var $dtrTransfertObject;
	var $itineraireTransfertObjects = array();
	
	// associer les champs au numéro de l'étape du formulaire
	var $filedsFormEtapes = array('iddemandetr'=>1, 'idcontact'=>1, 'idutilisateur'=>1, 'typeVoyage'=>1, 'nbEscales'=>1, 'nbEtapes'=>1, 'villes'=>1, 'cps'=>1, 'pays'=>1, 'typeTransfert'=>1, 'distance'=>1, 'dureestr'=>1, 'dateDepart'=>1, 'dateArrivee'=>1, 'dateDepartR'=>1, 'dateArriveeR'=>1, 'heureDepart'=>1, 'heureArrivee'=>1, 'heureDepartR'=>1, 'heureArriveeR'=>1, 'minutesDepart'=>1, 'minutesArrivee'=>1, 'minutesDepartR'=>1, 'minutesArriveeR'=>1, 'dtag'=>1, 'nbrBus'=>2, 'placesParBus'=>2, 'capacite'=>2, 'nbrBus'=>2, 'typeBus'=>2, 'immobilisation'=>2, 'doublage'=>2, 'commentaires'=>2, 'budget'=>2, 'diviserAnnonces'=>2);
 	
    
    function __construct($typeVoyage="transfert")
    {
        $this->typeVoyage=$typeVoyage;
        $this->dtrTransfertObject = new CObjetBDD();
	
    }
    
    function init($numFormEtape)
    {
		
			
    }
   
 	
    function checkErrors($formEtape)
    {
		$voyageCheck = new CVoyageCheck($this, $formEtape);   
		$this->erreurs = $voyageCheck->erreurs;
    }    
	
	
    function sessionSave($numformEtape)
    {
    	//$fields = array_keys($this->filedsFormEtapes, $numformEtape );
    	$fields = array_keys($this->filedsFormEtapes);
    	if(!empty($fields))
	    	foreach($fields as $field)
	    	{
	    		$_SESSION['voyage'][$field]=$this->$field;
	    	}
    } 
    
    
    function sessionLoadAll()
    {
    	$fields = array_keys($this->filedsFormEtapes);
    	if(!empty($_SESSION['voyage']))
	    	foreach($_SESSION['voyage'] as $field => $fieldValue)
	    	{
	    		$this->$field = $fieldValue;
	    	}
    }
    
    function sessionReset()
    {
    	$_SESSION['voyage'] = array();    	
    }
    
    function setDemandetrObjectBdd($operatorName = null)
    {

        $dtrTransfertObjectInfos = array();

        if($operatorName != "insert") $dtrTransfertObjectInfos["iddemandetr"] = $this->iddemandetr;
        
        $dtrTransfertObjectInfos["idcontact"] = $this->idcontact;
        $dtrTransfertObjectInfos["idutilisateur"] = $this->idutilisateur ;
        
        $dtrTransfertObjectInfos["date"] = date("Y-m-d H:m:s");
		if($this->typeTransfert == "a") $typetrajet = "aller_simple";
		else if($this->typeTransfert == "ar") $typetrajet = "aller_retour";
		$dtrTransfertObjectInfos["typetrajet"] = $typetrajet;
        //$dtrTransfertObjectInfos["typetrajet"] = ($this->typeTransfert == "a")?"aller_simple" : ($this->typeTransfert == "ar")?"aller_retour":null;
        $dtrTransfertObjectInfos["paysdepart"] = $this->pays[0];
        $dtrTransfertObjectInfos["villedepart"] = $this->villes[0];
        $dtrTransfertObjectInfos["cpdepart"] = $this->cps[0];
        $dtrTransfertObjectInfos["paysarrive"] = $this->pays[$this->nbEtapes-1];
        $dtrTransfertObjectInfos["villearrive"] = $this->villes[$this->nbEtapes-1];
        $dtrTransfertObjectInfos["cparrive"] = $this->pays[$this->nbEtapes-1];
        $dtrTransfertObjectInfos["datedepart"] = implode('-',array_reverse(explode('/',$this->dateDepart)));
        $dtrTransfertObjectInfos["heuredepart"] = $this->heureDepart.":".$this->minutesDepart.":"."00";
        $dtrTransfertObjectInfos["datearrive"] = implode('-',array_reverse(explode('/',$this->dateArrivee)));
        $dtrTransfertObjectInfos["heurearrive"] = $this->heureArrivee.":".$this->minutesArrivee.":"."00";
        $dtrTransfertObjectInfos["kilometragealler"] = $this->distance;
        $dtrTransfertObjectInfos["datedepartR"] = ($this->typeTransfert == 'ar')?implode('-',array_reverse(explode('/',$this->dateDepartR))):null;
        $dtrTransfertObjectInfos["heuredepartR"] = ($this->typeTransfert == 'ar')?($this->heureDepartR.":".$this->minutesDepartR.":"."00"):null;
        $dtrTransfertObjectInfos["datearriveR"] = ($this->typeTransfert == 'ar')?implode('-',array_reverse(explode('/',$this->dateArriveeR))):null;
        $dtrTransfertObjectInfos["heurearriveR"] = ($this->typeTransfert == 'ar')?($this->heureArriveeR.":".$this->minutesArriveeR.":"."00"):null;
        $dtrTransfertObjectInfos["BusSurPlace"]= ($this->immobilisation)?1:0; 
        $dtrTransfertObjectInfos["doublage"]= ($this->doublage)?1:0;       
        $dtrTransfertObjectInfos["doublagealler"] = 'false';//TODO
        $dtrTransfertObjectInfos["doublageretour"] = 'false';//TODO
        $dtrTransfertObjectInfos["typecar"] = $this->typeBus;
        $dtrTransfertObjectInfos["capacitenecessaire"] = $this->capacite;
        $dtrTransfertObjectInfos["nbrbus"] = ($this->nbrBus!='noBus')?$this->nbrBus:null;
        $dtrTransfertObjectInfos["placesparbus"] = ($this->nbrBus!='noBus')?implode(',',$this->placesParBus):null;
        $dtrTransfertObjectInfos["nbrnuittotal"] = 0;
        $dtrTransfertObjectInfos["nbrrepastotal"] = 0;
        $dtrTransfertObjectInfos["tarifconseille"] = 0; //TODO
        $dtrTransfertObjectInfos["tarifadopte"] = $this->budget;
        $dtrTransfertObjectInfos["typetransport"]= $this->typeVoyage;
        $dtrTransfertObjectInfos["dtag"]=$this->dtag;
        $dtrTransfertObjectInfos["dcommentaires"]= $this->commentaires;

         
        $dtrTransfertObjectInfos["preferencebus"]= ($this->nbrBus=='noBus')?0:1; //useless
        $this->dtrTransfertObject->set($dtrTransfertObjectInfos);
    }
    
    function setItineraireObjetBdd($numEtape,$iddemandetr)
    {
 		$this->itineraireTransfertObjects[$numEtape]= new CObjetBdd();
 		
 		$itineraireTransfertObjectInfos["iddemandetr"] = $iddemandetr;
    	$itineraireTransfertObjectInfos["numetape"] = $numEtape;
 		$itineraireTransfertObjectInfos["ville"] = $this->villes[$numEtape];
 		$itineraireTransfertObjectInfos["codepostal"] = $this->cps[$numEtape];
 		$itineraireTransfertObjectInfos["countrycode"] = $this->pays[$numEtape];  	
 		
 		$this->itineraireTransfertObjects[$numEtape]->set($itineraireTransfertObjectInfos);
    }
    
    function insertInBdd()
    {

    	
    	$dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
    	$itineraireDAO = new CItineraireDAO($GLOBALS['mysql']);
    	$tm = new CTransactionManager($GLOBALS['mysql']);
    	
    	$this->setDemandetrObjectBdd("insert");
    	
    	$tm->startTransaction();
    	
    	//cas NON diviser annonces
    	if(empty($this->diviserAnnonces)){
        	$iddemandetr = $dtrDAO->insert($this->dtrTransfertObject);
	        if(!$iddemandetr)
			{
				$tm->setQueryErr();
			}
			
			for($i=0;$i<$this->nbEtapes;$i++){
	    		$this->setItineraireObjetBdd($i,$iddemandetr);
	    		$iditineraire = $itineraireDAO->insert($this->itineraireTransfertObjects[$i]);
	    		if(!$iditineraire){
					$tm->setQueryErr();
				}
    		}	
			
        }
        //cas diviser annonces
        else {
			//nombre totale de places effective
			$totalPlacesParBus=0;
			for($i=0; $i<count($this->placesParBus);$i++)
			{
				$totalPlacesParBus+=$this->placesParBus[$i];
			}
			$budgetTotal = $this->budget;
			$nbrBusTotal = $this->nbrBus;
			$tabPlacesParBus = $this->placesParBus;
			for($i=0;$i<$nbrBusTotal;$i++)
			{
				//todo calcul du tarif en fct de la taille du bus
				if(!empty($budgetTotal))
					$this->budget = floor($budgetTotal/$nbrBusTotal);
				/*
				 * TO FIX : Warning: Division by zero in c:\Users\Florent\workspace\chartercar\formulaires\demandetransport_valider.php on line 61
				 * Traiter le cas si on ne spécifie pas le nbr de bus
				 */
				$this->placesParBus=array($tabPlacesParBus[$i]);
				
				$this->capacite=$tabPlacesParBus[$i];
				$this->nbrBus=1;
				$this->setDemandetrObjectBdd();
    			$tm->startTransaction();
    			$iddemandetr = $dtrDAO->insert($this->dtrTransfertObject);
		        if(!$iddemandetr)
				{
					$tm->setQueryErr();
				}
				
				for($j=0;$j<$this->nbEtapes;$j++){
		    		$this->setItineraireObjetBdd($j,$iddemandetr);
		    		$iditineraire = $itineraireDAO->insert($this->itineraireTransfertObjects[$j]);
		    		if(!$iditineraire){
						$tm->setQueryErr();
					}
	    		}	
			}		
        }
    	
    	if($tm->getQueryErr()){
			$tm->rollback();
			return false;
		}
		else{
			$tm->commit();
			return true;		
		}  
    }
    
    function loadFromBdd($iddemandetr)
    {
    	
    	
    	$dtrdao = new CObjetBddDao("demandetr");
    	$dtrTransfertObject = $dtrdao->getById($iddemandetr);
		$dtrTransfertObject->get("typetrajet");
		
  		$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
		$etapeTransfertObjects = $itineraireGestion->getItineraire($iddemandetr);


		$this->iddemandetr = $dtrTransfertObject->get("iddemandetr");
		$this->idutilisateur = $dtrTransfertObject->get("idutilisateur");
		$this->idcontact = $dtrTransfertObject->get("idcontact");
		
		if($dtrTransfertObject->get("typetrajet") == "aller_simple") $typetrajet = "a";
		else if($dtrTransfertObject->get("typetrajet") == "aller_retour") $typetrajet = "ar";
		
		$this->typeTransfert = $typetrajet;
        //$this->typeTransfert = ($dtrTransfertObject->get("typetrajet") == "aller_simple")?"a" : ($dtrTransfertObject->get("typetrajet") == "aller_retour")?"ar":null;
      	$this->nbEtapes = count($etapeTransfertObjects);
      	$this->nbEscales = $this->nbEtapes - 2;
      	for($i=0;$i<count($etapeTransfertObjects);$i++){
	        $this->villes[$i] = $etapeTransfertObjects[$i]->get("ville");
	        $this->cps[$i] = $etapeTransfertObjects[$i]->get("codepostal");
	        $this->pays[$i] = $etapeTransfertObjects[$i]->get("countrycode");	
      	}
		$this->dateDepart = implode('/',array_reverse(explode('-',$dtrTransfertObject->get("datedepart"))));
  		$tabHeureDepart = explode(':',$dtrTransfertObject->get("heuredepart"));
        $this->heureDepart = $tabHeureDepart[0];
        $this->minutesDepart = $tabHeureDepart[1];
  		$this->dateArrivee = implode('/',array_reverse(explode('-',$dtrTransfertObject->get("datearrive"))));
  		$tabHeureArrivee = explode(':',$dtrTransfertObject->get("heurearrive"));
        $this->heureArrivee = $tabHeureArrivee[0];
        $this->minutesArrivee = $tabHeureArrivee[1];
 		$this->distance =  $dtrTransfertObject->get("kilometragealler");
		$this->dateDepartR = ($this->typeTransfert == 'ar')?implode('/',array_reverse(explode('-',$dtrTransfertObject->get("datedepartR")))):"";
        $tabHeureDepartR = explode(':',$dtrTransfertObject->get("heuredepartR"));
        $this->heureDepartR = ($this->typeTransfert == 'ar')?$tabHeureDepartR[0]:"";
        $this->minutesDepartR = ($this->typeTransfert == 'ar')?$tabHeureDepartR[1]:"";    
        $this->dateArriveeR = ($this->typeTransfert == 'ar')?implode('/',array_reverse(explode('-',$dtrTransfertObject->get("datearriveR")))):"";
        $tabHeureArriveeR = explode(':',$dtrTransfertObject->get("heurearriveR"));
        $this->heureArriveeR = ($this->typeTransfert == 'ar')?$tabHeureArriveeR[0]:"";
        $this->minutesArriveeR = ($this->typeTransfert == 'ar')?$tabHeureArriveeR[1]:"";
		$this->typeBus = $dtrTransfertObject->get("typecar");
		$this->capacite = $dtrTransfertObject->get("capacitenecessaire");
		$this->nbrBus = ($dtrTransfertObject->get("nbrbus")== "")?'noBus':$dtrTransfertObject->get("nbrbus");
		$placesParBus = explode(',',$dtrTransfertObject->get("placesparbus"));
		$this->placesParBus = ($placesParBus[0] != "")?$placesParBus:array();
		$this->diviserAnnonces = 0;
        $this->budget = $dtrTransfertObject->get("tarifadopte");
		$this->typeVoyage = $dtrTransfertObject->get("typetransport");
		$this->commentaires = $dtrTransfertObject->get("dcommentaires");
		$this->immobilisation = $dtrTransfertObject->get("BusSurPlace");
        $this->doublage = $dtrTransfertObject->get("doublage");
        $this->dtag = $dtrTransfertObject->get("dtag");	
		     
        // 
        //     $this->   = $dtrTransfertObject->get("doublagealler")
        //     $this->   = $dtrTransfertObject->get("doublageretour")
		
		//TODO useless pour l instant $dtrTransfertObject->get("nbrnuittotal") = 0;
        //     $dtrTransfertObject->get("nbrrepastotal") = 0;
        // 	   $dtrTransfertObject->get("tarifconseille") = 0
        
 	
    }
    
    function updateInBdd(){
    	
    	$dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
    	
    	$this->setDemandetrObjectBdd();
   
		$dtrDAO->update($this->dtrTransfertObject);  
    }
    
    function deleteFromBdd($iddemandetr)
    {
    	$dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
    	$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
    	
    	$oldVoyageTransfertObject = new CObjetBdd();
    	$idinfo["iddemandetr"]=$iddemandetr;
    	$oldVoyageTransfertObject->set($idinfo);
    	$dtrDAO->_delete($oldVoyageTransfertObject); //supression des etapes associées a l itineraire
        $itineraireGestion->deleteItineraire($iddemandetr);
    }
      
}





 
?>