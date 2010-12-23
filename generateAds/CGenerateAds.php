<?php

	
	
class CGenerateAds {
	
	var $etapeNumber;
	
	var $idutilisateur;
	
	var $etapes = array();
	
	var $max_interval_hours_time; //interval max entre heure arrive et heure depart;
	
	var $max_interval_days_time; // interval max entre jour arrivé et jour départ;
	
	var $random_start_date;
	
	var $random_startR_date;
	
	var $typetrajet = array("aller_retour","aller_simple");
	
	var $maxkm ;
	
	var $maxnbrbus;
	
	var $diviserAnnonce = 0;  //( 0 ou 1)
	
	var $preferencebus;  //( 0 ou 1)
	
	var $max_tarif_adopte;
	
	var $doublage = array("0","1");
	
	var $immobilisation = array("0","1");
	
	public function generateTransfertAds($idutilisateur) {
	
	
	
		
				$infos = array();
				$infos["typetransport"]="transfert";
				$infos["dtag"]="newdemande";
				$CGenerateQuery = new CGenerateQuery();
				$this->idutilisateur = $idutilisateur;
				$this->etapeNumber = rand(1,6);
				$this->max_interval_hours_time = 8;
				$this->max_interval_days_time = 1;
				$this->random_start_date = date("Y-m-d H:m:00",strtotime("+".rand(0,60)." day"));
				$this->random_startR_date = date("Y-m-d H:m:00",$this->random_start_date+strtotime("+".rand(0,60)." day"));
				$this->maxkm = 800;
				$this->maxnbrbus = 6;
				$this->preferencebus = rand(0,1);
				$this->max_tarif_adopte = rand(10,5000);
				

				$infos["date"]=date("Y-m-d H:m:s");
				$infos["idutilisateur"]=$this->idutilisateur;
				$infos["idcontact"]=$this->idutilisateur;



				//ville depart et ville d'arrivee
				$CGenerateQuery->getCityAndPostalCodeAndCountryForDepartAndArrivee();
                $infos["villedepart"]=$CGenerateQuery->arrayCityAndPostalCodeAndCountryForDepartAndArrivee[0]->get("placename");
                $infos["cpdepart"]=$CGenerateQuery->arrayCityAndPostalCodeAndCountryForDepartAndArrivee[0]->get("postalcode");
  				$infos["paysdepart"]=$CGenerateQuery->arrayCityAndPostalCodeAndCountryForDepartAndArrivee[0]->get("countrycode");
  				              
                $infos["villearrive"]=$CGenerateQuery->arrayCityAndPostalCodeAndCountryForDepartAndArrivee[1]->get("placename");
                $infos["cparrive"]=$CGenerateQuery->arrayCityAndPostalCodeAndCountryForDepartAndArrivee[1]->get("postalcode");
				$infos["paysarrive"]=$CGenerateQuery->arrayCityAndPostalCodeAndCountryForDepartAndArrivee[1]->get("countrycode");
				

				$CGenerateQuery->getCityAndPostalCodeAndCountryForEtapes($this->etapeNumber);

				//etapes
				array_unshift($CGenerateQuery->arrayCityPostalCodeAndCountryForEtapes,$CGenerateQuery->arrayCityAndPostalCodeAndCountryForDepartAndArrivee[0]);
				array_push($CGenerateQuery->arrayCityPostalCodeAndCountryForEtapes,$CGenerateQuery->arrayCityAndPostalCodeAndCountryForDepartAndArrivee[1]);

				foreach($CGenerateQuery->arrayCityPostalCodeAndCountryForEtapes as $key => $value) {
					
				 $this->etapes[$key]=    array("placename" => $value->get("placename"),
				 								"codepostal" => $value->get("postalcode"),
				 								"countrycode" => $value->get("countrycode")
				 								);

				}
				
				

				

                $infos["datedepart"]=$this->random_start_date;
                $infos["datearrive"]=date($this->random_start_date,strtotime("+".rand(0,$this->max_interval_hours_time)." hour"));
                $infos["heuredepart"]=date("H:i:00",$this->random_start_date);
                $infos["heurearrive"]=date("H:i:00",$this->random_start_date+strtotime("+".rand(0,$this->max_interval_hours_time)." hours","+".rand(0,3600)." minute" ));
				
				
				//random typetrajet


            switch($this->typetrajet[array_rand($this->typetrajet)])
            {
            	case "aller_simple" :
            	
            	 $infos["typetrajet"]="aller_simple";
                 $infos["kilometragealler"]=rand(1,$this->maxkm);
                 
            	break;
            	
            	case "aller_retour" :
            	

            	 $infos["typetrajet"]="aller_retour";
                 $infos["datedepartR"]=$this->random_startR_date;
                 $infos["heuredepartR"]=date("H:i:00",$this->random_startR_date);
                 $infos["datearriveR"]=date($this->random_startR_date,strtotime("+".rand(0,$this->max_interval_hours_time)." hour"));
                 $infos["heurearriveR"]=date("H:i:00",$this->random_start_date+strtotime("+".rand(0,$this->max_interval_hours_time)." hours","+".rand(0,3600)." minute" ));
                 $infos["kilometragealler"]=2*$this->maxkm;
	
            	break;
            	
            }

				$infos["doublage"] = $this->doublage[array_rand($this->doublage)];
				$infos["BusSurPlace"] = $this->immobilisation[array_rand($this->immobilisation)];
 				$infos["capacitenecessaire"]=200;
                $infos["typecar"]=getTypeCarArray(rand(0,2));

                if($this->preferencebus)
                {

	               $infos["nbrbus"]=rand(1,$this->maxnbrbus);
		           $infos["capacitenecessaire"]=$infos["nbrbus"]*53;               
		   			
		   			for($i=0; $i<$infos["nbrbus"]; $i++)
	           		{
						if($infos["nbrbus"] == $i+1)
							$infos["PlacesParBus"] .= getSeatPerBusArray(rand(1,10));
						else
						    $infos["PlacesParBus"] .= getSeatPerBusArray(rand(1,10)).",";
					 
				
	           		}
                }


               
                $infos["dcommentaires"]="ok"; 
                $infos["nbrRepasTotal"]=0;
                $infos["nbrnuittotal"]=0;
                $infos["tarifadopte"]=$this->max_tarif_adopte;
                $infos["preferencebus"]=$this->preferencebus;
	        
	            $infos["tarifconseille"]= 0;


    
    
     	 $dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
		 $dTR = new CObjetBDD();
   
        
        $itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);

        
      
        //cas pas de division des annoncse
        if(!$this->diviserAnnonce)
        {
            $dTR->set($infos);
        	$iddemandetr = $dtrDAO->insert($dTR);
        	$itineraireGestion->nouvelItineraire($this->etapes, $iddemandetr);
        }



      	   		// require("../Rss/write_rss.php"); //écriture du fichier XML



    
    
    
    
    
                 


	}
}
?>
