<?php

if(defined("__CContactDAO"))
    return;

define("__CContactDAO","");

include_once("CObjetBddDAO.php");

/**
 * @package ObjetBddDAO
 */

/**
 * CContactDAO gére l'acces aux données (DAO) liées à un objet CContact
 *
 * @package ObjetBddDAO
*/
class CContactDAO extends CObjetBddDAO
{
    function CContactDAO($mysql_res)
    {
        parent::CObjetBddDAO("contact",$mysql_res);
    }

   /**
    * Cherche un contact selon son mail
    * @param  string $mail un mail
    * @return CObjetBdd    un objet satisfaisant les critéres de la recherche
    */
    function getByMail($mail)
    {
        return $this->getBy(array( "mail" => $mail ));
    }
}

?>