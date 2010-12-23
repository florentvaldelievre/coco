<?php
 
 
 include_once("class.phpmailer.php");
 
	class MailManager extends PHPMailer {
	
	 
		private static $instance;	 

		/*
		 * Singleton
		 */
	 	public static function getInstance() {
     		if ( !isset(self::$instance) ) {
       		self::$instance = new MailManager();
       		}      			 
     	return self::$instance;
    	}

	 	   /* 
	 	    *private car uniquement appelé par getInstance() 
	 	   */      
	 	private function __construct() {   
	 	      	    
	 	  //echo getcwd();
			$this->SetLanguage("fr","libs/");
	        $this->IsSMTP();                                      // set mailer to use SMTP
	        $this->Host = "localhost";  // specify main and backup server
	        $this->SMTPAuth = false;     // turn on SMTP authentication
	        $this->WordWrap = 50;                                 // set word wrap to 50 characters
		    $this->IsHTML(false);
		    $this->FromName = "waybus";

	 	}
	
		/**
		 * Prevenir le client que son annonce a été répondue
		 */
		 public function Envoi_mail($destinataire,$contenu,$objet)
		   {
		   		$this->Subject = "$objet";
		   		$this->Body    = "$contenu";
                $this->AltBody = "$contenu";					
				$expediteur = "mailer@chartercar.fr";
		        $this->From = "waydev@chartercar.fr";        
		        $this->AddAddress("$destinataire");                  // name is optional
				$this->send_email($destinataire);
       	   	
		   }
		
		
		
		/**
		 * Envoi du mail
		 */ 
		
		 private function send_email($destinataire)
		 {
		 	if(!$this->Send())
                
                {
                   echo "Le message n'a pas pu étre envoyé <p>";
                   echo "Mailer Error: ";  //$this->ErrorInfo;
                  //  exit;
                } 
                else
                {
               // echo "<br/>mail envoyé à ".$destinataire; 
                }
		 }

	 public  function __destruct() {
  
 		
   }

	}
?>
