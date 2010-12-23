<?php

if(defined("__CGis"))
    return;

define("__CGis","");

include_once("CObjetBdd.php");



class CGis extends CObjetBdd
{
    function __construct()
    {
        parent::CObjetBdd();
    }
}

?>