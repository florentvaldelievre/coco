

<?php
   	
     include_once("libs/CUtilisateurGestion.php");

 
   	$uDAO = new CUtilisateurGestion($GLOBALS['mysql']);
    $cDAO = new CObjetBddDAO("contact",$GLOBALS['mysql']);
    $contact = $cDAO->getBy(array("username" => $_POST['user'],"userpass" => md5($_POST['password']) ) );
    
    if($contact)
    {
	   
         $_SESSION["username"] = $_POST['user'];
         $_SESSION["idcontact"] = $contact->get("idcontact");
         $_SESSION["idutilisateur"] = $contact->get("idutilisateur");
         $_SESSION["typeutilisateur"] = $uDAO->getTypeUtilisateur($contact->get("username"));
         $_SESSION["prenom"] = $uDAO->getNicknameUtilisateurById($contact->get("idutilisateur"));
         
	     $uDAO = new CObjetBddDAO("utilisateur",$GLOBALS['mysql']);
	     $utilisateur = $uDAO->getById($contact->get("idutilisateur"));
         $infos=array();
         $infos["last_connexion"] = date('Y/m/d H:i:s');
         $infos["ip"] = $_SERVER["REMOTE_ADDR"]; 
         $utilisateur->set($infos);
         $uDAO->update($utilisateur);

		
		if($_SESSION["typeutilisateur"]=="client")
			echo "<meta http-equiv=\"refresh\" content=\"0;url=http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?action=login_client\">";
		else
			echo "<meta http-equiv=\"refresh\" content=\"0;url=http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?action=login_transporteur\">";

    }
    else
    {
    	echo "Nom d'utilisateur ou mot de passe incorrect";
    }
    
?>

 

