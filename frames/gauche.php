
<?php

    include_once("libs/CListingGestion.php");
    include_once('libs/CGererURL.php'); 
    
//---- Si loggé ----
if(isset( $_SESSION['username']) )
{
       

	// *** Identification - loggé ***    
	echo "<div class=\"portlet\">
	      <h5>Identification</h5>
	      <div class=\"portletBody\">
	      <div class=\"portletContent\">";
		  
	echo "<div class=\"portletTitle\">Bienvenue <strong>$_SESSION[prenom]</strong></div>";
	
	echo "<form name=\"deloggue\"  id=\"deloggue\" method=\"post\" action=\"?action=destroy\">    
		<ul class=\"portletMenu\">
		<li id=\"delog\"><input type=\"submit\" name=\"logout\" id=\"logout\" value=\"logout\" /></li>
	    </ul></form>";

	echo "</div></div></div>";         
	// ************************	
	      
	                 

	$listingGestion = new CListingGestion($GLOBALS['mysql']);
	$url = new CGererURL();

	
	//---- Si loggé en Transporteur----
	if( $_SESSION["typeutilisateur"] == "transporteur" ){
	  

	$consulterAnnonces = $listingGestion->consulterAnnonces("",null,null,$url);
	$nbconsulterAnnonces = $listingGestion->mysql_res->lastSelectNumberOfRows;
	
	$annoncesAttenteConfirmation = $listingGestion->annoncesAttenteConfirmation($_SESSION["idutilisateur"],null,null,$url);
  	$nbannoncesAttenteConfirmation = $listingGestion->mysql_res->lastSelectNumberOfRows;
   
    $demandeValideesTransporteur = $listingGestion->demandeValideesTransporteur($_SESSION["idutilisateur"],"", null,null,$url);
    $nbdemandeValideesTransporteur = $listingGestion->mysql_res->lastSelectNumberOfRows;
   
    $annoncesRefusees = $listingGestion->annoncesRefusees($_SESSION['idutilisateur'], null,null,$url);
	$nbannoncesRefusees  = $listingGestion->mysql_res->lastSelectNumberOfRows;  

	$annoncesExpirees = $listingGestion->annoncesExpirees($_SESSION['idutilisateur'], null,null,$url);	
	$nbannoncesExpirees  = $listingGestion->mysql_res->lastSelectNumberOfRows;  	
		
          
		// *** Profil Utilisateur ***    
		echo "<div class=\"portlet\">
		      <h5>Profil Utilisateur</h5>
		      <div class=\"portletBody\">
		      <div class=\"portletContent\">
		      <ul class=\"portletMenu\">";
		      
		echo "<li id=\"editerProfil\"><a href=\"index.php?action=modiftransporteur\">Editer profil</a></li>"; 
		echo "<li id=\"changerPass\"><a href=\"index.php?action=modifmdp\">Changer mot de passe</a></li>"; 
		echo "<li id=\"factures\"><a href=\"index.php?action=factures\">Voir ses factures</a></li>";
		  
		echo "</ul>";        
		echo "</div></div></div>";         
		// ************************	  
		  
		         
		// *** Annonces ***                   
		echo "<div class=\"portlet\">
			<h5>Annonces</h5>
		 	<div class=\"portletBody\">
			<div class=\"portletContent\">
			<ul class=\"portletMenu\">";
			
		echo "<li id=\"consulterAnnonce\"><a href=\"index.php?action=consulterannonce\">Consulter Annonces <span class=\"portletNumber\">"; 
		echo " (".$nbconsulterAnnonces.")";
		echo "</span></a></li>";
		
		echo "</ul>";                  
		echo "</div></div></div>";         
		// ************************	  
		  
		  
		// *** Mes propositions ***                 
		echo "<div class=\"portlet\">
		  	<h5>Mes propositions</h5>
		    <div class=\"portletBody\">
		    <div class=\"portletContent\">
		    <ul class=\"portletMenu\">"; 
		  
		// - en attente de confirmation
		echo "<li id=\"propositionAttente\"><a href=\"index.php?action=mesannonces\">En attente de confirmation <span class=\"portletNumber\">"; 
		echo " (".$nbannoncesAttenteConfirmation.")";
		echo "</span></a></li>";
		
		// - validées
		echo "<li id=\"propositionValide\"><a href=\"index.php?action=listing_valider_t\">Validées <span class=\"portletNumber\">";
		echo " (".$nbdemandeValideesTransporteur.")";
		echo "</span></a></li>";

		// - refusées
		echo "<li id=\"propositionRefuse\"><a href=\"index.php?action=listing_refuser\">Refusées <span class=\"portletNumber\">";	
		echo " (".$nbannoncesRefusees.")";
		echo "</span></a></li>";
		
		// - expirées
		echo "<li id=\"propositionExpire\"><a href=\"index.php?action=listing_expirer\">Expirées <span class=\"portletNumber\">";	
		echo " (".$nbannoncesExpirees.")";
		echo "</span></a></li>";
			
		echo "</ul>";
		echo "</div></div></div>"; 
		// ************************		
		   
	                           
	}
	//---- Si loggé en Client----       
	else {

	    $demandesAttenteReponseClient = $listingGestion->demandesAttenteReponseClient($_SESSION['idutilisateur'], null,null,$url);
		$nbdemandesAttenteReponseClient = $listingGestion->mysql_res->lastSelectNumberOfRows;
		
		$demandesRepondues = $listingGestion->demandesRepondues($_SESSION['idutilisateur'], null,null,$url);
		$nbdemandesRepondues = $listingGestion->mysql_res->lastSelectNumberOfRows;
				
		$demandesValidees = $listingGestion->demandeValideesClient($_SESSION['idutilisateur'],null,null,null,$url);
		$nbdemandesValidees = $listingGestion->mysql_res->lastSelectNumberOfRows;
				
   		$annoncesSupprimeesClient = $listingGestion->annoncesSupprimeesClient($_SESSION['idutilisateur'], null,null,$url);
		$nbannoncesSupprimeesClient = $listingGestion->mysql_res->lastSelectNumberOfRows;

		// *** Profil Utilisateur ***    
		echo "<div class=\"portlet\">
		      <h5>Profil Utilisateur</h5>
		      <div class=\"portletBody\">
		      <div class=\"portletContent\">
		      <ul class=\"portletMenu\">";
		
	//	echo "<li id=\"nouveauContact\"><a href=\"index.php?action=nouveaucontact\">Nouveau Contact</a></li>";               
		echo "<li id=\"editerProfil\"><a href=\"index.php?action=modifclient\">Editer profil</a></li>"; 
		echo "<li id=\"changerPass\"><a href=\"index.php?action=modifmdp\">Changer mot de passe</a></li>"; 
		  
		 echo "</ul>";        
		echo "</div></div></div>";         
		// ************************	  
		  
		  
		// *** Annonce ***    
		echo "<div class=\"portlet\">
		      <h5>Annonce</h5>
		      <div class=\"portletBody\">
		      <div class=\"portletContent\">
		      <ul class=\"portletMenu\">";			
		
		echo "<li id=\"demandeTransport\"><a href=\"index.php?action=demandetransport\"><strong>Demande de Transport</strong></a></li>";  
		 
		    echo "</ul>";        
		echo "</div></div></div>";         
		// ************************	 
		
		
		// *** Mes Demandes ***    
		echo "<div class=\"portlet\">
		      <h5>Mes demandes</h5>
		      <div class=\"portletBody\">
		      <div class=\"portletContent\">
		      <ul class=\"portletMenu\">";
		
		// - en attente de réponse
		echo "<li id=\"attenteReponse\"><a href=\"index.php?action=listing_newdemande\">Attente de réponse <span class=\"portletNumber\">";  
		echo " (".$nbdemandesAttenteReponseClient.")";           
		echo "</span></a></li>";
		   
		    // - répondues
		echo "<li id=\"demandeRepondue\"><a href=\"index.php?action=listing_newdemande_repondue\">Répondues <span class=\"portletNumber\">"; 
		echo " (".$nbdemandesRepondues.")";
		echo "</span></a></li>";
			
		// - validées	
		echo "<li id=\"demandeValide\"><a href=\"index.php?action=listing_valider_c\">Validées <span class=\"portletNumber\">";
		echo " (".$nbdemandesValidees.")";
		echo "</span></a></li>"; 
		
		echo "<hr />";
		
		// - supprimées
		echo "<li id=\"demandeSupprime\"><a href=\"index.php?action=listing_supprimer\">Supprimées <span class=\"portletNumber\">";
		echo " (".$nbannoncesSupprimeesClient.")";
		echo "</span></a></li>";
		 
		echo "</ul>";        
		echo "</div></div></div>";        
		// ************************	  
		
		
		// *** Liste des transporteurs ***    
		echo "<div class=\"portlet\">
		      <h5>Divers</h5>
		      <div class=\"portletBody\">
		      <div class=\"portletContent\">
		      <ul class=\"portletMenu\">";			
		
		echo "<li id=\"listeTransporteur\"><a href=\"index.php?action=listing_transporteur\">Liste des transporteurs</a></li>";  
		 
		echo "</ul>";        
		echo "</div></div></div>";         
		// ************************	 
	
	}
}
                             
