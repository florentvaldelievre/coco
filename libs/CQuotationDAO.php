<?php

if(defined("__CQuotationDAO"))
    return;

define("__CQuotationDAO","");

include_once("CObjetBddDAO.php");

/**
 * @package ObjetBddDAO
 */

/**
 * CQuotationDAO gére l'acces aux données (DAO) liées à un objet CUtilisateur
 *
 * @package ObjetBddDAO
 */

class CQuotationDAO extends CObjetBddDAO
{
    function __construct($mysql_res)
    {
        parent::CObjetBddDAO("quotation",$mysql_res);
    }
}

?>