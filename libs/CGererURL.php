<?php

/*
 * Permet de construire une URL en rajoutant/effaçant des elements dans un tableau
 * les elements dans $getURL sont de type [$key => $value]
 */

class CGererURL {
	

	//var $currentURL;

	var $action;
	
	var $filtres_actifs;
	
	var $filtre_tmp; //utilisé par CFiltreAffichage
	 
	var $orderBy;
	
	var $orderAscending;
	
	var $limitmin;
	
	var $rangesize;
	
	var $profilId;
	
	
	
	 function __construct() {
	 	
	//	$this->currentURL = $_GET;

	 }
  	
//     _          _       _ 
//    / \      __| |   __| |
//   / _ \    / _` |  / _` |
//  / ___ \  | (_| | | (_| |
// /_/   \_\  \__,_|  \__,_|
//                          
//
 		
   	function addActionElement($value) {		
   		

    	if(!empty($value) ) 		
   			$this->action["action"] = $value;

   	}
   	
    function addFiltresActifsElement($factif) {		
   		

   		if(!empty($factif))
   			$this->filtres_actifs = $factif;

   	} 	
   	
   	function addFiltreTmp($key, $value) {
   		   		
   		if(!empty($value))
   			$this->filtre_tmp[$key] = $value;
   	}
   
     function addOrderByElement($value) {		
   		
   		if(!empty($value))
   			$this->orderBy["OrderBy"] = $value;

   	}
   
     function addOrderAscendingElement($value) {		
   		
   		if(!empty($value))   		
   			$this->orderAscending["OrderAscending"] = $value;

   	}
   
   
    function addLimitMinElement($value) {		
   		
   		
   			$this->limitmin["limitmin"] = $value;

   	}  
   	
    function addRangeSizeElement($value) {		
   		
   		
   			$this->rangesize["rangesize"] = $value;

   	}     	


	function addProfilId($value) {
   		
   			$this->profilId["id"] = $value;		
	}

//  ____           _          _          
// |  _ \    ___  | |   ___  | |_    ___ 
// | | | |  / _ \ | |  / _ \ | __|  / _ \
// | |_| | |  __/ | | |  __/ | |_  |  __/
// |____/   \___| |_|  \___|  \__|  \___|
//                                       


 
	function delActionElement() {		
		
		unset($this->action["action"]);
   	}
   	
    function delFiltresActifsElement($key) {		
   			
		unset($this->filtres_actifs[$key]);
   	} 	
   	
   	function delFiltreTmp($key) {
   		   		
		unset($this->filtre_tmp[$key]);
   	}
   
   
   function delAllFiltreTmp() {
   	
   	unset($this->filtre_tmp);
   }
    function delOrderByElement() {		
   		
		unset($this->orderBy["OrderBy"]);
   	}
   
    function delOrderAscendingElement() {		
   		
		unset($this->OrderAscending["OrderAscending"]);
   	}
   
   
    function delLimitMinElement() {		
   		
		unset($this->limitmin["limitmin"]);
   	}  
   	
    function delRangeSizeElement() {		
   		
		unset($this->rangesize["rangesize"]);
   	}     
 


//   ____          _      __        __  _   _     _          ___   
//  / ___|   ___  | |_    \ \      / / (_) | |_  | |__      ( _ )  
// | |  _   / _ \ | __|    \ \ /\ / /  | | | __| | '_ \     / _ \/\
// | |_| | |  __/ | |_      \ V  V /   | | | |_  | | | |   | (_>  <
//  \____|  \___|  \__|      \_/\_/    |_|  \__| |_| |_|    \___/\/
                                                                                   


 	function getActionWithCommercialString() {
 		if(!empty($this->action["action"]))
 			return "?action=".$this->action["action"];
 	}
 	
 	
  	function getFiltresActifsWithCommercialString() {
  		if(!empty($this->filtres_actifs))		
 			return "&amp;".$this->filtres_actifs;
 	}
 	

 	function getOrderByWithCommercialString() {
  		if(!empty($this->orderBy["OrderBy"]))		
 			return "&amp;OrderBy=".$this->orderBy["OrderBy"];	
 		
 	}

 	function getOrderAscendingWithCommercialString() {
   		if(!empty($this->orderAscending["OrderAscending"]))			
 			return "&amp;OrderAscending=".$this->orderAscending["OrderAscending"];
 	}

 	function getLimitMinWithCommercialString() {
		if(!empty($this->limitmin["limitmin"]))			
 			return "&amp;limitmin=".$this->limitmin["limitmin"];
 	}
 
  	function getRangeSizeWithCommercialString() {
 		if(!empty($this->rangesize["rangesize"]))			
 			return "&amp;rangesize=".$this->rangesize["rangesize"];
 	}
 		
   	function getProfilIdWithCommercialString() {
 		if(!empty($this->profilId["id"]))			
 			return "&amp;id=".$this->profilId["id"];
 	}
 
 
//    ____          _       _   _                                      _ 
//  / ___|   ___  | |_    | \ | |   ___    _ __   _ __ ___     __ _  | |
// | |  _   / _ \ | __|   |  \| |  / _ \  | '__| | '_ ` _ \   / _` | | |
// | |_| | |  __/ | |_    | |\  | | (_) | | |    | | | | | | | (_| | | |
//  \____|  \___|  \__|   |_| \_|  \___/  |_|    |_| |_| |_|  \__,_| |_|
// 
 
 
  	function getOrderByElement() {
  		if(!empty($this->orderBy["OrderBy"]))		
 			return $this->orderBy["OrderBy"];	
 		
 	}
 
 
   	function getOrderAscendingElement() {
  		if(!empty($this->orderAscending["OrderAscending"]))		
 			return $this->orderAscending["OrderAscending"];	
 		
 	}
 
   	function getRangeSizeElement() {
  		if(!empty($this->rangesize["rangesize"]))		
 			return $this->rangesize["rangesize"];	
 		
 	} 
 
 
 		
 		 	 	 		
 	function getCompleteURL() {

			$url="index.php";
			$url.=$this->getActionWithCommercialString();
			$url.=$this->getFiltresActifsWithCommercialString();
			$url.=$this->getOrderByWithCommercialString();
			$url.=$this->getOrderAscendingWithCommercialString();
			$url.=$this->getLimitMinWithCommercialString();
			$url.=$this->getRangeSizeWithCommercialString();
			$url.=$this->getProfilIdWithCommercialString();
	 return $url;	


 	}
  
  
  

	  function getTmpFilterURL() {
	  	
	  	$first=true;

			$url="index.php".$this->getActionWithCommercialString();
			
	 		if(!empty($this->filtre_tmp)) {
			 		foreach($this->filtre_tmp as $key => $value) {
			 			
			 			if($first){
							$url.="&amp;".$key."=".$value;
							$first=false;
			 			}
						else {
							$url.="&amp;".$key."=".$value;
						}
						
			 		}
	 		}
	 		$url.=$this->getOrderByWithCommercialString();
			$url.=$this->getOrderAscendingWithCommercialString();
			$url.=$this->getLimitMinWithCommercialString();
			$url.=$this->getRangeSizeWithCommercialString();
			
	 	return $url;	
	  }
	  
	  
}
?>
