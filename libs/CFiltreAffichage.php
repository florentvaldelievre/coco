<?php

 
class CFiltreAffichage{
	
	
	
	var $active_filters = array();
	
	
	var $filter_list = array();
	
	
	
/*
 * On veux avoir dans le constructeur les filtre actifs et la liste des filtres
 */
	  function __construct($filter_list)
	  {
    	foreach($filter_list as $filter){			
			if(isset($_GET[$filter->name])){
				$this->active_filters[$filter->name] = $_GET[$filter->name];
			}
		}
    	$this->filter_list = $filter_list;
    	
      }
	
	
	/*
	 * Affiche les filtres cliqués entre <a> </a>
	 */
	function displayActiveFilters($url,$filter_list){
		
	$url->delAllFiltreTmp();
		foreach($filter_list as $filter){
			
			if(isset($this->active_filters[$filter->name])){
				$tmp_filters = $this->active_filters;
				unset($tmp_filters[$filter->name]);
			
				$url->delFiltreTmp($filter->name);
				foreach($tmp_filters as $key => $value){
											
						$url->addFiltreTmp($key,$value);
				}				
			
				 echo "<div class=\"selectedFilterRange\">".$filter->true_name.": ".$this->active_filters[$filter->name]." <a href=".$url->getTmpFilterURL().">[Effacer]</a></div>";					

			
			}
		}
	}

	
	
	/*
	 * Retourne le filtre selectionné sous la forme index.php?action=blah&brpers=10-50"
										"index.php?action=blah&brpers=50-90"
										"index.php?action=blah&brpers=90-140"
									    ...
	 */
	function addFilters($url,$filter_selected){	
		
		$unFiltreEtUneRange = array();	
		$urlFiltre = array();
		$url->delAllFiltreTmp();
		foreach($this->filter_list as $filter){
			
			
			if($filter->name == $filter_selected)
			{
				
				if( ($filter->maxValue - $filter->minValue + 1) <= CFiltreGenerique::$NombredeFiltre)
				{
					$range = $filter->minValue."-".$filter->maxValue;
					
					$tmp_filters = $this->active_filters;								
					if($tmp_filters[$filter->name] != $range){
						$tmp_filters[$filter->name] = $range;
						
						foreach($tmp_filters as $key => $value){
							$url->addFiltreTmp($key,$value);
						}
								
						$unFiltreEtUneRange = array($filter->name => $range);
								
						$nbr = $this->countFilterElements($filter,$unFiltreEtUneRange, $url);
	
						if($nbr == 0)
							array_push($urlFiltre,$range." (".$nbr.")");	
						else {
							array_push($urlFiltre,"<a title=\"Filtrer par ".$filter->true_name." (".$range.") \" href=\"".$url->getTmpFilterURL()."\">".$range." (".$nbr.")</a>");
						}
					}
					else{
						 array_push($urlFiltre,"<span class=\"clickedFilter\">$range</span>");
					}
				}
				else
				{
					for($i = $filter->minValue; $i<$filter->maxValue; $i+=$filter->step){
					$range = $i."-".($i+$filter->step);
				
						$tmp_filters = $this->active_filters;								
						if($tmp_filters[$filter->name] != $range){
							$tmp_filters[$filter->name] = $range;
							//On construit l'url
							//$url = $_SERVER['PHP_SELF']."?action=".$_GET['action'];
							foreach($tmp_filters as $key => $value){
								$url->addFiltreTmp($key,$value);
							}
							
							$unFiltreEtUneRange = array($filter->name => $range);
							
							$nbr = $this->countFilterElements($filter,$unFiltreEtUneRange, $url);
											
							if($nbr == 0)
								array_push($urlFiltre,$range." (".$nbr.")");	
							else {
								array_push($urlFiltre,"<a title=\"Filtrer par ".$filter->true_name." (".$range.") \" href=\"".$url->getTmpFilterURL()."\">".$range." (".$nbr.")</a>");
							}
						}
						else{
							 array_push($urlFiltre,"<span class=\"clickedFilter\">$range</span>");
						}
					
				  	}
				}
			}
		}
		
		return $urlFiltre;
		
	}



