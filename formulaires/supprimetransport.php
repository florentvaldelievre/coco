<?php




if(isset($_SESSION['username']))
{
$iddemandetr =$_GET['iddemandetr'];
  

 
 if($_POST['validerform'])
{

   
    if($_SESSION["typeutilisateur"]=="client")
        $dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);	
    else
    	$dtrDAO = new CObjetBddDAO("reponsetr",$GLOBALS['mysql']);
   
    $infos["dtag"]="supprimer";
    $infos["iddemandetr"]=$_GET["iddemandetr"];

   $demandetr = $dtrDAO->getBy( array ( "iddemandetr" =>  $iddemandetr , "idutilisateur" => $_SESSION['idutilisateur'] ));
   $dTR = new CObjetBDD();
   $dTR->set($infos);
   $dtrDAO->update($dTR);
  


   // require("consulter_annonceRSS.php"); //écriture du fichier XML
  
        $_POST['url']="index.php?action=listing_newdemande";
	$_POST['message']="Demande de transport  n°$iddemandetr  supprimée";
    include("formulaires/redirectMessage.php");
           


}
else
{
      $dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
      $demandetr = $dtrDAO->getBy( array ( "iddemandetr" => $iddemandetr ));
      $itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
      $listeEtapes = $itineraireGestion->getItineraire($demandetr->get("iddemandetr"));
      
    echo "<form name=\"supprimetransport\" id=\"supprimetransport\" method=\"post\" target=\"_self\" action=\"\">
             <div class=\"corpForm\">
            <fieldset id=Informations>
                        <legend>Supprimer une demande de transport</legend>
                        <br/>
                        <span>êtes vous sur de vouloir supprimer la demande <strong>n°$iddemandetr</strong></span><br /><br />";


				foreach($listeEtapes as $etape)
				{
					echo "<li>".$etape->get("ville")."</li>";
				}
				



             echo "   <br/><div class=\"piedForm\">
                             <input type=\"hidden\" name=\"validerform\" value=\"1\"/>
                             <input type=\"submit\" name=\"validerclient\" id=\"valid\" value=\"Supprimer\" />
                             </fieldset>
                             </div>
      </div>
     </form>";
}
}


?>