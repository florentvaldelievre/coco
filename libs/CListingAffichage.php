<?php

if(defined("__CListingAffichage"))
    return;

define("__CListingAffichage","");


include_once("libs/util.php");


/*
 * @class CListingAffichage gere l'affichage html des fonctions d'Listing
 */
class CListingAffichage 
{

/*
 * affiche la ville si elle a une inférieure a la taille maximale, sinon affiche la ville tronquée + Listing
 * @param: int maxsize_ville nombre de caracteres maximale d'une ville
 * @param: string ville nom de la ville
 */

 	static function afficheDate(&$demandetr)
 	{
 		

 		$info = "";
 
			switch($demandetr->get("typetransport"))
			{
				
				case "transfert" :
					$info.="<span class=smalltext><strong>Voyage aller</strong></span><br />";
					$info.="<span class=smalltext>Départ le </span>".formatDateUsToFR($demandetr->get("datedepart"))." à ".formatdate($demandetr->get("heuredepart"),DATE_DELIMITER)."<br />";
					$info.="<span class=smalltext>Arrivée le </span>".formatDateUsToFR($demandetr->get("datearrive"))." à ".formatdate($demandetr->get("heurearrive"),DATE_DELIMITER)."<br />";
					if($demandetr->get("typetrajet")=="aller_retour")
					{
						$info.="<span class=smalltext><strong>Voyage retour</strong></span><br />";
						$info.="<span class=smalltext>Départ le </span>".formatDateUsToFR($demandetr->get("datedepartR"))." à ".formatdate($demandetr->get("heuredepartR"),DATE_DELIMITER)."<br />";
						$info.="<span class=smalltext>Arrivée le </span>".formatDateUsToFR($demandetr->get("datearriveR"))." à ".formatdate($demandetr->get("heurearriveR"),DATE_DELIMITER)."<br />";
					
					}
					break;
				case "dispo" :
					$info.="<span class=smalltext>Départ le </span>".formatDateUsToFR($demandetr->get("datedepart"))." à ".formatdate($demandetr->get("heuredepart"),DATE_DELIMITER)."<br />";
					$info.="<span class=smalltext>Retour le </span>".formatDateUsToFR($demandetr->get("datearrive"))." à ".formatdate($demandetr->get("heurearrive"),DATE_DELIMITER)."<br />";
					break;
				case "sejour" :
					$info.="<span class=smalltext>Départ le </span>".formatDateUsToFR($demandetr->get("datedepart"))." à ".formatdate($demandetr->get("heuredepart"),DATE_DELIMITER)."<br />";
					$info.="<span class=smalltext>Retour le </span>".formatDateUsToFR($demandetr->get("datearrive"))." à ".formatdate($demandetr->get("heurearrive"),DATE_DELIMITER)."<br />";					
					break;
			}
			return $info;
 	}
 	
 	
 	static function afficheDateSansHTML(&$demandetr)
 	{
 		$info = "";
 
			switch($demandetr->get("typetransport"))
			{
				
				case "transfert" :
					$info.="Voyage aller\n";
					$info.="Départ le ".formatDateUsToFR($demandetr->get("datedepart"))." à ".$demandetr->get("heuredepart")."\n";
					$info.="Arrivée le ".formatDateUsToFR($demandetr->get("datearrive"))." à ".$demandetr->get("heurearrive")."\n";
					if($demandetr->get("typetrajet")=="aller_retour")
					{
						$info.="Voyage retour\n";
						$info.="Départ le ".formatDateUsToFR($demandetr->get("datedepartR"))." à ".$demandetr->get("heuredepartR")."\n";
						$info.="Arrivée le ".formatDateUsToFR($demandetr->get("datearriveR"))." à ".$demandetr->get("heurearriveR")."\n";
					
					}
					break;
				case "dispo" :
					$info.="Départ le ".formatDateUsToFR($demandetr->get("datedepart"))." à ".$demandetr->get("heuredepart")."\n";
					$info.="Retour le ".formatDateUsToFR($demandetr->get("datearrive"))." à ".$demandetr->get("heurearrive")."\n";
					break;
				case "sejour" :
					$info.="Départ le ".formatDateUsToFR($demandetr->get("datedepart"))." à ".$demandetr->get("heuredepart")."\n";
					$info.="Retour le ".formatDateUsToFR($demandetr->get("datearrive"))." à ".$demandetr->get("heurearrive")."\n";					
					break;
			}
			return $info;
 	}
 	
 	
  	static function afficheTarifAdopte(&$demandetr,$devise)
 	{
 		$info = "";
 			switch($demandetr->get("tarifadopte"))
			{
				case 0 :
					$info.="-";
				break;
				
			  default:
				$info .=$demandetr->get("tarifadopte")."$devise";
				break;
			}
	return $info;

	}
 
 
}
