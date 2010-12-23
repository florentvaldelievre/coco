<?php
if(defined("__CFacturesGestion"))
    return;

define("__CFacturesGestion","");

include_once("CFacturesDAO.php");


class CFacturesGestion
{

/*
 * Un objet de gestion DAO
 * @var $facturesDAO
 */
    var $facturesDAO;
/*
 * Une ressource CMySQL
 * @var CMySQL
 */
    var $mysql_res="";

    function __construct($mysql_res)
    {
        $this->mysql_res = $mysql_res;
        $this->facturesDAO = new CFacturesDAO($mysql_res);
    }
 
 function viewFactures($idutilisateur)
	{

		$query_facture = "SELECT * FROM factures r 
						 NATURAL JOIN contact 
						 NATURAL JOIN reponsetr  
						INNER JOIN transport ON (reponsetr.idreponsetr = transport.idreponsetr )
						INNER JOIN demandetr ON ( transport.iddemandetr = demandetr.iddemandetr )
						 where reponsetr.idutilisateur = ". $idutilisateur." Order by demandetr.iddemandetr DESC";
						

		$res = $this->facturesDAO->getByCustomQuery($query_facture); 
				
 		return $res;		
	}
	
	//AND (idfactures=3 OR idfactures=1)
	/*
	 * $selectedFactures : tableau d'idfactures Array ( [listeFactures] => Array ( [0] => 1 [1] => 3 ) )
	 * @return un tableau contenant pour chaque factures selectionnées les détails du trajet
	 */
  function viewFacturesWithSelectedFactures($idutilisateur,$selectedFactures)
  {

  					$elt=1;
					foreach( $selectedFactures as $key => $value)
					
					{
							if($elt == count($selectedFactures))
							{
								$or_list .= " idfactures = '$value' )";
								
							}
							else
							{
								$or_list .= "idfactures = '$value' OR ";
							}
						$elt++;

					}
					
  			
  		$query_facture = "SELECT * FROM factures r 
						 NATURAL JOIN contact 
						 NATURAL JOIN reponsetr  
						INNER JOIN transport ON (reponsetr.idreponsetr = transport.idreponsetr )
						INNER JOIN demandetr ON ( transport.iddemandetr = demandetr.iddemandetr )
						 where reponsetr.idutilisateur = ". $idutilisateur." AND (". $or_list."";
				


		$res = $this->facturesDAO->getByCustomQuery($query_facture); 
				
 		return $res;
 		
  }	
  
  
  
   
}
    
?>