	function countFilterElements($filter,$unFiltreEtUneRange, $url)
	{

		if($_GET['action']=="listing_newdemande_repondue")
			$nbr = count($filter->listingGestion->demandesRepondues($_SESSION['idutilisateur'],null,CFiltreAffichage::getGenerateBetweenQuery(array_merge($this->active_filters,$unFiltreEtUneRange)),$url));
		else if($_GET['action']=="listing_newdemande")
			$nbr = count($filter->listingGestion->demandesAttenteReponseClient($_SESSION['idutilisateur'],null,CFiltreAffichage::getGenerateBetweenQuery(array_merge($this->active_filters,$unFiltreEtUneRange)),$url));
		else if($_GET['action']=="listing_refuser")
			$nbr = count($filter->listingGestion->annoncesRefusees($_SESSION['idutilisateur'],null,CFiltreAffichage::getGenerateBetweenQuery(array_merge($this->active_filters,$unFiltreEtUneRange)),$url));
		else if($_GET['action']=="listing_valider_c")
			$nbr = count($filter->listingGestion->demandeValideesClient($_SESSION['idutilisateur'],null,null,CFiltreAffichage::getGenerateBetweenQuery(array_merge($this->active_filters,$unFiltreEtUneRange)),$url));
		else if($_GET['action']=="listing_valider_t")
			$nbr = count($filter->listingGestion->demandeValideesTransporteur($_SESSION['idutilisateur'],null,null,CFiltreAffichage::getGenerateBetweenQuery(array_merge($this->active_filters,$unFiltreEtUneRange)),$url));
		else if($_GET['action']=="consulterannonce")
			$nbr = count($filter->listingGestion->consulterAnnonces(null,null,CFiltreAffichage::getGenerateBetweenQuery(array_merge($this->active_filters,$unFiltreEtUneRange)),$url));
		else if($_GET['action']=="listing_supprimer")
			$nbr = count($filter->listingGestion->annoncesSupprimeesClient($_SESSION['idutilisateur'],null,CFiltreAffichage::getGenerateBetweenQuery(array_merge($this->active_filters,$unFiltreEtUneRange)),$url));
		else if($_GET['action']=="listing_expirer")
			$nbr = count($filter->listingGestion->annoncesExpirees($_SESSION['idutilisateur'],null,CFiltreAffichage::getGenerateBetweenQuery(array_merge($this->active_filters,$unFiltreEtUneRange)),$url));		
		else if($_GET['action']=="mesannonces")
			$nbr = count($filter->listingGestion->annoncesAttenteConfirmation($_SESSION['idutilisateur'],null,CFiltreAffichage::getGenerateBetweenQuery(array_merge($this->active_filters,$unFiltreEtUneRange)),$url));
		
		return $nbr;					
	}

/*
 * Renvoie les BETWEEN pour les filtres envoyé en parametres. Si aucun parametre n'est selectionné, renverra un tableau des Filtres Actifs uniquements
 * Retourne un tableau de type : Array ( [budget] => BETWEEN 80 AND 110 [meilleuroffre] => BETWEEN 770 AND 885 )
 * Les clef seront utilisées pour les requetes car elles correspondent avec les champs en bdd
 */
	function getGenerateBetweenQuery($filtres="") {
	
		$query = array();
	
	if(empty($filtres)) 	
		$filtres = $this->active_filters;

		foreach($filtres as $key => $filtre) {
			
			$between="BETWEEN ";
			$first=true;
			foreach(explode("-",$filtre) as $value) {
				
				if($first){
					$between.=$value." AND ";
					$first=false;
				} 
				else
				  $between.=$value;
			} 
			$query[$key]=$between;	
		}	
		return $query;
	}


	/*
	 * retourne les filtres actifs sous forme de string : kilometragealler=80-560&tarifadopte=575-70
	 */
	
	function getURLFiltresActifs() {
		
		$count = 1;
		
		foreach($this->active_filters as $key => $value) {
		
			if(count($this->active_filters) != $count) 
				$filtre_url .= $key."=".$value."&amp;";
			else
				$filtre_url .= $key."=".$value;
			$count++;	
		}
		
		return $filtre_url;
	}
	
	 public  function __destruct() {
  
 		
   			}
   			
	
}
 
?>
