<?php

if(defined("__CVoyageVue"))
    return;

define("__CVoyageVue","");

    include_once("libs/util.php");
    include_once('libs/CVoyage.php');
    include_once("nocommit/localdata.php");
    
        
class CVoyageVue
{
	//
    var $currentVue = 1;
    
	//pays
	var	$countriesNames;
	var	$countriesCodes ;
	var	$defaultCountryCode;
	var	$nbCountries;
	
	//erreur
	var $erreurs;

	//voyage
	var $voyage;
	
	//id de la demande a modifier si affichage de modif_transport, false pour nouvelle demandetr
	var $modif;
	
	var $typeTransfertRadio = array();
	//sauvegarde des données du form
	
	// en heures	
	var $amplitude; 

	
    function __construct($typeVoyage="transfert",$modif = false)
    {
        //pays
		$this->countriesNames = getCoutriesNames();
		$this->countriesCodes = getCoutriesCodes();
		$this->defaultCountryCode = "FR";
		$this->nbCountries = count($this->countriesCodes);
		$this->voyage = new CVoyage($typeVoyage);
		$this->modif = $modif;

    }
    
    
    function setVoyageParams($numFormEtape)
    {
    	switch($numFormEtape)
    	{
    		case 1:
		  		 $this->voyage->idutilisateur = $_SESSION['idutilisateur'];
		    	 $this->voyage->idcontact = $_SESSION['idcontact'];
		         if(isset($_POST['nbEscales'])) $this->voyage->nbEscales = $_POST['nbEscales'];
		         if(isset($_POST['nbEtapes'])) $this->voyage->nbEtapes = $_POST['nbEtapes'];
		         
		         for($i = 0; $i< $this->voyage->nbEtapes; $i++)
		         {
		         	$this->voyage->villes[$i] = $_POST["ville_$i"];
		         	$this->voyage->cps[$i] = $_POST["cp_$i"];
		         	$this->voyage->pays[$i] = $_POST["pays_$i"];
		         }
		         
		         if(isset($_POST['distance'])) $this->voyage->distance = $_POST['distance'];
		         if(isset($_POST['dureestr'])) $this->voyage->dureestr = $_POST['dureestr'];
		         if(isset($_POST['dateDepart'])) $this->voyage->dateDepart = $_POST['dateDepart'];
		         if(isset($_POST['dateArrivee'])) $this->voyage->dateArrivee = $_POST['dateArrivee'];
		         if(isset($_POST['dateDepartR'])) $this->voyage->dateDepartR = $_POST['dateDepartR'];
		         if(isset($_POST['dateArriveeR'])) $this->voyage->dateArriveeR = $_POST['dateArriveeR'];
		         if(isset($_POST['heureDepart'])) $this->voyage->heureDepart = $_POST['heureDepart'];
		         if(isset($_POST['heureArrivee'])) $this->voyage->heureArrivee = $_POST['heureArrivee'];
		         if(isset($_POST['heureDepartR'])) $this->voyage->heureDepartR = $_POST['heureDepartR'];
		         if(isset($_POST['heureArriveeR'])) $this->voyage->heureArriveeR = $_POST['heureArriveeR'];
		         if(isset($_POST['minutesDepart'])) $this->voyage->minutesDepart = $_POST['minutesDepart'];
		         if(isset($_POST['minutesArrivee'])) $this->voyage->minutesArrivee = $_POST['minutesArrivee'];
		         if(isset($_POST['minutesDepartR'])) $this->voyage->minutesDepartR = $_POST['minutesDepartR'];
		         if(isset($_POST['minutesArriveeR'])) $this->voyage->minutesArriveeR = $_POST['minutesArriveeR'];
		         if(isset($_POST['typeTransfert'])) $this->voyage->typeTransfert = $_POST['typeTransfert'];
		         $this->voyage->dtag= "newdemande";
				 $this->voyage->datedepartFormated = formatDateFrToUS($this->voyage->dateDepart)." ".$this->voyage->heureDepart.":".$this->voyage->minutesDepart.":00";
				 $this->voyage->datearriveeFormated = formatDateFrToUS($this->voyage->dateArrivee)." ".$this->voyage->heureArrivee.":".$this->voyage->minutesArrivee.":00";

				 //echo getAmplitude($this->voyage->datedepartFormated,$this->voyage->datearriveeFormated);
				 break;
				 
			case 2:
				 if(isset($_POST['capacite'])) $this->voyage->capacite = $_POST['capacite'];
				 if(isset($_POST['nbrBus'])) $this->voyage->nbrBus = $_POST['nbrBus'];
		         for($i = 0; $i< $this->voyage->nbrBus; $i++) {
		         	$this->voyage->placesParBus[$i] = $_POST["nbrPlaceBus_$i"];
		         }
				 $this->voyage->nbrSiegesTotal = array_sum($this->voyage->placesParBus);
		         if(isset($_POST['typeBus'])) $this->voyage->typeBus = $_POST['typeBus'];
				 if(isset($_POST['commentaires'])) $this->voyage->commentaires = $_POST['commentaires'];
				 if(isset($_POST['budget'])) $this->voyage->budget = $_POST['budget'];
		         (isset($_POST['diviserAnnonces']))?$this->voyage->diviserAnnonces = 1 : $this->voyage->diviserAnnonces = 0;
		         (isset($_POST['doublage']))?$this->voyage->doublage = 1 : $this->voyage->doublage = 0;
		         (isset($_POST['immobilisation']))?$this->voyage->immobilisation = 1 : $this->voyage->immobilisation = 0;		         	
 
				 break;	
			case 3:
				 break;
    	}
    }
    
