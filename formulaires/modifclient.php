

<?



if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

    include_once("libs/class.upload.php");
    include_once("libs/CContactDAO.php");
    include_once("libs/util.php");    
    include_once("libs/CUtilisateurDAO.php");
        
$erreurs = array();
$passwordsize=6;




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
               // $clDAO = new CObjetBddDAO("client",$GLOBALS['mysql']);


                $contact = $cDAO->getById( $_SESSION["idcontact"] );
                $infos=array();
                $infos["telephone"]=$_POST['telephonefixe'];
                $infos["portable"]=$_POST['telephoneportable'];
                $infos["fax"]=$_POST['fax'];
                $infos["mail"]=$_POST['mail'];
                if(!empty($handle->file_dst_name))
                	$infos["photo"]= $handle->file_dst_name;
             
                 if(isset($_POST['mailmodifnotifier'])) 
	   				$infos["mailmodifnotifier"]=1;
	   				else
	   				$infos["mailmodifnotifier"]=0;
	
	           	 if(isset($_POST['mailrepondunotifier'])) 
	   				$infos["mailrepondunotifier"]=1;
	   				else
	   				$infos["mailrepondunotifier"]=0;
                $contact->set($infos);
                $cDAO->update($contact);

                $utilisateur = $uDAO->getById( $contact->get('idutilisateur') );
                $infos = array();
               
                $utilisateur->set($infos);
                $uDAO->update($utilisateur);
/*
 * table client, on s'en fou pour le moment
 * 
                $client = $uDAO->getBy( array('idutilisateur' => $contact->get('idutilisateur') ));
                $infos=array();
                $client->set($infos);
                $clDAO->update($client);

*/

                $_SESSION["username"] = $contact->get("username");

                $_POST['url']="index.php?action=accueil";
				$_POST['message']="Votre profil a été mis à jour";
        		include("formulaires/redirectMessage.php");
        		unset($_POST); 
         



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

 $_POST['mailmodifnotifier'] = $contact->get("mailmodifnotifier");
 $_POST['mailrepondunotifier'] = $contact->get("mailrepondunotifier");

     $cDAO = new CObjetBddDAO("contact",$GLOBALS['mysql']);
 	 $contact = $cDAO->getById($_SESSION["idcontact"]);
 	 $infos["idutilisateur"]=$contact->get("idutilisateur");


    $uDAO = new CObjetBddDAO("utilisateur",$GLOBALS['mysql']);
    $utilisateur = $uDAO->getById($contact->get("idutilisateur"));
    $_POST['nomclient'] = $utilisateur->get("nomclient");
   ?>
         <div class="panelcentre">
        <div class="boiteform">
        <div class="bandeauform">
         <h4>Modification profil client   <? echo $contact->get("username"); ?></h4>
         </div>
   <form name="inscriptionclient" id="inscription" method="post" enctype="multipart/form-data"  target="_self" action="">
                
                <div class="corpForm">
                       
                        <br />
                       <fieldset>
                                  <legend>Contacts</legend>
                                  <br />
                               <p>

                                        <label for="nomclient" class="oblig" title="Ce nom apparaitra sur votre fiche">* Nom client :</label>

                                        <input type="text" name="nomclient" id="nomclient" disabled="disabled" value="<?echo $_POST[nomclient];?>" title="Ce nom apparaitra sur votre fiche"onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                          <? if(isset($erreurs['nomclient']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[nomclient]</img>";
                                             }
                                          ?>
                               </p>
                                                            <p>

                                     <label for="telephonefixe">Téléphone Fixe :</label>
                                     <input type="text" name="telephonefixe" id="telephonefixe" MAXLENGTH="10" value="<?echo $_POST[telephonefixe];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)"/>
                                     <span class="legende">ex: 0612345678 </span>
                               </p>
                               <p>

                                        <label for="telephoneportable">Téléphone Portable :</label>
                                        <input type="text" name="telephoneportable" id="telephoneportable" MAXLENGTH="10" value="<?echo $_POST[telephoneportable];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)"/>
                               </p>
                               <p>
                                        <label for="fax">Fax :</label>
                                        <input type="text" name="fax" id="fax" MAXLENGTH="10" value="<?echo $_POST[fax];?>" onfocus="this.className='focus';" onblur="this.className='normal';" onKeyPress="return numbersonly(this, event)" />
                               </p>


                               <p>

                                        <label for="mail" class="oblig">* E-mail :</label>
                                        <input type="text" name="mail" id="mail" value="<?echo $_POST[mail];?>" onfocus="this.className='focus';" onblur="this.className='normal';"/>
                                          <? if(isset($erreurs['mail']))
                                             {
                                                echo "<img src=\"images/icon_err.gif\"> $erreurs[mail]</img>";
                                             }
                                          ?>

                               </p>
								<div class="photoEditProfil">
								
                             
                               	<label><a href="photo/RealSize/<?echo $contact->get("photo")?>"><img src="photo/thumbs/<?echo $contact->get("photo")?>"/></a></label>
	
                               		
								</div>
								<br />
								<p>
                               		<label>Changer la photo actuelle</label>
                               	
                               		<input name="photo" type="file" value="" /> <span class="legende">( png, gif, jpg, Max 1MB)</span>
     								 <? if(isset($erreurs['photo']))
                                         {
                                            echo "<img src=\"images/icon_err.gif\"> $erreurs[photo]</img>";
                                         }
                                    ?>                                 
							   </p>	           
                        </fieldset>
                        <br />
                
                        <fieldset>
                          <legend>Notification par email</legend>
                          <br />

                               <p title="Recevoir un mail lorsqu'un transporteur modifie son annonce"><input type="checkbox" name="mailmodifnotifier[]"  <? if(($_POST['mailmodifnotifier'])) { echo "checked"; } else { echo ""; } ?> id="mailmodifnotifier">Recevoir un mail lorsqu'un transporteur modifie son annonce? </label></p>
                         		<br />
                         	   <p title="Recevoir un mail lorsqu'un transporteur a répondu à votre annonce"><input type="checkbox" name="mailrepondunotifier[]" <? if(($_POST['mailrepondunotifier'])) { echo "checked"; } else { echo ""; } ?> id="mailrepondunotifier">Recevoir un mail lorsqu'un transporteur a répondu à votre annonce? </label></p>
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

  