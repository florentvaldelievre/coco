<?php

if(defined("__CListingDAO"))
    return;

define("__CListingDAO","");

include_once("CObjetBddDAO.php");

/**
 * @package ObjetBddDAO
 */

/**
 * CListingDAO gére l'acces aux données (DAO) liées à un objet CListing
 *
 * @package ObjetBddDAO
 */

class CListingDAO extends CObjetBddDAO
{
    function __construct($mysql_res)
    {
        parent::CObjetBddDAO("demandetr",$mysql_res);
    }
}

?>