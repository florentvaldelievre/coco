<?php
     include_once("libs/CListingGestion.php");
        
  		$listingGestion = new CListingGestion($GLOBALS['mysql']);
		$transporteurs = $listingGestion->topNumberOfTransporteurReply();
    
	echo "<div class=\"bandeau\" ><h3 class=\"hcentre\">Liste de tous les transporteurs</h3></div>";
	
	echo "<br />";
	
			foreach($transporteurs as  $transporteur) {								
				 echo 	"<a href=\"?action=profil&amp;id=".$transporteur->get("idutilisateur")."\">".$transporteur->get("nomclient")."(".$transporteur->get("nbrReponse")."), </a>";
			}
?>
