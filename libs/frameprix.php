

<?php
 if(defined("__frameprix"))
    return;

 define("__frameprix","");
 include_once("CalculPrix.php");
 
 include_once("CLog.php");   

 $allersimple = $_GET['allersimple'];
 $doublagealler = $_GET['doublageallerJS'];
 $heuredepartJS = $_GET['heuredepart'];
 $heurearriveJS =  $_GET['heurearrive'];
 $datedepart = $_GET['datedepartJS'];
 $datearrive = $_GET['datearriveJS'];
 $kilometragealler = $_GET['kilometrageallerJS'];
 $typebus = $_GET['typebus'];
 $BusSurPlace = $_GET['BusSurPlaceJS'];
 $doublageretour = $_GET['doublageretourJS'];
 $heuredepartRJS = $_GET['heuredepartRJS'];
 $heurearriveRJS =  $_GET['heurearriveRJS'];
 $datedepartRJS = $_GET['datedepartRJS'];
 $datearriveRJS = $_GET['datearriveRJS'];
 $kilometrageretour = $_GET['kilometrageretourJS'];
 $typetransport = $_GET['typetransport'];
 $placesparbus = $_GET['placesparbus'];
 $nbrRepasTotal = $_GET['nbrRepasTotal'];
 $nbrnuittotal = $_GET['nbrnuittotal'];
  
 
 $log = new CLog("../Logs/FramePrix.log");  
 if($BusSurPlace=="true") { $BusSurPlace="Oui"; } else { $BusSurPlace="Non"; }
 if($doublagealler == "true") { $doublagealler = "Oui"; } else { $doublagealler = "Non"; }
 if($typetransport=="transfert") {          

    if($allersimple == "true")
    {
    $bus = explode(",", $placesparbus);

    foreach($bus as $key=>$nbr_place)
    {
        $prixbus = coefficient_taille_bus($nbr_place) * prix_transfert($datedepart,$heuredepartJS,$datearrive,$heurearriveJS,$kilometragealler,$doublagealler,$typebus,$nbrRepasTotal,$nbrnuittotal);
        $prixaller += ceil($prixbus);
        $log->AddLog("Le prix du bus est: $prixbus euros, sa taille est $nbr_place(coef:".coefficient_taille_bus($nbr_place).")");      
    }
    $nbheurevoyagealler = nb_heure_voyage($heuredepartJS,$heurearriveJS);
    echo "<script type=\"text/javascript\">parent.overlib('- Durée du voyage aller: <strong>$nbheurevoyagealler heures</strong><br/>- Contenance des Bus: (<strong>$placesparbus</strong>)<br/> - Nombre de kilometres aller: <strong>$kilometragealler Km</strong><br />- Repas compris : <strong>($nbrRepasTotal*13é)*Nombre Bus [".count($bus)."]</strong><br />- Nuit(s) comprise(s) : <strong>($nbrnuittotal*60é)*Nombre Bus [".count($bus)."]</strong><br />- Tarif conseillé comprenant repas et nuit(s) : <strong><font color=red>$prixaller €</font></strong>',parent.CAPTION, '<strong>Recapitulatif du voyage</strong>',parent.CAPTIONPADDING,'4',parent.FGCOLOR, '#FDFDFD',parent.WIDTH, '320',parent.STICKY,parent.CGBACKGROUND,'images/shade_caption.gif',parent.PRINT,parent.PRINTCOLOR,'#132884',parent.CLOSECLICK,parent.CLOSECOLOR,'#132884', parent.TEXTSIZE,'10px', parent.OFFSETY, -50);</script>";
    }
    else if($allersimple == "false")
    {
    $kmtotal=$kilometragealler+$kilometrageretour;
    $nbheurevoyagealler = nb_heure_voyage($heuredepartJS,$heurearriveJS);
    $nbheurevoyageretour = nb_heure_voyage($heuredepartRJS,$heurearriveRJS);

    $bus = explode(",", $placesparbus);
    $prixaller = 0;
    $prixretour = 0;

    foreach($bus as $key=>$nbr_place)
    {
        $prixbus = coefficient_taille_bus($nbr_place) * prix_transfert($datedepart,$heuredepartJS,$datearrive,$heurearriveJS,$kilometragealler,$doublagealler,$typebus,$nbrRepasTotal,$nbrnuittotal);
        $prixaller += $prixbus;
        $prixretour += $prixbus;
        $log->AddLog("Le prix du bus est: $prixbus euros, sa taille est $nbr_place(coef:".coefficient_taille_bus($nbr_place).")");
    }
    $prixtotal = ceil($prixaller + $prixretour);
    echo "<script>parent.overlib(' - Durée du voyage Aller: <strong>$nbheurevoyagealler heures</strong><br/>- Contenance des Bus: (<strong>$placesparbus</strong>)<br/>- Durée du voyage Retour: <strong>$nbheurevoyageretour heures</strong><br/>- Bus sur place: <strong>$BusSurPlace</strong><br/>- Nombre de kilometres Total: <strong>$kmtotal Km</strong><br />- Repas compris : <strong>($nbrRepasTotal*13é)*Nombre Bus [".count($bus)."]</strong><br />- Nuit(s) comprise(s) : <strong>($nbrnuittotal*60é)*Nombre Bus [".count($bus)."]</strong><br />- Tarif conseillé comprenant repas et nuit(s) : <strong><font color=red>$prixtotal €</font></strong>',parent.CAPTION, '<strong>Recapitulatif du voyage</strong>',parent.CAPTIONPADDING,'4',parent.FGCOLOR, '#FDFDFD',parent.WIDTH, '320',parent.STICKY,parent.CGBACKGROUND,'images/shade_caption.gif',parent.PRINT,parent.PRINTCOLOR,'#132884',parent.CLOSECLICK,parent.CLOSECOLOR,'#132884', parent.TEXTSIZE,'10px', parent.OFFSETY, -60);</script>";
    }
 }

 if($typetransport=="dispo") {

    $nbheurevoyagealler = nb_heure_voyage($heuredepartJS,$heurearriveJS);
    $kmtotal=$kilometragealler;
    
    $bus = explode(",", $placesparbus);
    $prixaller = 0;
    foreach($bus as $key=>$nbr_place)
    {         
        $prixbus = coefficient_taille_bus($nbr_place) * prix_disponibilite($datedepart,$heuredepartJS,$datearrive,$heurearriveJS,$kilometragealler,$doublagealler,$typebus,$nbrRepasTotal,$nbrnuittotal);
        $prixaller += ceil($prixbus);
        $log->AddLog("Le prix du bus est: $prixbus euros, sa taille est $nbr_place(coef:".coefficient_taille_bus($nbr_place).")");
        
    
    }
       echo "<script type=\"text/javascript\">parent.overlib('- Départ le : <strong>$datedepart</strong> à <strong>$heuredepartJS </strong><br/> - Arrivée le : <strong>$datearrive</strong> à <strong>$heurearriveJS </strong><br/>- Contenance des Bus: (<strong>$placesparbus</strong>)<br/> - Doublage du conducteur : <strong>$doublagealler</strong><br/>- Nombre de kilometres total : <strong>$kilometragealler Km</strong><br />- Repas compris : <strong>($nbrRepasTotal*13é)*Nombre Bus [".count($bus)."]</strong><br />- Nuit(s) comprise(s) : <strong>($nbrnuittotal*60é)*Nombre Bus [".count($bus)."]</strong><br />- Tarif conseillé comprenant repas et nuit(s) : <strong><font color=red>$prixaller €</font></strong>',parent.CAPTION, '<strong>Recapitulatif du voyage</strong>',parent.CAPTIONPADDING,'4',parent.FGCOLOR, '#FDFDFD',parent.WIDTH, '320',parent.STICKY,parent.CGBACKGROUND,'images/shade_caption.gif',parent.PRINT,parent.PRINTCOLOR,'#132884',parent.CLOSECLICK,parent.CLOSECOLOR,'#132884', parent.TEXTSIZE,'10px', parent.OFFSETY, -50);</script>";

     
    }

  if($typetransport=="sejour") {

    $nbheurevoyagealler = nb_heure_voyage($heuredepartJS,$heurearriveJS);
    $kmtotal=$kilometragealler;
    
    $bus = explode(",", $placesparbus);
    $prixaller = 0;
    foreach($bus as $key=>$nbr_place)
    {
        $prixbus = coefficient_taille_bus($nbr_place) * prix_disponibilite($datedepart,$heuredepartJS,$datearrive,$heurearriveJS,$kilometragealler,$doublagealler,$typebus,$nbrRepasTotal,$nbrnuittotal);
        $prixaller +=  ceil($prixbus);
        $log->AddLog("Le prix du bus est: $prixbus euros, sa taille est $nbr_place(coef:".coefficient_taille_bus($nbr_place).")");
    }
    
     echo "<script type=\"text/javascript\">parent.overlib('- Départ le : <strong>$datedepart</strong> à <strong>$heuredepartJS </strong><br/> - Arrivée le : <strong>$datearrive</strong> à <strong>$heurearriveJS </strong><br/>- Contenance des Bus: (<strong>$placesparbus</strong>)<br/> - Doublage du conducteur : <strong>$doublagealler</strong><br/>- Nombre de kilometres total : <strong>$kilometragealler Km</strong><br />- Repas compris : <strong>($nbrRepasTotal*13é)*Nombre Bus [".count($bus)."]</strong><br />- Nuit(s) comprise(s) : <strong>($nbrnuittotal*60é)*Nombre Bus [".count($bus)."]</strong><br />- Tarif conseillé comprenant repas et nuit(s) : <strong><font color=red>$prixaller €</font></strong>',parent.CAPTION, '<strong>Recapitulatif du voyage</strong>',parent.CAPTIONPADDING,'4',parent.FGCOLOR, '#FDFDFD',parent.WIDTH, '320',parent.STICKY,parent.CGBACKGROUND,'images/shade_caption.gif',parent.PRINT,parent.PRINTCOLOR,'#132884',parent.CLOSECLICK,parent.CLOSECOLOR,'#132884', parent.TEXTSIZE,'10px', parent.OFFSETY, -50);</script>";
  }
   
    

?>