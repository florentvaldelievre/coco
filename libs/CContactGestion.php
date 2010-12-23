<?php

if(defined("__CContactGestion"))
    return;

define("__CContactGestion","");

include_once("CContact.php");
include_once("CContactDAO.php");
include_once("class.phpmailer.php");



class CContactGestion
{
    var $contactDAO;
    var $mysql_res="";

    function CContactGestion($mysql_res)
    {
        $this->mysql_res = $mysql_res;
        $this->contactDAO = new CContactDAO($mysql_res);
    }

    function newPass($Nb_caracteres)
    {
        $Caractere_possible = "abcdefghijklmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);

        $pass="";
        for($i=0; $i<$Nb_caracteres; $i++)
        {
            $pass .= $Caractere_possible[rand()%strlen($Caractere_possible)];
        }

        return $pass;
    }



function nouveaucontact($infos_contact)
 {

       $cDAO = new CContactDAO($this->mysql_res);
       $contact = new CContact();
       $pass=$this->newPass(6);
       $infos=array();
       $infos["idutilisateur"]=$infos_contact["idutilisateur"];
       $infos["telephone"]=$infos_contact["telephone"];
       $infos["portable"]=$infos_contact["portable"];
       $infos["fax"]=$infos_contact["fax"];
       $infos["mail"]=$infos_contact["mail"];
       $infos["username"]=$infos_contact["username"];
       $infos["userpass"]=md5($pass);
       $infos["superuser"]=$infos_contact["superuser"];
       $contact->set($infos);

       $id_c = $cDAO->insert($contact);

        $expediteur = "moi@chartercar.fr";
        $objet="Nouveau contact sur chartercar.fr";
        $destinataire = $infos_contact["mail"];
        $contenu = "<html><body>
        <h1>Information Identification</h1>
        <span class=gras><u>Ajout dun nouveau contact sur www.chartercar.fr</u></span><br/>
        Nom d'utilisateur : ".$contact->get('username')."<br/>
        Mot de passe : $pass <br><br/>

        </body></html>";

        $mail = new PHPMailer();
        $mail->SetLanguage("fr","/var/www/chartercar/libs/");
        $mail->IsSMTP();                                      // set mailer to use SMTP
        $mail->Host = "localhost";  // specify main and backup server
        $mail->SMTPAuth = false;     // turn on SMTP authentication
        //$mail->Username = "jswan";  // SMTP username
        //$mail->Password = "secret"; // SMTP password
        $mail->From = "$expediteur";
        $mail->FromName = "Chartercar";
        //$mail->AddAddress("josh@example.net", "Josh Adams");
        $mail->AddAddress("$destinataire");                  // name is optional
        $mail->AddReplyTo("$destinataire", "Chartercar");
        $mail->WordWrap = 50;                                 // set word wrap to 50 characters
        //$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
        //$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
        $mail->IsHTML(true);                                  // set email format to HTML
        $mail->Subject = "$objet";
        $mail->Body    = "$contenu";
        $mail->AltBody = "$contenu";

        if(!$mail->Send())
        {
           echo "Le message n'a pas pu étre envoyé <p>";
           echo "Mailer Error: "; //$mail->ErrorInfo;
           return false;
        }

        return true;

 }


 function changePass($mail)
    {
        $contact = $this->contactDAO->getByMail($mail);

        if(!$contact){
                return 0;
        }

        $newpassDAO = new CObjetBddDAO("changementpass",$this->mysql_res);
        while( $newpassDAO->getBy( array( "idchangementpass" => ($id = $this->newPass(32) ) ) ) ){}

        $infos=array();
        $infos["idcontact"]=$contact->get("idcontact");
        $this->mysql_res->delete_all("changementpass",$infos);

        $pass=$this->newPass(6);

        $newpass = new CObjetBdd("changementpass",$this->mysql_res);
        $infos=array();
        $infos["idcontact"]=$contact->get("idcontact");
        $infos["nouveaupass"]=md5($pass);
        $infos["idchangementpass"]=$id;
        $newpass->set($infos);
        $newpassDAO->insert($newpass);

        $expediteur = "moi@chartercar.fr";
        $objet="Changement de mot de passe pour chartercar.fr";
        $destinataire = $mail;
        $contenu = "<html><body>
        <h1>Information Identification</h1>
        <span class=gras><u>Recapitulatif du compte sur www.chartercar.fr</u></span><br/>
        Nom d'utilisateur : ".$contact->get('username')."<br/>
        Nouveau mot de passe : $pass <br><br/>

        Pour activer ce nouveau mot de passe, suivez ce lien:
        <a href=".$GLOBALS['url_server']."index.php?action=newpass&i=$id>Activation du nouveau mot de passe</a>
        </body></html>";

        $mail = new PHPMailer();
        $mail->SetLanguage("fr","/var/www/chartercar/libs/");
        $mail->IsSMTP();                                      // set mailer to use SMTP
        $mail->Host = "192.168.0.3";  // specify main and backup server
        $mail->SMTPAuth = false;     // turn on SMTP authentication
        //$mail->Username = "jswan";  // SMTP username
        //$mail->Password = "secret"; // SMTP password
        $mail->From = "$expediteur";
        $mail->FromName = "Chartercar";
        //$mail->AddAddress("josh@example.net", "Josh Adams");
        $mail->AddAddress("$destinataire");                  // name is optional
        $mail->AddReplyTo("$destinataire", "Chartercar");
        $mail->WordWrap = 50;                                 // set word wrap to 50 characters
        //$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
        //$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
        $mail->IsHTML(true);                                  // set email format to HTML
        $mail->Subject = "$objet";
        $mail->Body    = "$contenu";
        $mail->AltBody = "$contenu";

        if(!$mail->Send())
        {
           echo "Le message n'a pas pu étre envoyé <p>";
           echo "Mailer Error: " . $mail->ErrorInfo;
           exit;
        }


    }

function changePassConfirm($idchangementpass)
    {

        $newpassDAO = new CObjetBddDAO("changementpass",$this->mysql_res);
        $newpass = $newpassDAO->getBy(array( "idchangementpass" => $idchangementpass) );

        if(!$newpass)
        {
                echo "Id inexistant, refaites une demande";
        }

        $contact = $this->contactDAO->getById($newpass->get('idcontact'));

        if(!$contact)
        {
                echo "User inexistant";
        }
        else
        {
           $contact->infos['userpass'] = $newpass->get('nouveaupass');
           $this->contactDAO->update($contact);
           $newpassDAO->_delete($newpass);
        }

    }
}

?>