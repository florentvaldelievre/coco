<?
	if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

    include_once('libs/CVoyageTransfertVue.php');

        
	$vue = new CVoyageTransfertVue();
	$vue->init();
	$vue->display();