<?php

if(defined("__CItineraireDAO"))
    return;

define("__CItineraireDAO","");

include_once("CObjetBddDAO.php");

/**
 * @package ObjetBddDAO
 */

/**
 * CItineraireDAODAO gére l'acces aux données (DAO) liées à un objet CUtilisateur
 *
 * @package ObjetBddDAO
 */

class CItineraireDAO extends CObjetBddDAO
{
    function __construct($mysql_res)
    {
        parent::CObjetBddDAO("etape",$mysql_res);
    }
}

?>