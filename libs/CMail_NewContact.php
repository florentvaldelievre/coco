<?php
 
 import("class.phpmailer.php");
 import("Clog.php");
 
	class CMail_NewContact extends PHPMailer{
		function CMail_NewContact($destinataire,$username,$userpass){
			$this->SetBody();
			
			$contenu = "<html><body>
	        <h1>Information Identification</h1>
	        <span class=gras><u>Ajout dun nouveau contact sur www.chartercar.fr</u></span><br/>
	        Nom d'utilisateur : ".$contact->get('username')."<br/>
	        Mot de passe : $pass <br><br/>
	        </body></html>";
		}
	
	}
	
	/*
	    $objet="Nouveau contact sur chartercar.fr";
        $destinataire = $infos_contact["mail"];
     */   
?>