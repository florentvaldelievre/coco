<?php


if(isset($_SESSION['username']) && ($action == "compare")) { 
        $DAO = new CObjetBddDAO("reponsetr",$GLOBALS['mysql']);  
        $query = "SELECT *
                     FROM reponsetr
                     NATURAL JOIN contact
					 NATURAL JOIN utilisateur
                     WHERE";
       
  $liste_get=$_GET['cmp'];
  $liste_get=explode(' ',$liste_get);
  $i=1;
  foreach($liste_get as $comparer)
  {
      if(count($liste_get)==$i)
      {
      $compare.= " reponsetr.idreponsetr = ".$liste_get[$i-1];   
      }
      else
      {
      $compare.= " reponsetr.idreponsetr = ".$liste_get[$i-1]." OR";   
      }
  $i++;
  }

$liste_compare = $DAO->getByCustomQuery($query.$compare); 
                  
$listechamp = array( "username" => "<strong>Utilisateur :</strong>","nbrconducteur" => "<strong>Nombre de conducteur(s) :</strong>","nbrcar" => "<strong>Nombre de bus :</strong>","capacitecar" => "<strong>Places par bus :</strong>","equipement" => "<strong>Spécificité du bus :</strong>","tarifttc" => "<strong>Tarif :</strong>");
  
  echo "<table align=\"center\" border=\"0\" cellpadding=\"6\" cellspacing=\"0\">";

  foreach( $listechamp as $champ => $label )
 {   

     echo "<tr class=\"line-odd\">";
          echo "<td >".$label."</td>";
          foreach($liste_compare as $reponsetr) 
          {  
             if($champ=="username") 
             {
             
              echo "<td class=\"line2left\"><a href=\"?action=profil&amp;id=".$reponsetr->get("idutilisateur")."\"><i>".$reponsetr->get("nomclient")."</i></td>"; 
             }
             else
             {
              echo "<td class=\"line2left\">".$reponsetr->get($champ)."</td>";
             } 
          }
     echo "</tr>";
}
 echo "</table>";

}   
?>