
<script language="JavaScript" type="text/javascript" src="javascript/sejour.js"></script>

<?
if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }


$erreurs = array();
include_once("libs/CalculDate.php");

   if($_POST[validerform])
    {


      	if(!CheckDateFormation($_POST['datedepart']))
		{
			echo $erreurs['datedepart']="";
		}
		if(!CheckDateFormation($_POST['datearrive']))
		{
			echo $erreurs['datearrive']="";
		}
		else
		{
             /*
              * Si amplitude > 8, doublage conducteur obligatoire
              */
            
            if(Duration($_POST['datedepart'],$_POST['heuredepart'],$_POST['minutesdepart'],$_POST['datearrive'],$_POST['heurearrive'],$_POST['minutesarrive'])> 8)
            {
				if(($_POST["doublagealler"])=="false")
				{
					echo $erreurs['']=" <pre><img src=\"images/attention.gif\" width=\"35\"> </img><br />Le voyage a une amplitude superieure à 8h, vous devez doubler le conducteur </pre>";
				}
				
		     }

		}
		
      
       if(empty($_POST['villedepart']))
        {
                $erreurs['villedepart'] = "";
        }

        if(empty($_POST['datedepart']))
        {
                $erreurs['datedepart'] = "";
        }
        if(empty($_POST['datearrive']))
        {
                $erreurs['datearrive'] = "";
        }

        if(empty($_POST['cpdepart']))
        {
                $erreurs['cpdepart'] = "";
        }


        if(empty($_POST['paysdepart']))
        {
                $erreurs['paysdepart'] = "";
        }



            if(!isset($_POST['doublagealler']))
            {
            $erreurs['doublagealler'] = "";
            }
             if(empty($_POST['datedepart']))
            {
            $erreurs['datedepart'] = "";
            }
             if(empty($_POST['datearrive']))
            {
            $erreurs['datearrive'] = "";
            }
            if(empty($_POST['kilometragealler']))
            {
            $erreurs['kilometragealler'] = "";
            }
     
            if(empty($_POST['via_1']))
            {
            $erreurs['via_1'] = "";
            }


        if( $erreurs == array() )
        {
          
                $infos=array();
                $infosDevis = array();
                $etapes[0]=$_POST['villedepart'];
                for($nbville=1;$nbville<=$_POST['nbr_etape'];$nbville++)
                {
                $etapes[$nbville]=$_POST["via_".($nbville)];
                echo "via_".($nbville);
                }
    
                                           
                $infos["idcontact"]=$_SESSION["idcontact"] ;
                $infos["date"]=date('j/m/Y');
                $infos["paysdepart"]=$_POST['paysdepart'];
                $infos["villedepart"]=$_POST['villedepart'];
                //$infos["paysarrive"]=$_POST['paysarrive'];
           //     $infos["villearrive"]=$_POST['villearrive'];
                $infos["cpdepart"]=$_POST['cpdepart'];
                //$infos["cparrive"]=$_POST['cparrive'];
                $infos["datedepart"]=formatDateFrToUS($_POST['datedepart']);
                $infos["heuredepart"]=$_POST['heuredepart'].":".$_POST['minutesdepart'].":00";
                $infos["datearrive"]=formatDateFrToUS($_POST['datearrive']);
                $infos["heurearrive"]=$_POST['heurearrive'].":".$_POST['minutesarrive'].":00";
                $infos["doublagealler"]=$_POST['doublagealler'];
                $infos["kilometragealler"]=$_POST['kilometragealler'];
                $infos["typetransport"]="sejour";
                $infos["typetrajet"]="aller_retour";
                $infos["BusSurPlace"]="1";
                $_SESSION["info_transport"] = $infos;
                $_SESSION["etapes"]=$etapes;

				$infosDevis["villearrive"]=end($etapes);  

  			   $infosDevis["prestation"]="séjour";

                $infosDevis["zone"]="Zone 1";
               if(($infos["doublagealler"])=="true")
               {
               	 $infosDevis["doublage"]="2 conducteurs";
               }
               else
               {
                 $infosDevis["doublage"]="1 conducteur";
               }
               
               
                $infosDevis["coupure"]="inférieure à 9 heures";
                
                /*
                 * relais ?
                 */
  				$infosDevis["relaisA"]="aucun";
  				$infosDevis["relaisR"]="aucun";
  				
  				
                $_SESSION["devis"] = array_merge($infos,$infosDevis);
        

                echo "<meta http-equiv=refresh content=\"0; url=index.php?action=demandetransport_divers\">";
                return;
        }
}
if(isset($_SESSION['username'])) {

?>

        <form name="reservation" id="reservation" method="post" target="_self" action="">
                <div class="corpForm"> <h2>Demande de Séjour</h2>

                <br />
                        <fieldset>
                        <legend>Information voyage</legend><br/>
					<p>
						<div class="infovoyage_gauche">

                                
                                  <span>Départ de (pays) :</span>
						
                                               <select name="paysdepart" id="paysdepart">
                                                <?
                                                  $tab = Array("","AL","DE","AD","AM","AT","BE","BY","BA","BG","CY","HR","DK","ES","EE","FO","FR","GE","GI","GB","GR","HU","IE","IT","LT","LU","LE","MT","MA","MD","MC","NO","NL","PL","PT","RO","RU","CZ","SK","CH","SE","UA","YU");
                                                  $tab2 = Array("Votre choix","Albanie","Allemagne","Andore","Arménie","Autriche","Belgique","Biélorussie","Bosnie et Hér.","Bulgarie","Chypre","Croatie","Dannemark","Espagne","Estonie","Féroé","France","Géorgie","Gibraltar","Gr. Bretagne","Gréce","Hongrie","Irlande","Italie","Lituanie","Luxembourg","Létonie","Malte","Maroc","Moldavie","Monaco","Norvége","Pays Bas","Pologne","Portugal","Roumanie","Russie","Rép. Tchéque","Slovaquie","Suisse","Suéde","Ukraine","Yougoslavie");
                                                  $paysINITIAL=count($tab);
                                                  for($i=0; $i<($paysINITIAL); $i++) {
                                                        if($tab[$i]==$_POST['paysdepart'])
                                                        {
                                                        echo "<option value=\"$tab[$i]\" selected=\"selected\">$tab2[$i]</option>";
                                                        }
                                                        else
                                                        {
                                                         if($tab[$i]=="FR")
                                                         {
                                                          echo "<option value=\"$tab[16]\" selected=\"selected\" >$tab2[16]</option>";   
                                                         }                                                               
                                                         echo "<option value=\"$tab[$i]\">$tab2[$i]</option>";
                                                        }
                                                  }
                                                  ?>
                                               </select>
                                            <?
                                                  if(isset($erreurs['paysdepart']))
                                                  {
                                                  echo "<img src=\"images/icon_err.gif\"> $erreurs[paysdepart]</img>";
                                                  }
                                            ?>

				
				                         <br /><span> Départ de (ville) :</span>
                                        <input type="text" name="villedepart" id="villedepart" value="<?echo $_POST[villedepart];?>" title="Ville de départ"  onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                          <? if(isset($erreurs['villedepart']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[villedepart]</img>";
                                             }
                                          ?>
                                        
                                          


  
                                        <br /><span>Code postal : </span>
                                          <input type="text" name="cpdepart"  id="cpdepart" value="<?echo $_POST[cpdepart];?>" title="Code postal de la ville de départ"  onfocus="this.className='focus';" onblur="this.className='normal';" />
                                          <? if(isset($erreurs['cpdepart']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[cpdepart]</img>";
                                             }
                                          ?>
                                       			
									 <br/><br/>
				
				
				</div>
				
				<div class="infovoyage_droite">
                                          <span>à destination de (nb villes) :</span>
                                          
                                                <?
                                                        echo "<SELECT name=\"nbr_etape\" onchange=\"add_text_textbox(this)\" id=\"nbr_etape\">";
												        for($i=1; $i<=10; $i++)
												        {
												 	echo "<OPTION VALUE=".$i.">$i";
												        }
												     echo "</SELECT>";

											      
                                          ?>

            

                                   <div id="divtextbox">Ville 1 :<input type="text" name="via_1" id="via_1" value="<? echo $_POST['via_1']; ?>">
                                 
                                          <? if(isset($erreurs['via_1']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[via_1]</img>";
                                             }
                                          ?>
                                         
                                     </div>                 
			</div>
				
		</p>			
				
					 <p>	
										<span id="tempstotal_div"></span><br/> 
                                        <label for="datedepart" title="départ du voyage">Date de départ (dd/mm/yyyy):</label>
                                        <input type="text" name="datedepart" id="datedepart"  value="<?echo $_POST[datedepart];?>" title="Selectionner un jour de départ avec le calendrier dd/MM/yyyy " onfocus="this.className='focus';" onblur="this.className='normal';" />
                                        <script language="JavaScript" type="text/javascript">
                                        var AfterTomorrow = new Date();
                                        AfterTomorrow.setDate(AfterTomorrow.getDate()+2);
                                        var test = new CalendarPopup("testdiv1");
                                        test.addDisabledDates(null,formatDate(AfterTomorrow,"yyyy-MM-dd"));

                                        test.addDisabledDates("Jan 1, 2008",null);
                                        </script>
                                        <a href="#" onClick="test.select(document.getElementById('datedepart'),'anchor17','dd/MM/yyyy'); return false;" title="Selectionnez le jour de départ" name="anchor17" id="anchor17"><img src="images/calendrier.gif" alt=""></img></a>
                                          <? if(isset($erreurs['datedepart']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[datedepart]</img>";
                                             }
                                          ?>

                                        <span>  à  </span>
                                                            <select name="heuredepart" id="heuredepart">
                                                            <?
                                                              $tab = Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");
                                                              $tab2 = Array("00h","01h","02h","03h","04h","05h","06h","07h","08h","09h","10h","11h","12h","13h","14h","15h","16h","17h","18h","19h","20h","21h","22h","23h");
                                                              $heurevalue=count($tab);


                                                              for($i=0; $i<($heurevalue); $i++) {

                                                                    if($tab[$i]==$_POST['heuredepart'])
                                                                    {
                                                                    echo "<option value=\"$tab[$i]\" selected=\"selected\">$tab2[$i]</option>";
                                                                    }
                                                                    else
                                                                    {
                                                                    echo "<option value=\"$tab[$i]\">$tab2[$i]</option>";
                                                                    }

                                                              }
                                                            ?>
                                                            </select>

                                                            <select name="minutesdepart" id="minutesdepart">
                                                            <?
                                                              $tab = Array("00","05","10","15","20","25","30","35","40","45","50","55");
                                                              $heurevalue=count($tab);

                                                              for($i=0; $i<($heurevalue); $i++) {

                                                                    if($tab[$i]==$_POST['minutesdepart'])
                                                                    {
                                                                    echo "<option value=\"$tab[$i]\" selected=\"selected\">$tab[$i]</option>";
                                                                    }
                                                                    else
                                                                    {
                                                                     echo "<option value=\"$tab[$i]\">$tab[$i]</option>";
                                                                    }
                                                              }

                                                            ?>
                                                            </select>


                                </p>
                                
								<p>
                                        <label for="datearrive" title="Date d'arrivée">Date d'arrivée (dd/mm/yyyy):</label>
                                        <input type="text" name="datearrive" id="datearrive"  value="<?echo $_POST[datearrive];?>" title="Selectionner une date de retour"  onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                         <a href="#" onClick="test.select(document.getElementById('datearrive'),'anchor18','dd/MM/yyyy'); return false;" title="Selectionner une date de retour" name="anchor18" id="anchor18"><img src="images/calendrier.gif" alt=""></img></a>
                                           <? if(isset($erreurs['datearrive']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[datearrive]</img>";
                                             }
                                          ?>

                                           <span>  à  </span>
                                                            <select name="heurearrive" id="heurearrive">
                                                             <?
                                                              $tab = Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");
                                                              $tab2 = Array("00h","01h","02h","03h","04h","05h","06h","07h","08h","09h","10h","11h","12h","13h","14h","15h","16h","17h","18h","19h","20h","21h","22h","23h");
                                                              $heurevalue=count($tab);
                                                              for($i=0; $i<($heurevalue); $i++) {
                                                                    if($tab[$i]==$_POST['heurearrive'])
                                                                    {
                                                                    echo "<option value=\"$tab[$i]\" selected=\"selected\">$tab2[$i]</option>";
                                                                    }
                                                                    else
                                                                    {
                                                                     echo "<option value=\"$tab[$i]\">$tab2[$i]</option>";
                                                                    }
                                                              }
                                                            ?>
                                                            </select>

                                                            <select name="minutesarrive" id="minutesarrive">
                                                            <?
                                                              $tab = Array("00","05","10","15","20","25","30","35","40","45","50","55");
                                                              $heurevalue=count($tab);

                                                              for($i=0; $i<($heurevalue); $i++) {

                                                                    if($tab[$i]==$_POST['minutesarrive'])
                                                                    {
                                                                    echo "<option value=\"$tab[$i]\" selected=\"selected\">$tab[$i]</option>";
                                                                    }
                                                                    else
                                                                    {
                                                                        echo "<option value=\"$tab[$i]\">$tab[$i]</option>";
                                                                    }
                                                              }

                                                            ?>
                                                            </select>

                                
							</p>
					
 									<hr/>
								      <div id="maparea"></div>
								      <input type="checkbox" name="usemap[]"  id="usemap" onclick="insertJavascriptIntoHeader('http://api.map24.com/ajax/1.2/');insertJavascriptIntoHeader('http://api.map24.com/ajax/1.2/?package=simple');">Afficher la Map ?<br/><br/>
 									  <div id="divviapoint">
 									<a href=javascript:startRouting(document.getElementById("villedepart").value,document.getElementById("via_1").value,1)><img src="http://img.map24.com/map24/portal/fr-fr/dyna/btn_next0.png" border="0"></a> Calcul du kilométrage automatique 
 									</div> 
                              
                                </fieldset>

                                <br/>


                               <fieldset id="fieldsetaller">
                                    <legend>Voyage</legend>
                                    <br/>
                               

                                 <p>


                                        <label for="kilometragealler" title="Kilométrage aller">Kilométrage en charge :  :</label>
                                        <input type="text" name="kilometragealler" id="kilometragealler" value="<? echo $_POST['kilometragealler']; ?>" title="Kilométrage aller" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)"/>
                                        <span>Km &nbsp;
                                        <? if(isset($erreurs['kilometragealler']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[kilometragealler]</img>";
                                             }
                                          ?>
                                          <a href="http://www.mappy.fr" target="_blank"><img src="images/mappy.gif" title="Site Mappy"></a></img></span>   

                                  </p>

                                  <p>

                                       <label for="doublagealler">Doublage du conducteur :</label>

                                     <?

                                        if($_POST[validerform])
                                            {
                                                if($_POST['doublagealler']=="true")
                                                {
                                                 echo "<input type=\"radio\" name=\"doublagealler\" id=\"doublagealleroui\" checked=\"checked\" value=\"true\">Oui&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                 echo "<input type=\"radio\" name=\"doublagealler\" id=\"doublageallernon\" value=\"false\">Non&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                }
                                                elseif($_POST['doublagealler']=="false")
                                                {
                                                    echo "<input type=\"radio\" name=\"doublagealler\" id=\"doublagealleroui\" value=\"true\">Oui&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                    echo "<input type=\"radio\" name=\"doublagealler\" id=\"doublageallernon\" checked=\"checked\" value=\"false\">Non&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                }
                                                elseif(empty($_POST['doublagealler']))
                                                {
                                                    echo "<input type=\"radio\" name=\"doublagealler\" id=\"doublagealleroui\"  value=\"true\">Oui&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                    echo "<input type=\"radio\" name=\"doublagealler\" id=\"doublageallernon\"  value=\"false\">Non&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                }
                                            }
                                            else
                                            {
                                            echo "<input type=\"radio\" name=\"doublagealler\" id=\"doublagealleroui\"  value=\"true\">Oui&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                            echo "<input type=\"radio\" name=\"doublagealler\" id=\"doublageallernon\"  value=\"false\">Non&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                            }

                                            if(isset($erreurs['doublagealler']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[doublagealler]</img>";
                                             }

                                     ?>

                                 &nbsp;<a href="javascript:void(0);" onclick="return  overlib('Le doublage du conducteur est obligatoire lorsque:<br/><br/> <strong> - durée du voyage dépassant 8 heures</strong><br /> ', parent.CAPTION, '<strong>Information doublage</strong>',parent.CAPTIONPADDING,'4',parent.FGCOLOR, '#FDFDFD',parent.WIDTH, '250',parent.STICKY,parent.CGBACKGROUND,'images/shade_caption.gif',parent.CLOSECLICK,parent.CLOSECOLOR,'#132884', parent.TEXTSIZE,'10px');"  onmouseout="nd();"><img src=images/interrogation.gif></a>

                               </p>



                            </fieldset>
                            <br/>



                     <em>* Champs obligatoires</em>
                 <div class="piedForm">
                         <input type="reset" name="reset" id="reset" value="Annuler" />
                         <input type="hidden" name="validerform" value="1"/>
                         <input type="submit" name="validerclient" id="valid" value="Suivant ( 1/3 )" />
                         
                 </div>
                </div>

        </form>
         <script language="JavaScript" type="text/javascript">
        type_trajet();
        document.getElementById('villedepart').focus();
        </script>
    <div id="testdiv1" style="position:absolute; visibility:hidden;background-color:white;"></div>

<?
}
?>