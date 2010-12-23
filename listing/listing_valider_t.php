<?    
	//verification log
	if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

  include_once("include/include_listing.php");	
	
	
		//initialisation des filtres
	
	$dtrdao = new CObjetBddDao("demandetr");
	$rtrdao = new CObjetBddDao("reponsetr");
				
	$filter_list = array(
		new CFiltreGeneriqueDao("kilometragealler","Kilométrage",$dtrdao),
		new CFiltreGeneriqueDao("capacitenecessaire","Nbr Pers",$dtrdao),
		new CFiltreGeneriqueDao("tarifttc","Prix",$rtrdao),

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



	
	//Init var
	$idutilisateur = $_SESSION["idutilisateur"];

	//Init dao
	$listingGestion = new CListingGestion($GLOBALS['mysql']);
	$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
	$cDAO = new CUtilisateurGestion($GLOBALS['mysql']);



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
           
    //execution des requetes et récupération des données de pagination  
    $demandesValidees = $listingGestion->demandeValideesTransporteur($idutilisateur,"", $resultLimiter,$filtre->getGenerateBetweenQuery(),$url);
	$nbresult = $listingGestion->listingDAO->noLimitNumberOfRows();   

	//html
	echo "<div class=\"panelcentre\" >"; 
			 
	//*** Affichage header de la page ***>       
	echo "<div class=\"bandeau\" ><h3 class=\"hcentre\">Demandes Validées</h3></div>";

    if( count($demandesValidees) == 0 )
    {
        echo  "<p>Vous n'avez aucune annonce validée</p>";
    }
    else
    {
		echo "<ul>

			<li>La liste des demandes validées répertorie toutes les affaires que vous avez précedemments conclues. Pensez à laisser une évalutation sur chacune de ces affaire, votre opinion est importante.</li>
			<li>Les demandes sont en rouge dans le cas ou le voyageur a abandonné l'annonce. Vous pouvez laisser un commentaire</li>
			<li>Vous aurez 1 mois pour nous payer la commission à compter de la date de départ du voyage</li>
			<li>Nous vons conseillons fortement d'attendre que le voyageur vous paye avant de procéder à la transaction.</p><p> Si le voyageur ne vous paye pas, nous ne serons pas en mesure de vous rembourser.</li>

			</ul>";

	
				
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
								<h5>Prix</h5>
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
					<th>".CFilterOrderBy::displayOrderBy($url,"iddemandetr","Ref.Transp")."</th>
					<th>".CFilterOrderBy::displayOrderBy($url,"nomclient","Nom Client")."</th>				
					<th>Etape</th>
					<th>".CFilterOrderBy::displayOrderBy($url,"datedepart","Date")."</th>
					<th>".CFilterOrderBy::displayOrderBy($url,"nbrbus","Nbr cars")." </th>
					<th>".CFilterOrderBy::displayOrderBy($url,"capacitenecessaire","Nbr pers")."</th>
					<th>".CFilterOrderBy::displayOrderBy($url,"tarifttc","Prix")." </th>
					<th>".CFilterOrderBy::displayOrderBy($url,"prixfacture","Com.")." </th>
					<th>Actions</th>
			   </tr>
			</thead>
			<tbody>";


        
           
              
		foreach($demandesValidees as $demandetr)
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
			echo "<td><strong>".$demandetr->get("typetransport")." n°". $demandetr->get("iddemandetr")."</strong></td>";		
			//nom client						
			echo"<td><a href=index.php?action=profil&id=".$cDAO->getIdUtilisateur($demandetr->get("nomclient")).">".$demandetr->get("nomclient")."</a></td>";
							
	
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
					
	
			//prix
			echo"<td>".$demandetr->get("tarifttc")."€</td>";
			//prix
			echo"<td>".COverlibAffichage::afficheCommissionOnMouseOver($demandetr)."</td>";			
			//actions
			echo"<td>";
			
			// -quotation
			if(!$demandetr->get("idquotation"))
			{
					echo"<a href=\"index.php?action=set_quotation&amp;idutilisateur2=".$demandetr->get("idutilisateurclient")."&amp;idtransport=".$demandetr->get("idtransport")."&amp;iddemandetr=".$demandetr->get("iddemandetr")."&amp;accessfrom=listing_valider_t\"><img src=\"images/style1/icon-bulle.gif\"   title=\"laisser une évaluation\" alt=\"laisser une évaluation\"></a>";
			}
			else
			{
					echo"<img src=\"images/style1/icon-bulle2.gif\"  title=\"évaluation ajoutée\" alt=\"évaluation ajoutée\">";
			}
			
			// -voir detail -> TODO
			echo"	    <a href=\"formulaires/genererDevis.php?idtr=".$demandetr->get("iddemandetr")." \"target=\"_blank\"><img src=\"images/style1/page_white_acrobat.gif\"  title=\"Generer le devis au format pdf\" alt=\"Generer le devis au format pdf\" ></a>";
			
			if($demandetr->get("paye"))
				echo "<div class=\"payee\">Payée</div>";
			else if($demandetr->get("cancelled"))
				echo "<div class=\"cancelled\">Abandonnée</div>";
			else
				echo"<a href=\"index.php?action=paypal_init&idtr=".$demandetr->get("iddemandetr")." \"><img src=\"images/style1/money.gif\" title=\"Payer par Paypal (sécurisé)\" alt=\"Payer par Paypal (sécurisé)\" ></a>";
		
			echo"	    <img src=\"images/details_coord.gif\" id=\"collapseimg_reponsedemande_".$demandetr->get("iddemandetr")."\" onclick=\"return toggle_collapse('reponsedemande_".$demandetr->get("iddemandetr")."','images/details_coord')\"></img>";
			

			echo"</td></tr>";	
				
            echo "<tr id=collapseobj_reponsedemande_".$demandetr->get("iddemandetr")." >
              		<td colspan=8 >                                              
						<div class=\"Coordonnee\">
						Coordonnées de <strong>".$demandetr->get("nomclient")."</strong>
						<br /><br />
							Mail : ".$demandetr->get("mailclient")."<br />
							Tel.Portable : ".$demandetr->get("portableclient")."<br />
							Tel.Fixe : ".$demandetr->get("telclient")."<br />
							Fax : ".$demandetr->get("faxclient")."
						</div>
          			</td>
             	  </tr>
             <script>toggle_uncollapse('reponsedemande_".$demandetr->get("iddemandetr")."','images/details_coord.gif')</script>";
		
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
	

	