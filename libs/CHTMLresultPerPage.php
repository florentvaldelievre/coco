<?

class CHTMLresultPerPage {
	
	
	
	var $resultPerPage;
		
	function __construct($resultLimiter,$url)
	{
		$this->resultPerPage = array (5,10,15,20,50);
		$this->display($resultLimiter, $url);
	}
	
	
		function display($resultLimiter,$url) {
			
		echo "Resultats par page : ";
		

		foreach($this->resultPerPage as $page ) {
			

			if($url->getRangeSizeElement() == $page) {
				echo "<span class=\"rangePageSelected\">$page</span>";
			}
			
			else {
				$newUrl = clone $url;
				$newUrl->addRangeSizeElement($page);						
				echo "<a class=\"rangePageNoSelected\" title=\"Afficher $page resultats par page\" href=\"".$newUrl->getCompleteURL()."\">".$page."</a>";										
			}	
			
		}			
			
		}
			
			
			
	
	
	
}


?>