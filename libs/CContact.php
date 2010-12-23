<?php

if(defined("__CContact"))
    return;

define("__CContact","");

include_once("CObjetBdd.php");

/**
 * @package ObjetBdd
 */

/**
 * Représentation d'un contact lié a un utilisateur
 *
 * @package ObjetBdd
 */
class CContact extends CObjetBdd
{
    function CContact()
    {
        parent::CObjetBdd();
    }
}
 
?>