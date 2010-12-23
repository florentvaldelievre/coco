<?php
if( $infos["typetransport"]=="transfert")
{
    echo " <script language=\"JavaScript\" type=\"text/javascript\" src=\"javascript/voyage.js\"></script>";
}
else if( $infos["typetransport"]=="dispo")
{
    echo " <script language=\"JavaScript\" type=\"text/javascript\" src=\"javascript/dispo.js\"></script>";
}
else if( $infos["typetransport"]=="sejour")
{
    echo " <script language=\"JavaScript\" type=\"text/javascript\" src=\"javascript/sejour.js\"></script>";
}
if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }    
if(isset($_SESSION['username'])) {
if($_POST[validerform])
    {
       

       
        $diviserAnnonces = $_SESSION["diviserAnnonces"];
		
	

        $infos=$_SESSION["info_transport"];

        $infos["dtag"]="newdemande";
        
        $infos["idutilisateur"]=$_SESSION['idutilisateur'];
       
        $dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
        
        
        $dTR = new CObjetBDD();
   
        
        $itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
        $itineraireGestion->nouvelItineraire($_SESSION["etapes"], $iddemandetr);
        
      
        //cas pas de division des annoncse
        if(empty($diviserAnnonces))
        {
            $dTR->set($infos);
        	$iddemandetr = $dtrDAO->insert($dTR);
        	$itineraireGestion->nouvelItineraire($_SESSION["etapes"], $iddemandetr);
        }
        //cas division des annonces
    	else	
	  	{
			
			$tabPlacesParBus = explode(",", $infos["PlacesParBus"]);
			
			//nombre totale de places effective
			$totalPlacesParBus=0;
			for($i=0; $i<count($tabPlacesParBus);$i++)
			{
				$totalPlacesParBus+=$tabPlacesParBus[$i];
			}
			
			
			$tarifTotal=$infos["tarifadopte"];
			
			for($i=0;$i<count($tabPlacesParBus);$i++)
			{
				//calcul du tarif en fct de la taille du bus
				floor($tabPlacesParBus[$i]*$tarifTotal/$totalPlacesParBus);
				/*
				 * TO FIX : Warning: Division by zero in c:\Users\Florent\workspace\chartercar\formulaires\demandetransport_valider.php on line 61
				 * Traiter le cas si on ne spécifie pas le nbr de bus
				 */
				$infos["PlacesParBus"]=$tabPlacesParBus[$i];
				$infos["capacitenecessaire"]=$tabPlacesParBus[$i];
				$infos["nbrbus"]=1;
				$dTR->set($infos);
				$iddemandetr = $dtrDAO->insert($dTR);
				$itineraireGestion->nouvelItineraire($_SESSION["etapes"], $iddemandetr);
			}		
	  	}


      	   		 require("Rss/write_rss.php"); //écriture du fichier XML


                $_POST['url']="index.php?action=listing_newdemande";
				$_POST['message']="Votre demande de transport a été validée et a été placée dans mes demandes <strong>En attente de réponse</strong>";
                include("formulaires/redirectMessage.php");


    }
   else
   {
    $infos = $_SESSION["info_transport"];
    $diviserAnnonces = $_SESSION["diviserAnnonces"];
       
       $tab = Array("","AL","DE","AD","AM","AT","BE","BY","BA","BG","CY","HR","DK","ES","EE","FO","FR","GE","GI","GB","GR","HU","IE","IT","LT","LU","LE","MT","MA","MD","MC","NO","NL","PL","PT","RO","RU","CZ","SK","CH","SE","UA","YU");
       $tab2 = Array("Votre choix","Albanie","Allemagne","Andore","Arménie","Autriche","Belgique","Biélorussie","Bosnie et Hér.","Bulgarie","Chypre","Croatie","Dannemark","Espagne","Estonie","Féroé","France","Géorgie","Gibraltar","Gr. Bretagne","Gréce","Hongrie","Irlande","Italie","Lituanie","Luxembourg","Létonie","Malte","Maroc","Moldavie","Monaco","Norvége","Pays Bas","Pologne","Portugal","Roumanie","Russie","Rép. Tchéque","Slovaquie","Suisse","Suéde","Ukraine","Yougoslavie");
       $paysINITIAL=count($tab);
       for($i=0; $i<($paysINITIAL); $i++) {
           if($infos['paysdepart'] == $tab[$i] )
           {
            $infos['paysdepart']=$tab2[$i];   
           } 
           if($infos['paysarrive'] == $tab[$i] )
           {
            $infos['paysarrive']=$tab2[$i];   
           }  
       }
   
      $tab = Array("Scolaire","Excursion","GT");
      $tab2 = Array("Ballade","Excursion","Grand Tourisme");
      $typecarValue=count($tab);
      for($i=0; $i<($typecarValue); $i++) {
            if($infos['typecar'] == $tab[$i] )
            {
             $infos['typecar'] = $tab2[$i];
            }
      }
   

     $infos[dcommentaires]=str_replace ("\n", "<br />", $infos[dcommentaires]);
	 echo " <pre>Recapitulatif du <i>$infos[typetransport]</i></pre><br />";

	 echo "<fieldset class=\"demandetransport\"><legend> Voyage &nbsp; </legend><br />
			<div class=\"recapitulatif\">";

	 if($infos[typetransport]=="transfert")
	 {
	  		 if($infos[typetrajet]== "aller_simple")
	   		 {
	   			echo "  Type voyage : $infos[typetrajet]<br/>
						Départ de <strong>$infos[villedepart]</strong> le $infos[datedepart] à $infos[heuredepart]<br />
		     			Arrivée à <strong>$infos[villearrive]</strong> le $infos[datearrive] à $infos[heurearrive]<br />
						Type Car : $infos[typecar]<br/>
						Capacité necessaire : $infos[capacitenecessaire]<br />";
						if($infos[nbrbus]=="")
						{
							echo	"Nombre de Bus : N/C <br />";
							echo   "Place par bus : N/C <br />";
						}
						else
						{
							echo   "Nombre de Bus : $infos[nbrbus] <br />";	
							echo   "Place par bus $infos[PlacesParBus] <br />";
						}
							
				
					echo "	Kilometrage en charge : $infos[kilometragealler] <br />
						Repas à charge du conducteur : $infos[nbrRepasTotal] <br />
						nuit(s) à charge du conducteur : $infos[nbrnuittotal] <br />
						Notre Tarif conseillé : <i>$infos[tarifconseille]</i> <br />";
						
						if(empty($infos[tarifadopte]))
							echo "Votre Tarif : N/C";
						else
							echo "Votre Tarif : <strong><font color=red>$infos[tarifadopte]€</font> </strong>";
						echo "<br /><br /><strong>Informations voyage</strong> : <br /> <i>$infos[dcommentaires]</i>";				
		 
	   		 }
			 else //AR
			 {
	   			echo "  Type voyage : $infos[typetrajet]<br/>
						<pre>Aller </pre>	Départ de <strong>$infos[villedepart]</strong> le $infos[datedepart] à $infos[heuredepart]<br />
		     								Arrivée à <strong>$infos[villearrive]</strong> le $infos[datearrive] à $infos[heurearrive]<br />
						
						<pre> Retour </pre>	Départ de <strong>$infos[villearrive]</strong> le $infos[datedepartR] à $infos[heuredepartR]<br />
		     								Arrivée à <strong>$infos[villedepart]</strong> le $infos[datearriveR] à $infos[heurearriveR]<br /><br />


						Type Car : $infos[typecar]<br/>
						Capacité necessaire : $infos[capacitenecessaire]<br />";
						if($infos[nbrbus]=="")
						{
							echo	"Nombre de Bus : N/C <br />";
							echo   "Place par bus : N/C <br />";
						}
						else
						{
							echo   "Nombre de Bus : $infos[nbrbus] <br />";	
							echo   "Place par bus $infos[PlacesParBus] <br />";
						}
						
			echo "		<br />
						Kilometrage en charge : 2*$infos[kilometragealler] <br />					
						Repas à charge du conducteur : $infos[nbrRepasTotal] <br />
						nuit(s) à charge du conducteur : $infos[nbrnuittotal] <br />
						Notre Tarif conseillé : <i>$infos[tarifconseille]</i> <br />";
						if(empty($infos[tarifadopte]))
							echo "Votre Tarif : N/C";
						else
							echo "Votre Tarif : <strong><font color=red>$infos[tarifadopte]€</font> </strong>";
						echo "<br /><br /><strong>Informations voyage</strong> : <br /> <i>$infos[dcommentaires]</i>";				
		 			 	
			 	
			 }
				
		     
	 }

	 else if(($infos[typetransport]=="dispo") || ($infos[typetransport]=="sejour"))
	 {
	
		   			echo " 
								Départ de <strong>$infos[villedepart]</strong> le $infos[datedepart] à $infos[heuredepart]<br />
 								Arrivée à <strong>".end($_SESSION["etapes"])."</strong> le $infos[datearrive] à $infos[heurearrive]<br /><br />";
						
						echo "Etapes : <strong>";
		
						 
						
						foreach($_SESSION["etapes"] as $etape => $value)
						{			
							if(count($_SESSION["etapes"])==$etape+1)
							{
							echo $value;
							}
							else
							{
							echo $value." => ";
							}
						}
echo "					</strong><br/>


						Type Car : $infos[typecar]<br/>
						Capacité necessaire : $infos[capacitenecessaire]<br />";
						if($infos[nbrbus]=="")
						{
							echo	"Nombre de Bus : N/C <br />";
							echo   "Place par bus : N/C <br />";
						}
						else
						{
							echo   "Nombre de Bus : $infos[nbrbus] <br />";	
							echo   "Place par bus $infos[PlacesParBus] <br />";
						}
				echo  "	
						Bus sur place : $infos[BusSurPlace]<br/>
						Kilometrage en charge : $infos[kilometragealler] <br />
						Repas à charge du conducteur : $infos[nbrRepasTotal] <br />
						Nuit(s) à charge du conducteur : $infos[nbrnuittotal] <br />
						Doublage conducteur : $infos[doublagealler]<br/>
						Notre Tarif conseillé : <i>$infos[tarifconseille]</i> <br />";
						if(empty($infos[tarifadopte]))
							echo "Votre Tarif : N/C";
						else
							echo "Votre Tarif : <strong><font color=red>$infos[tarifadopte]€</font> </strong>";
						echo "<br /><br /><strong>Informations voyage</strong> : <br /> <i>$infos[dcommentaires]</i>";				
		 
	 }




  	if(!empty($diviserAnnonces))	
  	{
  		
  		
		  	echo "</fieldset></div>";
		
			echo "<br /><br />";
			
		echo "<div class=\"panelcentre\" >";
		
		//Boite info - connexion
		echo "<div class=\"boiteinfo\">";
		
		echo "<div class=\"bandeauinfo\"><img src=\"./images/style1/exclamation-blue.gif\" alt=\"icon_exclamation-blue\" /></div> ";
		
		echo "<div class=\"boiteinfocontent\">
				<p>Vous avez activé la division des annonces. Un groupe de <strong>$infos[nbrbus] annonces distinctes </strong> à été créé.</p>";
		echo "<p> Le prix de chaque annonce est automatiquement calculée pour arrivé à un total de <strong>$infos[tarifadopte]€.</strong> (arrondi)</p>";
		  		
		  	

		$tabPlacesParBus = explode(",", $infos["PlacesParBus"]);
		
		//Compter le nombre total de place pour le calcul
	    for($i=0;$i<count($tabPlacesParBus);$i++)
		{
			$totalPlacesParBus+=$tabPlacesParBus[$i];
		}
		
		
		for($i=0;$i<count($tabPlacesParBus);$i++)
		{
			echo "Annonce n° ". ($i+1) ." : Un bus de ".$tabPlacesParBus[$i]." places à ".floor($tabPlacesParBus[$i]*$infos['tarifadopte']/$totalPlacesParBus). "€ <br />";	
		}		
  
  echo "</div>";

echo "<div class=\"footinfo\"><img class=\"alignright\" src=\"./images/style1/exclamation-blue.gif\" alt=\"icon_exclamation-blue\" /></div>";

echo "</div>";
  
  	}


     ?>
    
            <form name="reservation" id="reservation" method="post" target="_self" action="">
                 <div class="piedForm">
                         <input type="reset" name="reset" id="reset" value="Annuler" />
                         <input type="hidden" name="validerform" value="1"/>
                         <input type="submit" name="validerclient" id="valid" value="Valider et fin ( 3/3 )" />
                </div>
        </form>

    <?
   }

}
?>


