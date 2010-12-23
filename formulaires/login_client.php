

	<div class="accueil">

			<h2>Bienvenu(e) <?echo $_SESSION['prenom'];?></h2>	
			<div class="bloc1">

				<div class="imgBloc1Information"></div>
				<p>Si vous n'êtes pas <?echo $_SESSION['prenom'];?>, <a href="?action=destroy">Cliquez ici</a></p>

			
			 		    <p>Bienvenu(e) sur Waybus
			 		    <br />
			 		    Si vous cherchez un bus, faites une <strong><a href="index.php?action=demandetransport">demande de transport</a></strong>
			  			</p>
			  			<br/>
			  			
			  			<p>
						<ul>
							<li><strong>Editer profil</strong> permet de modifier diverses informations vous concernant<br/>
							Vos modifications sont immédiatements prises en compte.
							</li>
						
						<br/>
						<li><strong>Changer mot de passe</strong> permet de changer votre mot de passe de connexion
						</li>
						
						<br/>
						<li><strong>Attente de réponse</strong> permet de lister vos demandes. Vous pouvez modifier votre demande à tout moment. Vous pouvez également la supprimer à l'aide de l'icone <img width="20" height="20" title="Supprimer transfert n°4 " src="images/delete.gif"/>
						</li>						

						<br/>
						<li><strong>Répondues</strong> permet de lister vos demandes répondues par les transporteurs. <br /> 
						Plusieurs transporteurs peuvent répondre à votre annonce. Vous avez juste à choisir celui qui vous convient le mieux.
						</li>		
						
						<br/>
						<li><strong>Validées</strong> permet de lister vos demandes validées <br /> 
						Une demande est validée à partir du moment vous l'avez accepter dans le menu Répondues
						</li>	

						<br/>
						<li><strong>Supprimées</strong> permet de lister vos demandes supprimées <br /> 
						Une demande est supprimée lorsque vous l'avez supprimée dans le menu En attente de réponse.
						<br />

						</li>	
																								
						</ul>
						</p>

	  	</div>
	  	
	 </div>