    function init()
	{
		if(isset($_POST['validerform'])){
			$this->currentVue = $_POST['validerform'];
			$this->voyage->sessionLoadAll();
			$this->setVoyageParams($this->currentVue);
			$this->voyage->checkErrors($this->currentVue);
			if(empty($this->voyage->erreurs)){
				$this->voyage->sessionSave($this->currentVue);
				$this->currentVue++;
			}	
		}
		// on vide le voyage en session si premiere etape
		else{
			$this->voyage->sessionReset();
			
			if($this->modif){
				$this->voyage->sessionLoadAll();
				$this->voyage->loadFromBdd($this->modif);
				$this->voyage->sessionSave($this->currentVue);
			}
		}
	}
    
    
    
    ///////  VUES ////////
    //chaque vue correspond a une étape
		
 	function display()
    {
    	$vue= 'vue'.strval($this->currentVue);
    	$this->${'vue'}();
    }
    
    function vue1()
    {
 
 		//local var
		$numLastEtape = $this->voyage->nbEtapes -1;
		$this->typeTransfertRadio[$this->voyage->typeTransfert]="checked";
		$etapeHeader = ($this->voyage->nbEscales > 0 )?"<div class=\"subGroupFormHeader\">escales: </div>":"";

    	// includes javascript
    	echo " 	
		
		<script language=\"JavaScript\" type=\"text/javascript\" charset=\"utf-8\" src=\"javascript/voyage.js\"></script>
    	<script language=\"JavaScript\" type=\"text/javascript\" charset=\"utf-8\" src=\"javascript/escales.js\"></script>  
		<script language=\"JavaScript\" type=\"text/javascript\" charset=\"utf-8\" src=\"javascript/autocomplete/prototype.js\"></script>
		<script language=\"JavaScript\" type=\"text/javascript\" charset=\"utf-8\" src=\"javascript/autocomplete/effects.js\"></script>
		<script language=\"JavaScript\" type=\"text/javascript\" charset=\"utf-8\" src=\"javascript/autocomplete/controls.js\"></script>
		<script type=\"text/javascript\" src=\"http://maps.google.com/maps?file=api&v=2&hl=fr&key=".getGoogleMapApiKey()."\"></script> 
		<script language=\"JavaScript\" type=\"text/javascript\" charset=\"utf-8\" src=\"javascript/googlemapinit.js\"></script>



  <script type=\"text/javascript\" src=\"http://o.aolcdn.com/dojo/1.0.0/dojo/dojo.xd.js\"  djConfig=\"parseOnLoad: true\"</script>
		    
		";

    	
	
    	echo "<script>

			initEscale(".$this->voyage->nbEscales.");
			init_googlemap();

				</script>		
			 /* enableAndDisableFields(); */
			
";
    	
    	// boites englobantes et entetes
		echo"
		<div class=\"panelcentre\">
        <div class=\"boiteform\">
        <div class=\"bandeauform\">
        <h4>Creer une nouvelle annonce - Transfert</h4>
        </div>			

        <form name=\"reservation\" id=\"reservation\" method=\"post\" target=\"_self\" action=\"\">
        <div class=\"corpForm\"><br />    
        ".	$this->formErreurs() ."
		";
		
		// - trajets
		echo"
		<fieldset>
		<legend>Trajet</legend><br/>
		";

		// -- Traget départ
		echo"                    
        <div class=\"formLabelBlock\"> Départ: </div>"; 
		$this->createEtape(0,0);
		
        // -- escales        
	
		echo "<div id=\"etapeHeader\">$etapeHeader</div>";
		echo "<div id=\"escalePanel\">";
        for($i = 1; $i <= $this->voyage->nbEscales; $i++)
	        $this->createEtape($i,0);
       	echo "</div>";
        
		// --Trajet arrivée
		echo"
		<div class=\"subGroupFormHeader\">Arrivée:</div>";
		$this->createEtape($numLastEtape,0);

        $this->createItineraireControle(0);
		$this->createItineraireMapEtInfos(0);
		 
        echo "</fieldset><br /> ";
             
        // -date et horaire
        echo "
        <fieldset>
		<legend>date et horaire</legend><br/>
		";
	
		// -- dates
		echo "<input  type=\"radio\" id=\"typeTransfertA\"  name=\"typeTransfert\" value=\"a\" ".$this->typeTransfertRadio['a']."\ />Aller simple - Voyage Aller";
		$this->createVoyageAller();
		echo "<input  type=\"radio\" id=\"typeTransfertAr\" name=\"typeTransfert\" value=\"ar\" ".$this->typeTransfertRadio['ar']."\ />Aller retour - Voyage Retour";
		$this->createVoyageRetour();

		echo"
		</fieldset>
		";
		          
        // pied             
        echo "
        <div class=\"piedForm\">
		<input type=\"hidden\" name=\"validerform\" value=\"1\"/>
		<input  type=\"submit\" name=\"validerclient\" id=\"valid\">Suivant ( 1/3 ) </input>
        </div>
        
		</div></form></div></div>     
        ";          
    }
    
    
    function vue2()
    {

    	echo "
    	<script language=\"JavaScript\" type=\"text/javascript\" charset=\"utf-8\" src=\"javascript/voyage.js\"></script>
		<script language=\"JavaScript\" type=\"text/javascript\" charset=\"utf-8\" src=\"javascript/devis.js\"></script>
    	";
   		// boites englobantes et entetes
		echo"
		<div class=\"panelcentre\">
        <div class=\"boiteform\">
        <div class=\"bandeauform\">
        <h4>Creer une nouvelle annonce - Transfert</h4>
        </div>			

        <form name=\"reservation\" id=\"reservation\" method=\"post\" target=\"_self\" action=\"\">
        <div class=\"corpForm\" parseContent=\"true\"><br />    
        ".	$this->formErreurs() ."
		";
		
		// - transport
		echo"
		<fieldset>
		<legend>Transport</legend><br/>
		";
		
		// -- capacité
		echo "<div class=\"panelFormLine\">";
		$this->createCapacite();
  		echo "<div class=\"clearboth\"></div></div>";
  	
  		// -- nombre de bus
  		echo "<div class=\"panelFormLine\">";
  		$this->createBus($this->voyage->nbrBus);
  		echo "<div class=\"clearboth\"></div></div>";
  		
  		// -- places par bus
  		echo "<div class=\"panelFormLine\">";
  		$this->createBusSeat($this->voyage->placesParBus);
  		echo "<div class=\"clearboth\"></div></div>";
		
  		// -- type de bus
  		echo "<div class=\"panelFormLine\">";
  		$this->createTypeBus();
  		echo "<div class=\"clearboth\"></div></div>";
  		
  		// -- diviser annonces
  		echo "<div class=\"panelFormLine\">";
  		$this->createDiviserAnnonces();
  		echo "<div class=\"clearboth\"></div></div>";
  		
   		// -- immobilisation
  		echo "<div class=\"panelFormLine\">";
  		$this->createImmobilisation();
  		echo "<div class=\"clearboth\"></div></div>"; 		
  		
   		// -- immobilisation
  		echo "<div class=\"panelFormLine\">";
  		$this->createDoublage();
  		echo "<div class=\"clearboth\"></div></div>";   		
		echo"</fieldset><br />";
		
		// informations complementaires
		echo"
		<fieldset>  
        <legend>Informations complémentaires</legend>";
		$this->createInfoComplementaires();
		echo "</fieldset><br/>";
        
        echo"
		<fieldset>  
        <legend>Budget</legend>";
  		$this->createBudget();     
		echo "</fieldset>";
		          
        // pied             
        echo "                 
        <div class=\"piedForm\">
		<input type=\"reset\" name=\"reset\" id=\"reset\" value=\"Annuler\" />
		<input type=\"hidden\" name=\"validerform\" value=\"2\"/>
		<input type=\"submit\" name=\"validerclient\" id=\"valid\" value=\"Suivant ( 2/3 )\" />
        </div>

        </div></form></div></div>     
        ";          
    
    }
    
