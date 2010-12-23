<?php

if(defined("__CTransporteurpaysDAO"))
    return;

define("__CTransporteurpaysDAO","");

include_once("CObjetBddDAO.php");

/**
 * @package ObjetBddDAO
 */

/**
 * CTransporteurpaysDAO gére l'acces aux données (DAO) liées à un objet CTransporteurpays
 *
 * @package ObjetBddDAO
 */

class CTransporteurpaysDAO extends CObjetBddDAO
{
    function __construct($mysql_res)
    {
        parent::CObjetBddDAO("transporteurdpt_type",$mysql_res);
    }
}

?>