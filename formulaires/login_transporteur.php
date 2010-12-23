  <?
    include_once('include/include_listing.php');
    
    $demandeValidéesNonPayées = $listingGestion->getValidatedAdsWithLimitDate($_SESSION['idutilisateur']);
   	$nbDemandeValidéesNonPayées = count($demandeValidéesNonPayées);
   	
   	
?>


	<div class="accueil">

	<h2>Bienvenu(e) <?echo $_SESSION['prenom'];?></h2>	
			<div class="bloc1">

				<div class="imgBloc1Information"></div>
				<p>Si vous n'êtes pas <?echo $_SESSION['prenom'];?>, <a href="?action=destroy">Cliquez ici</a></p>
			
			 		    <p>Bienvenu(e) sur Waybus
			 		    <br />
			 		    Répondez aux demandes en <strong><a href="index.php?action=consulterannonce">Consultant les annonces</a></strong>
			  			</p>
			  			<br/>
			  			<?
			  			if($nbDemandeValidéesNonPayées > 0)
						{

							echo          "<table class=\"tablist\" cellspacing=\"0\">
												<thead>
														 <tr>
																<th>".CFilterOrderBy::displayOrderBy($url,"iddemandetr","Ref.Transp")."</th>
																<th>Prix à payer</th>
																<th>A payer avant le </th>
																<th>Action</th>
														   </tr>
												</thead>";
											foreach($demandeValidéesNonPayées as $demandeValideNonPaye)
												 {
													 echo"<tr>
																<td>".$demandeValideNonPaye->get("typetransport")." n°".$demandeValideNonPaye->get("iddemandetr")."</td>
																<td><strong>+".$demandeValideNonPaye->get("prixfacture")."€</strong></td>
																<td>".formatDateUsToFr($demandeValideNonPaye->get("datelimite"))."</td>
																<td><a href=\"index.php?action=paypal_init&idtr=".$demandeValideNonPaye->get("iddemandetr")." \"><img src=\"images/style1/money.gif\" title=\"Payer par Paypal (sécurisé)\" alt=\"Payer par Paypal (sécurisé)\" ></a></td>
															</tr>";
															
												}
							echo "</table>";
			  			 
						}
			  			?>
			  			
			  			
			  			<p>
						<ul>
							<li><strong>Editer profil</strong> permet de modifier diverses informations vous concernant<br/>
							Vos modifications sont immédiatements prises en compte.
							</li>
						
						<br/>
						<li><strong>Changer mot de passe</strong> permet de changer votre mot de passe de connexion
						</li>
						
						<br/>
						<li><strong>Voir ses factures</strong> permet de... pas fini TODO
						</li>					
					
						<br/>
						<li><strong>Consulter les annonces</strong> permet de lister les demandes des voyageurs
						</li>						

						<br/>
						<li><strong>En attente de confirmation</strong> permet de lister vos annonces en attente de confirmation par le voyageur. 
									Vous pouvez modifier votre prix à tout moment, le voyageur en sera notifié.
						</li>		
						
						<br/>
						<li><strong>Validées</strong> permet de lister vos demandes validées par le voyageur <br /> 
						Une demande est validée à partir du moment ou le voyageur a accepté votre proposition.
						</li>	

						<br/>
						<li><strong>Refusées</strong> permet de lister vos demandes Refusées <br /> 
						Une demande est refusée lorsqu'un voyageur a choisit un autre autocariste que vous.
						<br />

						</li>	
																								
						</ul>
						</p>

	  	</div>
	  	
	 </div>


