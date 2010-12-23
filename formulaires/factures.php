<?php
if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }


    include_once("libs/CFacturesGestion.php");

		$facturesGestion = new CFacturesGestion($GLOBALS['mysql']);
		$liste_factures = $facturesGestion->viewFactures($_SESSION['idutilisateur']);



         	

	echo "<div class=\"panelcentre\" >"; 
	 
	//*** Affichage header de la page ***>       
	echo "<div class=\"bandeau\" ><h3 class=\"hcentre\">Factures</h3></div>
		<p>Pour voir vos factures, selectionnez en une ou plusieurs (Control + click) puis cliquez sur 'valider'</b></p>";
									



echo "<form name=\"voirfacturepdf\" id=\"voirfacturepdf\" method=\"post\"  target=\"_blank\" action=\"formulaires/voirfacturepdf.php\">";
			echo "<select style=\"font-size: 12px; width:  400px;\" id=\"listeFactures\" multiple=\"multiple\" name=\"listeFactures[]\" size=\"10\">";
		
		
		foreach($liste_factures as $factures)
		{
			echo "<OPTION VALUE=\"".$factures->get('idfactures')."\">
			[Facture n°".$factures->get('idfactures')."] - 
			[Ref.Transport n° ".$factures->get('iddemandetr') ."] - 
			(". $factures->get('date').") - 
			".$factures->get('prixfacture')." € | ";
			if($factures->get('paye')) 
				 echo "Payée";
			else if($factures->get('cancelled'))
				echo "Abandonnée";
			else
				echo "Non payée";
		}
		
		
		echo "	</select>";
	
echo "	<p>


<input type=\"submit\" value=\"valider\">
</form>
</p>
</div>";

?>