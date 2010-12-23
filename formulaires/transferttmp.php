<?
	print_r($_POST);
	
	$vue = new CVoyageTransfertVue();
	$vue->initEtape1();
	$vue->display();