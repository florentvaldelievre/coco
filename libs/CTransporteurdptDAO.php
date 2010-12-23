<?php

if(defined("__CTransporteurdptDAO"))
    return;

define("__CTransporteurdptDAO","");

include_once("CObjetBddDAO.php");

/**
 * @package ObjetBddDAO
 */

/**
 * CTransporteurdptDAO gére l'acces aux données (DAO) liées à un objet CTransporteurdpt
 *
 * @package ObjetBddDAO
 */

class CTransporteurdptDAO extends CObjetBddDAO
{
    function __construct($mysql_res)
    {
        parent::CObjetBddDAO("transporteurdpt",$mysql_res);
    }
    
	
	/*
	 * CObjetBdd Object ( [infos] => Array ( [selectiontype] => ONLY_DPTS ) )
	 */
	function getSelectionType($idutilisateur) {
		
	$query = "SELECT selectiontype from transporteurdpt_type WHERE idutilisateur = $idutilisateur LIMIT 1";		
	$res = $this->getByCustomQuery($query);
	return $res[0];
		
	}
	
	
	function getDptsList($idutilisateur)
	{
	
		$query = "SELECT iddepartement from transporteurdpt WHERE idutilisateur = $idutilisateur";
		return $this->getByCustomQuery($query);
	}
	
}

?>