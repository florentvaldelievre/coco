<?php

    include_once("libs/CListingGestion.php");		
		
		$listingGestion = new CListingGestion($GLOBALS['mysql']);
		$transporteurs = $listingGestion->topNumberOfTransporteurReply(5);
		
?>


	<div class="accueil">

    <div id="consulterannonces"><a href="index.php?action=consulterannonce">Consulter les annonces</a></div>
 
			<h2>Vous désirez louer un autocar</h2>	
			<div class="bloc1">

				<div class="imgBloc1Client"></div>
						<ul> 
							 <li>Vous avez besoin d'un car pour organiser un voyage ?</li>
				 			 <li>Votre entreprise a besoin de moyens de transports pour organiser un séminaire ?</li>
				 			 <li>Vous êtes un groupe d'etudiants et cherchez un bus peu coûteux pour votre week-end d'intégration?</li>
				  		</ul>  

			
			 		    <p>Waybus propose un service qui satisfera vos attentes. 
			 		    <br />
			 		    Poster <strong>gratuitement</strong> une demande et attendez les reponses de nombreux transporteurs inscrits sur notre site. 
			 			 
			  			</p>
			  			<p>
						  Faites baisser les prix en faisant jouer la concurrence et profiter des prix les moins cher du marché
			  			</p>
				<ul>			  	
				  	<li class="arrowHomeLink">
			  		<a href="?action=demandetransport">Poster votre demande</a>
			   		</li>
			   	</ul>
	  	</div>
		
	
	
	
	
			<h2>Vous êtes transporteur / autocariste</h2>
			<div class="bloc1">		
				<div class="imgBloc1Transporteur"></div>	
					<ul> 
						<li>Vous désirez étendre votre clientèle tout au long de l'année?</li>
					 	<li>Vous souhaitez pouvoir acceder à notre banque d'annonces mise à jour en temps réel?</li>
					 	<li>Vous voulez une meilleure visibilité de votre entreprise et augmenter votre popularité?</li>
						</ul> 
					<br />
				 	 <p>			 
		 		   	 Consulter <strong> gratuitement </strong>les annonces des voyageurs 
		  			</p>
			  				<p>
 							 Repondez en quelques clics et rentrez directement en relation avec les voyageurs
				  			</p>

				<ul>
				  	<li class="arrowHomeLink">
				  		<a href="?action=consulterannonce">Consulter les annonces</a>
				   </li>
				</ul>

		</div>
			<br />
			<h3>Informations complémentaires -  Statistiques</h3>
			<div class="bloc1">		
						<div id="accueilFooter">
								Top 5 Réponses transporteurs:
					<?	
								if(count($transporteurs) > 0)
								{
								foreach($transporteurs as  $transporteur) {								
										 echo 	"<a href=\"?action=profil&amp;id=".$transporteur->get("idutilisateur")."\">".$transporteur->get("nomclient")."(".$transporteur->get("nbrReponse")."), </a>";
									}	
								}	
					?>
					&nbsp;<strong><a href="?action=listing_transporteurs"> Plus »</a></strong>
						</div>
			</div>

	</div>
	