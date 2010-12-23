<?php
if(defined("__CVoyageReponse"))
    return;

define("__CVoyageReponse","");

include_once("libs/CVoyageCheck.php");

class CVoyageReponse {
	
	var $idreponsetr;
	var $iddemandetr;
	
	var $idutilisateur;
	var $idcontact;


	var $nbrBus;
	var $tarifttc;
 	var $commentaires;
 	var $doublage;
 	var $equipement ;
 	var $conditions; 
 	var $date_reponse ; 
  	var $tag ;
	var $rtrTransfertObject;

	var $placesParBus = array();
		
	// associer les champs au numéro de l'étape du formulaire
	var $filedsFormEtapes = array('idreponsetr'=>1, 'iddemandetr'=>1, 'idcontact'=>1, 'idutilisateur'=>1,'capacite'=>1, 'nbrBus'=>1, 'tarifttc'=>1, 'commentaires'=>1, 'doublage'=>1, 'equipement'=>1, 'tag'=>1);
	    
	function __construct()
	{
		$this->rtrTransfertObject = new CObjetBDD();
	}
	    
    function init()
    {
    
    
    }
	
	
 	function setReponsetrObjectBdd($operatorName = null)
    {
        $rtrTransfertObjectInfos = array();

		if($operatorName != "insert") $rtrTransfertObjectInfos["idreponsetr"] = $this->idreponsetr; 
 		$rtrTransfertObjectInfos["iddemandetr"] = $this->iddemandetr;       
        $rtrTransfertObjectInfos["idcontact"] = $this->idcontact;
        $rtrTransfertObjectInfos["idutilisateur"] = $this->idutilisateur;
        $rtrTransfertObjectInfos["tarifttc"] = $this->tarifttc;
        $rtrTransfertObjectInfos["doublage"] = 'false';//TODO
        $rtrTransfertObjectInfos["nbrcar"] = ($this->nbrBus!='noBus')?$this->nbrBus:null;
        $rtrTransfertObjectInfos["capacitecar"] =  implode(',',$this->placesParBus);
		$rtrTransfertObjectInfos["equipement"] = $this->equipement;
		$rtrTransfertObjectInfos["conditions"] = $this->conditions;		       
		$rtrTransfertObjectInfos["rcommentaires"]= $this->commentaires;      
		$rtrTransfertObjectInfos["datereponse"] = date("Y-m-d H:i:s");
        $rtrTransfertObjectInfos["rtag"]="valider";
        $this->rtrTransfertObject->set($rtrTransfertObjectInfos);
    }	
	
	function loadFromBdd($idreponsetr)
    {

    	$rdao = new CObjetBddDao("reponsetr");
		$rtrTransfertObject = $rdao->getBy(array( "idreponsetr" => $idreponsetr));	
		
		$this->idreponsetr = $rtrTransfertObject->get("idreponsetr"); 		
		$this->iddemandetr = $rtrTransfertObject->get("iddemandetr");
		$this->idcontact = $rtrTransfertObject->get("idcontact");
		$this->idutilisateur = $rtrTransfertObject->get("idutilisateur"); 
		$this->placesParBus = explode(',',$rtrTransfertObject->get("capacitecar"));
   		$this->nbrBus = $rtrTransfertObject->get("nbrcar"); 
    	$this->tarifttc = $rtrTransfertObject->get("tarifttc");  
     	$this->commentaires = $rtrTransfertObject->get("rcommentaires"); 
     	$this->doublage   = $rtrTransfertObject->get("doublage"); 
     	$this->equipement   = $rtrTransfertObject->get("equipement"); 
     	$this->conditions   = $rtrTransfertObject->get("conditions"); 
     	$this->date_reponse   = $rtrTransfertObject->get("datereponse");          	
      	$this->tag   = $rtrTransfertObject->get("rtag");        	         	        	     				
    }
	
	function insertInBdd()
    {
    	$rDAO = new CObjetBddDAO("reponsetr",$GLOBALS['mysql']);
    	$this->setReponsetrObjectBdd("insert");
    	$idreponsetr = $rDAO->insert($this->rtrTransfertObject);
    	return $idreponsetr;
    	
    }
    
    
    function updateInBdd(){
    	
    	$rtrDAO = new CObjetBddDAO("reponsetr",$GLOBALS['mysql']);
    	
    	$this->setReponsetrObjectBdd();
   
		$rtrDAO->update($this->rtrTransfertObject);  
    }
    

    
    function checkErrors()
	{
		$voyageCheck = new CVoyageCheck($this);   
		$this->erreurs = $voyageCheck->erreurs; 
	}
	
	    
    function sessionSave($numformEtape)
    {
    	//$fields = array_keys($this->filedsFormEtapes, $numformEtape );
    	$fields = array_keys($this->filedsFormEtapes);
    	if(!empty($fields))
	    	foreach($fields as $field)
	    	{
	    		$_SESSION['voyageReponse'][$field]=$this->$field;
	    	}
    } 
    
    function sessionLoadAll()
    {
    	$fields = array_keys($this->filedsFormEtapes);
    	if(!empty($_SESSION['voyageReponse']))
	    	foreach($_SESSION['voyageReponse'] as $field => $fieldValue)
	    	{
	    		$this->$field = $fieldValue;
	    	}
    }
    
    function sessionReset()
    {
    	$_SESSION['voyageReponse'] = array();    	
    }
    	   
}   
    

?>
