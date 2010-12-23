<?php

if(defined("__CItineraire"))
    return;

define("__CItineraire","");

include_once("CObjetBdd.php");

/**
 * @package ObjetBdd
 */

/**
 * Représentation d'une quotation
 *
 * @package ObjetBdd
 */
class CItineraire extends CObjetBdd
{
    function __construct()
    {
        parent::CObjetBdd();
    }
}



 
?>