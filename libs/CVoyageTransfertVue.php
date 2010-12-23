<?php

if(defined("__CVoyageTransfertVue"))
    return;

define("__CVoyageTransfertVue","");

  include_once('libs/CVoyageVue.php');

class CVoyageTransfertVue extends CVoyageVue
{
    function __construct($modif = false)
    {
        parent::__construct('transfert',$modif);
    }
}

?>