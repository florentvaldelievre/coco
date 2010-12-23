	


<?

if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

    include_once('libs/CVoyageTransfertVue.php');


	$iddemandetr=$_GET['iddemandetr'];

    $vue = new CVoyageTransfertVue($iddemandetr);
	$vue->init();
	$vue->display();

?>