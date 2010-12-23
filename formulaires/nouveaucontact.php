

<?

return "non disponible pour le moment"; 

if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

$erreurs = array();

if($_POST[validerform])
{

       if(empty($_POST['nomclient']))
        {
                $erreurs['nomclient'] = "";
        }
        else
        {
                $cDAO = new CContactDAO($GLOBALS['mysql']);
                $contact = $cDAO->getBy( array( "username" => $_POST['nomclient']));
                if($contact)
                {
                        $erreurs['nomclient'] = "Utilisateur existant";
                }
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

        if( $erreurs == array() )
        {
                $cDAO = new CObjetBddDAO("contact",$GLOBALS['mysql']);
                $contact = $cDAO->getById($_SESSION["idcontact"]);
                $infos=array();
                $infos["idutilisateur"]=$contact->get("idutilisateur"); 
                $infos["telephone"]=$_POST['telephonefixe'];
                $infos["portable"]=$_POST['telephoneportable'];
                $infos["fax"]=$_POST['fax'];
                $infos["mail"]=$_POST['mail'];
                $infos["username"]=$_POST['nomclient'];
                $infos["superuser"]=0;

                $cgDAO = new CContactGestion($GLOBALS['mysql']);
                if($cgDAO->nouveaucontact($infos))
                {
                        echo "Nouveau contact: ".$infos["username"]."<br \>";
                }
                else
                {
                        echo "Echec de l'opération, veuillez réessayer ultérieurement<br \>";
                }

                echo "<meta http-equiv=refresh content=\"2; url=?action=accueil\">";
                return;
        }
}
?>
     <pre>Nouveau contact associé à <font color="#34A5E0"><? echo $_SESSION['username']  ?>  </font></pre>
     <form name="contacts" id="contacts" method="post" target="_self" action="">
                        <div class="corpForm"> <br/>
                        <fieldset>
                                <legend>Contact</legend>
                                <br />

                               <p>

                                        <label for="nomclient" class="oblig" title="Ce nom apparaitra sur votre fiche">* Nom client :</label>
                                        <input type="text" name="nomclient" id="nomclient" value="<?echo $_POST[nomclient];?>" title="Ce nom apparaitra sur votre fiche"  onfocus="this.className='focus';" onblur="this.className='normal';"/>
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
                         <br />
                        </fieldset>
                       <br />

   <em>* Champs obligatoires</em>
                 <div class="piedForm">
                         <input type="reset" name="reset" id="reset" value="Annuler" />
                         <input type="hidden" name="validerform" value="1"/>
                         <input type="submit" name="validerclient" id="valid" value="Valider" />
                 </div>
                </div>

        </form>