<?php

/**
 * @package ResultLimiter
 */

if(defined("__CResultLimiter"))
    return;

define("__CResultLimiter","");

/**
 * 	CResultLimiter permet de limiter les résultats d'une requete SQL à un certain intervalle
 */
class CResultLimiter
{
    /**
    * La liste des données sous la forme champ => variable
    * @var array
    */
	var $limitMin;
	var $limitMax;
	var $rangeSize;
	
    /**
    * Constructeur de la classe$
    * @param range = nombre de raw SQL a renvoyer
    */
	function __construct($limitMin=0, $rangeSize=1)
	{
		$this->rangeSize = $rangeSize;
		$this->limitMin = $limitMin;
		$this->limitMax = $rangeSize;		
	}

	/**
	 * fixe la taille de l'intervalle à sa valeur par défaut
	 */
	function setDefault($url)
	{
		$this->rangeSize = 5;
		$url->addRangeSizeElement(5);
		$this->limitMin = 0;
		$this->limitMax = $this->rangeSize;	
	}
	
	function nextRange()
	{
		$this->limitMin += $this->rangeSize;
		$this->limitMax += $this->rangeSize;
	}
	
	function previousRange()
	{
		if($this->limitMin - $this->rangeSize >= 0)
			$this->limitMin -= $this->rangeSize;
		else
			$this->range = 0;
		
		if($this->limitMax - $this->rangeSize >= 0)
			$this->limitMax -= $this->rangeSize;
		else
			$this->rangeSize = 0;
	}

	function __get($field)
    {
         if(!isset($this->field))
         {
         	return null;
         }
         return $this->field;
    }
}
?>