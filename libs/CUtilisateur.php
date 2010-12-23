<?php

if(defined("__CUtilisateur"))
    return;

define("__CUtilisateur","");

include_once("CObjetBdd.php");
/**
 * @package ObjetBdd
 */
 
/**
 * Représentation d'un utilisateur
 *
 * @package ObjetBdd
 */
class CUtilisateur extends CObjetBdd
{
    function CCUtilisateur()
    {
        parent::CObjetBdd();
    }
}


?>