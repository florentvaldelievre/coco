<?
$passwordsize=6;



if($_POST['valideperte']) {
   $cDAO = new CContactDAO($GLOBALS['mysql']);
   $contact = $cDAO->getByMail($_POST['mail']);
   if(checkEmail($_POST['mail']))
   {
   echo "Email erroné";
   echo "<meta http-equiv=refresh content=\"3; url=?action=accueil\">";
   }
   elseif(!$contact)
                {
                        echo "Désolé, Aucun compte avec cette adresse électronique n'existe à l'heure actuelle\nRetournez sur la page précédente et rééssayez avec une autre adresse.";
                }
   else
   {
   $cgDAO = new CContactGestion($GLOBALS['mysql']);
   $cgDAO->changePass($_POST['mail']);

   echo "un email avec votre nouveau mot de passe viens de vous étre envoyé";
   //echo "<meta http-equiv=refresh content=\"3; url=?action=accueil\">";
   }
}
else
{
 echo "<p>Envoi des identifiants<br/>

    Vous avez perdu ou tout simplement oublié vos identifiants de connexion ?<br/><br/>

    Pas de panique, il vous suffit de rentrer dans le formulaire ci-dessous l'adresse électronique <br/> avec laquelle vous vous étes inscrit(e) auparavant<br/>
    Un nouveau mot de passe vous sera envoyé</p>
       <form method=\"post\" target=\"_self\" action=\"\">
        <input type=\"text\" name=\"mail\" value=\"\" size=\"50\"><br><br/>
        <input class=\"form\" type=\"submit\" value=\"Envoyer\"><br><br/>
        <input type=\"hidden\" name=\"valideperte\" value=\"1\">
        </form>";
}
?>


