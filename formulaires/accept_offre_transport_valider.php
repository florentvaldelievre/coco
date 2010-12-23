<?

include_once("libs/mailmanager.php");
include_once("libs/CContenuMail.php");
include_once("libs/CFacturesDAO.php");


    $trDAO = new CObjetBddDAO("transport",$GLOBALS['mysql']);
    $cDAO = new CObjetBddDAO("contact",$GLOBALS['mysql']);
    $contact = $cDAO->getById($_SESSION["idcontact"]);
    $dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
    $rDAO = new CObjetBddDAO("reponsetr",$GLOBALS['mysql']);
    
    $transport = new CObjetBDD();
    $infos = array();
    $infos["iddemandetr"] = $_POST['idDtr'];
    $infos["idreponsetr"] = $_POST['idRtr'];
    $infos["date"] = date('Y/m/j H:i:s');
   
    $info_client = $_SESSION['info_client'];
    $info_transporteur = $_SESSION['info_transporteur'];
	$etapes = array();
    $transport->set($infos);
    $trDAO->insert($transport);
   
    foreach($_SESSION['etapes'] as $etape) {
    	array_push($etapes,$etape->get("ville"));
    }


	/*
	 * Requette permettant de connaitre le mail des transporteurs à qui l'on refusera l'annonce
	 */
	$query_transporteur_end = "SELECT * FROM utilisateur u 
								NATURAL JOIN contact c 								
								INNER JOIN reponsetr R on ( c.idutilisateur=R.idutilisateur ) 
								WHERE ( R.iddemandetr = ".$_POST['idDtr']." and R.idreponsetr <> ".$_POST['idRtr']." )";		
	
	$transporteurs_out = $rDAO->getByCustomQuery($query_transporteur_end);	
	
	
	//chargement des reponses a modifier
	$query_reponseToUpdate = "SELECT * FROM  reponsetr
							  WHERE ( iddemandetr = ".$_POST['idDtr']." and idreponsetr <> ".$_POST['idRtr']." )";		
	
	
	
	$oRtrs = $rDAO->getByCustomQuery($query_reponseToUpdate);
	
	
	
	
	 //update du tag de reponsetr
	 if(!empty($transporteurs_out))
	 {
	 	foreach( $oRtrs as $oRtr)
	 	{
					$oRtr->setOne("rtag","refuser");
					$rDAO->update($oRtr);
	 	}
	 }

  if(count($transporteurs_out)>=1)
  { 
		foreach( $transporteurs_out as $sendmail_tr)
		{


					if($sendmail_tr->get("mailrepondunotifier")) 
					{
						$contenu=CContenuMail::ContenuMailRefusAnnonceTransporteur($info_client[0]);
						$expediteur = "easyway";
		                $objet="Votre annonce sur la demande de transport n°".$_POST['idDtr']." n'a pas été retenue par le client";							
		     			$singleton = MailManager::getInstance();
		     			$singleton->Envoi_mail($sendmail_tr->get("mail"),$contenu,$objet);
		     			$singleton->ClearAddresses();
					} 
		}	
 }
	
/*
 * Mettre le tag "valider pour la table demandetr" 
 */

    $query = "SELECT *
                 FROM demandetr
                 WHERE iddemandetr=".$_POST['idDtr']."  ";
    $tag = " AND dtag = 'newdemande_repondue'";
 

	$query_valider = $dtrDAO->getByCustomQuery($query.$tag);
	
	$query_valider[0]->setOne("dtag","valider");
	$dtrDAO->update($query_valider[0]);



/*
 * Mettre le tag "valider pour la table reponsetr" 
 */
 
     $query = "SELECT * FROM  reponsetr
			   WHERE ( iddemandetr = ".$_POST['idDtr']." and idreponsetr = ".$_POST['idRtr']." )";		

	$query_valider = $rDAO->getByCustomQuery($query);
	$query_valider[0]->setOne("rtag","valider");
	$rDAO->update($query_valider[0]);
 


		
				/*
				 *  remplir la table factures pour le transporteur
				 */		
			
				$facturesbdd = new CObjetBdd();
				$facturesDAO =  new CFacturesDAO ($GLOBALS['mysql']);
				$facturesinfo = array();
				$facturesinfo['idutilisateur']=$info_transporteur[0]->get('idutilisateur');
				$facturesinfo['idreponsetr']=$_POST['idRtr'];
				$facturesinfo['prixfacture']=round(PERCENT_PRICE*$info_transporteur[0]->get('tarifttc'));
				$facturesinfo['date']=date('Y/m/j H:i:s');  
				$facturesinfo['paye']=0;
				$facturesinfo['cancelled']=0;				
				$facturesbdd->set($facturesinfo);
				$facturesDAO->insert($facturesbdd);


                $cDAO = new CObjetBddDAO("contact",$GLOBALS['mysql']);
                $transporteur = $cDAO->getById($_POST['idC_transporteur']);
				$transporteur_mail=$transporteur->get("mail");
				$client = $cDAO->getById( $_SESSION["idcontact"]);  
      			$client_mail = $client->get("mail");

				/*
				 * Envoi du mail au transporteur concernant les informations du client
				 * @arg $info_client=Array()
				 * @arg $info_transporteur=Array()
				 * @arg $etapes = Array()
				 * @arg 0 ou 1 type: client=0, transporteur=1
				 */
				$contenu=CContenuMail::ContenuMailValidationAnnonce($info_client[0],$info_transporteur[0],$etapes,"transporteur");
				$expediteur = "easyway";
                $objet="Un client a accepté votre réponse numero ".$_POST['idRtr'];  			    			
     			$singleton = MailManager::getInstance();
     			$singleton->Envoi_mail($transporteur_mail,$contenu,$objet);
     			$singleton->ClearAddresses();
				
				/*
				 * Envoi du mail au client concernant les informations du transporteur
				 * @arg $info_client=Array()
				 * @arg $info_transporteur=Array()
				 * @arg $etapes = Array()
				 * @arg 0 ou 1 type: client=0, transporteur=1
				 */
				$contenu=CContenuMail::ContenuMailValidationAnnonce($info_client[0],$info_transporteur[0],$etapes,"client");
				$expediteur = "easyway";
                $objet="Vous avez accepter l'offre du transporteur pour la demande numero ".$_POST['idDtr'];
     			$singleton = MailManager::getInstance();
     			$singleton->Envoi_mail($client_mail,$contenu,$objet);
     			$singleton->ClearAddresses();
			
		




$_POST['url']="index.php?action=listing_valider_c";
$_POST['message']="Vous avez accepté l'offre du transporteur<br /> 
Un mail a été envoyé à tout les autres transporteurs leur indiquant votre refus <br />
Nous allons vous mettre en contact avec le transporteur que vous avez choisis par email";

include("formulaires/redirectMessage.php");

 
?>