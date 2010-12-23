<?php
    require_once("libs/CMySQL.php");

  
  /*
   * DEFINE PATH of DocumentRoot
   */
    include_once("nocommit/localdata.php");
	$path = getIndexPath();
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);  
	include_once("libs/CObjetBdd.php");

	/*
	 * DEFINE CONSTANT
	 */
	 
	define ("MAXSIZE_VILLE", 12);
	define ("DATE_DELIMITER", ':');
	define ("EXPIRATION_DATE", 5);
	define ("PERCENT_PRICE",0.05);
	/*
	 * DEFINE TITLE
	 */
	 
	$title['']="Waybus, professionnels de la relation entre transporteurs, autocaristes et voyageurs";
	$title['faq']="Questions fréquentes ( FAQ )";
	$title['demonstration']="Démonstration du site (Necessite Macromedia Flash® )";
	$title['reglementation']="Réglementation en vigueur";
	$title['commentcamarche']="Comment le site fonctionne";
	$title['consulterannonce']="Consulter les annonces pour les transporteurs / autocaristes";
	$title['inscriptionclient']="Inscription en tant que voyageur";
	$title['inscriptiontransport']="Inscription en tant que transporteur / autocariste";
	$title['perteidentifiant']="Renvoyez de nouveaux identifiants de connexion";
	
   
    $mysql = new CMySQL("localhost","chartercar","passbdd");
    $mysql->connect();
    $mysql->selectDB("chartercar");
    $GLOBALS['mysql']=$mysql;
	//$GLOBALS['url_server']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	


	
?>