//---- Si non loggé ----
else
{                  

   
   	// *** Identification ***    
	echo "<div class=\"portlet\">
	      <h5>Identification</h5>
	      <div class=\"portletBody\">
	      <div class=\"portletContent\">";
				  

	
	
	echo "<form id=\"loginform\" method=\"post\" action=\"?action=login\">
		<ul class=\"portletList\"><li class=\"standard\"> Votre login : </li></ul>
		<input type=\"text\" name=\"user\" value=\"$_COOKIE[login]\" /><br/>
		<ul class=\"portletList\"><li class=\"standard\"> Votre password : </li></ul>  
		<input class=\"form\" type=\"password\" name=\"password\" value=\"$_COOKIE[pass]\" /><br/>
		<input type=\"checkbox\" checked=\"checked\" name=\"save_me\"/><span id=\"memInCookies\">Mémoriser sur cet ordinateur (7 jours)</span>
		<ul class=\"portletMenu\">
		<li id=\"log\"><input class=\"form\" type=\"submit\" value='Valider' /></li> 

		</ul>


		<input type=\"hidden\" name=\"valide\" value=\"1\" />
		<input type=\"hidden\" name=\"marqueurPage\" value=\"\" />
		<input type=\"hidden\" name=\"marqueurTypeUser\" value=\"\" />
</form>";  
		     
	echo "<ul class=\"portletMenu\">";			
	echo "<li id=\"mdpPerdu\"><a href=\"index.php?action=perteidentifiant\">Mot de passe perdu?</a></li>";  
	echo "</ul>";   
	echo "</div></div></div>";         
	// ************************	
	
	
   	// *** Liste des transporteurs ***    
	echo "<div class=\"portlet\">
	      <h5>Inscription</h5>
	      <div class=\"portletBody\">
	      <div class=\"portletContent\">
	      <ul class=\"portletMenu\">";			
	
	echo "<li id=\"inscriptionClient\"><a href=\"index.php?action=inscriptionclient\">Inscription Voyageur</a></li>";  
	echo "<li id=\"inscriptionTransporteur\"> <a href=\"index.php?action=inscriptiontransport\">Inscription Autocariste</a></li>";  
	  
	echo "</ul>";        
	echo "</div></div></div>";         
	// ************************	 
                     
}                     
                                  
?>