<?php
include_once("libs/util.php");

class CContenuMail {
	
	
	
	public static function ContenuMailValidationAnnonce($info_client,$info_transporteur,$etapes,$type_user) {


				
			
					if($type_user=="transporteur")
					{
						$contenu.="<div>UN CLIENT A REPONDU A VOTRE ANNONCE ! </div>";
						$contenu.="Cher(ère) Transporteur<br />";
						$contenu.="Un client a accepté votre annonce au tarif de <strong>".$info_transporteur->get("tarifttc")."€</strong><br />";
					}
					
					else
					{				
						$contenu.="<div>VOUS AVEZ ACCEPTE L'OFFRE DU TRANSPORTEUR</div>";
						$contenu.="Cher(ére) Client<br />";
						$contenu.="Vous avez accepté l'annonce du transporteur au tarif de <strong> ".$info_transporteur->get("tarifttc")."€</strong><br />";
					}


					
					$contenu.="Ce mail a pour but de vous mettre en relation afin que vous puissiez prendre contact<br />";
					      
				   	if($type_user=="transporteur")
						$contenu.="Récapitulatif de la demande du client : <br /><br />";
					else
						$contenu.="Récapitulatif de votre demande : <br /><br />";
					
					
					$contenu.="Type de transport : ".$info_client->get("typetransport")."<br />";

					$contenu .= self::getItineraire($etapes);
					$contenu .= "<br />";
	            	$contenu .= self::getDateVoyage($info_client);
					$contenu .= self::getInfoAnnonceVoyageurMail($info_client);
										
				    if($type_user=="transporteur")
				    {
						$contenu .= "<br /><div><strong>Coordonnées du client :</strong></div>";
				    	$contenu.= self::getCoordonnees($info_client);
				    }
				    else
					{
						$contenu .= "<br /><div><strong>Coordonnées du transporteur :</strong></div>";
						$contenu.= self::getCoordonnees($info_transporteur);
					}
					
					$contenu.= "<div>Vous pouvez dés à présent prendre contact avec lui afin de confirmer ses informations.</div>
						      	Bon voyage,<br /><br />
						     	 L'Equipe Waybus<br /> ";
					

			return $contenu;		
				
					
						}
						
						
		
	public static function ContenuMailReponseTransporteur($info_client,$info_transporteur,$etapes) {
		



		$contenu = "<div>UN TRANSPORTEUR A REPONDU A VOTRE ANNONCE !</div>
					Cher(ère) Client, <br />
				    Un transporteur a répondu à votre annonce n°". $info_transporteur->get("iddemandetr") ." au tarif de  <strong> ".$info_transporteur->get("tarifttc") ."€</strong><br />

				
Type de transport : ". $info_client->get("typetransport") ."<br />";
					$contenu .= self::getItineraire($etapes);
					$contenu .= "<br />";
					$contenu .= self::getDateVoyage($info_client);
					$contenu .= self::getInfoAnnonceVoyageurMail($info_client);
					$contenu .= "<br />";					
					$contenu .= "<div>Réponse du transporteur :</div>";
					$contenu .= self::getInfoAnnonceTransporteur($info_transporteur); 
					$contenu .= "<br />";
					$contenu .= "Votre compte a été mis à jour, aller vérifier sur : http://zaibe.ath.cx/chartercar/<br /><br />
						     	 L'Equipe Waybus<br />";

		return $contenu;
		
		
	}				
						
						
	public static function ContenuMailModificationAnnonceTransporteur($info_transporteur) {
		
		$contenu ="UN TRANSPORTEUR A MODIFIE SON ANNONCE! <br /> Voici sa nouvelle annonce <br />";	     
		$contenu .= self::getInfoAnnonceTransporteur($info_transporteur);

return $contenu;
		
	}
	
	public static function ContenuMailRefusAnnonceTransporteur($info_client) {
	$contenu= "Nous avons le regret de vous informer que le client n'a pu faire suite à votre réponse concernant la demande de transport n°".$info_client->get("iddemandetr")."<br />
			   Soit votre réponse a expirée (48h sans validation de la part du client). <br />
			   Soit il a choisi un autre transporteur et donc mis fin à votre réponse. <br />
			   Bonne journée<br /><br />
			   L'Equipe Waydev";
					
		return $contenu;

			}
	


public static function getInfoAnnonceVoyageurMail($info_client) {
	
		  $contenu.=" Kilométrage : ".$info_client->get("kilometragealler")." Km<br />
					  Type car :".$info_client->get("typecar")."<br />
					  Capacité nécessaire : ".$info_client->get("capacitenecessaire")."<br />
					  Nombre de Bus : "; if($info_client->get("nbrbus")=="") $contenu .= "N/C"; else $contenu.= $info_client->get("nbrbus"); $contenu .="<br />";
		$contenu .="  Places par bus : "; if($info_client->get("placesparbus")=="") $contenu .= "N/C"; else $contenu.= $info_client->get("placesparbus"); $contenu .="<br />";

		$contenu .="  
					  Informations complémentaires : ".$info_client->get("dcommentaires")."<br />
					  Ancien tarif  : <strong>".$info_client->get("tarifadopte")."€</strong><br />";
	
		return $contenu;
}


public static function getInfoAnnonceTransporteur($info_transporteur) {
	

	
		$contenu.="
					Nombre de bus : ". $info_transporteur->get("nbrcar") ."<br />
					Places par bus :  ". $info_transporteur->get("capacitecar") ."<br />
				    Equipement(s) particulier(s) :  ". $info_transporteur->get("equipement") ."<br />
					Informations complémentaires :  ". $info_transporteur->get("rcommentaires") ."<br />
					Tarif du transporteur : <strong> ". $info_transporteur->get("tarifttc") ."€</strong>";
		
		return $contenu;
	
}
	
public static function getCoordonnees($info)	{
	
	$contenu.="		
				Nom : ".$info->get("nomclient")."<br />
				Mail : ".$info->get("mail")."<br />
				Téléphone fixe : ".$info->get("telephone")."<br />
				Téléphone portable : ".$info->get("portable")."<br />
				Fax : ".$info->get("fax")."<br />";
	
	return $contenu;
	
}


public static function getItineraire($etapes) {
		
		$contenu.="Etapes :  ";
		foreach($etapes as $etape) $contenu.=$etape."&nbsp;";
	
	return $contenu;
}
	
	
public static function getDateVoyage($info_client) {
	


	$contenu.="Date de départ aller : ".formatDateUsToFR($info_client->get("datedepart"))." à ".$info_client->get("heuredepart")."<br />
		      Date d'arrivée aller : ".formatDateUsToFR($info_client->get("datearrive"))." à ".$info_client->get("heurearrive")."<br />";
   
	 if($info_client->get("aller_retour"))
	 {
		$contenu .= "Date de départ retour : ".formatDateUsToFR($info_client->get("datedepartR"))." à ".$info_client->get("heuredepartR")."<br />
		 Date d'arrivée retour : ".formatDateUsToFR($info_client->get("datearriveR"))." à ".$info_client->get("heurearriveR")."<br />";
	 }
	
	return $contenu;
}
	
}
						



			
						
?>
