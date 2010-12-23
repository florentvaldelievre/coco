


<?php
   
include_once("libs/mailmanager.php");
require_once('paypal.class.php');

//Lorsque le client valide la commande sur l'interface paypal, paypal nous le notifie ici en POST
//Pour être sur que la notification vien bien de paypal , nous devons renvoyer tte les variable post à paypal (validate_ipn())
// VERIFIED si c'est ok : on inserre en bdd

  $p = new paypal_class(); 
  
   
      if ($p->validate_ipn()) {
          
 
 
           //update du tag sur la table facture
		  $infos["paye"]=1;         
		  $query_add_tag_facture = "select * from factures f
									inner join transport t on (f.idreponsetr = t.idreponsetr )
									where ( t.iddemandetr = ".$p->ipn_data['item_number']." )";   
									
									       	
 	     	$fDAO = new CObjetBddDAO("factures",$GLOBALS['mysql']);   
			$add_tag = $fDAO->getByCustomQuery($query_add_tag_facture); 
			$dTR = $fDAO->getBy( Array( 'idreponsetr' => $add_tag[0]->get("idreponsetr")));
		    $dTR->set($infos);
		    $fDAO->update($dTR);

			//remplir la table paypal
			
			$infos=array();
			$infos["iddemandetr"]=$p->ipn_data['item_number'];
			$infos["idutilisateur"]=$p->ipn_data['custom'];			
			
			$paypalDAO = new CObjetBddDAO("paypal",$GLOBALS['mysql']); 
		    $paypalObj= new CObjetBDD();
		    $paypalObj->set($infos);
	        $paypalDAO->insert($paypalObj);
          
         // Payment has been recieved and IPN is verified.  This is where you
         // update your database to activate or process the order, or setup
         // the database with the user's order details, email an administrator,
         // etc.  You can access a slew of information via the ipn_data() array.
  
         // Check the paypal documentation for specifics on what information
         // is available in the IPN POST variables.  Basically, all the POST vars
         // which paypal sends, which we send back for validation, are now stored
         // in the ipn_data() array.
  
         // For this example, we'll just email ourselves ALL the data.
         $subject = "paiement paypal ".$p->ipn_data['item_number']." du ".date('m/d/Y')." à ".date('g:i A')." a fonctionné";
         $to = 'florent.valdelievre@wanadoo.fr';    //  your email
         $body =  "Payment bien reçu";
         $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
         $body .= " at ".date('g:i A')."\n\nDetails:\n";
//         
//         foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; } //voir les variables
						
     			$singleton = MailManager::getInstance();
     			$singleton->Envoi_mail($to,$body,$subject);
     			$singleton->ClearAddresses();
      }
      else
      {
      	     	
		      	 $subject = "Votre paiement paypal du ".date('m/d/Y')." à ".date('g:i A')." a échoué";
		         $to = $p->ipn_data['payer_email'];
		         $body =  "Le paiment de ".$p->ipn_data['item_name']." a échoué <br />";
		         $body .= "Veuillez reessayer ulterieusement";
      	     	 $singleton = MailManager::getInstance();
     			 $singleton->Envoi_mail($to,$body,$subject);
     			 $singleton->ClearAddresses(); 
      }


?>
