
 <script type="text/javascript" language="javascript">



Event.observe(window,'load',function(x) { 	      

				
	Event.observe('valid', 'click', function(e){ 
	 
		
		if(document.getElementById("dpt").value!="") {

			var map = window.location.href.toQueryParams(); 
			map["dpt"]=document.getElementById("dpt").value;
			var encodedURL =  $H(map).toQueryString();
			var decodedURL = unescape(encodedURL.replace(/\+/g,  " "));
			window.location.href = decodedURL;
			return false;
		}
		else
		{
			alert("veuillez entrer un département");
		}
		 });
		 
});

</script>




<?php
	

	//initialisation des filtres
  include_once("include/include_listing.php");	
    
    
                    	
	$dtrdao = new CObjetBddDao("demandetr");
	$rtrdao = new CObjetBddDao("reponsetr");
							
	$filter_list = array(
		new CFiltreGeneriqueDao("kilometragealler","Kilométrage",$dtrdao),
		new CFiltreGeneriqueDao("tarifadopte","Budget Client",$dtrdao),	
		new CFiltreGeneriqueDao("tarifttc","Meilleur Offre",$rtrdao),
	

	);


	$filtre = new CFiltreAffichage($filter_list);
	

	$url = new CGererURL();

	CFilterOrderBy::setDefault($url);
	CFilterOrderAscending::setDefault($url);

		
	$url->addActionElement($_GET['action']);
	$url->addOrderByElement($_GET['OrderBy']);
	$url->addOrderAscendingElement($_GET['OrderAscending']);
	$url->addRangeSizeElement($_GET['rangesize']);





	

	
	//Si l'utilisateur a slectionné le filtre personalisé alors qu'il n'est pas loggé en autocariste
	if($_GET['filtre']=="perso"&& $_SESSION['typeutilisateur']!="transporteur")
	{
		include "./formulaires/inscriptiontransportredir.php";
	}
	else
	{		
		//Init pagination		
		$nbresult;

		if(isset($_GET["limitmin"]) || isset($_GET["rangesize"]))
		{
			$resultLimiter = new CResultLimiter($_GET["limitmin"],$_GET["rangesize"]);			
		}
		else
		{
			$resultLimiter = new CResultLimiter();
			$resultLimiter->setDefault($url);
		}		



		//
		$dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
		$rtrDAO = new CObjetBddDAO("reponsetr",$GLOBALS['mysql']);
			
		$listingGestion = new CListingGestion($GLOBALS['mysql']);
		$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
		   
	
		//traitement formulaire
		if ($_POST['isformvalid']) {
			$dptlist = $_POST['dpt'];
			$dpts = explode(',',$dptlist);
			$dptvalide = true;
		}
		else if($_GET['dpt'] == true){
			$dptlist = $_GET['dpt'];
			$dpts = explode(',',$dptlist);
			$dptvalide = true;
		}
		else {
			$dptlist  = "";
		}
	
		$typelog = "nolog";
		
		// -- identification du type d'utilisateur'
		if(($_SESSION['typeutilisateur']=="transporteur"))
		{
			$typelog = "transporteur";
		}
		else
		{
			$typelog = "nolog";
		}
			
			
		// -- selection de la requete	

		//requete avec filtre départements
		if (!empty($dptlist)) {
			if( $dptvalide == true) {
				$liste_demandetr = $listingGestion->consulterAnnonces($dpts,$resultLimiter,$filtre->getGenerateBetweenQuery(),$url);
		   	    $nbresult = $listingGestion->listingDAO->noLimitNumberOfRows(); 
			}
		}
		//filtre personalisé
		else if($_GET['filtre']=="perso") {
			$liste_demandetr = $listingGestion->consulterAnnoncesCible($_SESSION['idutilisateur']);
		}
		//pas de filtre sur le lieu
		else {
		    $liste_demandetr = $listingGestion->consulterAnnonces("",$resultLimiter,$filtre->getGenerateBetweenQuery(),$url);
		    $nbresult = $listingGestion->listingDAO->noLimitNumberOfRows();   
		}
		

		
		
		if($liste_demandetr != 0)
			$nbr_reponse = count($liste_demandetr);

		echo "<div class=\"panelcentre\" >"; 
		 
		//*** Affichage header de la page ***>       
		echo "<div class=\"bandeau\" ><h3 class=\"hcentre\">Annonces pour les autocaristes</h3></div>";
		
        if( $nbresult == 0 )
        {
            echo  "<p>Il n'y a aucune annonce pour le moment</p>";
        }
        else
        {
			echo "<p> Les annonces auxquelles vous avez déja répondu sont surlignées en vert. <br />Vous pouvez modifier vos réponses en allant dans le menu <b>Mes propositions : En attente de confirmation</b></p>";
		
		
		

					
			//*** Affichage filtrage annonce ***> 		
			echo "<div class=\"boitestd\"><div class=\"menulvl2\">";		
	
			
			
/*			
  _____   _   _   _                       
 |  ___| (_) | | | |_   _ __    ___   ___ 
 | |_    | | | | | __| | '__|  / _ \ / __|
 |  _|   | | | | | |_  | |    |  __/ \__ \
 |_|     |_| |_|  \__| |_|     \___| |___/
*/
			
			

	
	echo "<div class=\"tabfilter\">
								<h5>Kilométrage.</h5>
								<ul class=\"filtresAffiches\">";

									foreach($filtre->addFilters($url,"kilometragealler") as $un_filtre) {
										echo "<li>".$un_filtre."</li>";
									}	
								
	echo  "						</ul>
							</div>";




	echo "<div class=\"tabfilter\">			       				
								<h5>Budget voyageur</h5>
								<ul class=\"filtresAffiches\">";
								
									foreach($filtre->addFilters($url,"tarifadopte") as $un_filtre) {
										echo "<li>".$un_filtre."</li>";
									}	
	echo "						</ul>		
							</div>";


	echo "<div class=\"tabfilter\">		      				 	
								<h5>Meilleur offre</h5>
								<ul class=\"filtresAffiches\">";

									foreach($filtre->addFilters($url,"tarifttc") as $un_filtre) {
										echo "<li>".$un_filtre."</li>";
									}	
	echo "						</ul>		
							</div>";



	if(count($filtre->active_filters) > 0) {
		echo "<div id=\"selectedFilter\">
				<div id=\"selectedFilterTitle\">Filtre(s) selectionné(s) :</div>";
					$filtre->displayActiveFilters($url,$filter_list);
		echo "</div>";
	}
	else
	{
		echo "<div id=\"selectedFilter\">
				<div id=\"selectedFilterTitle\">Aucun filtre selectionné</div>
		</div>";
	}
	

//on rajoute à la classe de gestionURL les filtres actifs
	$url->addFiltresActifsElement($filtre->getURLFiltresActifs());


	
	
echo "<div class=\"clearhack\"/>";



					
		echo "<hr class=\"ligne\"/>";
			   

				
						
			echo "<div class=\"pad\"><a href=\"index.php?action=consulterannonce&amp;filtre=all\">Toutes les annonces</a></div>"	;
			echo "<div class=\"pad\">" .
					"Les annonces ayant pour point de départ ou d'arrivée le département suivant:" .
					"<input type=\"text\" class=\"letext\" name=\"dpt\" id=\"dpt\" size=\"2\" maxlength=\"2\" value=\"$dptlist\" />" .
					"<input type=\"hidden\" name=\"isformvalid\" value=\"1\" />" .
					"<input type=\"button\" class=\"letext\" name=\"validform\" id=\"valid\" value=\"Valider\" />" .
					"</div>"	;
			
			if(($_SESSION['typeutilisateur']=="transporteur")) {
				echo "<div class=\"pad\"><a href=\"index.php?action=consulterannonce&amp;filtre=perso\">Les annonces que Waybus a selectionné pour vous</a></div>";
			}
			else {
				echo "<div class=\"pad\"><a href=\"index.php?action=consulterannonce&amp;filtre=perso\">Les annonces que Waybus a selectionné pour vous </a><span class=\"grise\" >- necessite d'être inscrit en tant qu'autocariste</span></div>";
			}
			
			
			echo "</div>";	
					
			echo "<hr class=\"ligne\" />";		


		echo "<div id=\"resultPerPage\">";
		new CHTMLresultPerPage($resultLimiter,$url);
		echo "</div>";	


	echo "<div class=\"orderAscending\">";				

		echo "Ordre : [ ";
		echo CFilterOrderAscending::displayOrderAscending($url,"true", "Ascendant");
		echo " | ";
		echo CFilterOrderAscending::displayOrderAscending($url,"false","Descendant");
		echo " ] ";
		echo "</div>";	
		

					
			//*** Affichage tableau annonces *** 	
				
			//++ Header	 du tableau ++	
		        
			echo "
				<table class=\"tablist\" cellspacing=\"0\">
				<thead>
				   <tr>
						<th>Tri</th>
						<th>".CFilterOrderBy::displayOrderBy($url,"iddemandetr","Ref.Transport")."</th>
						<th>Etape</th>
						<th>".CFilterOrderBy::displayOrderBy($url,"datedepart","Date")."</th>
						<th>".CFilterOrderBy::displayOrderBy($url,"capacitenecessaire","Nbr pers")."</th>
						<th>".CFilterOrderBy::displayOrderBy($url,"nbrbus","Nbr cars")." </th>
						<th>".CFilterOrderBy::displayOrderBy($url,"tarifadopte", "Budget voyageur")."</th>
						<th>".CFilterOrderBy::displayOrderBy($url,"tarifttc", "Meilleure offre")."</th>
				   </tr>
				</thead>
				<tbody>";
					 
			//++ lignes du tableau ++
			if(!empty($liste_demandetr)){
				
				foreach( $liste_demandetr as $demandetr )
				{
					$listeEtapes = $itineraireGestion->getItineraire($demandetr->get("iddemandetr"));
					//Reference annonce
					
					if($typelog=="transporteur" && ($demandetr->get("ridcontact")==$_SESSION["idcontact"])){
				    	echo "<tr class=\"pointeur_range altbg\" onmouseover=\"javascript:fOverAlt(this);\" onmouseout=\"javascript:fOutAlt(this);\">";
					}
					else{
						echo "<tr class=\"pointeur_range\" onmouseover=\"javascript:fOver(this);\" onmouseout=\"javascript:fOut(this);\">";	
					}
				
					//loupe
					echo "<td>";
					echo COverlibAffichage::afficheInfoAnnonceOverlib($demandetr);
					echo "</td>";
					
					//Reference annonce
					if($typelog=="transporteur" && ($demandetr->get("ridcontact")==$_SESSION["idcontact"])){
				    	echo "<td><span class=\"refannonce\">".$demandetr->get("typetransport")." n°". $demandetr->get("iddemandetr")."</span> ";
					}
					else{
						echo "<td><a class=\"lienannonce\" title=\"Répondez à cette annonce n°".$demandetr->get("iddemandetr")."\" href=\"index.php?action=repondreannonce&amp;iddemandetr=".$demandetr->get("iddemandetr")."\">".$demandetr->get("typetransport")." n°". $demandetr->get("iddemandetr")."</a>&nbsp;&nbsp;&nbsp;";	
					}
				    echo  "</td>";
				
					//Itinéraire						
					echo"<td>";
					foreach($listeEtapes as $etape)
					{
						COverlibAffichage::coupeVille(MAXSIZE_VILLE,$etape->get("ville"));
						echo "<br />";
					}
					echo"</td>";
					
					//Date et heure depart
					echo"<td>";
					echo CListingAffichage::afficheDate($demandetr);
					echo"</td>";	
				
					//Capacité
					echo "<td>".$demandetr->get("capacitenecessaire")."</td>";						
			
					//nombre du bus
					echo "<td>";
				
				  	$nbr_bus=$demandetr->get("nbrbus");
				  	if( empty( $nbr_bus ) )
				   	{
				   		echo "N/C";
				   	}
				   	else
				   	{
				   		echo $demandetr->get("nbrbus");
				   	}
					
					echo "</td>";
					
					//budget client
					echo "<td>";
				   
		 			echo CListingAffichage::afficheTarifAdopte($demandetr,"€");
				    echo "</td>";
				   	
				   	//meilleure offre
				   	echo "<td>";
				   	if(($demandetr->get('prixmin')!=NULL))
				    { 
				    	echo $demandetr->get('prixmin') ."€"; 
				    }
				    else
				    {
				    	echo " - ";
				    }
				    echo "</td></tr>";
				}
			}	 
			echo "</tbody></table>";
	 
			echo "<div id=\"paginationLine\">";  
				//*** Affichage pagination ***> 
		
				echo "<div id=\"pageCount\">";
				echo CHTMLPageCount::display($resultLimiter,$nbresult);
				echo "</div>";
				
				new CHTMLPageNumbering($resultLimiter,$nbresult, $url);
					
			echo "</div>"; 
        }
	
	echo "</div></div>";
	}

?>