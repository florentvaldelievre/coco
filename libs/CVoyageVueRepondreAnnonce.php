<?php

  
   include_once('libs/CVoyageVue.php');
    include_once('libs/CVoyageReponse.php');
     include_once("libs/CGisGestion.php");
         	 
class CVoyageVueRepondreAnnonce extends CvoyageVue {
	
	var $voyageReponse;
	
	//id de la reponse a modifier si affichage de modif_transport, false pour nouvelle reposetr
	var $modifReponse;
	
	var $gisGestion;
	
	
	function __construct($iddemandetr,$modifReponse = false)
    {

		parent::__construct("transfert",$iddemandetr);
		$this->voyage->iddemandetr = $iddemandetr;
		$this->voyageReponse = new CVoyageReponse();
		$this->modifReponse = $modifReponse;
		$this->gisGestion = new CGisGestion($GLOBALS['mysql']);
	    

    }

	function setVoyageReponseParams($numFormEtape)
	{
		switch($numFormEtape)
    	{
    		case 1:
		
				 if(!$this->modifReponse) $this->voyageReponse->iddemandetr = $this->modif;      
		         $this->voyageReponse->idcontact = $_SESSION['idcontact'];
		         $this->voyageReponse->idutilisateur = $_SESSION['idutilisateur'];
				 if(isset($_POST['nbrBus'])) $this->voyageReponse->nbrBus = $_POST['nbrBus'];
				 for($i = 0; $i< $this->voyageReponse->nbrBus; $i++) {
		         	$this->voyageReponse->placesParBus[$i] = $_POST["nbrPlaceBus_$i"];
		         }
				 if(isset($_POST['equipement'])) $this->voyageReponse->equipement = $_POST['equipement'];
				 if(isset($_POST['rcommentaires'])) $this->voyageReponse->commentaires = $_POST['rcommentaires'];
				 if(isset($_POST['tarifttc'])) $this->voyageReponse->tarifttc = $_POST['tarifttc'];

				 break;
		 
		 	case 2:
		 	break;
    	}
	}

	
	function init()
	{
	  	if(isset($_POST['validerform'])){
			$this->currentVue = $_POST['validerform'];

			$this->voyageReponse->sessionLoadAll(); 
			$this->setVoyageReponseParams($this->currentVue);
			$this->voyageReponse->checkErrors($this->currentVue);
			
			$this->voyage->sessionLoadAll();
			
			if(empty($this->voyageReponse->erreurs)){
				$this->voyageReponse->sessionSave($this->currentVue);
				$this->voyage->sessionSave($this->currentVue);
				$this->currentVue++;
			}	
		}
		else {
			$this->voyageReponse->sessionReset();
			$this->voyage->sessionReset();
			
			if($this->modifReponse){
				$this->voyageReponse->sessionLoadAll();
				$this->voyageReponse->loadFromBdd($this->modifReponse);
				$this->voyageReponse->sessionSave($this->currentVue);
	
				$this->voyage->loadFromBdd($this->voyageReponse->iddemandetr);
				$this->voyage->sessionSave($this->currentVue);
				
			}
			else if($this->modif){
	  			$this->voyage->loadFromBdd($this->modif);
	  			$this->voyage->sessionSave($this->currentVue);
			}
	
		}
	}
//     _       __     __  ___   ____    _____   ____  
//    / \      \ \   / / |_ _| |  _ \  | ____| |  _ \ 
//   / _ \      \ \ / /   | |  | |_) | |  _|   | |_) |
//  / ___ \      \ V /    | |  |  _ <  | |___  |  _ < 
// /_/   \_\      \_/    |___| |_| \_\ |_____| |_| \_\
//                                                    
	
	//TODO deporter la vue des erreurs ds CvoyagecheckVue
	function formErreurs()
    {
    	$errstr = "";
    	
    	if(!empty($this->voyageReponse->erreurs))
    	{
    	
    	$errstr .= "
    	<div class=\"boiteko\">
		<div class=\"bandeauko\"><img src=\"./images/style1/exclamation-red.gif\" alt=\"icon_exclamation-red\" /></div> 
		<div class=\"boitekocontent\">
		<p> Le formulaire comporte une ou plusieurs erreurs. Si le problème persiste veuillez <a href=\"index.php?action=contact\">contacter WayBus</a></p>	
        <ul class=\"formError\">
        ";
        	foreach($this->voyageReponse->erreurs as $erreur){
            $errstr .=  "<li>" .$erreur. "</li>";
            }
        $errstr .= "
        </ul>
		</div >
		<div class=\"footko\"><img class=\"alignright\" src=\"./images/style1/exclamation-red.gif\" alt=\"icon_exclamation-red\" /></div>
		</div>
		";
    	}
    	
    	return $errstr;
    }
	
