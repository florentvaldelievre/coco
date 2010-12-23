<?php

if(defined("__CListing"))
    return;

define("__CListing","");

include_once("CObjetBdd.php");

/**
 * @package ObjetBdd
 */

/**
 * Représentation d'une liste de demande'
 * @package ObjetBdd
 */
class CListing extends CObjetBdd
{
    function __construct()
    {
        parent::CObjetBdd();
    }
}



 
?>