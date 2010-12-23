<?

	include_once('libs/util.php');
	        
    include_once('libs/CFilterOrderAscending.php') ;
    include_once("libs/CResultLimiter.php");    	
    include_once("libs/CUtilisateurGestion.php");   
    include_once("libs/CTransporteurdptDAO.php");   
    
    include_once('libs/CHTMLresultPerPage.php'); 
    include_once('libs/CHTMLPageCount.php');
    include_once("libs/CHTMLPageNumbering.php");  
    
     	
	$id = $_GET['id'];


    $contactdao =  new CObjetBddDAO("contact",$GLOBALS['mysql']);
    $uDAO = new CObjetBddDAO("utilisateur",$GLOBALS['mysql']);
    
    $utilisateur = $uDAO->getById($id);
    $contact = $contactdao->getBy(array( "idutilisateur" => $id));

	$url = new CGererURL();
	$url->addOrderByElement("date");
	CFilterOrderAscending::setDefault($url);
	$url->addActionElement($_GET['action']);
	$url->addOrderByElement($_GET['OrderBy']);
	$url->addOrderAscendingElement($_GET['OrderAscending']);
	$url->addProfilId($_GET['id']);
	$url->addRangeSizeElement($_GET['rangesize']);

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
		


	$profil = new CUtilisateurGestion();
	$comments = new CListingGestion($GLOBALS['mysql']);
	$quotation = $comments->getAverageRatingById($id);
	$commentaire = $comments->getCommentairesClientOrTransporteur($id,$resultLimiter, $url);
	$nbcomment = count($commentaire);
	$nb_demande_validee = $comments->getNumberOfValidateAds($id);
	$nb_demande_attente = $comments->getNumberOfAdsInQueue($id);
	$nb_demande_abandonne = $comments->getNumberOfCancelledAds($id);
	

echo "<div id=\"allProfilPage\">";


	echo "<div id=\"headProfilArea\">
			<div id=\"headProfilName\"><h2>Profil de ".$profil->getNameUtilisateurById($id)."</h2></div>";
	echo "</div>";
		
	echo "<div id=\"leftProfil\">
	
			<a href=\"photo/RealSize/".$contact->get("photo")."\"><img id=\"photoProfil\" alt=\"image du profil de ".$profil->getNameUtilisateurById($id)."\" src=\"photo/thumbs/".$contact->get("photo")."\"/></a>";


if($profil->getTypeUtilisateurById($id)=="transporteur") {
	
	
	
								
	$tr_dpts = new CTransporteurdptDAO($GLOBALS['mysql']);
	$selection_type = $tr_dpts->getSelectionType($id);
	$dpts_list =  $tr_dpts->getDptsList($id);


	switch($selection_type->get("selectiontype"))
	{
		case "EUROPE" : 
			$prisEnCharge = "europe"; 
			break;
		
		case "FRANCE" : 
			$prisEnCharge = "france"; 
			break;
			
		case "FRANCE_WITHOUT_DPTS" : 

			$prisEnCharge =  "Toute la France Sauf : ".getListOfDptsWithCommaSeparated($dpts_list);
			 break;
		
		case "ONLY_DPTS": 

			$prisEnCharge =   "Seulement départements : ".getListOfDptsWithCommaSeparated($dpts_list);
			break;
	}
	
    $trDAO = new CObjetBddDAO("transporteur",$GLOBALS['mysql']);
    $infotr = $trDAO->getBy( array( "idutilisateur" => $id  )); //nul , y'a pas une autre fonction ???
			

				
echo "				<div id=\"infoProfil\">
								
								Date d'inscrit.:"; $time = strtotime($utilisateur->get('datecreation')); echo "<strong>".Date("d/m/Y",$time)."</strong>";
echo  "								<br />
								Nb Véhicule(s) total: ";echo  "<strong>".$infotr->get('totalvehicule')."</strong>";
echo "								<br />
								Age Parc Moyen: ";echo  "<strong>".$infotr->get('ageparcmoyen')."</strong>";
echo "								<br />
								Capacité min Bus: ";echo  "<strong>".$infotr->get('capacitemin')."</strong>";
echo "								<br />
								Capacité max Bus: ";echo  "<strong>".$infotr->get('capacitemax')."</strong>";
echo "								<br />
								Prise en charge: <strong>$prisEnCharge</strong>";
	
				
echo "						</div>";

				

}

echo "</div>";	//leftProfil

echo "<div id=\"rightProfil\">";
		
	

	echo   "<div id=\"statsProfil\">";
				
					echo "<br />Nombre de demande(s) en attente : ".$nb_demande_attente;
					echo "<br />Nombre de demande(s) validée(s) : ".$nb_demande_validee;
					echo "<br />Total du nombre de demande(s) : ".($nb_demande_attente+$nb_demande_validee);
					if($profil->getTypeUtilisateurById($id)=="client")
						echo "<br />Total du nombre de demande(s) abandonnée(s) : ".$nb_demande_abandonne. " soit (".round(($nb_demande_abandonne/$nb_demande_validee)*100) ."%)";					
					echo "<br />Note moyenne : <img alt=\"Rating\" src=\"images/".round($quotation,0)."_star.gif\"/>";

echo		 "</div>";
		

echo   "<div id=\"commentProfil\">";


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


	echo "				<table class=\"tablist\" cellspacing=\"0\">	
							<thead>
								   <tr>
										<th>Commentaire</th>			
										<th>De</th>
										<th>Date</th>
										<th>Note</th>		
								   </tr>
								</thead>
								<tbody>";
			
								if($commentaire != null) {
									
									foreach($commentaire as $comment)
									{
									
										echo "<tr>
												<td> ".wrapWord($comment->get("commentaire"),20)."</td>
												<td> ".$comment->get("nomclient") ."</td>
												<td> ".$comment->get("date")."</td>
												<td> ".$comment->get("note")."</td>
									
											</tr>";
									}
								}
								else
									echo "<tr> <td> Aucun commentaire</td> </tr>";
		
		
		echo 					"</tbody>
						</table>

				</div> <!-- commentProfil -->
	</div>"; //  <!-- RightProfil --> 	

	echo "<div class=\"clearhack\"/>";

			echo "<div id=\"paginationLine\">";  
				//*** Affichage pagination ***> 
		
				echo "<div id=\"pageCount\">";
				echo CHTMLPageCount::display($resultLimiter,$nbcomment);
				echo "</div>";
				
				new CHTMLPageNumbering($resultLimiter,$nbcomment, $url);
					
			echo "</div>"; 	

	
	echo "</div>"; // <!-- allProfilPage --> 	 





?>