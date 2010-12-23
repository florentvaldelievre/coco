<?php


class CFilterOrderBy  {
	



	static function setDefault($url) {
		
		if(!isset($_GET['OrderBy']));
			$url->addOrderByElement("iddemandetr");	
	}
	
	
	static function displayOrderBy($url,$orderby_selected,$screenName) {
		
		if($url->getOrderByElement() == $orderby_selected) {
			return "<div class=\"selectedOrder\">$screenName</div>";
		}
		
		else {
			$newUrl = clone $url;
			$newUrl->addOrderByElement($orderby_selected);						
			return "<div class=\"unselectedOrder\"><a title=\"Trier par $screenName\" href=\"".$newUrl->getCompleteURL()."\">".$screenName."</a></div>";
												
		}	
	}	



	
}		

?>
