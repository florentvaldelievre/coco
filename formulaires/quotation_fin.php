<?php


function quotationFinOk($typeutilisateur) 
{
	if($typeutilisateur == "client")
	{
		$url = 'index.php?action=listing_valider_c';
	}
	else if($typeutilisateur == "transporteur")
	{
		$url = 'index.php?action=listing_valider_t';
	}

	echo "<div class=\"panelcentre\" >";

	echo "<div class=\"boiteok\">";
	
	echo "<div class=\"bandeauok\"><img src=\"./images/style1/accept.gif\" alt=\"icon_accept\" /></div> ";
	
	echo "<div class=\"boiteokcontent\"><p> Votre évaluation a été ajoutée avec succès. </p>";
	echo "</div >";
	
	echo "<div class=\"footok\"><img class=\"alignright\" src=\"./images/style1/accept.gif\" alt=\"icon_accept\" /></div>";
	
	echo "</div>";
	
	echo "</div >";
	
	echo "<a class=\"boiteinfolinkcenter\" href=\"".$url."\">Retour aux annonces valider </a>";
}

function quotationFinKo($typeutilisateur)
{
	if($typeutilisateur == "client")
	{
		$url = 'index.php?action=listing_valider_c';
	}
	else if($typeutilisateur == "transporteur")
	{
		$url = 'index.php?action=listing_valider_t';
	}
	
	echo "<div class=\"panelcentre\" >";

	echo "<div class=\"boiteko\">";
	
	echo "<div class=\"bandeauko\"><img src=\"./images/style1/exclamation-red.gif\" alt=\"icon_exclamation-red\" /></div> ";
	
	echo "<div class=\"boitekocontent\"><p> Une erreur s'est produite lors de l'ajout de l'évaluation. Veuillez réessayer ultériement en vérifiant la cohérence des données entrées. Si le problème persiste veuillez <a href=\"index.php?action=contact\">contacter le support WayBus</p>";	
	echo "</div >";
	
	echo "<div class=\"footko\"><img class=\"alignright\" src=\"./images/style1/exclamation-red.gif\" alt=\"icon_exclamation-red\" /></div>";
	
	echo "</div>";
	
	echo "</div >";
	
	echo "<a class=\"boiteinfolinkcenter\" href=\"".$url."\">Retour aux annonces valider </a>";
	
}




?>
