
<?php
 include_once("libs/mailmanager.php");


if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé en tant qu'autocariste pour répondre à cette annonce"; return; }
  
  		       $itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
               $infos = array();
               $infos = $_SESSION["repondreannonce"];
               $dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
               $demandetr = $dtrDAO->getById( $infos["iddemandetr"] );
				
				/*
				 * On place les elements de demandetr en session pour la page suivante
				 */
		      
		      $listeEtapes = $itineraireGestion->getItineraire($demandetr->get("iddemandetr"));

			
//		      foreach($demandetr as $key => $value) {
//		      	$_SESSION['info_transport_client'][$key] = $value;	      
//		      }

				$_SESSION['info_transport_client'] = $demandetr;
  			     $bus = explode(",", $PlacesParBus); 
                 $infos = array();   
                 $infos = $_SESSION["repondreannonce"];


echo "<pre>Récapitulatif de votre réponse</pre>";


echo "<div class=\"portlet\">
        <h5>Vous répondez à l'annonce n°$infos[iddemandetr] :</h5>
	        <div class=\"portletBody\">
	            <div class=\"portletContent\">";
    

echo CAffichageAnnonceVoyageur::getInfoAnnonceVoyageur($demandetr,$listeEtapes);

echo "</div></div></div>";



echo "<div class=\"portlet\">
        <h5>Ma réponse :</h5>
	        <div class=\"portletBody\">
	            <div class=\"portletContent\">";
 			
 				echo "Type de car : ".$infos[typecar]."<br/>";
 				echo "Nombre de bus : ".$infos[nbrcar]."<br/>";
 				echo "Places par bus : ".$infos[capacitecar]."<br/>";
 				echo "Equipement proposé : ".$infos[equipement]."<br/>";
 				
 				echo "<strong>Commentaires</strong><br />";
 				echo str_replace("\r\n","<br />",$infos[rcommentaires])."<br />";
 				echo "<br /><strong>Mon tarif : <font color=red>".$infos["tarifttc"]." €</font></strong>";	
							

              
 
echo "</div></div></div>";             
                

echo "<fieldset id=\"confirmation_transport_fieldset\"><legend><strong>Confirmation</strong></legend>
<br /> - Attention, en acceptant l'offre, vous vous engager aupres du voyageur à la respecter
<br /> - Le voyageur recevra un mail de votre réponse
<br /> - Pour que la transaction se fasse, il doit confirmer votre réponse

<br /> - S'il ne répond pas à votre réponse dans un délais de <strong>".EXPIRATION_DATE." jours</strong>, l'annonce et la transaction seront annulées. Votre proposition expirera automatiquement le <strong>". date("d/m/Y à H:i:s" , strtotime ("+".EXPIRATION_DATE." day")  )." </strong>
<br /> - Si le voyageur réponds, vous nous devrez <strong>5%</strong> de votre tarif (arrondi) soit <font color=\"red\"><strong>".round($infos["tarifttc"]*PERCENT_PRICE)." €</strong></font>
<br /> - Si le voyageur réponds, Vous aurez <strong>1 mois</strong> pour nous payer la commission à compter de la date de départ du voyage

";
echo "<form name=\"accept_offre\" id=\"accept_offre\" method=\"post\" action=\"?action=repondreannonce_valider\">";
 
 echo " <input type=\"hidden\" name=\"accept_offre_transport_valider\" value=\"1\"/>
         <input type=\"submit\" name=\"validerclient\" id=\"valid\" value=\"Valider et envoyer la réponse au voyageur\" />";
         echo "</form></fieldset>";
 
                
?>
