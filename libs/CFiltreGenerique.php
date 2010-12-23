<?php
//define("NombredeFiltre",4);
    
  include_once("libs/CListingGestion.php");


class CFiltreGenerique {
	
	static $NombredeFiltre = 4;
	
	var $listingGestion;
	
	var $name;
	
	var $true_name;

	var $minValue;	
	
	var $maxValue;
	
	var $step;
	
	var $gererURL;
	
	

	function __construct($name,$true_name,$min,$max) {
	
		$this->listingGestion = new CListingGestion($GLOBALS['mysql']);		
		$this->name=$name;
		$this->true_name=$true_name;
		$this->minValue=$min;
		$this->maxValue=$max;
		$reste = (($max-$min+1)) % self::$NombredeFiltre;
		if($reste != 0 )
		{
			$this->maxValue += self::$NombredeFiltre - $reste;
		}		
		$stepvalue=($this->maxValue-$this->minValue+1)/self::$NombredeFiltre;	
		$stepvalue = floor($stepvalue);
		$this->step = $stepvalue;	
	}
	
	
    public  function __destruct() {
  
 		
   }
}
?>