    function vue3()
    {
    	// boites englobantes et entetes
		echo"
		<div class=\"panelcentre\">
        <div class=\"boiteform\">
        <div class=\"bandeauform\">
        <h4>Creer une nouvelle annonce - Transfert</h4>
        </div>	";
    	
    	echo "<form name=\"reservation\" id=\"reservation\" method=\"post\" target=\"_self\" action=\"\">
        <div class=\"corpForm\"><br />    
        ".	$this->formErreurs() ."
		";
    	
    	echo"
		<fieldset>
		<legend>Confirmation</legend><br/>
		";
		
		echo "<div class=\"panelFormLine\"><span class=\"infomsg\">Veuiller vérifier que les informations à enregistrer ne comportent pas d'erreurs avant de les valider</span></div>";           
    	echo "<ul class=\"resume\">";
    	
    	$this->printTrajet();
    	$this->printKilometrage();
    	$this->printDates();
    	$this->printTransport();
    	$this->printDiviserAnnonces();
    	$this->printImmobilisation();
    	$this->printDoublage();
		echo "</fieldset>";
		          
        // pied             
        echo "                 
        <div class=\"piedForm\">
		<input type=\"reset\" name=\"reset\" id=\"reset\" value=\"Annuler\" />
		<input type=\"hidden\" name=\"validerform\" value=\"3\"/>
		<input type=\"submit\" name=\"validerclient\" id=\"valid\" value=\"Valider l'annonce (3/3)\" />

        </div>
        </div>
        </form>
        </div>
        </div>     
        ";          
    }
    
