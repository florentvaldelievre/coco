 <?

   $newpass=$_GET[i];

   $cgDAO = new CContactGestion($GLOBALS['mysql']);
   $cgDAO->changePassConfirm($newpass);


    $_POST['url']="index.php?action=accueil";
	$_POST['message']="votre nouveau mot de passe à bien été pris en compte";
    include("../formulaires/redirectMessage.php");
    



?>