<?php
$infos = $_SESSION["info_transport"];
$infosDevis = $_SESSION["devis"];

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


echo " <script language=\"JavaScript\" type=\"text/javascript\" src=\"javascript/devis.js\"></script>";

if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

include_once("libs/CalculPrix.php");
$erreurs = array();


    if($_POST[validerform])
    {
     if(($_POST['preference'])=="1")
     {  
       
  
	      
	      
	       if($_POST['bus'] == " ")
	        {
	                $erreurs['bus'] = "";
	        }
	
	        for($i=0; $i<$_POST['bus']; $i++) {


	            $temp = "NumberOfBus".($i+1);
	            $PlacesParBus[$i] = $_POST["$temp"];
	            $capacite_totale_bus += $_POST["$temp"]; 
	       }
	        $PlacesParBus = implode(",", $PlacesParBus);
	        $capacite_necessaire = $_POST['capacite'];
	        
	        if($capacite_totale_bus < $capacite_necessaire) {
	        	 echo $erreurs['']=" <pre><img src=\"images/attention.gif\" width=\"35\"> </img><br />La capacité des bus est inférieure à la capacité nécessaire</pre>";	
	        }
        	
        	
        }


      
      
   if($_POST['diviserAnnonces'][0]) //si la case diviser annonce est cochée
                                          {      
         if(empty($_POST['tarifadopte']))
        {
                $erreurs['tarifadopte'] = "";
        }    
      
    } 
    
         if(empty($_POST['typecar']))
        {
                $erreurs['typecar'] = "";
        }

        if(!isset($_POST['nbrRepasTotal']))
        {
            
                $erreurs['nbrRepasTotal'] = "";
        }
        if(!isset($_POST['nbrnuittotal']))
        {
                $erreurs['nbrnuittotal'] = "";
        }

        
        if(empty($_POST['capacite']))
        {
                $erreurs['capacite'] = "";
        }

            if(!isset($_POST['preference']))
            {
            $erreurs['preference'] = "";
            }
        

        if( $erreurs == array() )
        {

                $bus = explode(",", $PlacesParBus);
                $prixaller = 0;
                $prixretour = 0;
                $infos = $_SESSION["info_transport"];
                $infos["typecar"]=$_POST['typecar'];
                if(!empty($_POST['bus']))
               		$infos["nbrbus"]=$_POST['bus'];
                $infos["dcommentaires"]=$_POST['dcommentaires']; 
                if(!empty($PlacesParBus))
                	$infos["PlacesParBus"]=$PlacesParBus;             
                $infos["nbrRepasTotal"]=$_POST["nbrRepasTotal"];
                $infos["nbrnuittotal"]=$_POST["nbrnuittotal"];
                $infos["tarifadopte"]=$_POST["tarifadopte"];
                $infos["capacitenecessaire"]=$_POST["capacite"];
                $infos["preferencebus"]=$_POST["preference"];
	            $infos["tarifconseille"]= $_POST["TarifTTC"];
                 $_SESSION["info_transport"] = $infos;
                 $_SESSION["diviserAnnonces"] = $_POST["diviserAnnonces"];
                 
                 echo "<meta http-equiv=refresh content=\"0; url=?action=demandetransport_valider\">";
                 return;
        }


}

