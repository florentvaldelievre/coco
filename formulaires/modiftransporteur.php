


<?

if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

    include_once("libs/CTransporteurdptDAO.php");
    include_once("libs/util.php");
    include_once("libs/class.upload.php");    
    include_once("libs/CContactDAO.php");
    include_once("libs/CUtilisateurDAO.php");    
    include_once("libs/CTransactionManager.php");    
    include_once("libs/CUtilisateur.php");
    include_once("libs/CTransporteurpaysDAO.php");

                
$erreurs = array();




if($_POST[validerform])
{


     $handle = new Upload($_FILES['photo']);
	 $handle->allowed = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
	 $handle->file_max_size = '1048576';

	if(!empty($_FILES['photo']['name'])) {
		if(!array_key_exists($handle->file_src_mime, array_flip($handle->allowed)))
			   $erreurs['photo'] = "images autorisées : jpg, png, gif";
	} 
	
	if($handle->file_src_size > $handle->file_max_size) 
			 $erreurs['photo'] = "Problème: ".$handle->error;


        $cDAO = new CContactDAO($GLOBALS['mysql']);
        $contact = $cDAO->getBy( array( "username" => $_POST['username']));
        if($contact && $contact->get('username') != $_SESSION['username'] )
        {
                $erreurs['username'] = "Utilisateur existant";
        }


      

        if(empty($_POST['mail']))
        {
                $erreurs['mail'] = "";
        }
        elseif(checkEmail($_POST['mail']))  {
            $erreurs['mail'] = "Email erroné";
        }


        else
        {
                $cDAO = new CContactDAO($GLOBALS['mysql']);
                $contact = $cDAO->getByMail($_POST['mail']);
                if($contact && $contact->get('username') != $_SESSION['username'])
                {
                        $erreurs['mail'] = "Mail existant";
                }
        }

       


              if(empty($_POST['nbrvehicultotal']))
       {
               $erreurs['nbrvehicultotal'] = "";
       }
              if(empty($_POST['Ageparcmoyen']))
       {
               $erreurs['Ageparcmoyen'] = "";
       }
              if(empty($_POST['capamin']))
       {
               $erreurs['capamin'] = "";
       }
              if(empty($_POST['capamax']))
       {
               $erreurs['capamax'] = "";
       }




        if( $erreurs == array() )
        {
               

             if(!empty($_FILES["photo"]["name"])) { //si on a remplit qqch dans la case

	              if($_FILES["photo"]["name"] != $contact->get("photo") && $contact->get("photo") != "no_picture.jpg") {
					 $handle->deleteFile('photo/RealSize/'.$contact->get("photo"));
					 $handle->deleteFile('photo/thumbs/'.$contact->get("photo"));
	            	
	              }
              
	                if ($handle->uploaded) {
			
				        $handle->Process('photo/RealSize');
				        if (!$handle->processed)
				            echo $handle->error;
				   
				    	//creation du thumb
				        $handle->image_resize            = true;
				        $handle->image_ratio_y           = true;
				        $handle->image_x                 = 155;
			
			       	    
			       	    $handle->Process('photo/thumbs');        
				        if (!$handle->processed)
				            echo  $handle->error;

			       	$handle-> Clean();
				  }
    
             }  

             

                $uDAO = new CUtilisateurDAO($GLOBALS['mysql']);
                $cDAO = new CContactDAO($GLOBALS['mysql']);
                $trDAO = new CObjetBddDAO("transporteur",$GLOBALS['mysql']);
                $tm = new CTransactionManager($GLOBALS['mysql']);
        
              

              	$tm->startTransaction();
                $utilisateur = new CUtilisateur();
                $infos = array();
                $infos["prenom"]=$_POST['prenom'];
                $infos["civilite"]=$_POST['civilite'];
                $utilisateur->set($infos);
                $id_u = $uDAO->update($utilisateur);
				if(!$id_u)
				{
					$tm->setQueryErr();
				}
              
              

                $contact = $cDAO->getById( $_SESSION["idcontact"] );
                $infos=array();
                $infos["telephone"]=$_POST['telephonefixe'];
                $infos["portable"]=$_POST['telephoneportable'];
                $infos["fax"]=$_POST['fax'];
                $infos["mail"]=$_POST['mail'];

         
               if(!empty($handle->file_dst_name))
                	$infos["photo"]= $handle->file_dst_name;
                $contact->set($infos);
                $id_c = $cDAO->update($contact);
                if(!$id_c)
				{
					$tm->setQueryErr();
				}
                 


                $transporteur = $trDAO->getBy(  array( 'idutilisateur' => $contact->get('idutilisateur') ));
                $infos=array();

                $infos["nomsociete"]=$_POST['nomsociete'];
                $infos["delaipaiement"]="";
                $infos["totalvehicule"]=$_POST['nbrvehicultotal'];
                $infos["caannuel"]=$_POST['CAtotalAnnuel'];
                $infos["ageparcmoyen"]=$_POST['Ageparcmoyen'];
                $infos["capacitemin "]=$_POST['capamin'];
                $infos["capacitemax "]=$_POST['capamax'];
                isset($_POST['receiveAds'])?$infos["receiveAds"]=1 : $infos["receiveAds"]=0;
                $transporteur->set($infos);
                $trDAO->update($transporteur);



				/*
				
				$trpaysinfos['idutilisateur'] = $_SESSION['idutilisateur'];
				$trpaysDAO = new CTransporteurdptDAO($GLOBALS['mysql']);
				$trcountrybdd = $trpaysDAO->getSelectionType($_SESSION['idutilisateur']);
				$dpts_list =  $trpaysDAO->getDptsList($_SESSION['idutilisateur']);
				*/
				
				
				

				
				
				$trpaysDAO = new CTransporteurpaysDAO($GLOBALS['mysql']);
	            $trdptDAO = new CTransporteurdptDAO ($GLOBALS['mysql']);
	            
				$trcountrybdd = $trpaysDAO->getBy( array ( "idutilisateur" =>  $_SESSION['idutilisateur'] ));

				$trdptbdd = new CObjetBdd();
				$trpaysinfos['idutilisateur'] = $_SESSION['idutilisateur'];
				$trdptinfos['idutilisateur'] = $_SESSION['idutilisateur'];
				
			switch($_POST["r_charge"])
				{
					

					case "europe":


						$trpaysinfos['selectiontype'] = "EUROPE";
						$trcountrybdd->set($trpaysinfos);
						$queryRes = $trpaysDAO->update($trcountrybdd);
						
						if(!$queryRes)
							$tm->setQueryErr();
						
						$infos_tmp['idutilisateur']=$_SESSION['idutilisateur'];
						$trdptDAO->mysql_res->delete_all("transporteurdpt",$infos_tmp); //on efface les anciennes données de la bdd


						
					break;
					   
					case "france":

						$trpaysinfos['selectiontype'] = "FRANCE";
						$trcountrybdd->set($trpaysinfos);
						$queryRes = $trpaysDAO->update($trcountrybdd);
						
                     	if(!$queryRes)
							$tm->setQueryErr();
							
						$infos_tmp['idutilisateur']=$_SESSION['idutilisateur'];
						$trdptDAO->mysql_res->delete_all("transporteurdpt",$infos_tmp);
                         
                    break;
					
					case "francesansdpt":

					
						$trpaysinfos['selectiontype'] = "FRANCE_WITHOUT_DPTS";
						$trcountrybdd->set($trpaysinfos);
						$queryRes = $trpaysDAO->update($trcountrybdd);
							
                     	if(!$queryRes)
							$tm->setQueryErr();
						
                         $dpts = explode(",",$_POST['francesansdpt']);
						
                         if (!empty($dpts)) {
	                         	

	             				$infos_tmp['idutilisateur']=$_SESSION['idutilisateur'];
								$trdptDAO->mysql_res->delete_all("transporteurdpt",$infos_tmp);              
	                           
	                            foreach($dpts as $dpt)
	                         	{
	                         		$trdptinfos['iddepartement'] = $dpt;
	                         		$trdptbdd->set($trdptinfos);
									$queryRes = $trdptDAO->insert($trdptbdd);
		                         	if(!$queryRes)
										$tm->setQueryErr();
                         		}
                         }

                    break;
					
					case "francedpt":
						
						$trpaysinfos['selectiontype'] = "ONLY_DPTS";
						$trcountrybdd->set($trpaysinfos);
						$queryRes = $trpaysDAO->update($trcountrybdd);
							
                     	if(!$queryRes)
							$tm->setQueryErr();
						
                         $dpts = explode(",",$_POST['francedpt']);
						
                         if (!empty($dpts)) {
	                         	
	             				$infos_tmp['idutilisateur']=$_SESSION['idutilisateur'];
								$trdptDAO->mysql_res->delete_all("transporteurdpt",$infos_tmp); 
	                            foreach($dpts as $dpt)
	                         	{
	                         		$trdptinfos['iddepartement'] = $dpt;
	                         		$trdptbdd->set($trdptinfos);
									$queryRes = $trdptDAO->insert($trdptbdd);
		                         	if(!$queryRes)
										$tm->setQueryErr();
                         		}
                         }
			          break;	
				}







				if($tm->getQueryErr())
				{
					$tm->rollback();
					include("formulaires/inscription_fin.php");
         			inscriptionFinKo();
         			exit;
				}
				else
				{
					
					$tm->commit();	
					
				}
                $_SESSION["username"] = $contact->get("username");






                $_POST['url']="index.php?action=accueil";
				$_POST['message']="Vos modifications ont été prises en compte";
                include("formulaires/redirectMessage.php");

        }
}
else
{
    $contactdao =  new CObjetBddDAO("contact",$GLOBALS['mysql']);
    $contact = $contactdao->getById($_SESSION["idcontact"]);


    $_POST['fax'] = $contact->get("fax");
    $_POST['telephonefixe'] = $contact->get("telephone");
    $_POST['telephoneportable'] = $contact->get("portable");
    $_POST['mail'] = $contact->get("mail");

   // $_POST['photo'] = $contact->get("photo");

    $uDAO = new CObjetBddDAO("utilisateur",$GLOBALS['mysql']);
    $utilisateur = $uDAO->getById($contact->get("idutilisateur"));            
    $_POST['nomclient'] = $utilisateur->get("nomclient");
    $_POST['prenom'] = $utilisateur->get("prenom");

    $trDAO = new CObjetBddDAO("transporteur",$GLOBALS['mysql']);
    $transporteur = $trDAO->getBy(array( 'idutilisateur' => $contact->get("idutilisateur")));

    $_POST['nomsociete'] = $transporteur->get("nomsociete");
    $_POST['CAtotalAnnuel'] = $transporteur->get("caannuel");
    $_POST['nbrvehicultotal'] = $transporteur->get("totalvehicule");
    $_POST['Ageparcmoyen'] = $transporteur->get("ageparcmoyen");
    $_POST['capamin'] = $transporteur->get("capacitemin");
    $_POST['capamax'] = $transporteur->get("capacitemax");
    $_POST['receiveAds'] = $transporteur->get("receiveAds");
	
	$tr_dpts = new CTransporteurdptDAO($GLOBALS['mysql']);
	$selection_type = $tr_dpts->getSelectionType($_SESSION['idutilisateur']);
	$dpts_list =  $tr_dpts->getDptsList($_SESSION['idutilisateur']);


	switch($selection_type->get("selectiontype"))
	{
		case "EUROPE" : 
			$_POST['r_charge'] = "europe"; 
			break;
		
		case "FRANCE" : 
			$_POST['r_charge'] = "france"; 
			break;
			
		case "FRANCE_WITHOUT_DPTS" : 
			$_POST['r_charge'] = "francesansdpt";
			$_POST['francesansdpt'] =  getListOfDptsWithCommaSeparated($dpts_list);
			 break;
		
		case "ONLY_DPTS": 
			$_POST['r_charge'] = "francedpt"; 
			$_POST['francedpt'] =  getListOfDptsWithCommaSeparated($dpts_list);
			break;
	}



	switch($utilisateur->get("civilite"))
	{
		case "M": $_POST['civilite'] = "M"; break;
		case "Mme": $_POST['civilite'] = "Mme"; break; 
		case "Mlle": $_POST['civilite'] = "Mlle"; break;
		
	}
    


?>

        <div class="panelcentre">
        <div class="boiteform">
        <div class="bandeauform">
         <h4>Modification profil transporteur <?echo $contact->get("username") ?></h4>
        </div>
 <form name="inscriptiontransp" id="inscription" method="post" enctype="multipart/form-data"  target="_self" action="">
                <div class="corpForm"> </h2><br />

                        <br />
                        <fieldset>
                                  <legend>Informations sur votre société</legend>
                                  <br />
                              
                               <p>

                                        <label for="nomsociete" class="oblig" title="nom de votre société"><span class="asterisk">*</span> Nom de votre société :</label>
                                        <input type="text" name="nomsociete" id="nomsociete" value="<?echo $_POST[nomsociete];?>" title="nomsociete"  onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                          <? if(isset($erreurs['nomsociete']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[nomsociete]</img>";
                                             }
                                          ?>
                               </p>
                              
                              <p class="info">
                               <img src="images/style1/information.gif" alt="information"> <span><i>les champs suivants concernent le contact de votre société</i></span>
                              </p>	
                              
                               <p>	
                              		
                              		<label for="civilite" class="oblig" title="civilité"><span class="asterisk">*</span> civilité :</label>        
									<select id="civilite" name="civilite"><option value="0" <?if($_POST['civilite']==0) echo "selected=\"selected\""; ?>>-</option>
									<? echo $_POST['civilite'];?>
									<option value="M" <?if($_POST['civilite']=="M") echo "selected=\"selected\""; ?>>M</option>
									<option value="Mme" <?if($_POST['civilite']=="Mme") echo "selected=\"selected\""; ?>>Mme</option>
									<option value="Mlle" <?if($_POST['civilite']=="Mlle") echo "selected=\"selected\""; ?>>Mlle</option></select>
									      <? if(isset($erreurs['civilite']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[civilite]</img>";
                                             }
                                          ?>
									
                               </p>
                              
                              
                               <p>

                                        <label for="nomclient" class="oblig" title="Votre nom" disabled="disabled" ><span class="asterisk">*</span> Nom :</label>
                                        <input type="text" name="nomclient" id="nomclient" disabled="disabled" value="<?echo $_POST[nomclient];?>" title="votre nom"  onfocus="this.className='focus';" onblur="this.className='normal';" />
                                          <? if(isset($erreurs['nomclient']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[nomclient]</img>";
                                             }
                                          ?>
                               </p>
                               
                              <p>

                                        <label for="prenom" class="oblig" title="votre prénom"><span class="asterisk">*</span> Prénom :</label>
                                        <input type="text" name="prenom" id="prenom" value="<?echo $_POST[prenom];?>" title="votre prénom"  onfocus="this.className='focus';" onblur="this.className='normal';" />
                                          <? if(isset($erreurs['prenom']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[prenom]</img>";
                                             }
                                          ?>
                               </p>
                               
 
                               
                               
                               <p>             

                                     <label for="telephonefixe" class="oblig"><span class="asterisk">*</span>Téléphone Fixe :</label>
                                     <input type="text" name="telephonefixe" id="telephonefixe" MAXLENGTH="10" value="<?echo $_POST[telephonefixe];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)"/>
                                     <span class="legende"> ex: 0112345678 </span>
                                          <? if(isset($erreurs['telephonefixe']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[telephonefixe]</img>";
                                             }
                                          ?>
                               </p>
                               <p>
				
                                        <label for="telephoneportable" class="oblig">Téléphone Portable :</label>
                                        <input type="text" name="telephoneportable" id="telephoneportable" MAXLENGTH="10" value="<?echo $_POST[telephoneportable];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)"/>
 										<? if(isset($erreurs['telephoneportable']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[telephoneportable]</img>";
                                             }
                                          ?>                              
                               
                               </p>
                               <p>
                                        <label for="fax">Fax :</label>
                                        <input type="text" name="fax" id="fax" MAXLENGTH="10" value="<?echo $_POST[fax];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)" />
                               </p>


                               <p>

                                        <label for="mail" class="oblig"><span class="asterisk">*</span> E-mail :</label>
                                        <input type="text" name="mail" id="mail" value="<?echo $_POST[mail];?>" onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                          <? if(isset($erreurs['mail']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[mail]</img>";
                                             }
                                          ?>

                               </p>

                        </fieldset>
                        <br />
                      
                        <br />
  <fieldset id="Infotransporteur">
                                <legend>Informations complémentaires</legend>
                                  <br />


                                <p>

                                        <label for="nbrvehicultotal" class="oblig"><span class="asterisk">*</span>Nombre de vehicules total :</label>
                                        <input type="text" name="nbrvehicultotal" id="nbrvehicultotal"  value="<?echo $_POST['nbrvehicultotal'];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)" />
                                         <? if(isset($erreurs['nbrvehicultotal']))
                                         {
                                            echo "<img src=\"images/icon_err.gif\"> $erreurs[nbrvehicultotal]</img>";
                                         }
                                    ?>
                               </p>
                                <p>
                                        <label for="CAtotalAnnuel" class="oblig" ><span class="asterisk">*</span>Chiffre d'affaire total annuel :</label>
                                        <input type="text" name="CAtotalAnnuel" id="CAtotalAnnuel"  value="<?echo $_POST['CAtotalAnnuel'];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)" /> Euros

                                       <? if(isset($erreurs['CAtotalAnnuel']))
                                         {
                                            echo "<img src=\"images/icon_err.gif\"> $erreurs[CAtotalAnnuel]</img>";
                                         }
                                    ?>
                               </p>
                               
                               
                                <p>
                                        <label for="Ageparcmoyen" class="oblig" ><span class="asterisk">*</span>Age Parc Moyen :</label>
                                        <input type="text" name="Ageparcmoyen" MAXLENGTH="3" id="Ageparcmoyen" value="<?echo $_POST['Ageparcmoyen'];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)" /> Ans
                                        <? if(isset($erreurs['Ageparcmoyen']))
                                         {
                                            echo "<img src=\"images/icon_err.gif\"> $erreurs[Ageparcmoyen]</img>";
                                         }
                                    ?>
                               </p>
                                <p>
                                        <label for="capamin" class="oblig" ><span class="asterisk">*</span>Capacité minimale :</label>
                                        <input type="text" name="capamin" MAXLENGTH="3" id="capamin" value="<?echo $_POST['capamin'];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)"  /> Places
                                                         <? if(isset($erreurs['capamin']))
                                         {
                                            echo "<img src=\"images/icon_err.gif\"> $erreurs[capamin]</img>";
                                         }
                                    ?>
                               </p>
                                <p>
                                        <label for="capamax" class="oblig" ><span class="asterisk">*</span>Capacité maximale :</label>
                                        <input type="text" name="capamax" MAXLENGTH="3" id="capamax"  value="<?echo $_POST['capamax'];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)" /> Places
                                                                             <? if(isset($erreurs['capamax']))
                                         {
                                            echo "<img src=\"images/icon_err.gif\"> $erreurs[capamax]</img>";
                                         }
                                    ?>
                               </p>
                               
                               <p>
                               	<label class="oblig" >Prise en charge :</label>
							   </p>	                               
                            
                              	<div class="dptcharge">
                               		<input type="radio" name="r_charge" value="europe" <? if($_POST['r_charge']=="europe" || empty($_POST['r_charge'])) { echo "checked=\"checked\""; } ?> onClick="updateRadioCharge(this)" />
                              		<span>France entière et Europe </span><br />
                              		<input type="radio" name="r_charge" value="france"<? if($_POST['r_charge']=="france") { echo "checked=\"checked\""; } else { echo ""; } ?> onClick="updateRadioCharge(this)" />
                              		<span>France entière</span><br />
                              		<input type="radio" name="r_charge" value="francesansdpt" <? if($_POST['r_charge']=="francesansdpt") { echo "checked=\"checked\""; } ?> onClick="updateRadioCharge(this)" />
                              		<span>Toute la France sauf les départements suivants</span><br />          		
  									<input type="text" class="bigmargin" name="francesansdpt" id="francesansdpt" value="<?echo $_POST['francesansdpt'];?>" size="30" maxlength="60" /><span class="legende"> ex: 94,47,02</span><br />
                              		<input type="radio" name="r_charge" value="francedpt" <? if($_POST['r_charge']=="francedpt") { echo "checked=\"checked\""; } ?> onClick="updateRadioCharge(this)" />
                              		<span>Seulement les départements suivants</span><br />                              		                  
                          		    <input type="text" class="bigmargin" name="francedpt" id="francedpt" value="<?echo $_POST['francedpt'];?>" size="30" maxlength="60" /><span class="legende"> ex: 94,47,02</span><br />
                               </div>
                           
                        	   <div class="clearhack"/>
                               <br />
		
		
								<div class="photoEditProfil">
								
                             
                               	<label><a href="photo/RealSize/<?echo $contact->get("photo")?>"><img src="photo/thumbs/<?echo $contact->get("photo")?>"/></a></label>
	
                               		
								</div>
		
		<br />
								<p>
                               		<label>Changer la photo actuelle</label>
                               	
                               		<input name="photo" type="file" value="" /> <span class="legende">( png, gif, jpg, Max 1MB)</span>
     								<INPUT type=hidden name="MAX_FILE_SIZE"  VALUE="1024">
     								 <? if(isset($erreurs['photo']))
                                         {
                                            echo "<img src=\"images/icon_err.gif\"> $erreurs[photo]</img>";
                                         }
                                    ?>                                 
							   </p>	                  

                        
                         <br />
                         <p>
                         <input type="checkbox"  name="receiveAds[]"  <? if($_POST['receiveAds']) { echo "checked"; } else { echo ""; } ?> id="receiveAds">Recevoir les annonces des clients quotidiennement
                         </p>


                       </fieldset>

                 <div class="piedForm">
                         <input type="reset" name="reset" id="reset" value="Annuler" />
                          <input type="hidden" name="validerform" value="1"/>
                         <input type="submit" name="validertransp" id="valid" value="Valider" />
                 </div>
                </div>

        </form>
        </div>
        </div>


</body>
</html>
<?
}
?>
       