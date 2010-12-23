<?php
class CAffichageAnnonceVoyageur {
	
	
	
	static function getInfoAnnonceVoyageur($demandetr,$etapes) {
	
		 	     $contenu.="<strong>Etapes </strong><br />";
							
							foreach($etapes as $etape)
							{
								$contenu .=  $etape->get("ville")."<br />";
							}
						$contenu .=  "<br />";
						$contenu .= CListingAffichage::afficheDate($demandetr);					


						$contenu .=  "<br />Kilométrage en charge : ".$demandetr->get("kilometragealler")."<br />";
						$contenu .=  "Doublage conducteur : "; if($demandetr->get("doublagealler")=="true"){ $contenu .=  "Oui"; } else { $contenu .=  "Non"; } 
						$contenu .=  "<br /><br /><strong>Information transport</strong><br />Type de car : ".$demandetr->get("typecar")."<br />";
						$contenu .= "Nombre de pers. ".$demandetr->get("capacitenecessaire")."<br />";
						$contenu .=  "Nombre de Bus : "; if($demandetr->get("nbrbus")=="") $contenu .= "N/C"; else $contenu.= $demandetr->get("nbrbus"); $contenu .="<br />";
						$contenu .=  "Places par bus : "; if($demandetr->get("placesparbus")=="") $contenu .= "N/C"; else $contenu.= $demandetr->get("placesparbus"); $contenu .="<br /><br />";

						$contenu .=  "<strong>Prise en charge conducteur</strong><br />";
						$contenu .=  "Repas non pris en charge : ".$demandetr->get("nbrrepastotal")."<br />";
						$contenu .=  "Nuits non prises en charges : ".$demandetr->get("nbrnuittotal")."<br /><br />";
						$contenu .=  "<strong>Commentaire</strong><br />".str_replace("\r\n","<br />",addslashes($demandetr->get("dcommentaires")))."<br /><br />";
						$contenu .=  "<strong>Tarif : <font color=red>".$demandetr->get("tarifadopte")." €</font></strong> ";
	
	return $contenu;
		
	}
	

	
}
?>
