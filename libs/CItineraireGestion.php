<?php

if(defined("__CItineraireGestion"))
    return;

define("__CItineraireGestion","");

include_once("CItineraire.php");
include_once("CItineraireDAO.php");


/*
 * CItineraireGestion gere les manipulations et operations relatives aux etapes
 */
class CItineraireGestion
{
/*
 * Un objet de gestion DAO
 * @var CItineraireDAO
 */
    var $itineraireDAO;
/*
 * Une ressource CMySQL
 * @var CMySQL
 */   
    var $mysql_res="";

    function __construct($mysql_res)
    {
        $this->mysql_res = $mysql_res;
        $this->itineraireDAO = new CItineraireDAO($mysql_res);
    }
    
/*
 * renvoie la liste des etapes
 * @param: int iddemandetr l id de la demandetr associée
 * @return: CObjetBDD[] la liste des etapes
 */
 	function getItineraire($iddemandetr)
 	{
 		$infos = array( "iddemandetr" => $iddemandetr);
 		$etapesbdd = $this->itineraireDAO->getAllBy($infos);
 		return $etapesbdd;
 	}
  
  
/*
 * insere un nouvel itineraire dans la bdd
 * @param: string[] les etapes
 * @param: int iddemandetr l id de la demandetr associée
 */
 	function nouvelItineraire($etapes, $iddemandetr)
 	{

 		 		
 		$etapeInfos["iddemandetr"] = $iddemandetr;
 							
 		$etapebdd = new CItineraire();
 		
 			foreach($etapes as $numEtape => $etape )
 			{
 			
 				
 				
 				$etapeInfos["numetape"] = $numEtape;
 				$etapeInfos["ville"] = $etape["placename"];
 				$etapeInfos["codepostal"] = $etape["codepostal"];
 				$etapeInfos["countrycode"] = $etape["countrycode"];
 				$etapebdd->set($etapeInfos); 
 				$this->itineraireDAO->insert($etapebdd);
 			}
 	}
 	
/*
 * supprime un itineraire de la bdd
 * @param: int iddemandetr l id de la demandetr dont les etapes sont a supprimer
 */ 	
 	function deleteItineraire($iddemandetr)
 	{
		$etapesASupprimer = $this->getItineraire($iddemandetr);
		foreach($etapesASupprimer as $etape)
		{
			$this->itineraireDAO->_delete($etape);
		}
 	}
 	

 /*
  * met a jour en bdd les iddemandeTr d un iteneraire
  * @param: int currentIddemandetr la valeur de iddemandetr a modifier
  * @param: newIddemandetr la valeur
  */
	function updateIddemandetr($currentIddemandetr,$newIddemandetr)
	{
		$etapesAModifier = $this->getItineraire($currentIddemandetr);
		foreach($etapesAModifier as $etape)
		{
			$etape->setOne("iddemandetr",$newIddemandetr);
			$this->itineraireDAO->update($etape);
		}
	}

}
 
