<?php

if(defined("__COverlibAffichage"))
    return;

define("__COverlibAffichage","");


/*
 * @class COverlibAffichage gere l'affichage html des fonctions d'Overlib
 */
class COverlibAffichage 
{
 
/*
 * Une chaine de caractere contenant le code html appelant la fonction overlib
 * @var htmltext
 */
   
   // pas encore exploité
   // var $htmltext;


  
/*
 * affiche la ville si elle a une inférieure a la taille maximale, sinon affiche la ville tronquée + overlib
 * @param: int maxsize_ville nombre de caracteres maximale d'une ville
 * @param: string ville nom de la ville
 */

 	static function coupeVille($maxsize_ville,$ville)
 	{
            if(strlen($ville) > $maxsize_ville)
            {
             echo "<span class=\"etapeBullet\" onmouseover=\"return overlib('".$ville."',FGCOLOR, '#FFFFCC', WIDTH,'150');\" onmouseout=\"return nd();\">".substr($ville, 0, $maxsize_ville)."...</span>";
            }
             else
             {
             echo "<span class=\"etapeBullet\">$ville</span>";
             }
 	}
 	
 	
 	
 	static function afficheInfoAnnonceOverlib(&$demandetr)
 	{
 	     $info = "";	  	
 	     $itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
 	     $listeEtapes = $itineraireGestion->getItineraire($demandetr->get("iddemandetr"));

		//plusieurs Variables info pour rendre le JS XHTML compliant , > remplacé par &gt; ...		
 	     $infoInit .=  "<a href=\"javascript:void(0)\" title=\"Voir annonce n°".$demandetr->get("iddemandetr")."\" onclick=\"return overlib( '";
 	     $infoJs .= "Ajoutée le ".$demandetr->get("date")."<br /><br />";
 	     
 	     $infoJs.="<strong>Etapes </strong><br />";
							
							foreach($listeEtapes as $etape)
							{
								$infoJs .=  $etape->get("ville")." ".$etape->get("codepostal")."<br />";
							}
						$infoJs .=  "<br />";
						$infoJs .= CListingAffichage::afficheDate($demandetr,1);					


						$infoJs .=  "<br />Kilométrage en charge : ".$demandetr->get("kilometragealler")."<br />";
						$infoJs .=  "Doublage conducteur : "; if($demandetr->get("doublagealler")=="true"){ $infoJs .=  "Oui"; } else { $infoJs .=  "Non"; } 
						$infoJs .=  "<br /><br /><strong>Information transport</strong><br />Type de car : ".$demandetr->get("typecar")."<br />";
						$infoJs .=  "Nombre de pers. ".$demandetr->get("capacitenecessaire")."<br />";
						$infoJs .=  "Nombre de Bus : "; if($demandetr->get("nbrbus")=="") $infoJs .= "N/C"; else $infoJs.= $demandetr->get("nbrbus"); $infoJs .="<br />";
						$infoJs .=  "Places par bus : "; if($demandetr->get("placesparbus")=="") $infoJs .= "N/C"; else $infoJs.= $demandetr->get("placesparbus"); $infoJs .="<br /><br />";


						$infoJs .=  "<strong>Prise en charge conducteur</strong><br />";
						$infoJs .=  "Repas non pris en charge : ".$demandetr->get("nbrrepastotal")."<br />";
						$infoJs .=  "Nuits non prises en charges : ".$demandetr->get("nbrnuittotal")."<br /><br />";
						$infoJs .=  "<strong>Commentaire</strong><br />".str_replace("\r\n","<br />",addslashes($demandetr->get("dcommentaires")))."<br /><br />";
						$infoJs .=  "<strong>Tarif : <font color=red>".$demandetr->get("tarifadopte")." €</font></strong>',CAPTION,'<strong>".$demandetr->get("typetransport")." n°". $demandetr->get("iddemandetr")."</strong>',CAPTIONPADDING,'4',FGCOLOR, '#FDFDFD',WIDTH, '280',STICKY,CGBACKGROUND,'images/shade_caption.gif',PRINT,PRINTCOLOR,'#132884',DRAGGABLE,CLOSECLICK,CLOSECOLOR,'#132884', TEXTSIZE,'10px');\" ";


					$infoEnd = "onmouseout=\"return nd();\"><img src=\"images/style1/magnifier.gif\" alt=\"Voir annonce\"/></a>";                             
 	
			$infoJs = str_replace("<" , "&lt;" , $infoJs );
 			$infoJs = str_replace(">" , "&gt;" , $infoJs );
 			
 			$info =  $infoInit.$infoJs.$infoEnd;
 	return $info;
 	}
	
	static function afficheCommissionOnMouseOver(&$demandetr)
	 	{
	 		
	 		$info=  "<span onmouseover=\"return overlib('Ce prix indique la commission de ".intval(PERCENT_PRICE*100)." %(arrondie) du prix du voyage.<br /> &nbsp;".$demandetr->get("tarifttc")."*".PERCENT_PRICE." = <strong>".$demandetr->get("prixfacture")."€</strong>', TEXTSIZE,'x-small');\" onmouseout=\"nd();\">";
			$info.="<strong><font color=\"red\">+".$demandetr->get("prixfacture")."€</font></strong></span>";
	 		return $info;
	 	}
	
	
	
	static function afficheAcceptOffreOnMouseOver(&$reponsetr)
	{
		$info = "<a onmouseover=\"return overlib('Etape <strong>1</strong>/2 <br />- Attention, en acceptant l\'offre, vous vous engager aupres du transporteur à la respecter. <br /><strong>Cliquez</strong> pour aller à l\'etape suivante' , TEXTSIZE,'x-small');\" onmouseout=\"nd();\" class=\"acceptOffre\" href=\"?action=accept_offre_transport&amp;idRtr=".$reponsetr->get("idreponsetr")."&amp;idDtr=".$reponsetr->get("iddemandetr")." \">Accepter</a>";
		return $info;		
	}
	
	static function affichePropositionOnMouseOver(&$reponsetr)
	{
		$info = "<a onmouseover=\"return overlib('Etape <strong>1</strong>/2 <br />- Si vous trouvez que le transporteur affiche un tarif trop important, vous pouvez lui proposer un autre montant.<br /> Il recevra un mail concernant votre proposition', TEXTSIZE,'x-small');\" onmouseout=\"nd();\" href=\"?action=proposition_tarif&amp;idU=".$reponsetr->get("idutilisateur")."&amp;idDtr=".$reponsetr->get("iddemandetr")."\" class=\"proposition\">Négocier prix</a>";
		return $info;	
	}	
}
 
