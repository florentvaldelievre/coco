<?php

if(defined("__CalculPrix"))
    return;

define("__CalculPrix","");


define("jour",2);
define("mois",4);
define("annee",5);

define("heure",1);
define("minute",2);
define("seconde",3);

//Nombre de secondes depuis le début du jour
function strtosec($str)
{
    if( ereg ("([0-9]{2}):([0-9]{2}):([0-9]{2})", $str, $regs))
        $sec = intval($regs[seconde])+60*(intval($regs[minute])+60*intval($regs[heure]));
    return $sec;
}

function nb_heure_voyage($heuredepart,$heurearrive)
{
    $nb = ceil( (strtosec($heurearrive)-strtosec($heuredepart))/3600 );
    if($nb<0)
    {
        $nb = $nb+24;
    }
    return $nb;
}

function nb_jour_mois($mois,$annee)
{
    return cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
}

//Nombre de jours depuis le début de l'année
function nb_jour($jour,$mois,$annee)
{
    $nb=0;
    for($i=1;$i<$mois;$i++)
    {
        $nb = $nb + nb_jour_mois($i,$annee);
    }
    $nb = $nb + $jour;
    return $nb;
}

function nb_jour_voyage($depart,$arrive)
{
    if($depart[annee] == $arrive[annee] )
    {
        //$nb_jour_voyage =  nb_jour(DEPART) - nb_jour(ARRIVE)
        $nb_jour_voyage = nb_jour($arrive[jour],$arrive[mois],$arrive[annee]) - nb_jour($depart[jour],$depart[mois],$depart[annee]);
    }
    else if($depart[annee] == $arrive[annee] -1)
    {
        //$nb_jour_voyage =  nb_jour(DEPART) + (365 ou 366) - nb_jour(ARRIVE)
        $nb_jour_voyage = nb_jour($arrive[jour],$arrive[mois],$arrive[annee]) + 365 + ( nb_jour_mois(2,$depart[annee]) - 28) - nb_jour($depart[jour],$depart[mois],$depart[annee]);
    }
    else
    {
        //$nb_jour_voyage =  nb_jour(DEPART) + n*(365 ou 366) - nb_jour(ARRIVE)
        $nb_jour_voyage = 0;
        for($i=1;$i<$arrive[annee]-$depart[annee];$i++)
        {
            $nb_jour_voyage += 365 + (nb_jour_mois(2,$depart[annee]+$i-1) -28);
        }
        $nb_jour_voyage += nb_jour($arrive[jour],$arrive[mois],$arrive[annee]);
        $nb_jour_voyage -= nb_jour($depart[jour],$depart[mois],$depart[annee]);
    }

    return $nb_jour_voyage;
}

function nb_repas_jour($heuredepart,$heurearrive)
{
 if( ereg ("([0-9]{2}):([0-9]{2}):([0-9]{2})", $heuredepart, $departregs) && ereg ("([0-9]{2}):([0-9]{2}):([0-9]{2})", $heurearrive, $arriveregs))
 {
  $nbr_repas = 0;
  if($departregs[heure]<11 && $arriveregs[heure]>13)
     $nbr_repas++;
  if($departregs[heure]<19 && $arriveregs[heure]>21)
     $nbr_repas++;
 }
 return $nbr_repas;
}

function nb_repas_voyage($date_depart,$heuredepart,$date_arrive,$heurearrive)
{
  if( ereg ("([0]{0,1})([0-9]{1,2})/([0]{0,1})([0-9]{1,2})/([0-9]{4})",$date_depart, $depart)
     &&  ereg ("([0]{0,1})([0-9]{1,2})/([0]{0,1})([0-9]{1,2})/([0-9]{4})",$date_arrive, $arrive) )
 {
        $nb_jour = nb_jour_voyage($depart,$arrive);

        if($nb_jour == 0)
        {
            $nb_repas = nb_repas_jour($heuredepart,$heurearrive);
        }
        else
        {
            $nb_repas = 0;
            $nb_repas += nb_repas_jour($heuredepart,"24:00:00");
            $nb_repas += nb_repas_jour("00:00:00",$heurearrive);
            $nb_repas += 2*($nb_jour - 1);
        }
        return $nb_repas;
 }
}


?>