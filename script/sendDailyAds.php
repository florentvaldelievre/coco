<?php



$contenu .="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"fr\" xml:lang=\"fr\">
<head><title></title>
<meta name=\"Description\" content=\"Vous cherchez une location de bus ou de car pour organiser un voyage, Waybus permet la relation entre transporteurs et voyageurs pour leur sejour, circuit ou balade\" />
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />

<meta http-equiv=\"Content-Script-Type\" content=\"application/javascript; charset=UTF-8\">
<meta name=\"robots\" content=\"index,all\" />
<meta name=\"Keywords\" content=\"WEI, Week-ends d'integration, sejour, étudiants, voyage, voyageurs, transporteurs, autocaristes, transport, bus, car, gratuitement, location d'autocar, organiser, circuit, devis\"/>
<link href=\"http://";  $contenu .= $_SERVER['SERVER_NAME']."/chartercar/styles/easyway_style1.css\" rel=\"styleSheet\" type=\"text/css\"></link>
</head>";

		
		
		include_once("../all_includes.php");
	    include_once("../libs/mailmanager.php");	
	$url = new CGererURL();

	CFilterOrderBy::setDefault($url);
	CFilterOrderAscending::setDefault($url);

		
	$url->addActionElement($_GET['action']);
	$url->addOrderByElement($_GET['OrderBy']);
	$url->addOrderAscendingElement($_GET['OrderAscending']);
	$url->addRangeSizeElement($_GET['rangesize']);
		
		
		$dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
		$rtrDAO = new CObjetBddDAO("reponsetr",$GLOBALS['mysql']);
			
		$listingGestion = new CListingGestion($GLOBALS['mysql']);
		$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
		
		$liste_mail_transporteurs = $listingGestion->getAllTransporteurMailWithReceiveAdsTag();
		$liste_demandetr = $listingGestion->consulterAnnoncesDailyAds(1);
   	    $nbresult = $listingGestion->listingDAO->noLimitNumberOfRows(); 
   	    
   	    $contenu .=  "
				<table class=\"tablist\" cellspacing=\"0\">
				<thead>
				   <tr>

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

						$contenu .=  "<tr>";	
						$contenu .=  "<td><a class=\"lienannonce\" title=\"Répondez à cette annonce n°".$demandetr->get("iddemandetr")."\" href=\"index.php?action=repondreannonce&amp;iddemandetr=".$demandetr->get("iddemandetr")."\">".$demandetr->get("typetransport")." n°". $demandetr->get("iddemandetr")."</a>&nbsp;&nbsp;&nbsp;";	

				    $contenu .=   "</td>";
				
					//Itinéraire						
					$contenu .= "<td>";
					foreach($listeEtapes as $etape)
					{
						$contenu.=$etape->get("ville");
						$contenu .=  "<br />";
					}
					$contenu .= "</td>";
					
					//Date et heure depart
					$contenu .= "<td>";
					$contenu .=  CListingAffichage::afficheDate($demandetr);
					$contenu .= "</td>";	
				
					//Capacité
					$contenu .=  "<td>".$demandetr->get("capacitenecessaire")."</td>";						
			
					//nombre du bus
					$contenu .=  "<td>";
				
				  	$nbr_bus=$demandetr->get("nbrbus");
				  	if( empty( $nbr_bus ) )
				   	{
				   		$contenu .=  "N/C";
				   	}
				   	else
				   	{
				   		$contenu .=  $demandetr->get("nbrbus");
				   	}
					
					$contenu .=  "</td>";
					
					//budget client
					$contenu .=  "<td>";
				   
		 			$contenu .=  CListingAffichage::afficheTarifAdopte($demandetr,"€");
				    $contenu .=  "</td>";
				   	
				   	//meilleure offre
				   	$contenu .=  "<td>";
				   	if(($demandetr->get('prixmin')!=NULL))
				    { 
				    	$contenu .=  $demandetr->get('prixmin') ."€"; 
				    }
				    else
				    {
				    	$contenu .=  " - ";
				    }
				    $contenu .=  "</td></tr>";
				}
			}	 
			$contenu .=  "</tbody></table>";
	 
   	   $contenu .=  "</html>";
		
     if(count($liste_demandetr) > 0 )   
     {
        foreach($liste_mail_transporteurs as $transporteur)
        {
	        $expediteur = "admin@waybus.com";
	        $objet=count($liste_demandetr)." nouvelle(s) annonce(s)";
	        $destinataire = $transporteur->get("mail");               
			$singleton = MailManager::getInstance();
			$singleton->Envoi_mail($destinataire,$contenu,$objet);
			$singleton->ClearAddresses();
			 echo count($liste_demandetr)." nouvelles annonces.<br /> Envoi du mail à <strong>".$transporteur->get("mail")."</strong><br/>";
        }
     }
     else
     	echo "aucune nouvelle annonce";
       
?>
