<?php


session_start();
include_once("../all_includes.php");
include_once("../libs/tcpdf/tcpdf.php");
include_once("../libs/tcpdf/config/lang/eng.php");   

if(empty($_POST['listeFactures']))
	{
		echo "Selectionnez au moins une facture";
	}
	else
	{
$facturesGestion = new CFacturesGestion($GLOBALS['mysql']);
$liste_factures = $facturesGestion->viewFacturesWithSelectedFactures($_SESSION['idutilisateur'],$_POST['listeFactures']);
 
 
 
 $htmlcontent.="<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />";
 $htmlcontent.="<hr />";
 $htmlcontent.="<table><thead><tr><th>Facture n°</th><th>Ref. Transport</th><th>Date</th><th>Prix</th></tr></thead><tbody>";



 foreach($liste_factures as $facture)
{
		$prixtotal+=$facture->get('prixfacture');
		
		$htmlcontent.="<tr><td>";
		$htmlcontent.=$facture->get('idfactures');
		$htmlcontent.="</td>";

		$htmlcontent.="<td>";
		$htmlcontent.=$facture->get('iddemandetr');
		$htmlcontent.="</td>";		
		
		$htmlcontent.="<td>";
		$htmlcontent.=$facture->get('date');
		$htmlcontent.="</td>";	
		
		$htmlcontent.="<td>";
		$htmlcontent.=$facture->get('prixfacture')." € TTC";
		$htmlcontent.="</td>";

		$htmlcontent.="</tr>";				


	
}
 
$htmlcontent.="</tbody></table>";

$htmlcontent.="<hr />";

$htmlcontent.="Total = ".$prixtotal."€ TTC";

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true); 
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//initialize document
$pdf->AliasNbPages();
$pdf->AddPage();



// output some HTML code
$pdf->writeHTML($htmlcontent, true, 0);
$pdf->Output();
	}


?>
