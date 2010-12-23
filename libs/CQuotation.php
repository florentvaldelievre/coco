<?php

if(defined("__CQuotation"))
    return;

define("__CQuotation","");

include_once("CObjetBdd.php");

/**
 * @package ObjetBdd
 */

/**
 * Représentation d'une quotation
 *
 * @package ObjetBdd
 */
class CQuotation extends CObjetBdd
{
    function __construct()
    {
        parent::CObjetBdd();
    }
}



 
?>