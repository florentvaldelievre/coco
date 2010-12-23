<?//todo: verifier que l'annonce existe car un autre transporteur a pu répondre à l'annonce pdt le temps de remplissage du formulaire

 include_once("libs/mailmanager.php");


if(($_SESSION['typeutilisateur']!="transporteur") ) 
{  
		include "./formulaires/inscriptiontransportredir.php"; 
}
else
{
	   $infos["iddemandetr"]=$_GET["iddemandetr"];
	   $dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
	   $demandetr = $dtrDAO->getById( $_GET["iddemandetr"] );

	$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
	$listeEtapes = $itineraireGestion->getItineraire($demandetr->get("iddemandetr"));
	
		
    echo " <script language=\"JavaScript\" type=\"text/javascript\" src=\"javascript/voyage.js\"></script>";


$erreurs = array();
if($_POST[validerform])
{
        if(empty($_POST['tarifttc']))
        {
                $erreurs['tarifttc'] = "";
        }

        if(!isset($_POST['NumberOfBus1']))
        {
                $erreurs['NumberOfBus1'] = "";
        }
        if(($_POST['bus'])=="Spécifier")
        {
                $erreurs['bus'] = "";
                
        }
        for($i=0; $i<$_POST['bus']; $i++) {
        $temp = "NumberOfBus".($i+1);
        $PlacesParBus[$i] = $_POST["$temp"];
       }
        $PlacesParBus = implode(",", $PlacesParBus);
        


        if( $erreurs == array() )
        {
                       
       
         		$infos["iddemandetr"]=$_GET["iddemandetr"];
                $infos["idcontact"]=$_SESSION["idcontact"];
                $infos["iddemandetr"]=$_GET["iddemandetr"];
                $infos["tarifttc"]=$_POST['tarifttc'];
                //$infos["nbrconducteur"]=$_POST['nbrconducteur'];
                $infos["doublage"]=$_POST['doublage'];
                $infos["capacitecar"]=$PlacesParBus;                
                $infos["nbrcar"]=$_POST['bus'];
                $infos["equipement"]=$_POST['equipement'];
                $infos["conditions"]="";
                $infos["rcommentaires"]=$_POST['rcommentaires']; 
                $infos["datereponse"]=date('Y-m-j H:i:s');  
                $_SESSION["repondreannonce"]=$infos;
                echo "<meta http-equiv=refresh content=\"0; url=?action=repondreannonce2\">";

        }
}


?>

        <div class="panelcentre">
        <div class="boiteform">
        

        
        <div class="bandeauform">
                 <h4>Reponse pour <?echo $demandetr->get("typetransport")." n°". $demandetr->get("iddemandetr") ?></h4>
        </div>
          <div class="corpForm"> 
       <fieldset> <legend>Recapitulatif</legend> <br/> 
           
         <?
     	  echo  CAffichageAnnonceVoyageur::getInfoAnnonceVoyageur($demandetr,$listeEtapes);
         ?>
         </fieldset>
          </div> 
   
        
        <form name="repondreannonce" id="repondreannonce" method="post" target="_self" action="">
                <div class="corpForm"> 
                
                    
                                
							<div/>
                              <fieldset> <legend>Réponse</legend> <br/> 
                               <p>
                                 
                                 
								<?
								 echo createBus($selected);
								 echo createBusSeat($demandetr);
  
                                ?>
                              	</p>
                        		<p>
                 
	                               <label for="tarifclient"  title="Tarif du client" >Tarif TTC du client</label>
	                                <input type="text" disabled="disabled" name="tarifclient" id="tarifclient" value="<?echo CListingAffichage::afficheTarifAdopte($demandetr,"");?>" />
	                               <span> €</span>
                             	 </p>

                                
                                <p>

                                        <label id="tarifttc" for="tarifttc"  title="Tarif transporteur TTC" >Votre Tarif TTC</label>
                                        <input type="text" name="tarifttc" value="<?echo $_POST[tarifttc];?>" title="tarif transporteur ttc" />
                                        <span> €</span>
                                          <? if(isset($erreurs['tarifttc']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[tarifttc]</img>";
                                             }
                                          ?>

                                </p>




                                
                                <p>
                                    <?  /*
                                    if( $demandetr->get("typetransport")!="transfert") {

                                        echo "<label for=\"doublage\">Doublage du conducteur :</label>";
                                        if($_POST[validerform])
                                        {
                                            if($_POST['doublage']=="true")
                                            {
                                             echo "<input type=\"radio\" name=\"doublage\" id=\"doublagealleroui\" checked=\"checked\" value=\"true\">Oui&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                             echo "<input type=\"radio\" name=\"doublage\" id=\"doublageallernon\" value=\"false\">Non&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                            }
                                            else if($_POST['doublage']=="false")
                                            {
                                                echo "<input type=\"radio\" name=\"doublage\" id=\"doublagealleroui\" value=\"true\">Oui&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                echo "<input type=\"radio\" name=\"doublage\" id=\"doublageallernon\" checked=\"checked\" value=\"false\">Non&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                            }

                                        }
                                          else if($demandetr->get("doublage") == "true")
                                            {
                                             echo "<input type=\"radio\" name=\"doublage\" id=\"doublagealleroui\" checked=\"checked\" value=\"true\">Oui&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                             echo "<input type=\"radio\" name=\"doublage\" id=\"doublageallernon\"  value=\"false\">Non&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                            }
                                            else
                                            {
                                             echo "<input type=\"radio\" name=\"doublage\" id=\"doublagealleroui\"  value=\"true\">Oui&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                             echo "<input type=\"radio\" name=\"doublage\" id=\"doublageallernon\"  checked=\"checked\" value=\"false\">Non&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                            }

                                            if(isset($erreurs['doublage']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[doublage]</img>";
                                             }
                                        echo "&nbsp;<a href=\"javascript:void(0);\" onclick=\"return  overlib('Le doublage du conducteur est obligatoire lorsque:<br/><br/> <strong> - durée du voyage dépassant 8 heures</strong><br /> ', STICKY,CAPICON,'images/IconBus.gif', CAPTION, '  Informations doublage',WIDTH, 295,BGCOLOR, '#0758BC', CLOSECOLOR, 'white');\"  onmouseout=\"nd();\"><img src=images/interrogation.gif></a>";
                                     }
                                    */ ?>    
                                </p>
                                
                                

                                
                                
                                
                             
                                <p>

                                        <label for="equipement" title="Equipement proposé ">Spécificité du car :</label>
                                        <input type="text" name="equipement" id="equipement" value="<?echo $_POST[equipement];?>" title="Equipement proposé "  onfocus="this.className='focus';" onblur="this.className='normal';" />
                                        <span>Video,clim,wc,réfrigérateur...</span>
                                          <? if(isset($erreurs['equipement']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[equipement]</img>";
                                             }
                                          ?>
                                </p>
						<br />
	                      
	                      
	                        <fieldset>  
	                         <legend>Informations complémentaires</legend>
	                          <p align="center">
	                            <textarea name="rcommentaires" COLS="40" ROWS="6" ><? echo $_POST[rcommentaires]; ?></textarea>
	                           </p>
	                        </fieldset>
                        <br/>


   <em>* Champs obligatoires</em>
                 <div class="piedForm">
                         <input type="reset" name="reset" id="reset" value="Annuler" />
                         <input type="hidden" name="validerform" value="1"/>
                         <input type="submit" name="validerclient" id="valid" value="Confirmer(1/2)" />
                 </div>
              </fieldset>
                </div>
</div>
</div>
        </form>

<?
      		echo " <script>BusCount()</script>";

       	
}