	function createEquipement()
	{	
		echo "<label class=\"labelAlignRight\" for=\"equipement\" title=\"equipement\">équipement: </label>
		<textarea id=\"equipement\" name=\"equipement\" value=\"".$this->voyageReponse->equipement."\" COLS=40 ROWS=3 ></textarea>
        <script> document.getElementById(\"equipement\").value=\"".$this->voyageReponse->equipement."\"</script>";
	}
	
	
	function createInfoComplementaires()
	{	
		echo "<label class=\"labelAlignRight\" for=\"rcommentaires\" title=\"budget informationnel\">Informations complémentaires: </label>
		<textarea id=\"rcommentaires\" name=\"rcommentaires\" value=\"".$this->voyageReponse->commentaires."\" COLS=40 ROWS=5 ></textarea>
        <script> document.getElementById(\"rcommentaires\").value=\"".$this->voyageReponse->commentaires."\"</script>";
	}
	
     
    function createTarif()
    {	
	
		echo "<div class=\"panelFormLine\">
		<label class=\"labelAlignRight\" for=\"tarifttc\" title=\"tarifttc\"><b>Votre tarif TTC :</b></label>
        <input type=\"text\" name=\"tarifttc\" id=\"tarifttc\" value=\"".$this->voyageReponse->tarifttc."\" title=\"tarifttc\" onKeyPress=\"return numbersonly(this, event)\"
		<span>€</span>
		</div>";    	
    }
    
    function createCharteReponse()
    {
		$charte ="
					<ul class=\"charteSmallText\">
					<li>En acceptant l'offre, vous vous engager aupres du voyageur à la respecter</li>
					<li> Le voyageur recevra un mail de votre réponse, il devra confirmer votre réponse afin de valider la transaction</li>
					<li>S'il ne répond pas à votre réponse dans un délais de <strong>".EXPIRATION_DATE." jours</strong>, l'annonce et la transaction seront annulées. Votre proposition expirera automatiquement le <strong>". date("d/m/Y à H:i:s" , strtotime ("+".EXPIRATION_DATE." day")  )." </strong></li>
					<li>S'il valide la transaction, vous serez redevable a Waybus d'un montant s'élevant à <strong>5%</strong> du cout de votre prestation.</li>
					<li> Plus d'informations dont disponibles sur la <a>charte d'utilisation de Waybus</a></li>

					</ul>";
    
        if($this->modif){
			echo "<div class=\"panelFormLine\">$charte</div>";           
		}

      
    }
	
 
	
	function vue1()
	{
		$actionStr;
		$placeParBus;
		$nbrBus;
   		if($this->modifReponse){
   			$actionStr = "Modifier";
   			$placeParBus = $this->voyageReponse->placesParBus;
   			$nbrBus =  $this->voyageReponse->nbrBus;
   			
   		}
   		else{
   			$actionStr = "Répondre à";
   			$placeParBus = $this->voyage->placesParBus;
   			$nbrBus =  $this->voyage->nbrBus;
   		}
   			
   			
   			
   	// includes javascript		
		echo "<script language=\"JavaScript\" type=\"text/javascript\" charset=\"utf-8\" src=\"javascript/voyage.js\"></script>";
		echo "<script type=\"text/javascript\" src=\"http://maps.google.com/maps?file=api&v=2&hl=fr&key=".getGoogleMapApiKey()."\"></script>";
		echo "<script language=\"JavaScript\" type=\"text/javascript\" charset=\"utf-8\" src=\"javascript/googlemapinit.js\"></script>";
		  	// boites englobantes et entetes
		echo"
		<div class=\"panelcentre\">
        <div class=\"boiteform\">
        <div class=\"bandeauform\">
        <h4>$actionStr l'annonce ".$this->voyage->iddemandetr."</h4>
        </div>	";
    	
    	echo "<form name=\"reservation\" id=\"reservation\" method=\"post\" target=\"_self\" action=\"\">
        <div class=\"corpForm\"><br />    
        ".	$this->formErreurs() ."
		";
    	
    	echo"
		<fieldset>
		<legend>Recapitulatif de l'annonce</legend><br />
		";
		
		echo "<ul class=\"resume\">";
    	
    	$this->printTrajet();
    	$this->printKilometrage();
    	$this->printDates();
    	$this->printTransport();
    	$this->printImmobilisation();
    	$this->printDoublage();
        echo "<div id=\"escalePanel\">";
       
        for($i = 0; $i <= $this->voyage->nbEtapes; $i++)
	        $this->createEtape($i,1);
       	
       	echo "</div>";
 		
 		$this->createItineraireControle(1);
       	$this->createItineraireMapEtInfos(1);
       	
    	echo "</ul>";
		echo "</fieldset><br />";
		 	
		// - transport
		echo"
		<fieldset>
		<legend>Votre réponse</legend><br/>
		";
		
		$this->createCharteReponse();
 
 
  		// -- nombre de bus
  		echo "<div class=\"panelFormLine\">";
  		$this->createBus($nbrBus);
  		echo "<div class=\"clearboth\"></div></div>";
  		
  		// -- places par bus
  		echo "<div class=\"panelFormLine\">";
  		$this->createBusSeat($placeParBus);
  		echo "<div class=\"clearboth\"></div></div>"; 
  		
  		// --équipement
  		echo "<div class=\"panelFormLine\">";
  		$this->createEquipement();
  		echo "<div class=\"clearboth\"></div></div>"; 

  		// -- information complémentaires
  		echo "<div class=\"panelFormLine\">";
  		$this->createInfoComplementaires();
  		echo "<div class=\"clearboth\"></div></div>"; 
  		
  		// -- tarif
  		echo "<div class=\"panelFormLine\">";
  		$this->createTarif();
  		echo "<div class=\"clearboth\"></div></div>"; 
  				
  		
		 
		echo "</fieldset><br />";
	

		echo "<script language=\"JavaScript\" type=\"text/javascript\">gmap_init()</script>";
		 
        // pied             
        echo "                 
        <div class=\"piedForm\">
		<input type=\"reset\" name=\"reset\" id=\"reset\" value=\"Annuler\" />
		<input type=\"hidden\" name=\"validerform\" value=\"1\"/>
		<input type=\"submit\" name=\"validerclient\" id=\"valid\" value=\"Valider l'annonce\" />

        </div>
        </div>
        </form>
        </div>
        </div>     
        ";     
	
	}
	
	
	function vue2()
	{		
		//insertion bdd
		
	 	include_once("libs/mailmanager.php");		
		include_once("libs/CContenuMail.php");	
		

		
		if($this->modifReponse)
		{
			$this->voyageReponse->updateInBdd();
		}
		else if($this->modif)
		{
			$idReponseTr = $this->voyageReponse->insertInBdd();
			$this->voyageReponse->idreponsetr=$idReponseTr;
			$this->voyage->dtag = "newdemande_repondue";
			$this->voyage->updateInBdd();
		}

		
		$historiqueDAO = new CObjetBddDAO("historiqueprix",$GLOBALS['mysql']); 
		$histoprix = new CObjetBDD();
	   	$infoprix = array();
	    $infoprix["idreponsetr"] =  $this->voyageReponse->idreponsetr;
	 	$infoprix["prix"] = $this->voyageReponse->tarifttc;
	 	$histoprix->set($infoprix);
	    $historiqueDAO->insert($histoprix);
		
		
		
		$cDAO = new CObjetBddDAO("contact",$GLOBALS['mysql']);
		$demandeur = $cDAO->getBy( array("idutilisateur" => $this->voyage->idutilisateur ));

		//Envoi au client
		if($this->modifReponse)
		{

			$contenu = CContenuMail::ContenuMailModificationAnnonceTransporteur($this->voyageReponse->rtrTransfertObject);
	        $objet="Un transporteur a modifié son annonce pour votre demande n°".$this->voyage->iddemandetr;	
		}
		else
		{
			$contenu = CContenuMail::ContenuMailReponseTransporteur($this->voyage->dtrTransfertObject,$this->voyageReponse->rtrTransfertObject,$this->voyage->villes);
	        $objet="Un transporteur a répondu à votre demande de transport n°".$this->voyageReponse->rtrTransfertObject->get("iddemandetr");
		}   
        $expediteur = "admin@waybus.com";
        $destinataire = $demandeur->get("mail");               
		$singleton = MailManager::getInstance();
		$singleton->Envoi_mail($destinataire,$contenu,$objet);
		$singleton->ClearAddresses();
		
		//vue
		//TODO gerer controle derr et transaction
		if(true){
			
	 	   include_once("listing/listing_nearest_cities.php");	
		   $nearest_demandetr =  $this->gisGestion->getNearestCitiesFromVilleArrive($this->voyage->iddemandetr, $this->voyage->dateDepart);			
			if($nearest_demandetr > 0)
				listing_nearest_cities::displayNearestCities($nearest_demandetr,$this->voyage->villes,$this->gisGestion->radius);

    
			$msg = "Votre annonce à été enregistré avec succès. Vous pouvez suivre l'évolution des réponses des transporteurs
			dans la rubrique <a href=\"index.php?action=mesannonces\">en attente de réponse</a>";
			$msgbox = new CMessageBoxVue("validation", $msg);
			$msgbox->display();
    	}
    	else{
    		$msg = "Une erreur s'est produite lors de l'enregistrement de votre annonce. Veuillez réessayer ultériement en vérifiant la cohérence des données entrées. Si le problème persiste veuillez <a href=\"index.php?action=contact\">contacter WayBus</a>";
			$msgbox = new CMessageBoxVue("erreur", $msg);
			$msgbox->display();	
    	}
    	
    	$this->voyageReponse->sessionReset();
	}
}
?>
