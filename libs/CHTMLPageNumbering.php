<?php
if(defined("__CHTMLPageNumbering"))
    return;

define("__CHTMLPageNumbering","");

class CHTMLPageNumbering
{
	var $numPageToDisplay;
	
	function __construct($resultLimiter, $nbrows, $url, $numPageToDisplay = 5)
	{
		//$this->numPageToDisplay = $numPageToDisplay;
		$this->numPageToDisplay = $resultLimiter->rangeSize;
		$this->display($resultLimiter, $nbrows, $url);
	}
	
	function  display($resultLimiter, $nbrows, $url)
	{
		//calcul des parametres -- a séparer dans une autre méthode ultérieurement / passer les paramètres en champ de la classe
		if($nbrows == 0 or $resultLimiter == null or $url == "") return;
	
		$nbpages = floor($nbrows / $resultLimiter->rangeSize);
		
		if($nbrows % $resultLimiter->rangeSize != 0)
		{
			$nbpages++;
		}
		
		$currentPage = floor($resultLimiter->limitMin / $resultLimiter->rangeSize);
		
		$beginPos = 0;
		$endPos = $nbpages;
		
		if($nbpages > $this->numPageToDisplay)
		{
			if($currentPage > floor(($this->numPageToDisplay / 2)))
			{
				$beginPos = $currentPage - floor(($this->numPageToDisplay / 2));
			}
			else 
			{
				$beginPos = 0;
			}
			
			if($currentPage < ( $nbpages - floor($this->numPageToDisplay / 2)))
			{
				$endPos = $beginPos + $this->numPageToDisplay;
			}
			else 
			{
				$endPos = $currentPage + floor(($this->numPageToDisplay / 2));
			}
		}
		
			
		//Affichage
		if($currentPage == 0)
		{
			echo "<span class=\"disabled Precedent\">« précédentes </span>";	
		}
		else
		{
			$limitMin = ($currentPage - 1) * $resultLimiter->rangeSize;
			$url->addLimitMinElement($limitMin);
			$url->addRangeSizeElement($resultLimiter->rangeSize);
			//$finalUrl = $url . "&limitmin=" . $limitMin . "&rangesize=" . $resultLimiter->rangeSize;
			
			echo "<a href=\"".$url->getCompleteURL()." \"><span class=\"Precedent\">« précédentes </span></a>";
		}
		
		$i = $beginPos;
		
		for( $i; $i < $currentPage; $i++ )
		{
		
			$limitMin = $i*$resultLimiter->rangeSize;
			$url->addLimitMinElement($limitMin);
			$url->addRangeSizeElement($resultLimiter->rangeSize);
			//$finalUrl = $url . "&limitmin=" . $limitMin . "&rangesize=" . $resultLimiter->rangeSize;
			$numPage = $i + 1;
			echo "<a href=\"".$url->getCompleteURL()." \"><span class=\"numPage\">$numPage</span></a>";
		}
		
		$limitMin = $i*$resultLimiter->rangeSize;
		//$finalUrl = $url . "&limitmin=" . $limitMin . "&rangesize=" . $resultLimiter->rangeSize;
	
		$url->addLimitMinElement($limitMin);
		$url->addRangeSizeElement($resultLimiter->rangeSize);		
		$numPage = $i + 1;
		echo "<span id=\"selectedPage\"> $numPage </span>";
		
		$i++;
		
		for( $i; $i < $endPos; $i++ )
		{
				
			$limitMin = $i*$resultLimiter->rangeSize;
			//$finalUrl = $url . "&limitmin=" . $limitMin . "&rangesize=" . $resultLimiter->rangeSize;
			$url->addLimitMinElement($limitMin);
			$url->addRangeSizeElement($resultLimiter->rangeSize);	
			$numPage = $i + 1;
			echo "<a href=\"".$url->getCompleteURL()." \"><span class=\"numPage\">$numPage</span></a>";
		}

		if($currentPage == ($nbpages - 1))
		{
			echo "<span class=\"disabled Suivant\"> suivantes » </span>";	
		}
		else
		{
			
			$limitMin = ($currentPage + 1) * $resultLimiter->rangeSize;
			//$finalUrl = $url . "&limitmin=" . $limitMin . "&rangesize=" . $resultLimiter->rangeSize;
			$url->addLimitMinElement($limitMin);
			$url->addRangeSizeElement($resultLimiter->rangeSize);				
			echo "<a href=\"".$url->getCompleteURL()." \"><span class=\"Suivant\">suivantes » </span></a>";
		}
	}	
}
?>
