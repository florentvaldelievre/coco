<?//todo: verifier que l'annonce existe car un autre transporteur a pu répondre à l'annonce pdt le temps de remplissage du formulaire

 include_once("libs/mailmanager.php");

    include_once('libs/CVoyageVueRepondreAnnonce.php');

if(($_SESSION['typeutilisateur']!="transporteur") ) 
{  
		include "./formulaires/inscriptiontransportredir.php"; 
}
else
{
	  	$vue = new CVoyageVueRepondreAnnonce(false,$_GET["idreponsetr"]);
		$vue->init();
		$vue->display();
		
}