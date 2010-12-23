


<?
    
    include_once("libs/class.upload.php");
	include_once("libs/CContactDAO.php");
	include_once("libs/CContact.php");
	include_once("libs/CUtilisateurDAO.php");	
	include_once("libs/CUtilisateur.php");	
	include_once("libs/util.php");
	include_once("libs/CTransactionManager.php");
	include_once("libs/CTransporteurpaysDAO.php");			
    require_once("captcha/hn_captcha.class.x1.php");
	include_once("captcha/captcha_conf.php");
	
	$captcha =& new hn_captcha_X1($CAPTCHA_INIT, false);
 
$erreurs = array();



/*
 * true if match regexp
 */
function checkDpt($dpts) {
	if(ereg("[0-9]",$dpts))
	{
		return true;
	}
	return false;

	
}



if($_POST['validerform'])
{
 $checkbox=$_POST['checkfrance'];
	
	
	switch($captcha->validate_submit()) {
		  case 1:  break;
		  case 2:  $erreurs['captcha'] = "Les données ne correspondent pas avec l'image"; break;
		  case 3: $erreurs['captcha'] = " vous avez atteind le nombre de tentatives autorisées"; break;
	}


     $handle = new Upload($_FILES['photo']);
	 $handle->allowed = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
	 $handle->file_max_size = '1048576';

	if(!empty($_FILES['photo']['name'])) {
		if(!array_key_exists($handle->file_src_mime, array_flip($handle->allowed)))
			   $erreurs['photo'] = "images autorisées : jpg, png, gif";
	} 
	
	if($handle->file_src_size > $handle->file_max_size) 
			 $erreurs['photo'] = "Problème: ".$handle->error;
     		 
        if(empty($_POST['username']))
        {
                $erreurs['username'] = "";
        }
        else
        {
                $cDAO = new CContactDAO($GLOBALS['mysql']);
                $contact = $cDAO->getBy( array( "username" => $_POST['username']));
                if($contact)
                {
                        $erreurs['username'] = "Utilisateur existant";
                }
        }

        if(empty($_POST['mdp1']))
        {
                $erreurs['mdp1'] = "";
        }
        elseif($_POST['mdp1'] != $_POST['mdp2'])
        {
                $erreurs['mdp2'] = "Verifiez";
        }

        elseif(strlen($_POST['mdp1']) < $passwordsize)
        {
                $erreurs['mdp1'] = "Password trop court";
        }

        if(empty($_POST['nomsociete']))
        {
                $erreurs['nomsociete'] = "";
        }


        if(empty($_POST['nomclient']))
        {
                $erreurs['nomclient'] = "";
        }
        
        
        
        else
        {
                $uDAO = new CUtilisateurDAO($GLOBALS['mysql']);
                $utilisateur = $uDAO->getBy( array( "nomclient" => $_POST['nomclient']));
                if($utilisateur)
                {
                        $erreurs['nomclient'] = "Client existant";
                }
        }

        if(empty($_POST['prenom']))
        {
                $erreurs['prenom'] = "";
        }
        
        if(empty($_POST['civilite']))
        {
                $erreurs['civilite'] = "";
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
                if($contact)
                {
                        $erreurs['mail'] = "Mail existant";
                }
        }


               if(empty($_POST['telephonefixe']))
        {
                $erreurs['telephonefixe'] = "";
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
       
              if(empty($_POST['CAtotalAnnuel']))
       {
               $erreurs['CAtotalAnnuel'] = "";
       }



/* Comprend pas ton traitement ici && c'est francesansdpt*/ 
/*
         if($_POST['r_charge'] == "francesaufdpt" && empty($_POST['francesaufdpt']) && checkDpt($_POST['francesaufdpt']))
                        {
                         $erreurs['francesaufdpt'] = "";
                        }
            if($_POST['r_charge'] == "francedpt"  && empty($_POST['dptprisencharge']) && checkDpt($_POST['francedpt']))
                        {
                         $erreurs['dptprisencharge'] = "";
                        }
        */                



        if( $erreurs == array() )
        {
                
                
		        if ($handle->uploaded) {
		
			        $handle->Process('photo/RealSize');
			        if (!$handle->processed)
			            $erreurs['photo'] = $handle->error;
			   
			    	//creation du thumb
			        $handle->image_resize            = true;
			        $handle->image_ratio_y           = true;
			        $handle->image_x                 = 155;
		
		       	    $handle->Process('photo/thumbs');        
			        if (!$handle->processed)
			            $erreurs['photo'] = $handle->error;
		
		       	$handle-> Clean();
			  }
		             



                $uDAO = new CUtilisateurDAO($GLOBALS['mysql']);
                $cDAO = new CContactDAO($GLOBALS['mysql']);
                $trDAO = new CObjetBddDAO("transporteur",$GLOBALS['mysql']);
                $tm = new CTransactionManager($GLOBALS['mysql']);

				$tm->startTransaction();

                $utilisateur = new CUtilisateur();
                $infos = array();
                $infos["datecreation"]=date('Y/m/j H:i:s');
                $infos["last_connexion"]=date('Y/m/j H:i:s');
                $infos["ip"] = $_SERVER["REMOTE_ADDR"]; 
                $infos["nomclient"]=$_POST['nomclient'];
                $infos["prenom"]=$_POST['prenom'];
                $infos["civilite"]=$_POST['civilite'];
                $infos["typeutilisateur"]="transporteur";
                
                $utilisateur->set($infos);
                $id_u = $uDAO->insert($utilisateur);
				if(!$id_u)
				{
					$tm->setQueryErr();
				}
				
                $contact = new CContact();
                $infos=array();
                $infos["idutilisateur"]=$id_u;
                $infos["telephone"]=$_POST['telephonefixe'];
                $infos["portable"]=$_POST['telephoneportable'];
                $infos["fax"]=$_POST['fax'];
                $infos["mail"]=$_POST['mail'];
                $infos["username"]=$_POST['username'];
                $infos["userpass"]=md5($_POST['mdp1']);
                $infos["superuser"]=1;
                if(empty($handle->file_dst_name))
                	$infos["photo"]= "no_picture.jpg";
                else
                	$infos["photo"]= $handle->file_dst_name;
                
                $contact->set($infos);
                $id_c = $cDAO->insert($contact);
                if(!$id_c)
				{
					$tm->setQueryErr();
				}

                $transporteur= new CObjetBDD();
                $infos=array();
                $infos["idutilisateur"]=$id_u;
                $infos["nomsociete"]=$_POST['nomsociete'];
                $infos["delaipaiement"]="";
                $infos["totalvehicule"]=$_POST['nbrvehicultotal'];
                $infos["caannuel"]=$_POST['CAtotalAnnuel'];
                $infos["ageparcmoyen"]=$_POST['Ageparcmoyen'];
                $infos["capacitemin "]=$_POST['capamin'];
                $infos["capacitemax "]=$_POST['capamax'];
               	isset($_POST['receiveAds'])?$infos["receiveAds"]=1 : $infos["receiveAds"]=0;
	   				
	   				
	
                $transporteur->set($infos);
                $id_tr =  $trDAO->insert($transporteur);

				if(!$id_tr)
				{
					$tm->setQueryErr();
				}

				//--- Traitement des départements
				
				$trpaysDAO = new CTransporteurpaysDAO($GLOBALS['mysql']);
				$trcountrybdd = new CObjetBdd();
				$trdptbdd = new CObjetBdd();
				$trpaysinfos['idutilisateur'] = $id_u;
			    $trdptinfos['idutilisateur'] = $id_u;

				switch($_POST["r_charge"])
				{
					

					case "europe":

						$trpaysinfos['selectiontype'] = "EUROPE";
						$trcountrybdd->set($trpaysinfos);
						$queryRes = $trpaysDAO->insert($trcountrybdd);
						
						if(!$queryRes)
							$tm->setQueryErr();
					break;
					   
					case "france":

						$trpaysinfos['selectiontype'] = "FRANCE";
						$trcountrybdd->set($trpaysinfos);
						$queryRes = $trpaysDAO->insert($trcountrybdd);
						
                     	if(!$queryRes)
							$tm->setQueryErr();
                         
                    break;
					
					case "francesansdpt":

					
						$trpaysinfos['selectiontype'] = "FRANCE_WITHOUT_DPTS";
						$trcountrybdd->set($trpaysinfos);
						$queryRes = $trpaysDAO->insert($trcountrybdd);
							
                     	if(!$queryRes)
							$tm->setQueryErr();
						
                         $dpts = explode(",",$_POST['francesansdpt']);
						
                         if (!empty($dpts)) {
	                         	
	                         	$trdptDAO = new CTransporteurdptDAO ($GLOBALS['mysql']);

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
						$queryRes = $trpaysDAO->insert($trcountrybdd);
							
                     	if(!$queryRes)
							$tm->setQueryErr();
						
                         $dpts = explode(",",$_POST['francedpt']);
						
                         if (!empty($dpts)) {
	                         	
	                         	$trdptDAO = new CTransporteurdptDAO ($GLOBALS['mysql']);

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
					$_SESSION["idcontact"] = $id_c;
                 	$_SESSION["username"] = $_POST['username'];
                 	$_SESSION["idutilisateur"] = $id_u;
       				$_SESSION["typeutilisateur"] = "transporteur";
                 	
              	    //$_POST['url']="index.php?action=accueil";
					//$_POST['message']="Votre inscription a été validée";

					
					
					//si l'utilisateur viens d'une page nécessitant d etre loggé
					if(!empty($_GET["marqueurTypeUser"]) && $_GET["marqueurTypeUser"] == "transporteur")
      			    { 
       
	         				include("formulaires/inscription_fin.php");
	         				inscriptionFinOk();
	         				$redirurl = reconstruireUrl($_GET["marqueurPage"]);
	         				include("formulaires/choiceredirectmessage.php");
	         				exit;
                    }
                    //si l'inscription se fait par le menu'
                    else
                    {
                		//include("formulaires/redirectMessage.php");
                		include("formulaires/inscription_fin.php");
         				inscriptionFinOk();
         				InscriptionFinNotes_t();
         				exit;
                    }
				}
                

        }
}

 ?>
        <div class="panelcentre">
        <div class="boiteform">
        <div class="bandeauform">
         <h4>Formulaire d'inscription autocariste</h4>
        </div>
        	<form name="inscriptiontransp" id="inscription" method="post" enctype="multipart/form-data" target="_self" action="">
                
                  
                <div class="corpForm">
               
                <img src="images/style1/error.gif" alt="attention"> <span><i>Il est important de bien remplir ce formulaire afin que la mise en relation avec les voyageurs se fasse dans les meilleures conditions. Les champs précédés d'un <span class="asterisk">*</span> sont obligatoires. </i></span>
                        <br />
                 <br />
                   <fieldset>
                                <legend>Identifiants de connexion</legend>
                                <br />
                                   <p>
                                        <label for="nom" class="oblig" title="Ce nom d'utilisateur servira à vous connecter sur le site" ><span class="asterisk">*</span> Nom d'utilisateur :</label>
                                        <input type="text" name="username" id="username" value="<?echo $_POST[username];?>" title="Ce nom d'utilisateur servira à vous connecter sur le site"  onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                            <? if(isset($erreurs['username']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[username]</img>";
                                             }
                                          ?>
                                     </p>

                                     <p>

                                        <label for="mdp1" class="oblig" title="Mot de passe de la connexion"><span class="asterisk">*</span> Mot de passe :</label>
                                        <input type="password" name="mdp1" id="mdp1" MAXLENGTH="12" value="<?echo $_POST[mdp1];?>" title="Mot de passe de la connexion"  onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                        <? if(isset($erreurs['mdp1']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[mdp1]</img>";
                                             }
                                          ?>
                                     </p>

                                     <p>

                                        <label for="mdp2" class="oblig" title="Mot de passe de la connexion"><span class="asterisk">*</span> Confirmation Mot de passe :</label>
                                        <input type="password" name="mdp2" id="mdp2" MAXLENGTH="12" value="<?echo $_POST[mdp2];?>" title="Mot de passe de la connexion"  onfocus="this.className='focus';" onblur="this.className='normal';" />
                                      <? if(isset($erreurs['mdp2']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[mdp2]</img>";
                                             }
                                          ?>
                                     </p>

                        </fieldset>
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

                                        <label for="nomclient" class="oblig" title="votre prénom"><span class="asterisk">*</span> Nom :</label>
                                        <input type="text" name="nomclient" id="nomclient" value="<?echo $_POST[nomclient];?>" title="votre nom"  onfocus="this.className='focus';" onblur="this.className='normal';" />
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
								<p>
                               		<label>Photo pour le profil</label>
                               	
                               		<input name="photo" type="file" value="" /> <span class="legende">( png, gif, jpg, Max 1MB)</span>
     								 <? if(isset($erreurs['photo']))
                                         {
                                            echo "<img src=\"images/icon_err.gif\"> $erreurs[photo]</img>";
                                         }
                                    ?>                                 
							   </p>	                  


						<p> 	
							<label> Image générée :</label>
                              <? echo $captcha->display_form_part('image')."<br />"; ?>
                        </p><br />
						
                    	<p>
                        	<label> Entrez les caractères ci-dessus (Majuscule):</label>
                               <?  echo  $captcha->display_form_part('input')."<br />"; 
                               if(isset($erreurs['captcha']))
                                         {
                                            echo "<img src=\"images/icon_err.gif\"> $erreurs[captcha]</img>";
                                         }
                               
                               ?>
                        </p>
                        
                         <br />

                         <p>
                         <input type="checkbox" checked="checked" name="receiveAds[]"  <? if(isset($_POST['receiveAds'])) { echo "checked"; } else { echo ""; } ?> id="receiveAds">Recevoir les annonces des clients quotidiennement
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
        
<script type="text/javascript" >
		initDisableChargeText();
</script>  

