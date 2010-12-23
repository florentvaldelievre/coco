<?php

  include_once("include/include_listing.php");	

  	$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);

	//verification log
	if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }
	
	
	//initialisation des filtres
	
	$dtrdao = new CObjetBddDao("demandetr");				
	$filter_list = array(
		new CFiltreGeneriqueDao("kilometragealler","Kilométrage",$dtrdao),
		new CFiltreGeneriqueDao("capacitenecessaire","Nbr Pers",$dtrdao),
		new CFiltreGeneriqueDao("tarifconseille","Tarif conseillé",$dtrdao),

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


		
		
		$idutilisateur = $_SESSION["idutilisateur"];

        $cDAO = new CObjetBddDAO("contact",$GLOBALS['mysql']);
        $contact = $cDAO->getById($_SESSION["idcontact"]);
        $dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);

		$historiqueDAO = new CObjetBddDAO("historiqueprix",$GLOBALS['mysql']); 
		
		$listingGestion = new CListingGestion($GLOBALS['mysql']);

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
	    $liste_demandetr = $listingGestion->demandesRepondues($idutilisateur, $resultLimiter,$filtre->getGenerateBetweenQuery(),$url);
		$nbresult = $listingGestion->listingDAO->noLimitNumberOfRows();   

	
		//html
		echo "<div class=\"panelcentre\" >"; 
			 
		//*** Affichage header de la page ***>       
		echo "<div class=\"bandeau\" ><h3 class=\"hcentre\">Annonce(s) Répondue(s)</h3></div>";
 
 					
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
								<h5>Tarif conseillé</h5>
								<ul class=\"filtresAffiches\">";

								
									foreach($filtre->addFilters($url,"tarifconseille") as $un_filtre) {
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
			
		
			echo "<table class=\"tablist\" cellspacing=\"0\"><caption>Liste des demandes répondues</caption>
			<thead>
			   <tr>
					<th>Tri</th>
					<th>".CFilterOrderBy::displayOrderBy($url,"iddemandetr","Ref.Transport")."</th>
					<th>".CFilterOrderBy::displayOrderBy($url,"etape","Itinéraire")."</th>
					<th>".CFilterOrderBy::displayOrderBy($url,"datedepart","Date")."</th>
					<th>".CFilterOrderBy::displayOrderBy($url,"capacitenecessaire","Nbr pers")."</th>
					<th>".CFilterOrderBy::displayOrderBy($url,"nbrbus","Nbr cars")." </th>
					<th>".CFilterOrderBy::displayOrderBy($url,"tarifconseille","Tarif conseillé")." </th>
					<th>".CFilterOrderBy::displayOrderBy($url,"nbreponse","Nb reponse(s)")." </th>
					
			   </tr>
			</thead>
			<tbody>";
		
		       
		           //TODO : enlever la query du foreach
		            foreach( $liste_demandetr as $demandetr )
		            {
		        
		            $query = "SELECT * FROM utilisateur u 
							  NATURAL JOIN contact c 
							  INNER JOIN reponsetr R on (c.idutilisateur=R.idutilisateur ) 
							  WHERE R.iddemandetr = ".$demandetr->get("iddemandetr")." ";
		           
		          
         
            $DAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
            $liste_reponsetr = $DAO->getByCustomQuery($query) or $liste_reponsetr=array();

  	
		
			$listeEtapes = $itineraireGestion->getItineraire($demandetr->get("iddemandetr"));


            if(count($liste_reponsetr)>0)
            {
       
				echo "<tr class=\"pointeur_range\" onmouseover=\"fOver(this);\" onmouseout=\"fOut(this);\"><td>"; 


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
							
					echo	"<td>
					 	".$demandetr->get("tarifconseille")."</td>";
					
 							
 							
                         
                           echo "<td><strong>".count($liste_reponsetr)."</strong>&nbsp;&nbsp;&nbsp;<img src=\"images/details.gif\" id=\"collapseimg_reponsedemande_".$demandetr->get("iddemandetr")."\" onclick=\"return toggle_collapse('reponsedemande_".$demandetr->get("iddemandetr")."','images/details')\"></img></td></tr>";

                           //Ligne contenant l'affichage des reponses, pouvant etre masquée (collapse).
                           //Modifier le colspan si le nombre de colonne augmente
                           echo "<tr id=collapseobj_reponsedemande_".$demandetr->get("iddemandetr").">
									<td colspan=8>
                           				<table>";

                           //Contenus du tableau, une ligne par réponse.
                           foreach( $liste_reponsetr as $reponsetr )
                           {
                
                           //historique pour chaque transporteur 
                           $query_histo = "SELECT * from reponsetr R NATURAL JOIN historiqueprix h WHERE ( R.idreponsetr = ".$reponsetr->get("idreponsetr")." )";	
  						   $liste_historique = $historiqueDAO->getByCustomQuery($query_histo) or $liste_historique=array();
                            
                          
                            //On récupere les informations utiles
                             $transporteur = $reponsetr->get("nomclient");
                             $tarif = $reponsetr->get("tarifttc");
                             echo "<tr>
                              		<td>                                                
									
									> <a href=\"?action=profil&amp;id=".$reponsetr->get("idutilisateur")."\"><strong>$transporteur</strong></a> propose une offre à
									";
									foreach ($liste_historique as $key => $historique)
									{
										if(count($liste_historique)==$key+1)
											echo $historique->get("prix");
										else
											echo "<s>".$historique->get("prix")."</s>&nbsp;	=> ";										
									}
									
								echo "	 euros TTC.";
							    echo " <a  href=\"javascript:void(0)\" onclick=\"return overlib('<br /><strong>Réponse transporteur</strong><br /> Nombre de conducteur : ".$reponsetr->get("nbrconducteur")." <br /> Capacité du car : ".$reponsetr->get("capacitecar")." <br />Nombre de car : ".$reponsetr->get("nbrcar")."<br />Equipement(s) proposé(s) : ".$reponsetr->get("equipement")."<br /><br /><strong>Commentaire : </strong><br />".str_replace("\r\n","<br />",addslashes($reponsetr->get("rcommentaires")))."<br /><br />Au Tarif de : <font color=red><strong>".$reponsetr->get("tarifttc")." €</strong></font>',CAPTION,'<strong>".$demandetr->get("typetransport")." n°". $demandetr->get("iddemandetr")."</strong>',CAPTIONPADDING,'4',FGCOLOR, '#FDFDFD',WIDTH, '280',STICKY,CGBACKGROUND,'images/shade_caption.gif',PRINT,PRINTCOLOR,'#132884',DRAGGABLE,CLOSECLICK,CLOSECOLOR,'#132884', TEXTSIZE,'10px');\" onmouseout=\"return nd();\"><i>Voir cette offre</i></a>";

								echo "<img src=\"images/fleche_droite.gif\"></img>&nbsp;&nbsp;";
							
								
								if(isExpired($reponsetr) )
									echo "<strong><font color=\"red\">Expirée: </font> ".getExpirationDate($reponsetr)." </strong>";
								else
								{
								echo COverlibAffichage::afficheAcceptOffreOnMouseOver($reponsetr);
								echo " | ";
								echo COverlibAffichage::affichePropositionOnMouseOver($reponsetr);

	                          echo " &nbsp;&nbsp;<br /> <span class=\"smalltext\"> <strong>Expire le ".getExpirationDate($reponsetr)." </strong></span></td>
                             	  </tr>
                             <script>toggle_uncollapse('reponsedemande_".$demandetr->get("iddemandetr")."','images/details')</script>";
								}
                           
                           }
                           echo "</table>
                           <a href=index.php?action=compare&amp;cmp=";
                           $tag_plus = "";
                           if(count($liste_reponsetr) > 1 )
                           {
                               foreach( $liste_reponsetr as $reponsetr ) 
                               {
                                 $requete = $tag_plus.$reponsetr->get("idreponsetr");
                                 $tag_plus="+";
                                 echo $requete;
                               }
                               echo ">Comparer</a>";
                           }         
                        echo "</td></tr>"; 
            }
            
            
            
       }
       
       
       		
			echo "</tbody></table></div>";
			
			echo "<div id=\"paginationLine\">";  
						//*** Affichage pagination ***> 
				
						echo "<div id=\"pageCount\">";
						echo CHTMLPageCount::display($resultLimiter,$nbresult);
						echo "</div>";
						
						new CHTMLPageNumbering($resultLimiter,$nbresult, $url);
							
					echo "</div>"; 
            
  	echo "</div></div>";
    }
	


            
          
       

?>
