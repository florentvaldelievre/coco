

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

if($_POST[validerform])
{

	
	switch($captcha->validate_submit()) {
		  case 1:  break;
		  case 2: $erreurs['captcha'] = "Les données ne correspondent pas avec l'image"; break;
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
                $clDAO = new CObjetBddDAO("client",$GLOBALS['mysql']);
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
                $infos["typeutilisateur"]="client";
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
                 if(empty($handle->file_dst_name))
                	$infos["photo"]= "no_picture.jpg";
                else
                	$infos["photo"]= $handle->file_dst_name;
                	              	
	           	 if(isset($_POST['mailmodifnotifier'])) 
	   				$infos["mailmodifnotifier"]=1;
	   				else
	   				$infos["mailmodifnotifier"]=0;
	
	           	 if(isset($_POST['mailrepondunotifier'])) 
	   				$infos["mailrepondunotifier"]=1;
	   				else
	   				$infos["mailrepondunotifier"]=0;

                $infos["username"]=$_POST['username'];
                $infos["userpass"]=md5($_POST['mdp1']);
                $infos["superuser"]=1;
                $contact->set($infos);
                $id_c = $cDAO->insert($contact);
                if(!$id_c)
				{
					$tm->setQueryErr();
				}

                $client = new CObjetBDD();
                $infos=array();
                $infos["idutilisateur"]=$id_u;
                $client->set($infos);
                $id_cl = $clDAO->insert($client);
                if(!$id_cl)
				{
					$tm->setQueryErr();
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
       				$_SESSION["typeutilisateur"] = "client";
	
	                //$_POST['url']="index.php?action=accueil";
					//$_POST['message']="Votre inscription a été validée";
	                //include("formulaires/redirectMessage.php");
	                
	                //si l'utilisateur viens d'une page nécessitant d etre loggé
					if(!empty($_GET["marqueurTypeUser"]) && $_GET["marqueurTypeUser"] == "client")
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
         				InscriptionFinNotes_c();
         				exit;
                    }
	                
				}
				
				
				

                

        }
}

?>
        <div class="panelcentre">
        <div class="boiteform">
        <div class="bandeauform">
         <h4>Formulaire d'inscription voyageur</h4>
        </div>  
        <form name="inscriptionclient" id="inscription" method="post" enctype="multipart/form-data" target="_self" action="">
                <div class="corpForm"> 
                        <img src="images/style1/error.gif" alt="attention"> <span><i>Il est important de bien remplir ce formulaire afin que la mise en relation avec les transporteurs se fasse dans les meilleures conditions. Les champs précédés d'un <span class="asterisk"><span class="asterisk">*</span></span> sont obligatoires. </i></span>
                        <br />
                        <br />
                        <fieldset>
                                <legend>Identifiants de connexion</legend>
                                <br />
                                <p>

                                        <label for="username" class="oblig" title="Ce nom d'utilisateur servira à vous connecter sur le site" ><span class="asterisk">*</span> Nom d'utilisateur :</label>
                                        <input type="text" name="username" id="username" value="<?echo $_POST[username];?>" title="Ce nom d'utilisateur servira à vous connecter sur le site"  onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                          <? if(isset($erreurs['username']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[username]</img>";
                                             }
                                          ?>

                                </p>
                                <p>
                                        <label for="mdp1" class="oblig" title="Mot de passe de la connexion"><span class="asterisk">*</span> Mot de passe :</label>
                                        <input type="password" name="mdp1" id="mdp1" value="<?echo $_POST[mdp1];?>" title="Mot de passe de la connexion"  onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                          <? if(isset($erreurs['mdp1']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[mdp1]</img>";
                                             }
                                          ?>
                                </p>
                                <p>

                                        <label for="mdp2" class="oblig" title="Mot de passe de la connexion"><span class="asterisk">*</span> Confirmation Mot de passe :</label>
                                        <input type="password" name="mdp2" id="mdp2" value="<?echo $_POST[mdp2];?>" title="Mot de passe de la connexion"  onfocus="this.className='focus';" onblur="this.className='normal';" />
                                          <? if(isset($erreurs['mdp2']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[mdp2]</img>";
                                             }
                                          ?>
                                </p>

                        </fieldset>
                        <br />
                        <fieldset>
                                  <legend>Informations personnelles</legend>
                                  <br />
                                  
                               <p>	
                              		
                              		<label for="civilite" class="oblig" title="civilité"><span class="asterisk">*</span> civilité :</label>        
									<select id="civilite" name="civilite"><option value="0" <?if($_POST['civilite']==0) echo "selected=\"selected\""; ?>>-</option>
									<option value="M" <?if($_POST['civilite']=="M") echo "selected=\"selected\""; ?>>M</option>
									<option value="Mme" <?if($_POST['civilite']=="Mme") echo "selected=\"selected\""; ?>>Mme</option>
									<option value="Mlle" <?if($_POST['civilite']=="Mlle") echo "selected=\"selected\""; ?>>Mlle</option></select>
									      <? if(isset($erreurs['civilite']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[nomclient]</img>";
                                             }
                                          ?>
									
                               </p>
                              
      
                               <p>

                                        <label for="nomclient" class="oblig" title="nom"><span class="asterisk">*</span> Nom :</label>
                                        <input type="text" name="nomclient" id="nomclient" value="<?echo $_POST[nomclient];?>" title="votre nom"  onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                          <? if(isset($erreurs['nomclient']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[nomclient]</img>";
                                             }
                                          ?>
                               </p>
                               
                                                              <p>

                                        <label for="prenom" class="oblig" title="prenom"><span class="asterisk">*</span> Prénom :</label>
                                        <input type="text" name="prenom" id="nomclient" value="<?echo $_POST[prenom];?>" title="votre prénom"  onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                          <? if(isset($erreurs['prenom']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[prenom]</img>";
                                             }
                                          ?>
                               </p>
                               
                               <p>

                                     <label for="telephonefixe" class="oblig"><span class="asterisk">*</span>Téléphone Fixe :</label>
                                     <input type="text" name="telephonefixe" id="telephonefixe" MAXLENGTH="10" value="<?echo $_POST[telephonefixe];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)"/>
                                     <span class="legende">ex: 0112345678 </span>
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
                                                    
			
					  </fieldset>
                       <br />
                       
                         <fieldset>
                                  <legend>Notification par email</legend>
                                  <br />

                               <p title="Recevoir un mail lorsqu'un transporteur modifie son annonce"><input type="checkbox" checked="checked" name="mailmodifnotifier[]"  <? if(isset($_POST['mailmodifnotifier'])) { echo "checked"; } else { echo ""; } ?> id="mailmodifnotifier">Recevoir un mail lorsqu'un transporteur modifie son annonce? </label></p>
                       
                         	   <p title="Recevoir un mail lorsqu'un transporteur a répondu à votre annonce"><input type="checkbox" checked="checked" name="mailrepondunotifier[]" <? if(isset($_POST['mailrepondunotifier'])) { echo "checked"; } else { echo ""; } ?> id="mailrepondunotifier">Recevoir un mail lorsqu'un transporteur a répondu à votre annonce? </label></p>
                         </fieldset> 
                 <div class="piedForm">
                         <input type="reset" name="reset" id="reset" value="Annuler" />
                         <input type="hidden" name="validerform" value="1"/>
                         <input type="submit" name="validerclient" id="valid" value="Valider" />
                 </div>
                </div>

        </form>
        </div>
        </div>
        