    function vue4()
    {
    	if($this->voyage->insertInBdd()){
			
			if($this->modif){
				$msg = "Les modifications ont été enregistrées avec succès. Un nouveau numéro d'annonce a été attribué a l'annonce. Vous pouvez le consulter et suivre l'évolution des réponses des transporteurs
				dans la rubrique <a href=\"index.php?action=listing_newdemande\">en attente de réponse</a>";
				$this->voyage->deleteFromBdd($this->modif);
			}
			else{
				$msg = "Votre annonce à été enregistré avec succès. Vous pouvez suivre l'évolution des réponses des transporteurs
				dans la rubrique <a href=\"index.php?action=listing_newdemande\">en attente de réponse</a>";
			}
			$msgbox = new CMessageBoxVue("validation", $msg);
			$msgbox->display();
    	}
    	
    	else{
    		$msg = "Une erreur s'est produite lors de l'enregistrement de votre annonce. Veuillez réessayer ultériement en vérifiant la cohérence des données entrées. Si le problème persiste veuillez <a href=\"index.php?action=contact\">contacter WayBus</a>";
			$msgbox = new CMessageBoxVue("erreur", $msg);
			$msgbox->display();	
    	}
    	$this->voyage->sessionReset();    	
    }
    
    
    // affiche les erreurs du formulaire
    function formErreurs()
    {
    	$errstr = "";
    	
    	if(!empty($this->voyage->erreurs))
    	{
    	
    	$errstr .= "
    	<div class=\"boiteko\">
		<div class=\"bandeauko\"><img src=\"./images/style1/exclamation-red.gif\" alt=\"icon_exclamation-red\" /></div> 
		<div class=\"boitekocontent\">
		<p> Le formulaire comporte une ou plusieurs erreurs. Si le problème persiste veuillez <a href=\"index.php?action=contact\">contacter WayBus</a></p>	
        <ul class=\"formError\">
        ";
        	foreach($this->voyage->erreurs as $erreur){
            $errstr .=  "<li>" .$erreur. "</li>";
            }
        $errstr .= "
        </ul>
		</div >
		<div class=\"footko\"><img class=\"alignright\" src=\"./images/style1/exclamation-red.gif\" alt=\"icon_exclamation-red\" /></div>
		</div>
		";
    	}
    	
    	return $errstr;
	 
    }
    
    ///////  MODULES D AFFICHAGES ////////
    
    ////pays et dates
    
    function genOptionsPays($pays)
    {       
		
		$optPaysStr = "";
		
		if(!isset($pays))
		{
		  	for($i=0; $i<($this->nbCountries); $i++) {
		  		if($this->countriesCodes[$i]==$this->defaultCountryCode){
		        	$optPaysStr .= "<option value=\"".$this->countriesCodes[16]."\" selected=\"selected\" >".$this->countriesNames[16]."</option>";   
		        }                                                               
		        else {
		        	$optPaysStr .= "<option value=\"".$this->countriesCodes[$i]."\">".$this->countriesNames[$i]."</option>";
		        }     
		  	}
		}
		else
		{
			for($i=0; $i<($this->nbCountries); $i++) {
		    	if($this->countriesCodes[$i]==$pays){
		        	$optPaysStr .= "<option value=\"".$this->countriesCodes[$i]."\" selected=\"selected\" >".$this->countriesNames[$i]."</option>"; 
		        }
		        else {
		        	$optPaysStr .= "<option value=\"".$this->countriesCodes[$i]."\">".$this->countriesNames[$i]."</option>";
		        }
		    }
		}
		
		return $optPaysStr;
                          
    }
    
    function genOptionsHeures($selected)
    {
    	$optHeures = "";
    	
    	$tabHeures = Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");
        $tab2 = Array("00h","01h","02h","03h","04h","05h","06h","07h","08h","09h","10h","11h","12h","13h","14h","15h","16h","17h","18h","19h","20h","21h","22h","23h");   	

        for($i=0; $i<count($tabHeures); $i++) {
        	if($tabHeures[$i]==$selected)
            {
            	$optHeures .= "<option value=\"$tabHeures[$i]\" selected=\"selected\">${tabHeures[$i]}h</option>";
            }
            else
            {
            	$optHeures .= "<option value=\"$tabHeures[$i]\">${tabHeures[$i]}h</option>";
            }
    	}
    	
    	return $optHeures;
    }
    
    function genOptionsMinutes($selected)
	{     
        $optMinutes = "";
        $tabMinutes = Array("00","05","10","15","20","25","30","35","40","45","50","55");

        for($i=0; $i<count($tabMinutes); $i++) {
        	if($tabMinutes[$i]==$selected)
            {
            	$optMinutes .= "<option value=\"$tabMinutes[$i]\" selected=\"selected\">$tabMinutes[$i]</option>";
            }
           	else
            {
            	$optMinutes .= "<option value=\"$tabMinutes[$i]\">$tabMinutes[$i]</option>";
            }
        }
        
        return $optMinutes;
    }
    
