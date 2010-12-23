<?
if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }


if($_POST[accept_annuler]) {
	
	            $_SESSION["cancelcomment"]=$_POST["cancelcomment"];
                echo "<meta http-equiv=refresh content=\"0; url=?action=annulerAnnonce_valider&idtr=".$_GET['idtr']."\">";
}
echo "
	    <div class=\"panelcentre\">
        <div class=\"boiteform\">
        <div class=\"bandeauform\">
         <h4>Annulation d'une demande </h4>
        </div>	         
 ";
echo "<fieldset id=\"confirmation_transport_fieldset\"><legend><strong>Confirmation</strong></legend>



<br /> - Attention, en annulant cette demande, les différents transporteurs le verront sur votre profil
<br /> - Le transporteur recevra un mail concernant cette annulation
<br /><br /><strong> Veuillez entrer le motif :</strong>
";


echo "<form name=\"accept_offre\" id=\"accept_offre\" method=\"post\" target=\"_self\" action=\"\" >";
 
 echo "                          <p align=\"center\">

                            <textarea name=\"cancelcomment\" COLS=40 ROWS=6 ></textarea>
                           </p>";
 
 
 echo " <input type=\"hidden\" name=\"accept_annuler\" value=\"1\"/>
         <input type=\"submit\" name=\"validerclient\" id=\"valid\" value=\"Valider l'annulation\" />";
         echo "</form></fieldset></div></div>";
 
?> 