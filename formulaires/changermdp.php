 <?
 if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

include_once("libs/mailmanager.php");
   $passwordsize=6;

if($_POST['validerform'])
{
       
       	$uDAO = new CObjetBddDAO("contact",$GLOBALS['mysql']);
	    $contact = $uDAO->getById($_SESSION["idcontact"]);
       
        if(empty($_POST['mdp1']) || empty($_POST['mdp2']))
        {
                $erreurs['mdp1'] = "case vide";
                echo "case vide";
        }
        elseif($_POST['mdp1'] != $_POST['mdp2'])
        {
                $erreurs['mdp2'] = "Mots de passe différents";
                echo "Mots de passe différents";
        }
        elseif(strlen($_POST['mdp1']) < $passwordsize)
        {
                $erreurs['mdp1'] = "Password trop court";
                echo "Password trop court";
        }
        
        elseif($contact->get('userpass') != md5($_POST['ancienmdp']))
        {
                $erreurs['ancienmdp'] = "L'ancien mot de passe ne correspond pas";
                 echo "L'ancien mot de passe ne correspond pas";
        }  
        
          elseif($contact->get('userpass') == md5($_POST['mdp1']))
        {

            $erreurs['identique'] = "identique en base de donnée";
    		echo "le mot de passe pour <strong>$_SESSION[username]</strong> est identique en base de donnée<br/>";

        }            

   if( $erreurs == array() )
   {

		    $infos["userpass"]=md5($_POST['mdp1']);
		    $contact->set($infos);
		    $uDAO->update($contact);
	    
			$expediteur = "admin@waybus.com";
            $objet="Votre mot de passe waybus a été changé";
            $contenu = " Votre nouveau mot de passe : ".$_POST["mdp1"];					
 			$singleton = MailManager::getInstance();
 			$singleton->Envoi_mail($contact->get("mail"),$contenu,$objet);
 			$singleton->ClearAddresses();
		     			   
	            $_POST['url']="index.php?action=accueil";
				$_POST['message']="Le mot de passe a été changé";
                include("formulaires/redirectMessage.php");
                
	    

   }

}
else
{


echo "<form name=\"newmdp\" id=\"newmdp\" method=\"post\" target=\"_self\" action=\"\">
         <div class=\"corpForm\">
        <fieldset id=Informations>
                    <legend>Changement de mot de passe</legend>
                                        <br/>

                                        <p>
                                        <label for=\"ancienmdp\" title=\"Ancien mot de passe\" >Ancien mot de passe :</label>
                                        <input type=\"password\" name=\"ancienmdp\" id=\"ancienmdp\" value=\"\" title=\"Ancien mot de passe\" />";
                                         if(isset($erreurs['ancienmdp']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[ancienmdp]</img>";
                                             }


echo "</p>
                                        <p>
                                        <label for=\"mdp1\" title=\"Nouveau mot de passe\" >Nouveau mot de passe :</label>
                                        <input type=\"password\" name=\"mdp1\" id=\"mdp1\" value=\"\" title=\"Ce nom d'utilisateur servira à vous connecter sur le site\" />";
                                         if(isset($erreurs['mdp1']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[mdp1]</img>";
                                             }


echo "</p>
                                        <p>
                                        <label for=\"mdp2\"  title=\"Confirmation\">Confirmation:</label>
                                        <input type=\"password\" name=\"mdp2\" id=\"mdp2\" value=\"\" title=\"Mot de passe de la connexion\" />";

                                           if(isset($erreurs['mdp2']))
                                             {
                                               echo "<img src=\"images/icon_err.gif\"> $erreurs[mdp2]</img>";
                                             }

echo "</p>              <br/><div class=\"piedForm\">
                         <input type=\"hidden\" name=\"validerform\" value=\"1\"/>
                         <input type=\"submit\" name=\"validerclient\" id=\"valid\" value=\"Changer de mot de passe\" />
                         </fieldset>
                         </div>
  </div>
 </form>";

}



?>

