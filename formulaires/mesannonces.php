<?php


  include_once("include/include_listing.php");	


	//vérification log
	if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

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



       
        $itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
       	$listingGestion = new CListingGestion($GLOBALS['mysql']);

        //Init pagination		
		$nbresult;
		$paginationUrl;
		if(isset($_GET["limitmin"]) || isset($_GET["rangesize"]))
		{
			$resultLimiter = new CResultLimiter($_GET["limitmin"],$_GET["rangesize"]);			
		}
		else
		{
			$resultLimiter = new CResultLimiter();
			$resultLimiter->setDefault($url);
		}
               
        $liste_reponsetr = $listingGestion->annoncesAttenteConfirmation($_SESSION["idutilisateur"], $resultLimiter,$filtre->getGenerateBetweenQuery(),$url);
		$nbresult = $listingGestion->listingDAO->noLimitNumberOfRows();   

		//html
		echo "<div class=\"panelcentre\" >"; 
			 
		//*** Affichage header de la page ***>       
		echo "<div class=\"bandeau\" ><h3 class=\"hcentre\">Annonce(s) en attente de confirmation par le voyageur</h3></div>";

        if( count($liste_reponsetr) == 0 )
        {
            echo  "<p>Vous n'avez aucune demande en attente de validation</p>";
        }
        else
        {
			echo "<p>Les annonces repertoriées ci-dessous sont en attente d'une réponse voyageur<br /></p>";	
			
				
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
								<h5>Nbr Pers.</h5>
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
		




		echo "<table class=\"tablist\" cellspacing=\"0\">
		<thead>
		   <tr>
				<th>Tri</th>
				<th>".CFilterOrderBy::displayOrderBy($url,"iddemandetr","Ref.Transport")."</th>
				<th>Etape</th>
				<th>".CFilterOrderBy::displayOrderBy($url,"datedepart","Date")."</th>
				<th>".CFilterOrderBy::displayOrderBy($url,"nbrbus","Nbr cars")." </th>
				<th>".CFilterOrderBy::displayOrderBy($url,"tarifttc","Prix")." </th>
				<th>Modification</th>
	
		   </tr>
		</thead>
		<tbody>";
	


            foreach( $liste_reponsetr as $reponsetr )
            {
  			 	echo"<tr onmouseover=\"fOver(this);\" onmouseout=\"fOut(this);\">"; 
 			
                $listeEtapes = $itineraireGestion->getItineraire($reponsetr->get("iddemandetr"));
	   		    //Ref.Transport
			    echo "<td>";
	
	            echo COverlibAffichage::afficheInfoAnnonceOverlib($reponsetr);
	
				echo "</td>";
						
				echo "<td><strong>".$reponsetr->get("typetransport")." n°". $reponsetr->get("iddemandetr")."</strong><br /><span class=\"smalltext\">Expire le ".getExpirationDate($reponsetr)."</span></td>";	

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
				echo CListingAffichage::afficheDate($reponsetr);
				echo"</td>";
        
				echo"<td>";

			  $nbr_car=$reponsetr->get("nbrcar");
               if( empty( $nbr_car ) )
               {
               	echo "N/C";
               }
               else
               {
               	echo $reponsetr->get("nbrcar");
               }
				".</td>";
					
			 	
			 	echo "<td>".$reponsetr->get("tarifttc")."€</td></td><td><a href=index.php?action=modif_annonce_transporteur&amp;idreponsetr=".$reponsetr->get("idreponsetr")."><img src=\"images/modifier.gif\"></img></a>
				</td></tr>";
			
            }  
            echo "</tbody></table></div>";
            
			echo "<div id=\"paginationLine\">";  
						//*** Affichage pagination ***> 
				
						echo "<div id=\"pageCount\">";
						echo CHTMLPageCount::display($resultLimiter,$nbresult);
						echo "</div>";
						
						new CHTMLPageNumbering($resultLimiter,$nbresult, $url);
							
					echo "</div></div>";
               
        }

		echo "</div>";
       



?>
