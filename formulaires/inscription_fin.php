<?php


function InscriptionFinOk() 
{
	echo "<div class=\"panelcentre\" >";

	echo "<div class=\"boiteok\">";
	
	echo "<div class=\"bandeauok\"><img src=\"./images/style1/accept.gif\" alt=\"icon_accept\" /></div> ";
	
	echo "<div class=\"boiteokcontent\"><p> Votre inscription s'est déroulée avec succès. </p>";
	
	echo "</div >";
	
	echo "<div class=\"footok\"><img class=\"alignright\" src=\"./images/style1/accept.gif\" alt=\"icon_accept\" /></div>";
	
	echo "</div>";
	
	echo "</div >";
}

function InscriptionFinKo()
{
	echo "<div class=\"panelcentre\" >";

	echo "<div class=\"boiteko\">";
	
	echo "<div class=\"bandeauko\"><img src=\"./images/style1/exclamation-red.gif\" alt=\"icon_exclamation-red\" /></div> ";
	
	echo "<div class=\"boitekocontent\"><p> Une erreur s'est produite lors de l'inscription. Veuillez réessayer ultériement en vérifiant la cohérence des données d'inscription. Si le problème persiste veuillez <a href=\"index.php?action=contact\">contacter WayBus</a></p>";	
	echo "</div >";
	
	echo "<div class=\"footko\"><img class=\"alignright\" src=\"./images/style1/exclamation-red.gif\" alt=\"icon_exclamation-red\" /></div>";
	
	echo "</div>";
	
	echo "</div >";
	
	echo "<p><a href=\"index.php\">retour à l'acceuil</a></p>";
	
}


function InscriptionFinNotes_t() 
{
	echo "<div class=\"panelcentre\" >";

	echo "<p> Vous faites maintenant parti des autocaristes connectés sur BusWay. Vous pouvez dès à présent répondre aux <a href=\"index.php?action=consulterannonce\">demandes d'autocars</a> enregistrées sur le site.</p>";

	echo "</div >";
}

function InscriptionFinNotes_c() 
{
	echo "<div class=\"panelcentre\" >";

	echo "<p> Vous faites maintenant parti des utilisateurs connectés sur BusWay. Vous pouvez dès à présent <a href=\"index.php?action=consulterannonce\">enregistrer une demande d'autocar</a> sur le site.</p>";

	echo "</div >";
}



?>