    ////éléments du formulaire
    /*
     * $param $numEtape, $hidden 
     */
    function createEtape($numEtape,$hidden)
	{
	    ($hidden) ? $hidden="hidden" : $hidden="text";   
	    echo "	
		<div class=\"locationEntry\"> 
	    <div class=\"locationEntry-header\">
	    <div class=\"locationEntry-villeLabel $hidden\">Ville</div >
	    <div class=\"locationEntry-zoneLabel $hidden\">Code Postal</div >
	    <div class=\"locationEntry-paysLabel $hidden\">Pays</div >
	    </div>                 
	    <div  class=\"locationEntry-Input $hidden\">  
	    <input  type=\"text\" name=\"ville_$numEtape\" id=\"ville_$numEtape\" value=\"".$this->voyage->villes[$numEtape]."\" title=\"Ville escale $numEtape\"  class=\"locationEntry-villeInput\" />
		". viewFormError($this->voyage->erreurs['villes'][$numEtape]) ."
		<input  type=\"text\" name=\"cp_$numEtape\"  id=\"cp_$numEtape\" value=\"".$this->voyage->cps[$numEtape]."\" title=\"Code postal escale $numEtape\" class=\"locationEntry-zoneInput\" />
	    ". viewFormError($this->voyage->erreurs['cps'][$numEtape]) ."                     
		<select   name=\"pays_$numEtape\" id=\"pays_$numEtape\" class=\"locationEntry-paysInput\" > 
		". $this->genOptionsPays($this->voyage->pays[$numEtape]) ."
		</select>
		". viewFormError($this->voyage->erreurs['pays'][$numEtape]) ."                       
		<div class=\"hintville\" id=\"hintville_$numEtape\"></div>
		</div>                
		<script type=\"text/javascript\">	
		new Ajax.IOAutocompleter(\"ville_$numEtape\",\"cp_$numEtape\",\"hintville_$numEtape\",\"./formulaires/autocompletion.php\");
		</script>
		</div>  ";
			
	}
	
	function createItineraireControle($hidden)
    {                 
	   ($hidden) ? $hidden="hidden" : $hidden="text";   
		echo "
		<input type=\"hidden\" id=\"nbEscales\" name=\"nbEscales\" value=\"".$this->voyage->nbEscales."\" \>
		<input type=\"hidden\" id=\"nbEtapes\" name=\"nbEtapes\" value=\"".$this->voyage->nbEtapes."\" \>
		<div class= \"panelControleEscale\">
		<span class=\"addEscale $hidden\"><input   type=\"button\" onclick=\"ajouteEscale('escalePanel')\">Ajouter une escale</input></span>
<span class=\"supprEscale $hidden\"><input  type=\"button\" onclick=\"supprEscale('escalePanel')\">Supprimer la dernière escale</input></span>
		</div>
		";    
    }
    
	function createItineraireMapEtInfos($hidden)
	{   
		($hidden) ? $hidden="hidden" : $hidden="text"; 
		// -google map
		echo "
		<div id=\"mapPanel\" class=\"mapPanel\"></div>
        <span class=\"$hidden\" id=\"CalculateRouting\">Calcul Automatique (Heure d'arrivée, Kilométrage) et afficher la map</span>   
		";
      
         // - infos trajet
        echo "
		<br />
		<div class=\"panelInfoTrajet $hidden \">
		<div class=\"panelDistance $hidden\">
		distance <input  type=\"text\" id=\"distance\" name=\"distance\" class=\"distance $hidden\" value=\"".$this->voyage->distance."\" \> km
		</div>
		<div class=\"panelTemps $hidden\">
		<span class=\"$hidden\" id=\"tempsTrajetlabel\"> - Durée du trajet: </span><span class=\"$hidden\" id=\"tempsTrajetValue\"></span>
        </div> 
		<div class=\"clearboth\"></div>
		</div>
		";
	}
    
    function createVoyageAller()
	{
		echo"
		<div class=\"panelTransfertDate0\">
		<div class=\"panelTransfertDate1\">
		<div class=\"panelTransfertDate1a\">
		<span class=\"LabelDate\">Départ <span class=\"date\">(dd/mm/aaaa)</span></span>
		<span class=\"controlePanel\"><input  type=\"text\"  class=\"inputDate\" name=\"dateDepart\"  id=\"dateDepart\"  value=\"". $this->voyage->dateDepart ."\" title=\"date du départ du voyage\" />


		à <select  name=\"heureDepart\" id=\"heureDepart\">".$this->genOptionsHeures($this->voyage->heureDepart)."</select>
		<select  name=\"minutesDepart\" id=\"minutesDepart\">".$this->genOptionsMinutes($this->voyage->minutesDepart)."</select>
		</span></div>
		<div class=\"panelTransfertDate1a\">
		<span class=\"LabelDate\">Arrivée <span class=\"date\">(dd/mm/aaaa)</span></span>
		<span class=\"controlePanel\"> <input  type=\"text\" class=\"inputDate\" name=\"dateArrivee\" id=\"dateArrivee\"  value=\"". $this->voyage->dateArrivee ."\" title=\"date d\'arrivée du voyage\" />
		à <select  name=\"heureArrivee\" id=\"heureArrivee\">".$this->genOptionsHeures($this->voyage->heureArrivee)."</select>
		<select  name=\"minutesArrivee\" id=\"minutesArrivee\">".$this->genOptionsMinutes($this->voyage->minutesArrivee)."</select>
		</span></div>
		</div>
		<!-- <div class=\"panelTransfertDate2\"><span class=\"textButton\">Estimer la date d'arrivée</span></div> -->
		<div class=\"clearboth\"></div></div>
		";
	}
    
    function createVoyageRetour()
	{
		echo"
		<div class=\"panelTransfertDate0\">
		<div class=\"panelTransfertDate1\">
		<div class=\"panelTransfertDate1a\">
		<span class=\"LabelDate\">Départ <span class=\"date\">(dd/mm/aaaa)</span></span>
		<span class=\"controlePanel\"><input  type=\"text\" class=\"inputDate\" name=\"dateDepartR\" id=\"dateDepartR\"  value=\"". $this->voyage->dateDepartR ."\" title=\"date du départ du voyage retour\" />
  		à <select  name=\"heureDepartR\" id=\"heureDepartR\">".$this->genOptionsHeures($this->voyage->heureDepartR)."</select>
		<select  name=\"minutesDepartR\" id=\"minutesDepartR\">".$this->genOptionsMinutes($this->voyage->minutesDepartR)."</select>
		</span></div>
		<div class=\"panelTransfertDate1a\">
		<span class=\"LabelDate\">Arrivée <span class=\"date\">(dd/mm/aaaa)</span></span>
		<span class=\"controlePanel\"> <input   type=\"text\" class=\"inputDate\"  name=\"dateArriveeR\" id=\"dateArriveeR\"  value=\"". $this->voyage->dateArriveeR ."\" title=\"date d\'arrivée du voyage retour\" />
 		à <select  name=\"heureArriveeR\" id=\"heureArriveeR\">".$this->genOptionsHeures($this->voyage->heureArriveeR)."</select>
		<select  name=\"minutesArriveeR\" id=\"minutesArriveeR\">".$this->genOptionsMinutes($this->voyage->minutesArriveeR)."</select>
		</span></div>
		</div>
		<!-- <div class=\"panelTransfertDate2\"> <span class=\"textButton\">Estimer la date d'arrivée</span> </div> -->
		<div class=\"clearboth\"></div>
		";
		

}
   
     
    function createBudget()
    {	
		echo "<div class=\"panelFormLine\"><span class=\"warning\">Le budget est donné à titre indicatif, les prix des offres sont fixés par les sociétés de transport</span></div>";
		
//       	echo "
//		<div class=\"panelFormLine\">
//		<span id=\"estimeCout\" class=\"textButton\" onclick=startDevis();printPrixDevis();> Estimer le cout du voyage </span>
//		<div id=\"outBudget\"></div>
//		</div>";
		
		echo "<div class=\"panelFormLine\">
		<label class=\"labelAlignRight\" for=\"budget\" title=\"budget informationnel\">budget (<span id=\"budgetFacultatif\">Facultatif</span>) :</label>
        <input type=\"text\" name=\"budget\" id=\"budget\" value=\"".$this->voyage->budget."\" title=\"budget informationnel\" onKeyPress=\"return numbersonly(this, event)\"
		<span>€</span>
		</div>";    	
    }
    
    function createCapacite()
    {
    	echo "<label class=\"labelAlignRight\" for=\"capacite\" title=\"nombre total de voyageur\">Nombre de voyageurs: </label>
        <input type=\"text\" name=\"capacite\" id=\"capacite\" maxlength=\"3\" value=\"".$this->voyage->capacite."\" title=\"nombre total de voyageur\" onKeyPress=\"return numbersonly(this, event)\"/>
        <span> personnes</span>";
    }
    
	function createBus($selected) {
		echo "<label class=\"labelAlignRight\" id=\"nbrbus\">Nombre de cars: </label>";
		echo "<select name=\"nbrBus\" onchange=\"createSeatPerBusSelectBox()\" id=\"tableSelect\">";
		if($selected == "choixTransporteur"){
			 $selectAttrib="selected=\"selected\"";
		}
		echo "<option value=\"noBus\" ".$selectAttrib." >pas de préférence</option>";
		$selectAttrib ="";
		
		 for($i=1; $i<count(getNbrBusArray()); $i++){
		 	if($selected == getNbrBusArray($i)){
		 		$selectAttrib = "selected=\"selected\"";
		 	}
	        	echo "<option value=\"".getNbrBusArray($i)."\" ".$selectAttrib.">".getNbrBusArray($i)."</option>";
		 		$selectAttrib ="";
		 } 
		echo "</select>";	
		//
	}	
	
		
	function createBusSeat($tabSelected)
	{
		
		$total = 0;
		echo "<label class=\"labelAlignRight\" name=\"placesparbus\" id=\"placesparbus\">Nombre de sièges par car: </label>";
		echo "<span name=\"overwrite_bus\" id=\"overwrite_bus\">";
		
		if(isset($tabSelected) && !empty($tabSelected))
		{
			foreach( $tabSelected as $key => $nbrBusvalue ){
				echo "<select id=\"NumberOfBus".$key."\"  onchange=\"BusCount(this)\" name=\"nbrPlaceBus_".$key."\">";
				for($i=0; $i<count(getSeatPerBusArray()); $i++){
			 		if($nbrBusvalue == getSeatPerBusArray($i)){
			 			$selectAttrib = " selected=\"selected\"";
			 		}
		        	echo "<option value=\"".getSeatPerBusArray($i)."\"".$selectAttrib.">".getSeatPerBusArray($i)."</option>";
			 		$selectAttrib ="";	
				 }
				 if(!empty($nbrBusvalue))
				 $total += intval($nbrBusvalue);
				 
				echo "</select>"; 
			}	 
		    echo "</select>
				 </span>";
			echo "<span id=\"somme\">";
			if(!empty($total))
				echo "Total = <b>$total</b>";
			echo "</span>";
		}
		else{
			echo "</span>";
			echo "<span id=\"somme\">";
			echo "</span>";
			
		}
	}
	
	function createTypeBus()
	{
		$tabTypeBus = getTypeBusName();
		
		echo "<label class=\"labelAlignRight\" for=\"typeBus\" title=\"Type de car\">Type de car: </label>";
		echo "<select id=\"typeBus\" name=\"typeBus\">";
		
		$selectAttrib[$this->voyage->typeBus]= "selected=\"selected\"";
		foreach($tabTypeBus as $key => $typeBus)
		{
			echo "<option value=".$key." ".$selectAttrib[$key].">".$typeBus."</option>";
		}
		
		echo "</select>";	
	}
	
	function createDiviserAnnonces()
	{
		 if($this->voyage->diviserAnnonces)
		 	$checked[$this->voyage->diviserAnnonces] =  "checked=\"checked\"";
	 	echo "<label class=\"labelAlignRight\" for=\"diviserAnnonces\">Diviser les annonces: </label>";
        echo "<input type=\"checkbox\" ".$checked[$this->voyage->diviserAnnonces]." name=\"diviserAnnonces\" id=\"diviserAnnonces\"  onclick=\"innerHTMLDiviserAnnonces();\"/>";
        echo "<a href=\"javascript:void(0);\" onclick=\"return  overlib('Si vous devez transporter un grand nombre de personnes, nous vous conseillons de diviser votre demande en plusieurs annonces indépendantes afin qu\'une majorité de transporteurs puisse vous répondre. <br />Vous bénéficierez ainsi d\'une plus forte concurrence tarifaire. <br /><br />En contrepartie vous devrez probablement traiter avec différents transporteurs.<br /><br />Si vous cochez cette case, il y aura autant d\'annonces que de bus. Le budget de chaque annonce sera divisé par le nombre de bus <br /> (Ex.  Nombre de cars : 5, Budget de 5000€ => 5 annonces de 1000€ chacune) <br /><br /><i>Cette option n\'est activable que si vous avez spécifiez le nombre de bus nécessaire ainsi qu\'un budget </i> ', parent.CAPTION, '<strong>Diviser les annonces</strong>',parent.CAPTIONPADDING,'4',parent.FGCOLOR, '#FDFDFD',parent.WIDTH, '350',parent.STICKY,parent.CGBACKGROUND,'images/shade_caption.gif',parent.CLOSECLICK,parent.CLOSECOLOR,'#132884', parent.TEXTSIZE,'10px',OFFSETX, -150);\"  onmouseout=\"nd();\"><img src=images/interrogation.gif></a>";
	}
	
	
	function createDoublage()
	{
	 	if($this->voyage->doublage)
	 		$checked[$this->voyage->doublage] = "checked=\"checked\"";
	 	echo "<label class=\"labelAlignRight\" for=\"doublage\">Doublage du conducteur: </label>";
        echo "<input type=\"checkbox\" ".$checked[$this->voyage->doublage]." name=\"doublage\" id=\"doublage\"  />";
        echo "<a href=\"javascript:void(0);\" onclick=\"return  overlib('Le doublage du conducteur est obligatoire pour un temps de trajet superieur à 8h', parent.CAPTION, '<strong>Immobilisation du bus</strong>',parent.CAPTIONPADDING,'4',parent.FGCOLOR, '#FDFDFD',parent.WIDTH, '350',parent.STICKY,parent.CGBACKGROUND,'images/shade_caption.gif',parent.CLOSECLICK,parent.CLOSECOLOR,'#132884', parent.TEXTSIZE,'10px',OFFSETX, -150);\"  onmouseout=\"nd();\"><img src=images/interrogation.gif></a>";
		
	}

	
	function createImmobilisation()
	{

	 	if($this->voyage->immobilisation)
	 		$checked[$this->voyage->immobilisation] = "checked=\"checked\"";	 	
	 	echo "<label class=\"labelAlignRight\" for=\"immobilisation\">Besoin d'un/des bus sur place: </label>";
        echo "<input type=\"checkbox\" ".$checked[$this->voyage->immobilisation]." name=\"immobilisation\" id=\"immobilisation\" />";
        echo "<a href=\"javascript:void(0);\" onclick=\"return  overlib('Si vous avez besoin d\'immobiliser le bus pour une journée, ou une nuit , veuillez cocher la case', parent.CAPTION, '<strong>Immobilisation du bus</strong>',parent.CAPTIONPADDING,'4',parent.FGCOLOR, '#FDFDFD',parent.WIDTH, '350',parent.STICKY,parent.CGBACKGROUND,'images/shade_caption.gif',parent.CLOSECLICK,parent.CLOSECOLOR,'#132884', parent.TEXTSIZE,'10px',OFFSETX, -150);\"  onmouseout=\"nd();\"><img src=images/interrogation.gif></a>";

	}
		
	function createInfoComplementaires()
	{	
		echo "<textarea id=\"dcommentaires\" name=\"commentaires\" value=\"".$this->voyage->commentaires."\" COLS=40 ROWS=5 ></textarea>
        <script> document.getElementById(\"dcommentaires\").value=\"".$this->voyage->commentaires."\"</script>";
	}
		
	////éléments du résumé de confirmation
	function printDates()
	{
		if($this->voyage->typeVoyage == 'transfert')
		{
						
			if($this->voyage->typeTransfert == 'ar')
			{
				echo "<li>Voyage aller:<br />  
				Départ le <b>".$this->voyage->dateDepart."</b> à <b>".$this->voyage->heureDepart."h".$this->voyage->minutesDepart."</b><br />
				Arrivée le <b>".$this->voyage->dateArrivee."</b> à <b>".$this->voyage->heureArrivee."h".$this->voyage->minutesArrivee."</b><br />
				</li><li>Voyage retour:<br /> 
				Départ le <b>".$this->voyage->dateDepartR."</b> à <b>".$this->voyage->heureDepartR."h".$this->voyage->minutesDepartR."</b><br />
				Arrivée le <b>".$this->voyage->dateArriveeR."</b> à <b>".$this->voyage->heureArriveeR."h".$this->voyage->minutesArriveeR."</b>	
				</li>"; 
			}
			
			else if($this->voyage->typeTransfert == 'a')
			{
				echo"<li>Départ le <b>".$this->voyage->dateDepart."</b> à <b>".$this->voyage->heureDepart."h".$this->voyage->minutesDepart."</b></li>";
				echo"<li>Arrivée le <b>".$this->voyage->dateArrivee."</b> à <b>".$this->voyage->heureArrivee."h".$this->voyage->minutesArrivee."</b></li>";
			}
		}
		if($this->voyage->typeVoyage == 'circuit')
		{
			echo"<li>Départ le <b>".$this->voyage->dateDepart."</b> à <b>".$this->voyage->heureDepart."h".$this->voyage->minutesDepart."</b></li>";
			echo"<li>Retour le <b>".$this->voyage->dateArrivee."</b> à <b>".$this->voyage->heureArrivee."h".$this->voyage->minutesArrivee."</b></li>";
		}
		if($this->voyage->typeVoyage == 'séjour')
		{
			echo"<li>Départ le <b>".$this->voyage->dateDepart."</b> à <b>".$this->voyage->heureDepart."h".$this->voyage->minutesDepart."</b></li>";
			echo"<li>Arrivée le <b>".$this->voyage->dateArrivee."</b> à <b>".$this->voyage->heureArrivee."h".$this->voyage->minutesArrivee."</b></li>";
		}	
	}
	
	function printTrajet()
	{
		if($this->voyage->typeVoyage == 'transfert'){
			if($this->voyage->typeTransfert == 'a')
				$typeTransfert = "";
			else if($this->voyage->typeTransfert == 'ar')
				$typeTransfert = " <img src=\"images/style1/arrow_refresh.gif\" alt=\"aller retour\" /> ";
		}
		else 
			$typeTransfert="";
			
		echo "<li>Trajet $typeTransfert : ".$this->voyage->villes[0];
		for($i=1; $i<count($this->voyage->villes);$i++){
			echo " <img src=\"images/style1/arrow_right.gif\" alt=\"vers\" /> ".$this->voyage->villes[$i];
		}
		echo "</li>";
		
		
	
	}
	
	function printKilometrage()
	{
		echo "<li>kilomètres en charge: ".$this->voyage->distance;
		if($this->voyage->typeTransfert == 'ar'){
			echo " * 2 = ". $this->voyage->distance *2;
		} 
		echo " km</li>";;
	}
	
	function printTransport()
	{
		echo "<li>nombre de voyageurs: ".$this->voyage->capacite."</li>";
		if(!($this->voyage->nbrBus == 'noBus'))
		{
			echo "<li>nombre de cars: ".$this->voyage->nbrBus."</li>";
			echo "<li>nombre de sièges par car: ";
			for($i=0;$i<$this->voyage->nbrBus;$i++)
				echo "car $i: ".$this->voyage->placesParBus[$i].", ";
			echo "</li>";
			
		}
		else
			echo "<li>nombre de cars: à définir par le transporteur</li>";

		echo "<li>type de car: ".$this->voyage->typeBus."</li>";
		if(!empty($this->voyage->commentaires))
			echo "<li>informations complémentaires: ".$this->voyage->commentaires."</li>";


		if(($this->voyage->diviserAnnonces))
		{
				for($i=1; $i <= $this->voyage->nbrBus; $i++ ) {
					echo "<li>Annonce $i: ".floor($this->voyage->budget/$this->voyage->nbrBus)." €</li>";					
				}
		}
		else
		{
			if(!empty($this->voyage->budget))
					echo "<li>budget: ".$this->voyage->budget." €</li>";
		}
		



		
	}
	
	
	
	function printImmobilisation()
	{
		echo "<li> Immobilisation du bus: ";
		if($this->voyage->immobilisation)  echo "Oui"; else echo "Non";
		echo "</li>";		
	} 
	
	function printDoublage()
	{
		echo "<li> Doublage: ";
		if($this->voyage->doublage)  echo "Oui"; else echo "Non";
		echo "</li>";		
	}

	function printDiviserAnnonces()
	{
		echo "<li> Diviser annonces: ";
		if($this->voyage->diviserAnnonces)  echo "Oui"; else echo "Non";
		echo "</li>";	
	}

}

  
?>