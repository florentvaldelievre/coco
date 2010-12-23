<?    
  include_once("include/include_listing.php");	
  
  
if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

$utilisateurDAO =  new CUtilisateurDAO($GLOBALS['mysql']);
$contactDAO = new CContactDAO($GLOBALS['mysql']);

$contact = $contactDAO->getById($_SESSION["idcontact"]);
$utilisateurCourant = $utilisateurDAO->getById($contact->get("idutilisateur"));	

$quotationGestion = new CQuotationGestion($GLOBALS['mysql']);
?>					
<fieldset class=\"demandetransport\"><legend> quotations non renseignées &nbsp; </legend>						
	<p>
	<br />Vous devez laisser une evaluation pour les affaires suivantes : <br />
	
	<?
	
	if($utilisateurCourant->get("typeutilisateur")=="client")
	{
		$atraiter = $quotationGestion->aTraiterClient($utilisateurCourant->get("idutilisateur"));
	}
	else
	{
		$atraiter = $quotationGestion->aTraiterTransporteur($utilisateurCourant->get("idutilisateur"));
	}
	
	echo "<ul>";
	foreach($atraiter as  $value)
	{
		echo"<li>utilisateur <strong>".$value->get('nomutilisateur')."</strong> pour le transport <strong>".$value->get('idtransport')."</strong> </li>";
	}	
	echo "</ul>";
	
	?>

	</p>
</fieldset>
	