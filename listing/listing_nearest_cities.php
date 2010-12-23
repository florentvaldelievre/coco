<?php

  include_once("include/include_listing.php");	 
                
class listing_nearest_cities {
		
		public static function displayNearestCities($nearest_demandetr, $etapes, $radius) {
			

			    $nbresult = count($nearest_demandetr);
			    $url = new CGererURL();
			    CFilterOrderBy::setDefault($url);
			    CFilterOrderAscending::setDefault($url);
				$url->addActionElement($_GET['action']);
				$url->addOrderByElement($_GET['OrderBy']);
				$url->addOrderAscendingElement($_GET['OrderAscending']);
				$url->addRangeSizeElement($_GET['rangesize']);
			    $itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
		
			if(isset($_GET["limitmin"]) || isset($_GET["rangesize"]))
			{
				$resultLimiter = new CResultLimiter($_GET["limitmin"],$_GET["rangesize"]);			
			}
			else
			{
				$resultLimiter = new CResultLimiter();
				$resultLimiter->setDefault($url);
			}		

	echo "<div class=\"bandeau\" ><h3 class=\"hcentre\">Liste des demandes de transport dans un rayon de ".intval($radius*100)." Km </h3></div>";
		echo "<table class=\"tablist\" cellspacing=\"0\">
		
					<thead>
					   <tr>
							<th>Tri</th>
							<th>Ref.Transport</th>
							<th>Etape</th>
							<th>Date</th>
							<th>Nbr cars</th>
					        <th>Nbr pers</th>						
							<th>Distance de <strong>".end($etapes)."</strong></th>

					   </tr>
					</thead>
					<tbody>";
				
		
				foreach($nearest_demandetr as $demandetr)
				{
					
					
					$listeEtapes = $itineraireGestion->getItineraire($demandetr->get("iddemandetr"));
			
					if(($demandetr->get("cancelled")))
						echo"<tr class=\"scratchbar\" onmouseover=\"fOverAltCancelled(this);\" onmouseout=\"fOutAltCancelled(this);\">";		  	
				  	else
						echo"<tr onmouseover=\"fOver(this);\" onmouseout=\"fOut(this);\">";
				    
				    //Ref.Transport
				    echo "<td>";
		
		             echo COverlibAffichage::afficheInfoAnnonceOverlib($demandetr);
		
					echo "</td>";
					echo "<td><a class=\"lienannonce\" title=\"Répondez à cette annonce n°".$demandetr->get("iddemandetr")."\" href=\"index.php?action=repondreannonce&amp;iddemandetr=".$demandetr->get("iddemandetr")."\">".$demandetr->get("typetransport")." n°". $demandetr->get("iddemandetr")."</a>&nbsp;&nbsp;&nbsp;";
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
					
					
					//Nb de car ( obligé de mettre dans variable pour le empty ... trop nul)
					$nbrcar=$demandetr->get("nbrbus");
					echo"<td>"; 
						if(empty($nbrcar)) echo "NC"; else echo $demandetr->get("nbrbus");
					echo "</td>";
					
					//Nb de pers.
					echo"<td>".$demandetr->get("capacitenecessaire")."</td>";
			
					echo"<td>".round($demandetr->get("distance")*100,1)." Km</td>";					

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
}
  ?>