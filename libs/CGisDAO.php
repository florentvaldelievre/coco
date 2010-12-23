
<?php

if(defined("__CGisDAO"))
    return;

define("__CGisDAO","");

include_once("CObjetBddDAO.php");



class CGisDAO extends CObjetBddDAO
{
    function __construct($mysql_res)
    {
        parent::CObjetBddDAO("villeinfo",$mysql_res);
    }
}

?>