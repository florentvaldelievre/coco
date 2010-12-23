<?php

if(defined("__CFiltreGeneriqueDao"))
    return;

define("__CFiltreGeneriqueDao","");

include_once("CFiltreGeneriqueDao.php");
include_once("CFiltreGenerique.php");


/**
 * CFiltreGeneriqueDao permet la construction de filtres a partir d'une dao'
 *
 * @package CFiltreGeneriqueDao
 */

class CFiltreGeneriqueDao extends CFiltreGenerique
{
    function __construct($name,$true_name,$dao)
    {
        parent::__construct($name,$true_name,$dao->getMin($name),$dao->getMax($name));
    }
}

?>