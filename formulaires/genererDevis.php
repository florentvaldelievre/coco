<?php

session_start();

include_once("../all_includes.php");
include_once("../libs/tcpdf/tcpdf.php");
include_once("../libs/tcpdf/config/lang/eng.php");

	$url = new CGererURL();

	CFilterOrderBy::setDefault($url);
	CFilterOrderAscending::setDefault($url);
	
	
	$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);	
	$listingGestion = new CListingGestion($GLOBALS['mysql']);
	if($_SESSION["typeutilisateur"]=="client")
		$devis_res = $listingGestion->demandeValideesClient($_SESSION['idutilisateur'],$_GET['idtr'],null,null,$url);
	else
		$devis_res = $listingGestion->demandeValideesTransporteur($_SESSION['idutilisateur'],$_GET['idtr'],null,null,$url);
		
	

	


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true); 
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);


//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor
$pdf->SetFont("freeserif", "", 8);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


//initialize document
$pdf->AliasNbPages();
$pdf->AddPage();

	if($_SESSION["typeutilisateur"]=="client")
	{
		$pdf->writeHTMLCell(50,24,140,5,
		"Coordonnées de <b>".$devis_res[0]->get("nomclient")."</b>
		<hr />
		Mail : ".$devis_res[0]->get("mail")."<br />
		Tel.Portable : ".$devis_res[0]->get("portable")."<br />
		Tel.Fixe : ".$devis_res[0]->get("telephone")."<br />
		Fax : ".$devis_res[0]->get("fax")
		,1,1,0);
	}

	else
	{
		$pdf->writeHTMLCell(50,24,140,5,
		"Coordonnées de <b>".$devis_res[0]->get("nomclient")."</b>
		<hr />
		Mail : ".$devis_res[0]->get("mailclient")."<br />
		Tel.Portable : ".$devis_res[0]->get("portableclient")."<br />
		Tel.Fixe : ".$devis_res[0]->get("telclient")."<br />
		Fax : ".$devis_res[0]->get("faxclient")
		,1,1,0);
	}
$pdf->Ln(20);
$pdf->MultiCell(20, 5, "Ref.Transport", 1, 'L', 0, 0);
$pdf->MultiCell(40, 5, "Itinéraire", 1, 'L', 0, 0);
$pdf->MultiCell(50, 5, "Date et heure départ", 1, 'L', 0, 0);
$pdf->MultiCell(20, 5, "Nb de car", 1, 'L', 0, 0);
$pdf->MultiCell(20, 5, "Nb de Pers.", 1, 'L', 0, 0);
$pdf->MultiCell(20, 5, "Nom", 1, 'L', 0, 0);
$pdf->MultiCell(20, 5, "Prix TTC", 1, 'L', 0, 0);
$pdf->Ln(6);



 foreach($devis_res as $devis)
{
		$listeEtapes = $itineraireGestion->getItineraire($devis->get("iddemandetr"));
		
		$pdf->MultiCell(20,5,$devis->get("iddemandetr"),0, 'c', 0, 0);
	
		foreach($listeEtapes as $etape)
		{
			$listeVilles.=$etape->get("ville")."\n";	
		}
		$pdf->MultiCell(40,5,$listeVilles,0, 'c', 0, 0);
		$pdf->MultiCell(50,5,CListingAffichage::afficheDateSansHTML($devis),0, 'c', 0, 0);
		
		$nbrcar=$devis->get("nbrbus");
			if(empty($nbrcar)) 
				$pdf->MultiCell(20,5,"NC",0, 'c', 0, 0); 
				else 
				 $pdf->MultiCell(20,5,$nbrcar,0, 'c', 0, 0);

		$pdf->MultiCell(20,5,$devis->get("capacitenecessaire"),0, 'c', 0, 0);	
		$pdf->MultiCell(20,5,$devis->get("nomclient"),0, 'c', 0, 0);
		$pdf->MultiCell(20,5,$devis->get("tarifttc")." €",0, 'c', 0, 0);

}

$pdf->Ln(6);


// output some HTML code
$pdf->writeHTML($htmlcontent, true, 0);
$pdf->Output();


?>
