<?php
	 include_once("libs/mailmanager.php");		
	 include_once("libs/CContenuMail.php");	       
				       
			 

		  		$infos_transporteur=array();
		  		$infos_transporteur = $_SESSION["repondreannonce"];
		  		$infos_client=$_SESSION["info_transport_client"];
		  		
		        $dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
		        $demandetr = $dtrDAO->getById( $infos_transporteur["iddemandetr"] );
				

				//update tag
				$infos_client_tag["iddemandetr"]=$infos_transporteur["iddemandetr"];
				$infos_client_tag["dtag"]="newdemande_repondue";
                $dTR = new CObjetBDD();
                $dTR->set($infos_client_tag);  
                $dtrDAO->update($dTR);
               
                
			   $infos_transporteur["idutilisateur"]= $_SESSION['idutilisateur'];
			   $rDAO = new CObjetBddDAO("reponsetr",$GLOBALS['mysql']);
			   $reponsetr = new CObjetBDD();
			   $reponsetr->set($infos_transporteur);
			   // recuperation de l'iddreponsetr pour la table historiqueprix
			   $idReponseTr =  $rDAO->insert($reponsetr);

						
				$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
                $listeEtapes = $itineraireGestion->getItineraire($infos_transporteur["iddemandetr"]);              
                $cDAO = new CObjetBddDAO("contact",$GLOBALS['mysql']);
                $demandeur = $cDAO->getById( $demandetr->get("idcontact") );
                $transporteur = $cDAO->getById( $infos_transporteur["idcontact"]);




				$historiqueDAO = new CObjetBddDAO("historiqueprix",$GLOBALS['mysql']); 
				$histoprix = new CObjetBDD();
               	$infoprix = array();
                $infoprix["idreponsetr"] =  $idReponseTr;
             	$infoprix["prix"] = $infos_transporteur["tarifttc"];
             	$histoprix->set($infoprix);
                $historiqueDAO->insert($histoprix);
                
               





echo "<br/>";



				$contenu = CContenuMail::ContenuMailReponseTransporteur($infos_client,$reponsetr,$listeEtapes);
				//Envoi au client
                $expediteur = "admin@waybus.com";
                $objet="Un transporteur a répondu à votre demande de transport n°".$infos_transporteur["iddemandetr"];
                $destinataire = $demandeur->get("mail");               
				$singleton = MailManager::getInstance();
     			$singleton->Envoi_mail($destinataire,$contenu,$objet);
     			$singleton->ClearAddresses();
     		
     		
     			
/* Pas trop d'utilité ?

                //Envoi au transporteur       
                $objet="Réponse à la demande de transportn°".$infos_transporteur["iddemandetr"];
                $destinataire = $transporteur->get("mail");
				$singleton = MailManager::getInstance();
     			$singleton->Envoi_mail($destinataire,$contenu,$objet);
     			$singleton->ClearAddresses();
*/
			    $_POST['url']="index.php?action=mesannonces";
				$_POST['message']="Votre annonce vient d'être notifiée au voyageur par email, celle-ci est placée sur le menu à gauche <strong>Attente de confirmation</strong>";
                include("formulaires/redirectMessage.php");
                


    
?>
