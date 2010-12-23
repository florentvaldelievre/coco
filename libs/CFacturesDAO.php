<?php
if(defined("__CFacturesDAO"))
    return;

define("__CFacturesDAO","");

include_once("CObjetBddDAO.php");

/**
 * @package ObjetBddDAO
 */

/**
 * CFacturesDAO gére l'acces aux données (DAO) liées à un objet Cfactures
 *
 * @package ObjetBddDAO
 */
 


class CFacturesDAO extends CObjetBddDAO
{
    function __construct($mysql_res)
    {
        parent::CObjetBddDAO("factures",$mysql_res);
        
    }
 

}

?>
