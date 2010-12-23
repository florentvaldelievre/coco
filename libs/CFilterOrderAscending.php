<?php
class CFilterOrderAscending {


	function setDefault($url) {
		
			if(!isset($_GET['OrderAscending']));
				$url->addOrderAscendingElement("false");	
		
	}
	
	
	function displayOrderAscending($url,$orderAscending_selected,$screenName) {
		

			if($url->getOrderAscendingElement() == $orderAscending_selected) {
			return "<span class=\"selectedOrderAscending\">$screenName</span>";
		}
		
		else {
			$newUrl = clone $url;
			$newUrl->addOrderAscendingElement($orderAscending_selected);						
			return "<a class=\"NoselectedOrderAscending\" title=\"Ordonner par sens $screenName\" href=\"".$newUrl->getCompleteURL()."\">".$screenName."</a>";
												
		}	

	}
	
}
?>
