<?php



 if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }


 include_once("libs/mailmanager.php");
 
function checkNumberOnly($tarif) {
	if(ereg("[0-9]",$tarif))
	{
		return true;
	}
	return false;

}
if($_POST['validerform'])
{

	if(!checkNumberOnly($_POST['tarif'])) {
		$erreurs['tarif']="Le tarif doit être un nombre";
		echo "Le tarif doit être un nombre";
	}
	
   if( $erreurs == array() )
   {		
	    
	          
	    $query= "    SELECT mail,tarifttc FROM utilisateur u
							  NATURAL JOIN contact c 
							  INNER JOIN reponsetr R on (c.idutilisateur=R.idutilisateur ) 
							  WHERE ( R.iddemandetr = ".$_GET['idDtr']." AND R.idutilisateur=".$_GET['idU']." )  ";
	          
		    $DAO = new CObjetBddDAO("utilisateur",$GLOBALS['mysql']);     
		    $info_user = $DAO->getByCustomQuery($query);

	        
	            $expediteur = "moi@waybus.fr";
                $contenu="Votre derniere proposition pour la demande de transport n°".$_GET['idDtr']." est de ".$info_user[0]->get("tarifttc")."€<br />";
                $contenu.="Le voyageur vous fait une proposition de prix à ".$_POST['tarif']."€<br />";
                $contenu.="Pour lui faire une proposition de prix, allez dans le menu 'En attente de confirmation', Modifier, puis changez votre prix";               
                $objet="Un voyageur vous fait une proposition de prix à ".$_POST['tarif']."€ TTC";
                $destinataire = $info_user[0]->get("mail");               
				$singleton = MailManager::getInstance();
     			$singleton->Envoi_mail($destinataire,$contenu,$objet);
     			$singleton->ClearAddresses();
     		
	          
	            $_POST['url']="index.php?action=listing_newdemande_repondue";
				$_POST['message']="Nous avons avertis le transporteur de votre proposition de tarif";
                include("formulaires/redirectMessage.php");

	    }
   }


else
{


echo "<form name=\"tarif\" id=\"tarif\" method=\"post\" target=\"_self\" action=\"\">
         <div class=\"corpForm\">
        <fieldset id=Informations>
                    <legend>Faire une proposition</legend>
                                        <br/>
                                        <p>
                                        <label for=\"tarif\" title=\"Proposition tarif\" >Proposition de tarif :</label>
                                        <input type=\"text\" name=\"tarif\" value=\"\" title=\"Proposition tarif\" />€";



echo "</p>

        <br/><div class=\"piedForm\">
                         <input type=\"hidden\" name=\"validerform\" value=\"1\"/>
                         <input type=\"submit\" name=\"validerclient\" id=\"valid\" value=\"Envoyer la proposition\" />
                         </fieldset>
                         </div>
  </div>
 </form>";

}



?>

