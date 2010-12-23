<?
class CHTMLPageCount {
	

	
	static function display($resultLimiter,$nbtotal) {
	
		
		$result.="Resultat : ";
		$result.=($resultLimiter->limitMin+1);
		$result.="-";
		if(($resultLimiter->limitMin+$resultLimiter->limitMax) > $nbtotal )
			$result.=$nbtotal;
		else
			$result.=($resultLimiter->limitMin+$resultLimiter->limitMax);
		$result .= " sur ";
		$result .= $nbtotal;
		return $result;
			
	}
}

?>