if(isset($_SESSION['username'])) {

?>

        <form name="reservation" id="reservation" method="post" target="_self" action="">
                <div class="corpForm"> <h2><?if( $infos["typetransport"]=="transfert") { echo "Demande de transfert"; } else if( $infos["typetransport"]=="dispo") { echo " Demande de disponibilité"; } else { echo "Demande de séjour"; } ?></h2>

                <br />
                        <fieldset>
                                  <legend>Information transport</legend>
                                

                            
                             
                               <p>
                                     <label for="typecar">Type de car :</label>
                                     <?
                                      $tab = Array("Scolaire","Excursion","GT");
                                      $tab2 = Array("Scolaire","Excursion","Grand Tourisme");
                                      $typecarValue=count($tab);
                                      for($i=0; $i<($typecarValue); $i++) {
                                            if($tab[$i]==$_POST['typecar'])
                                            {
                                             echo "<input type=\"radio\" name=\"typecar\" id=\"typebus$tab[$i]\"  checked=\"checked\" value=\"$tab[$i]\">$tab2[$i]";
                                            }
                                            else
                                            {
                                            echo "<input type=\"radio\" name=\"typecar\" id=\"typebus$tab[$i]\" value=\"$tab[$i]\">$tab2[$i]";
                                            }
                                      }
                                      if(isset($erreurs['typecar']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[typecar]</img>";
                                             }
                                          ?>
                                  
 
                                         
                                          
                               </p>
                           
                               <p>
                               
                               <label for="capacite" title="capacite necessaire">Capacité necessaire :</label>
                                        <input type="text" name="capacite" id="capacite" maxlength="3" value="<?echo $_POST[capacite];?>" title="Capacité necessaire"  onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)"/>
                                        <span>Personnes</span>
                                          <? if(isset($erreurs['capacite']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[capacite]</img>";
                                             }
                                          ?>
                                         
                               </p>
                               
                            <br />
                            <fieldset>  
                            <p>
                                      <label for="preference">Préférence bus :</label>
                                     <?
                                      
                                      	echo createPreference();
                       
                                 
                                      if(isset($erreurs['preference']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[preference]</img>";
                                             }
 									echo "&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"return  overlib('- Si vous choisissez <strong>oui</strong>, le transporteur s\'adaptera au mieu à votre demande <br /> - Si vous choisissez <strong>non</strong>, le transporteur choisira le nombre de bus approprié en fonction de la capacité necessaire indiquée ', parent.CAPTION, '<strong>Préférence</strong>',parent.CAPTIONPADDING,'4',parent.FGCOLOR, '#FDFDFD',parent.WIDTH, '350',parent.STICKY,parent.CGBACKGROUND,'images/shade_caption.gif',parent.CLOSECLICK,parent.CLOSECOLOR,'#132884', parent.TEXTSIZE,'10px',OFFSETX, -150);\"  onmouseout=\"nd();\"><img src=images/interrogation.gif></a>";                                

                                          ?>                           

                            </p>                           
                               
                               
                               <p>

                                       <?    echo createBus(); ?>
                                          
                                          <br />
                                          <label for="diviserAnnonces">Diviser les annonces</label>
                                          <input type="checkbox" name="diviserAnnonces" id="diviserAnnonces" value="TRUE" onclick="innerHTMLInformationTarif();"/>
                                          <?
                                          echo "&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"return  overlib('Si vous devez transporter un grand nombre de personnes, nous vous conseillons de diviser votre demande en plusieurs annonces indépendantes afin qu\'une majorité de transporteurs puisse vous répondre. <br />Vous bénéficierez ainsi d\'une plus forte concurrence tarifaire. <br /><br />En contrepartie vous devrez probablement traiter avec différents transporteurs.<br /><br /><i>Cette option n\'est activable que si vous avez spécifiez le nombre de bus nécessaire. </i> ', parent.CAPTION, '<strong>Diviser les annonces</strong>',parent.CAPTIONPADDING,'4',parent.FGCOLOR, '#FDFDFD',parent.WIDTH, '350',parent.STICKY,parent.CGBACKGROUND,'images/shade_caption.gif',parent.CLOSECLICK,parent.CLOSECOLOR,'#132884', parent.TEXTSIZE,'10px',OFFSETX, -150);\"  onmouseout=\"nd();\"><img src=images/interrogation.gif></a>";
                                                   
 										  ?>
                               </p>
                               </fieldset>   
                        </fieldset>
                       <br />
                       <fieldset>
                                <legend>Prise en charge conducteur</legend>
                                  <br />
                               <p>

                                        <label for="nbrRepasTotal">Repas non pris en charge :</label>
                                        <input type="text" name="nbrRepasTotal" id="nbrRepasTotal" maxlength="2" value="<?echo $_POST[nbrRepasTotal];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)"/>
                                        <span>Repas <?echo "(".nb_repas_voyage($infos['datedepart'],$infos['heuredepart'],$infos['datearrive'],$infos['heurearrive'])." au total)"; ?></span>
                                          <? if(isset($erreurs['nbrRepasTotal']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[nbrRepasTotal]</img>";
                                             }
                                          ?>
                               </p>
                               <p>

                                        <label for="nbrnuittotal" title="Nuits prises en charges">Nuits non prises en charges :</label>
                                        <input type="text" name="nbrnuittotal" id="nbrnuittotal" maxlength="2" value="<?echo $_POST[nbrnuittotal];?>" title="Nuits prises en charges"  onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)"/>
                                        <span>Nuits</span>
                                          <? if(isset($erreurs['nbrnuittotal']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[nbrnuittotal]</img>";
                                             }
                                          ?>
                               </p>

                       </fieldset>
                        <br/>
                        
                        <fieldset>  
                         <legend>Informations complémentaires</legend>
                          <p align="center">

                            <textarea name="dcommentaires" value="<?echo $_POST[dcommentaires];?>" COLS=40 ROWS=6 ></textarea>
                           </p>
                        </fieldset>


                      <br/>
                        
                        <fieldset>
                                <legend>Tarif</legend>
                               
                               
                             <span id="innerHTMLInformationTarif">
                             
                             
                               <div class="boiteinfo">

								<div class="bandeauinfo"><img src="./images/style1/exclamation-blue.gif" alt="icon_exclamation-blue" /></div>
								
								<div class="boiteinfocontent">
								<p>Si vous ne spécifiez aucune valeur, les transporteurs vous proposeront des prix. <br /> Vous aurez juste à choisir le prix et le transporteur qui vous convient le mieux.</p>
								</div>
								
								<div class="footinfo"><img class="alignright" src="./images/style1/exclamation-blue.gif" alt="icon_exclamation-blue" /></div>
								
								</div>
                             </span>
                             
                             
                               
                               
                               
                                <br/>
                                        <label for="tarif">Tarif adopté :</label>
                                        <input type="text" name="tarifadopte" id="tarifadopte" value="<?echo $_POST[tarifadopte];?>" title="Tarif adopté"  onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                           <span>  €  </span>&nbsp;&nbsp;&nbsp;&nbsp;
                                           <a href=javascript:void(0); onclick=startDevis();printPrixDevis(); onmouseout=nd();>Prix conseillé</a>
                                           <span id='prixDevis'></span>
                                           <iframe id='calculprix' style="visibility: hidden;" width='0' height='0'></iframe>
                                         
                                          <? 
                                          
                                          if($_POST['diviserAnnonces'][0]) //si la case diviser annonce est cochée
                                          {
                                          	  if(isset($erreurs['tarifadopte']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[tarifadopte]</img>";
                                             }
                                          }

                                          ?>
                            
                            <br/>
                        </fieldset>
                        <br/>
                        
                        

                     <em>* Champs obligatoires</em>
                 <div class="piedForm">
                         <input type="reset" name="reset" id="reset" value="Annuler" />
                         <input type="hidden" name="validerform" value="1"/>
                         <input type="submit" name="validerclient" id="valid" value="Suivant ( 2/3 )" />
                 </div>
                </div>
<?
    $infos = $_SESSION["info_transport"];

    /*
    foreach( $infos as $key => $value )
    {
        echo "<input type=\"hidden\" name=\"$key\" id=\"$key\" value=\"$value\"></input>\n";
    }
    */
        foreach( $infosDevis as $key => $value )
    {
        echo "<input type=\"hidden\" name=\"$key\" id=\"$key\" value=\"$value\"></input>\n";
    }
    
    echo "<input type=\"hidden\" name=\"TarifTTC\" id=\"TarifTTC\"></input>\n";
    
?>

        </form>
    <div id="testdiv1" style="position:absolute; visibility:hidden;background-color:white;"></div>
    <script>disablefields();

    
    
    </script>

	<script type="text/javascript">    

    </script>

<?
}
?>