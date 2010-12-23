<?

if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

$id_reponsetr=$_GET['idRtr'];
$id_demandetr=$_GET['idDtr'];


    include_once("libs/util.php");
    include_once("libs/CItineraireGestion.php");
    include_once('libs/CAffichageAnnonceVoyageur.php');
    include_once("libs/CListingAffichage.php");            
    include_once("libs/CObjetBdd.php");         
    include_once("libs/CObjetBddDAO.php");       
        
$query_reponsetr = "SELECT * FROM utilisateur 
					NATURAL JOIN contact 
					NATURAL JOIN reponsetr 
					WHERE ( reponsetr.iddemandetr = ".$id_demandetr." 
					AND reponsetr.idreponsetr = ".$id_reponsetr." )";




$query_demandetr = "SELECT *
                     FROM demandetr
                     NATURAL JOIN contact
					 NATURAL JOIN utilisateur
                     WHERE ( contact.idutilisateur = ".$_SESSION['idutilisateur']." AND demandetr.iddemandetr = ".$id_demandetr." )";
        $tag = " AND dtag = 'newdemande_repondue' ORDER BY 'iddemandetr' DESC "; 
        


        		 
$DAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
$reponsetr = $DAO->getByCustomQuery($query_reponsetr) or $reponsetr=array();
$demandetr = $DAO->getByCustomQuery($query_demandetr) or $demandetr=array();

if(isExpired($reponsetr[0]))
	echo "expirée";
else
{
	

		$idC_transporteur=$reponsetr[0]->get("idcontact");
		$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
		$listeEtapes = $itineraireGestion->getItineraire($id_demandetr);
		
		/*
		 * On place toute les informations du client et du transporteur pour la page suivante
		 */
				      foreach($demandetr as $key => $value) {
				      	$_SESSION['info_client'][$key] = $value;
				      
				      }
				      
				      foreach($reponsetr as $key => $value) {
				      	$_SESSION['info_transporteur'][$key] = $value;
				      
				      }		   
		
					   foreach($listeEtapes as $key => $value) {
						 $_SESSION['etapes'][$key] = $value;
										
						}
				 		
		
		echo "<pre>Accepter l'offre</pre>";
		
		
		echo "<div class=\"portlet\">
		        <h5>Votre Demande de Transport n°$id_demandetr :</h5>
			        <div class=\"portletBody\">
			            <div class=\"portletContent\">";
		    
		
		echo CAffichageAnnonceVoyageur::getInfoAnnonceVoyageur($demandetr[0],$listeEtapes);
		
		echo "</div></div></div>";
		
		
		echo "<div class=\"portlet\">
		        <h5>Vous accepter l'offre de <strong>".$reponsetr[0]->get("nomclient")."</strong> n°$id_reponsetr :</h5>
			        <div class=\"portletBody\">
			            <div class=\"portletContent\">";
			            
		
		
			
		
		echo "<br /><strong>Réponse transporteur</strong><br /> Nombre de conducteur : ".$reponsetr[0]->get("nbrconducteur")." <br /> Capacité du car : ".$reponsetr[0]->get("capacitecar")." <br />Nombre de car : ".$reponsetr[0]->get("nbrcar")."<br />Equipement(s) proposé(s) : ".$reponsetr[0]->get("equipement")."<br /><br /><strong>Commentaire : </strong><br />".str_replace("\r\n","<br />",$reponsetr[0]->get("rcommentaires"))."<br /><br />Au Tarif de : <font color=red><strong>".$reponsetr[0]->get("tarifttc")." €</strong></font>";
		
		
		echo "</div></div></div>";
		
		
		echo "<fieldset id=\"confirmation_transport_fieldset\"><legend><strong>Confirmation</strong></legend>
		 <img src=\"images/attention.gif\" width=\"35\"> </img>
		<br /> - Attention, en acceptant l'offre, vous vous engager aupres du transporteur à la respecter
		<br /> - Le transporteur recevra un mail l'informant de votre réponse
		<br /> - Confirmer cette offre mettra fin à toute les autres offres correspondant à votre annonce  n°$id_demandetr
		<br /> - <strong>Si vous Confirmez, vous serez immediatement en relation avec le transporteur par email</strong>
		
		";
		echo "<form name=\"accept_offre\" id=\"accept_offre\" method=\"post\" action=\"?action=accept_offre_transport_valider\">";
		 
		 echo " <input type=\"hidden\" name=\"accept_offre_transport_valider\" value=\"1\"/>
		        <input type=\"hidden\" name=\"idRtr\" value=\"$id_reponsetr\"/>
		        <input type=\"hidden\" name=\"idDtr\" value=\"$id_demandetr\"/>
				<input type=\"hidden\" name=\"idC_transporteur\" value=\"$idC_transporteur\"/>
		         <input type=\"submit\" name=\"validerclient\" id=\"valid\" value=\"Confirmer(2/2)\" />";
		         echo "</form></fieldset>";
}
?>