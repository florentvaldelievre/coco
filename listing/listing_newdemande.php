<?php

  include_once("include/include_listing.php");	

  	$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);


if(isset($_SESSION['username']) && ($action == "listing_newdemande")) {

     
     
	
	//initialisation des filtres
	
	$dtrdao = new CObjetBddDao("demandetr");				
	$filter_list = array(
		new CFiltreGeneriqueDao("kilometragealler","Kilométrage",$dtrdao),
		new CFiltreGeneriqueDao("capacitenecessaire","Nbr Pers",$dtrdao),
		new CFiltreGeneriqueDao("tarifadopte","Tarif adopté",$dtrdao),

	);	

	$filtre = new CFiltreAffichage($filter_list);
	

	$url = new CGererURL();

	CFilterOrderBy::setDefault($url);
	CFilterOrderAscending::setDefault($url);
		
	$url->addActionElement($_GET['action']);
	$url->addOrderByElement($_GET['OrderBy']);
	$url->addOrderAscendingElement($_GET['OrderAscending']);
	//$url->addLimitMinElement($_GET['limitmin']);
	$url->addRangeSizeElement($_GET['rangesize']);
     
     
    
    
    	$listingGestion = new CListingGestion($GLOBALS['mysql']);
		$idutilisateur=$_SESSION['idutilisateur'];
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
	           
	    //execution des requetes et récupération des données de pagination  
	    $liste_demande_r = $listingGestion->demandesAttenteReponseClient($idutilisateur, $resultLimiter,$filtre->getGenerateBetweenQuery(),$url);
		$nbresult = $listingGestion->listingDAO->noLimitNumberOfRows();   
    


	echo "<div class=\"panelcentre\" >"; 
	 
	//*** Affichage header de la page ***>       
	echo "<div class=\"bandeau\" ><h3 class=\"hcentre\">Mes demandes en attente de réponse</h3></div>";
	
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
								<h5>Nb de pers.</h5>
								<ul class=\"filtresAffiches\">";

								
									foreach($filtre->addFilters($url,"capacitenecessaire") as $un_filtre) {
										echo "<li>".$un_filtre."</li>";
									}	
	echo "						</ul>		
							</div>";


	echo "<div class=\"tabfilter\">		      				 	
								<h5>Tarif adopté</h5>
								<ul class=\"filtresAffiches\">";

								
									foreach($filtre->addFilters($url,"tarifadopte") as $un_filtre) {
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
		

					
  if( $nbresult == 0 )
    {
        echo  "<p>Vous n'avez aucune annonce répondue</p>";
    }
    else
    {

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
						<th>".CFilterOrderBy::displayOrderBy($url,"tarifadopte", "Tarif adopté")."</th>
						<th>Modifier</th>
				   </tr>
				</thead>
				<tbody>";
				




            foreach( $liste_demande_r as $demandetr )
            {
        		$tarifadopte=$demandetr->get("tarifadopte");
        		$listeEtapes = $itineraireGestion->getItineraire($demandetr->get("iddemandetr"));
   
        	
                        echo "<tr class=\"pointeur_range\" onmouseover=\"fOver(this);\" onmouseout=\"fOut(this);\"><td><a href=index.php?action=supprimetransport&amp;iddemandetr=".$demandetr->get("iddemandetr")."><img src=\"images/delete.gif\" width=\"20px\" height=\"20px\" title=\"Supprimer ".$demandetr->get("typetransport")." n°".$demandetr->get("iddemandetr")." \" />&nbsp;&nbsp;&nbsp;</a>";


                                 
                             echo COverlibAffichage::afficheInfoAnnonceOverlib($demandetr);
                              
                              echo "</td>";
                              
                             
                             echo "<td><strong>".$demandetr->get("typetransport")." n°". $demandetr->get("iddemandetr")."</strong></td>";


							//Itinéraire
							echo "<td>";
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
                    
							echo"

 						
  							<td>
 							".$demandetr->get("capacitenecessaire")."</td>						
  							<td>";

 						  $nbr_bus=$demandetr->get("nbrbus");
                           if( empty( $nbr_bus ) )
                           {
                           	echo "N/C";
                           }
                           else
                           {
                           	echo $demandetr->get("nbrbus");
                           }
							".</td>";
							
					 	
					 	echo "<td>"; 
					 	
					 	
					 	echo CListingAffichage::afficheTarifAdopte($demandetr,"€");

					 	echo "</td></td><td><a href=index.php?action=modiftransport&amp;iddemandetr=".$demandetr->get("iddemandetr")."><img src=\"images/modifier.gif\"></img></a></td></tr>";
					
            }
 echo "</tbody></table>";    



	echo "<div id=\"paginationLine\">";  
				//*** Affichage pagination ***> 
		
				echo "<div id=\"pageCount\">";
				echo CHTMLPageCount::display($resultLimiter,$nbresult);
				echo "</div>";
				
				new CHTMLPageNumbering($resultLimiter,$nbresult, $url);
					
			echo "</div>"; 

echo "</div></div>";
    }

}
?>
