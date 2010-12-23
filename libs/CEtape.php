<?php

if(defined("__CEtape"))
    return;

define("__CEtape","");



/*
 * CEtape modelise une étape
 */
class CEtape
{

/*
 * nom de la ville
 * @string $ville
 */   
    var $ville;
/*
 * date d Arrivée à l etape
 * @string $dateArrivee
 */ 
    var $datearrive;
    
/*
 * date de départ de l etape
 * @string $dateDepart
 */ 
    var $datedepart;
    
/*
 * heure d Arrivée à l etape
 * @string $heureArrivee
 */ 
    var $heurearrive;
    
/*
 * heure de départ de l etape
 * @string $heureDepart
 */ 
    var $heuredepart;
    

    function __construct($ville, $datearrive, $datedepart, $heurearrive, $heuredepart)
    {
        $this->ville=$ville;
        $this->datearrive=$datearrive;
        $this->datedepart=$datedepart;
        $this->heurearrive=$heurearrive;
        $this->heuredepart=$heuredepart;  
    }
    
    function __get($key)
    {
         return $this->$key;
    }
     
}
?>