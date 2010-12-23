<?php
$marqueurPage= getMarqueurPage($_GET);
$marqueurTypeUser = "transporteur";

//mise en place des fonctions js
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"javascript/majloginform.js\"></script>";
echo "<script language=\"JavaScript\" type=\"text/javascript\"> majLoginForm('". $marqueurPage ."','". $marqueurTypeUser ."')</script>";

echo "<div class=\"panelcentre\" >";

//Boite info - connexion
echo "<div class=\"boiteinfo\">";

echo "<div class=\"bandeauinfo\"><img src=\"./images/style1/exclamation-blue.gif\" alt=\"icon_exclamation-blue\" /></div> ";

echo "<div class=\"boiteinfocontent\"><p>L'action que vous désirez effectuer nécessite d'être authentifié en tant qu'autocariste." .
		" Veuillez vous connecter à l'aide de vos identifiants </p>";

echo "<p>Si vous n'avez pas de compte, vous pouvez <a href=index?action=inscriptiontransport&marqueurTypeUser=".$marqueurTypeUser."&marqueurPage=".$marqueurPage.">créer un compte autocariste</a> dès maintenant.</p></div>";

echo "<div class=\"footinfo\"><img class=\"alignright\" src=\"./images/style1/exclamation-blue.gif\" alt=\"icon_exclamation-blue\" /></div>";

echo "</div>";

//Infos supplémentaire
echo "<div class=\"boitelight\"><div class=\"lightcontent\">La création d'un compte autocariste indispensable pour utiliser les services de BusWay. <br />Cette inscription est gratuite et sans engagement. Elle vous permettra notamment de répondre aux annonces, et d'augmenter la visibilité votre compagnie. La banque de voyages de BusWay est mise à jour en temps réel. Si vous ne connaissez pas encore le fonctionnement de BusWay, nous vous invitons à vous rendre sur notre page <a href=\"index.php?action=commentcamarche\">BusWay: Comment ca marche?</a> ainsi que sur <a href=\"index.php?action=faq\">la foire aux questions</a>.</div></div>";

echo "</div >";

?>


