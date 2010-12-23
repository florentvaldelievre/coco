<?php


	require_once('paypal.class.php');  // include the class file

	$url = new CGererURL();
	CFilterOrderBy::setDefault($url);
	CFilterOrderAscending::setDefault($url);
	$listingGestion = new CListingGestion($GLOBALS['mysql']);
	$infoAnnonce = $listingGestion->demandeValideesTransporteur($_SESSION['idutilisateur'],$_GET['idtr'], null,null,$url);
	
	$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);
	$listeEtapes = $itineraireGestion->getItineraire($infoAnnonce[0]->get("iddemandetr"));



	$p = new paypal_class();             // initiate an instance of the class
	$p->paypal_url = 'https://www.sandbox.paypal.com/fr/cgi-bin/webscr';   // testing paypal url
	$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; //index.php



echo "    <div class=\"panelcentre\">
        	<div class=\"boiteform\">
		        <div class=\"bandeauform\">
		         	<h4>Paiment avec <img src=\"images/PayPal_mark_37x23.gif\"/></h4>
		        </div>			

                               <div class=\"boiteinfo\">

									<div class=\"bandeauinfo\"><img src=\"./images/style1/exclamation-blue.gif\" alt=\"icon_exclamation-blue\" /></div>
								
									<div class=\"boiteinfocontent\">
										<p>Nous vons conseillons fortement d'attendre que le voyageur vous paye avant de procéder à la transaction.</p><p> Si le voyageur ne vous paye pas, nous ne serons pas en mesure de vous rembourser.</p>
									</div>
								
									<div class=\"footinfo\">
										<img class=\"alignright\" src=\"./images/style1/exclamation-blue.gif\" alt=\"icon_exclamation-blue\" />
									</div>
								
								</div>

        <h5>Vous payez pour la demande validée N°".$infoAnnonce[0]->get("iddemandetr")." :</h5>";



echo "<strong>Etapes </strong><br />";
							
			foreach($listeEtapes as $etape)
			{
				echo $etape->get("ville")."<br />";
			}
		echo "<br />";
			
		echo "<strong>Montant à payer : <font color=\"red\">".   $infoAnnonce[0]->get("prixfacture")." €</font></strong>";


      // There should be no output at this point.  To process the POST data,
      // the submit_paypal_post() function will output all the HTML tags which
      // contains a FORM which is submited instantaneously using the BODY onload
      // attribute.  In other words, don't echo or printf anything when you're
      // going to be calling the submit_paypal_post() function.
 
      // This is where you would have your form validation  and all that jazz.
      // You would take your POST vars and load them into the class like below,
      // only using the POST values instead of constant string expressions.
 
      // For example, after ensureing all the POST variables from your custom
      // order form are valid, you might have:
      //
      // $p->add_field('first_name', $_POST['first_name']);
      // $p->add_field('last_name', $_POST['last_name']);
      
      $p->add_field('business', 'floren_1194471024_biz@wanadoo.fr');
      $p->add_field('return', $this_script.'?action=paypal_thx');
      $p->add_field('cancel_return', $this_script.'?action=listing_valider_t');
      $p->add_field('notify_url', $this_script.'?action=paypal_notify');
      $p->add_field('item_name', $infoAnnonce[0]->get("typetransport")." ".$infoAnnonce[0]->get("iddemandetr"));
      $p->add_field('item_number', $infoAnnonce[0]->get("iddemandetr"));
      $p->add_field('custom', $_SESSION['idutilisateur']);    //champs custom, pratique!
      $p->add_field('currency_code" ', 'EUR');
      $p->add_field('amount',round($infoAnnonce[0]->get("tarifttc")*PERCENT_PRICE));


      $p->submit_paypal_post(); // submit the fields to paypal
     // $p->dump_fields();      // for debugging, output a table of all the fields


  echo "</div></div>"; 

?>