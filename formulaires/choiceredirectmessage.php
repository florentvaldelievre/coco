<?php

echo "<div class=\"panelcentre\" >";

//Boite info - choix redirection
echo "<div class=\"boiteinfo\">";

echo "<div class=\"bandeauinfo\"><img src=\"./images/style1/exclamation-blue.gif\" alt=\"icon_exclamation-blue\" /></div> ";

echo "<div class=\"boiteinfocontent\"><p>Souhaitez-vous poursuivre l'action qui nécessitait d'être authentifié ?</p>";
echo "<a class=\"boiteinfolinkleft\" href=\"index.php\"> aller à ma page d'acceuil </a> <a class=\"boiteinfolinkright\" href=\"index.php?".$redirurl."\"> continuer</a>";
echo "</div>";
echo "<div class=\"footinfo clearboth\"><img class=\"alignright\" src=\"./images/style1/exclamation-blue.gif\" alt=\"icon_exclamation-blue\" /></div>";

echo "</div>";


echo "</div >";

?>
