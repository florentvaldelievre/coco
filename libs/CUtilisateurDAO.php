<?php

if(defined("__CUtilisateurDAO"))
    return;

define("__CUtilisateurDAO","");

include_once("CObjetBddDAO.php");

/**
 * @package ObjetBddDAO
 */

/**
 * CUtilisateurDAO gére l'acces aux données (DAO) liées à un objet CUtilisateur
 *
 * @package ObjetBddDAO
 */

class CUtilisateurDAO extends CObjetBddDAO
{
    function CUtilisateurDAO($mysql_res)
    {
        parent::CObjetBddDAO("utilisateur",$mysql_res);
    }
}

?>