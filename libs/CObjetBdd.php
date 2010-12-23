<?php

/**
 * @package ObjetBdd
 */

if(defined("__CObjetBdd"))
    return;

define("__CObjetBdd","");

/**
 * Un enregistrement d'une base de données
 * @package ObjetBdd
 */
class CObjetBdd
{
        /**
        * La liste des données sous la forme champ => variable
        * @var array
        */
	var $infos;

        /**
        * Constructeur de la classe
        */
	function CObjetBDD()
	{
		$this->infos = array();
	}

        /**
        * Modifie ou définit la valeur des champs de l'enregistrement
        * @param array $infos la liste des champs sous la forme champ => valeur
        */
	function set($infos)
	{

        foreach( $infos as $field => $value )
		{
			$this->infos[$field] = $value;
		}
	}

       /**
        * Modifie la valeur du champ spécifié
        * @param string $field nom du champ
        * @param mixed $value valeur
        */
	function setOne($field, $value)
	{
			$this->infos[$field] = $value;
	}
	
        /**
        * Recupére la valeur d'un champ
        * @param string $field
        */
	function get($field)
	{
		return $this->infos[$field];
	}
}
?>