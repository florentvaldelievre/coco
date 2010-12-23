<?

if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }
$maxsize_ville=9;

if(isset($_GET["s"]))
    $start=$_GET["s"];
else
    $start=0;
if(isset($_GET["n"]))
    $nbr_annonce=$_GET["n"];
else
    $nbr_annonce=10;
$limitTag = "LIMIT $start,$nbr_annonce";
	
	$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
	
	$query_reponsetr = " SELECT * , DATE_FORMAT( datereponse, '%d-%m-%Y %H:%i:%s' ) AS datefr
	FROM demandetr, reponsetr
	WHERE (
	TO_DAYS( NOW( ) ) - TO_DAYS( datereponse ) <= 7
	AND reponsetr.iddemandetr = demandetr.iddemandetr
	)
	GROUP BY demandetr.iddemandetr
	ORDER BY date DESC";
	

 $rDAO = new CObjetBddDAO("reponsetr",$GLOBALS['mysql']);
 $listing_reponsetr = $rDAO->getByCustomQuery($query_reponsetr) or $listing_reponsetr = array();                     

/*
            $query = "SELECT *, DATE_FORMAT( datereponse, '%d-%m-%Y %H:%i:%s' ) AS datefr2 FROM utilisateur NATURAL JOIN contact NATURAL JOIN reponsetr WHERE reponsetr.iddemandetr = ".$reponsetr->get("iddemandetr")."";
            $DAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
            $liste_reponsetr = $DAO->getByCustomQuery($query) or $liste_reponsetr=array();
*/
   	     echo "<h3 class=\"hcentre\">Transporteurs ayant répondu aux annonces ces sept derniers jours</h3>
			
		<div class=\"centre\">
	<table class=\"tablist\" cellspacing=\"0\"><caption>Liste des demandes répondues</caption>
	<thead>
	   <tr>
			<th>Ref.Transport</th>
			<th>itinéraire</th>
			<th>date et heure départ</th>
	
			<th>Nb de pers.</th>
			<th>Nb de cars </th>
			<th>Tarif Adopté voyageur</th>

			
	   </tr>
	</thead>
	<tbody>";
	

foreach( $listing_reponsetr as $reponsetr)
{


 if(count($listing_reponsetr)>0)
            {
  				$listeEtapes = $itineraireGestion->getItineraire($reponsetr->get("iddemandetr"));
         			
				echo"<tr onmouseover=\"fOver(this);\" onmouseout=\"fOut(this);\">";
			    
			    //Ref.Transport
			    echo"<td><a href=\"javascript:void(0)\" onclick=\"return overlib('<br /><b>Voyage</b><br />Départ de : ".$reponsetr->get("villedepart")." <br /> Arrivé à : ".$reponsetr->get("villearrive")."<br />Date du départ : ".$reponsetr->get("datedepart")." à ".$reponsetr->get("heuredepart")."<br />Date de retour : ".$reponsetr->get("datearrive")." à ".$reponsetr->get("heurearrive")."<br />Kilométrage en charge : ".$reponsetr->get("kilometragealler")."<br /><br /><b>Information transport</b><br />Type de car : ".$reponsetr->get("typecar")."<br />Nombre de Bus : ".$reponsetr->get("nbrbus")."<br />Places par bus : ".$reponsetr->get("placesparbus")."<br /><br /><b>Prise en charge conducteur</b><br />Repas non pris en charge : ".$reponsetr->get("nbrrepastotal")."<br />Nuits non prises en charges : ".$reponsetr->get("nbrnuittotal")."<br /><br /><b>Commentaire</b><br />".str_replace("\r\n","<br />",$reponsetr->get("dcommentaires"))."<br /><br /><b>Tarif initial de : <font color=red>".$reponsetr->get("tarifadopte")." €</font></b>',CAPTION,'<b>".$reponsetr->get("typetransport")." n°". $reponsetr->get("iddemandetr")."</b>',CAPTIONPADDING,'4',FGCOLOR, '#FDFDFD',WIDTH, '280',STICKY,CGBACKGROUND,'images/shade_caption.gif',PRINT,PRINTCOLOR,'#132884',DRAGGABLE,CLOSECLICK,CLOSECOLOR,'#132884', TEXTSIZE,'10px');\" onmouseout=\"return nd();\"><img src=\"images/loupe.gif\"></img></a>&nbsp;&nbsp;".$reponsetr->get("typetransport")." n°". $reponsetr->get("iddemandetr")."</td>";
				
				//Itinéraire
				echo"<td>";	
				foreach($listeEtapes as $etape)
				{
					COverlibAffichage::coupeVille(MAXSIZE_VILLE,$etape->get("ville"));
					echo "<br />";
				}
				echo"</td>";
				
				//Date et heure depart
				echo"<td>";
				echo CListingAffichage::afficheDate($reponsetr);
				echo"</td>";		
          


                           echo "
 						
  							<td>
 							".$reponsetr->get("capacitenecessaire")."</td>						

  							<td>";

 						  $nbr_bus=$reponsetr->get("nbrbus");
                           if( empty( $nbr_bus ) )
                           {
                           	echo "N/C";
                           }
                           else
                           {
                           	echo $reponsetr->get("nbrbus");
                           }
							".</td>";
							
						echo	"<td>".$reponsetr->get("tarifttc")."€</td>";

                           echo "</td></tr>"; 
            }
	
}

	if(count($listing_reponsetr)>9){	
		
        echo "<br />Page: ";  
            for($i=1;$i<$nbr_page+1;$i++)
            {
                echo "<a href=".$_SERVER['PHP_SELF']."?action=".$_GET['action']."&s=".($nbr_annonce*($i-1))."&n=".($nbr_annonce)." >".$i." </a>";
            }
	}

?>
