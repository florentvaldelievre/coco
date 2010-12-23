<?php

if(defined("__CListingGestion"))
    return;

define("__CListingGestion","");

include_once("CListing.php");
include_once("CListingDAO.php");

/*
 * CListingGestion gere les manipulations et operations relatives à un listing.
 * Un listing est génaralement concue sur la base d'une demande de transport.
 */
class CListingGestion
{

/*
 * Un objet de gestion DAO
 * @var CListingDAO
 */
    var $listingDAO;
/*
 * Une ressource CMySQL
 * @var CMySQL
 */
    var $mysql_res="";

    function __construct($mysql_res)
    {
        $this->mysql_res = $mysql_res;
        $this->listingDAO = new CListingDAO($mysql_res);
    }
    
  
  function demandesAttenteReponseClient($idutilisateurclient, $resultLimiter = null,$between = "",$url_info) {
  	      
  	      
  	        $query = "SELECT *
                     FROM demandetr d
					 INNER JOIN contact c ON ( d.idutilisateur = c.idutilisateur ) 
                     WHERE c.idutilisateur = $idutilisateurclient AND dtag = 'newdemande' ";
                     
                     
		     if (!empty($between))
					{		  
					   foreach($between as $key => $value) {
							$filtreswhere .= " AND ".$key." $value ";
							$query .= $filtreswhere;

						}
					}
					$query .= " AND d.datedepart >= CURDATE() "; //on ne veux pas d'annonce périmées 	
							
					$query .= "GROUP BY iddemandetr";
					if($url_info->getOrderByElement())
					{
						$query .= " ORDER BY ".$url_info->getOrderByElement();
						
	
						if($url_info->getOrderAscendingElement()=="true")
							$query .= " ASC";
						else
							$query .= " DESC";
					}
		

		$res = $this->listingDAO->getByCustomQuery($query, $resultLimiter); 


	return $res;     
  }
  
  
  
    
/*
 * revoie la liste des demandes validés pour un utilisateur client
 * @param: int $idutilisateurclient l idutilisateur d'un client
 * @param: optionnel
 * @return objetbdd[] la liste des demandes validées.
 */   
    function demandeValideesClient($idutilisateurclient,$iddemandetr="", $resultLimiter = null,$between = "",$url_info)
    {
  		/* TODO
  		 * Il fodrait simplifier la requette car problème avec les orders
  		 */
  		
  		
  		$query=
			"SELECT tab1.*, tab2.*, idutilisateurtransporteur, nomclient AS nomutilisateur, idquotation
			FROM (
				
				(
				SELECT idtransport, c1.idutilisateur AS idutilisateurclient, d1.*
				FROM transport t1
				INNER JOIN demandetr d1 ON t1.iddemandetr = d1.iddemandetr
				INNER JOIN contact c1 ON d1.idcontact = c1.idcontact
				)tab1
			
				INNER JOIN (
				
				SELECT idtransport , u1.typeutilisateur, c2.telephone, c2.portable, c2.fax, c2.mail, c2.idutilisateur AS idutilisateurtransporteur, nomclient, r1.tarifttc, f.cancelled, f.paye
				FROM transport t2
				INNER JOIN reponsetr r1 ON t2.idreponsetr = r1.idreponsetr
				INNER JOIN factures f ON f.idreponsetr = r1.idreponsetr
				INNER JOIN contact c2 ON r1.idcontact = c2.idcontact
				INNER JOIN utilisateur u1 ON c2.idutilisateur = u1.idutilisateur
				)tab2 ON (tab1.idtransport = tab2.idtransport)
			)
			
			LEFT OUTER JOIN
			
				quotation ON ( tab1.idtransport = quotation.idtransport
				AND tab2.idutilisateurtransporteur = quotation.idutilisateur2 )";
				

		$query.= " WHERE idutilisateurclient = ".$idutilisateurclient;
		
		if(!empty($iddemandetr)) 
			$query .= " AND tab1.iddemandetr = $iddemandetr ";
					


	     if (!empty($between))
				{		  
				   foreach($between as $key => $value) {
						$filtreswhere .= " AND ".$key." $value ";
						$query .= $filtreswhere;

					}
				}
				
				
				if($url_info->getOrderByElement())
				{
					$query .= " ORDER BY ".$url_info->getOrderByElement();
					

					if($url_info->getOrderAscendingElement()=="true")
						$query .= " ASC";
					else
						$query .= " DESC";
				}

		
		$res = $this->listingDAO->getByCustomQuery($query, $resultLimiter); 	
	
		return $res;
 			
 			
    }
  
  
/*
 * revoie la liste des demandes validés pour un utilisateur transporteur
 * @param: int $idutilisateurclient l idutilisateur d'un transporteur
 * @return objetbdd[] la liste des demandes validées.
 */    
    function demandeValideesTransporteur($idutilisateurtransporteur,$iddemandetr="", $resultLimiter = null,$between = "",$url_info)
    {
  		/*
  		 * TODO rajouter DISTINCT pour être sur de ne pas avoir deux fois les idreponsetr à l'affichage ( si le trigger déconne)
  		 * + simplifié la requete car pb avec certain order ( prix par exemple )
  		 */
  		
  		$query=
			"SELECT tab1.*, tab2.*, idutilisateurclient, nomclient AS nomutilisateur, idquotation
			FROM (
				
				(
				SELECT idtransport, c1.mail AS mailclient, c1.telephone AS telclient, c1.portable AS portableclient, c1.fax AS faxclient, c1.idutilisateur AS idutilisateurclient, nomclient, d1.* 
				FROM transport t1
				INNER JOIN demandetr d1 ON t1.iddemandetr = d1.iddemandetr
				INNER JOIN contact c1 ON d1.idcontact = c1.idcontact
				INNER JOIN utilisateur u1 ON c1.idutilisateur = u1.idutilisateur
				)tab1
			
				INNER JOIN (
				
				SELECT idtransport, c2.telephone, c2.portable, c2.fax, c2.mail, c2.idutilisateur AS idutilisateurtransporteur, r1.tarifttc, f.prixfacture, f.paye, f.date, f.cancelled
				FROM transport t2
				INNER JOIN reponsetr r1 ON t2.idreponsetr = r1.idreponsetr
				INNER JOIN factures f ON f.idreponsetr = r1.idreponsetr
				INNER JOIN contact c2 ON r1.idcontact = c2.idcontact
				)tab2 ON (tab1.idtransport = tab2.idtransport)
			)
			
			LEFT OUTER JOIN
			
				quotation ON ( tab1.idtransport = quotation.idtransport
				AND tab1.idutilisateurclient = quotation.idutilisateur2 )";

		$query.= " WHERE idutilisateurtransporteur = ".$idutilisateurtransporteur;
	
		if(!empty($iddemandetr)) 
			$query .= " AND tab1.iddemandetr = $iddemandetr ";


				

	     if (!empty($between))
				{		  
				   foreach($between as $key => $value) {
						$filtreswhere .= " AND ".$key." $value ";
						$query .= $filtreswhere;

					}
				}
				
			if($url_info->getOrderByElement())
			{
				$query .= " ORDER BY ".$tabname ."".$url_info->getOrderByElement();
				

				if($url_info->getOrderAscendingElement()=="true")
					$query .= " ASC";
				else
					$query .= " DESC";
			}


		$res = $this->listingDAO->getByCustomQuery($query, $resultLimiter); 	


		return $res;
    }

    
/*
 * revoie la liste des demandes que peu consulter un transporteur
 * @return objetbdd[] la liste des demandes à consulter
 */      
    function consulterAnnonces( $dpts = "", $resultLimiter = null,$between = "",$url_info)
    {	
    	
    	
    	$query = 
			"SELECT DISTINCT d.*, MIN(tarifttc) as prixmin, r.idcontact AS ridcontact
			 FROM demandetr d 
			 LEFT OUTER JOIN reponsetr r ON ( d.iddemandetr = r.iddemandetr ) 
			 WHERE (
			 dtag = 'newdemande'
			 OR dtag = 'newdemande_repondue'
			 OR dtag = 'attente_reponse_tr'
			 ) ";
			 
		$query .= " AND d.datedepart >= CURDATE() "; //on ne veux pas d'annonce périmées 
		

		
			if (!empty($dpts))
			{
				 	$dptlist = implode(',',$dpts);
				 	$dptwhere = "AND ( SUBSTRING( d.cpdepart, 1, 2 ) IN ( $dptlist ) OR SUBSTRING( d.cparrive, 1, 2 )  IN ( $dptlist ) ) ";
					$query .= $dptwhere;

			
			}		
			
			if (!empty($between))
			{		  
			   foreach($between as $key => $value) {
					$filtreswhere = " AND ".$key." $value ";
					$query .= $filtreswhere;

				}
			}
		
			$query .= "GROUP BY iddemandetr";
			
				
			if($url_info->getOrderByElement())
			{
				$query .= " ORDER BY ".$url_info->getOrderByElement();
				

				if($url_info->getOrderAscendingElement()=="true")
					$query .= " ASC";
				else
					$query .= " DESC";
			}

			
			$res = $this->listingDAO->getByCustomQuery($query, $resultLimiter); 	


 			return $res;		 		
    }


	function consulterAnnoncesDailyAds($day) {
		
	    	$query = 
			"SELECT DISTINCT d.*, MIN(tarifttc) as prixmin, r.idcontact AS ridcontact FROM demandetr d 
			LEFT OUTER JOIN reponsetr r ON ( d.iddemandetr = r.iddemandetr ) 
			WHERE ( dtag = 'newdemande' OR dtag = 'newdemande_repondue' OR dtag = 'attente_reponse_tr' ) 
			AND 
			d.datedepart >= CURDATE() 
			AND d.date > DATE_SUB(CURDATE(), INTERVAL $day DAY)

 			Group by iddemandetr";
		
			$res = $this->listingDAO->getByCustomQuery($query); 	
 			return $res;	
		
		
	}


/**
 * revoie la liste des demandes ciblé pour le transporteur
 * @return objetbdd[] la liste des demandes à consulter
 */      
    function consulterAnnoncesCible( $idutilisateur )
    {
    	$query = 
			"SELECT dtr. * , MIN( tarifttc ) AS prixmin, NULL AS repondue
			FROM demandetr dtr
			LEFT OUTER JOIN reponsetr r ON ( dtr.iddemandetr = r.iddemandetr )
			JOIN departement d ON ( SUBSTRING( dtr.cpdepart, 1, 2 ) = d.numdepartement )
			JOIN transporteurdpt td ON ( d.iddepartement = td.iddepartement )
			WHERE (
			dtag = 'newdemande'
			OR dtag = 'newdemande_repondue'
			)
			AND idtransporteur = (
			SELECT t.idtransporteur
			FROM transporteur t
			JOIN utilisateur u ON ( t.idutilisateur = u.idutilisateur )
			WHERE u.idutilisateur = $idutilisateur)
			GROUP BY iddemandetr";
			

			$res = $this->listingDAO->getByCustomQuery($query); 	
 			return $res;		 		
    }

	    
		 /**
		 * revoie la liste des demandes en attente de confirmation pour le transporteur passé en parametre
		 * @return objetbdd[] la liste des demandes retournée
		 */  
	    function annoncesAttenteConfirmation( $idutilisateur, $resultLimiter = null,$between = "",$url_info)
	    {
		    	       
	        /*
	         * TODO tjs le pb avec nbrres
	         */

	        
	        $query = "SELECT *
					FROM reponsetr r
					NATURAL JOIN contact 
					INNER JOIN demandetr d ON (d.iddemandetr = r.iddemandetr) 
					WHERE contact.idutilisateur = ".$idutilisateur." 
					AND dtag = 'newdemande_repondue' AND TIMESTAMPADD(SQL_TSI_DAY,".EXPIRATION_DATE.",datereponse) > CURDATE() ";

	
				if (!empty($between))
						{		  
						   foreach($between as $key => $value) {
								$filtreswhere .= " AND ".$key." $value ";
								$query .= $filtreswhere;
			
							}
						}

				
			if($url_info->getOrderByElement())
			{
				$query .= " ORDER BY d.".$url_info->getOrderByElement();
				

				if($url_info->getOrderAscendingElement()=="true")
					$query .= " ASC";
				else
					$query .= " DESC";
			}


			$res = $this->listingDAO->getByCustomQuery($query, $resultLimiter); 	

		return $res;
	}

		function annoncesRefusees( $idutilisateur, $resultLimiter = null,$between = "",$url_info)
		{
		/*
		 * TODO : pb ac nbrres
		 */
		
			$query = "SELECT * 
					FROM reponsetr r
					JOIN demandetr d ON (d.iddemandetr = r.iddemandetr) 
					JOIN contact ON r.idcontact = contact.idcontact
					WHERE contact.idutilisateur = $idutilisateur								
					AND rtag = 'refuser'";

	
	if (!empty($between))
			{		  
			   foreach($between as $key => $value) {
					$filtreswhere .= " AND ".$key." $value ";
					$query .= $filtreswhere;

				}
			}

			if($url_info->getOrderByElement())
			{
				$query .= " ORDER BY d.".$url_info->getOrderByElement();
				

				if($url_info->getOrderAscendingElement()=="true")
					$query .= " ASC";
				else
					$query .= " DESC";
			}
	

				
			$res = $this->listingDAO->getByCustomQuery($query, $resultLimiter); 	
   						
	   return $res;				
	}
	
	
	function annoncesExpirees( $idutilisateur, $resultLimiter = null,$between = "",$url_info) {
		


	        
	        $query = "SELECT *
					FROM reponsetr r
					NATURAL JOIN contact 
					INNER JOIN demandetr d ON (d.iddemandetr = r.iddemandetr) 
					WHERE contact.idutilisateur = ".$idutilisateur." 
					AND dtag = 'newdemande_repondue' AND TIMESTAMPADD(SQL_TSI_DAY,".EXPIRATION_DATE.",datereponse) < CURDATE() ";
							

	
	if (!empty($between))
			{		  
			   foreach($between as $key => $value) {
					$filtreswhere .= " AND ".$key." $value ";
					$query .= $filtreswhere;

				}
			}

				
			if($url_info->getOrderByElement())
			{
				$query .= " ORDER BY d.".$url_info->getOrderByElement();
				

				if($url_info->getOrderAscendingElement()=="true")
					$query .= " ASC";
				else
					$query .= " DESC";
			}


			$res = $this->listingDAO->getByCustomQuery($query, $resultLimiter); 	

	return $res;
	
	 }

	
		
		function demandesRepondues ($idutilisateur, $resultLimiter = null,$between = "",$url_info)
		{
			$query = "SELECT *
                     FROM demandetr d
					 NATURAL JOIN contact
                     WHERE contact.idutilisateur = ".$idutilisateur."
       				 AND dtag = 'newdemande_repondue' "; 

			
			if (!empty($between))
			{		  
			   foreach($between as $key => $value) {
					$filtreswhere .= " AND ".$key." $value ";
					$query .= $filtreswhere;
				}
			}
			
			if($url_info->getOrderByElement())
			{
				$query .= " ORDER BY ".$url_info->getOrderByElement();
				

				if($url_info->getOrderAscendingElement()=="true")
					$query .= " ASC";
				else
					$query .= " DESC";
			}

			$res = $this->listingDAO->getByCustomQuery($query, $resultLimiter); 	
		
		return $res;				
	}
			
		function annoncesSupprimeesClient($idutilisateur, $resultLimiter = null,$between = "",$url_info)
		{
			 $query = "SELECT *
		         FROM demandetr
		         NATURAL JOIN contact
		         WHERE contact.idutilisateur = ".$idutilisateur."
		         AND dtag = 'supprimer'";
		         
   
		
			if (!empty($between))
					{		  
					   foreach($between as $key => $value) {
							$filtreswhere .= " AND ".$key." $value ";
							$query .= $filtreswhere;

						}
					}
					
			if($url_info->getOrderByElement())
			{
				$query .= " ORDER BY ".$url_info->getOrderByElement();
				

				if($url_info->getOrderAscendingElement()=="true")
					$query .= " ASC";
				else
					$query .= " DESC";
			}
  
		    $res = $this->listingDAO->getByCustomQuery($query, $resultLimiter); 	

   						
        	return $res;	    
		}
		
		
		function annoncesSupprimeesTransporteur($idutilisateur, $resultLimiter = null)
		{
		    
		}
	
	
	
	function getAllTransporteurMailWithReceiveAdsTag() {
		
		
		$query = "SELECT * from transporteur t
					  INNER JOIN contact c ON (t.idutilisateur = c.idutilisateur ) 
					  WHERE t.receiveAds = 1";
		$res = $this->listingDAO->getByCustomQuery($query);
		return $res;			  	
		
		
	}
	
//                          __   _   _ 
//  _ __    _ __    ___    / _| (_) | |
// | '_ \  | '__|  / _ \  | |_  | | | |
// | |_) | | |    | (_) | |  _| | | | |
// | .__/  |_|     \___/  |_|   |_| |_|
// |_|                                 
//		
		
		
		function getCommentairesClientOrTransporteur($idutilisateur, $resultLimiter = null,$url_info) {
			
		
			$query_commentaire = "SELECT * FROM quotation q
			   INNER JOIN utilisateur u ON ( q.idutilisateur1 = u.idutilisateur )
				WHERE q.idutilisateur2 = $idutilisateur";
				
			if($url_info->getOrderByElement())
			{
				$query_commentaire .= " ORDER BY ".$url_info->getOrderByElement();
				

				if($url_info->getOrderAscendingElement()=="true")
					$query_commentaire .= " ASC";
				else
					$query_commentaire .= " DESC";
			}
				
			$res = $this->listingDAO->getByCustomQuery($query_commentaire, $resultLimiter); 


			if($res)
				return $res;
			else
			 	return null;
			
			
		}
		
	
	
	function getAverageRatingById($idutilisateur) {
		
		$query ="SELECT avg(note) AS moyenne 
					FROM quotation q 
					INNER JOIN utilisateur u ON ( q.idutilisateur2 = u.idutilisateur ) 
				    WHERE u.idutilisateur = $idutilisateur";
		
		$res = $this->listingDAO->getByCustomQuery($query); 
		
		return $res[0]->get("moyenne");
	
	}	
	
	
	function getNumberOfValidateAds($idutilisateur) {
		
		$ugestion = new CUtilisateurGestion();
		if($ugestion->getTypeUtilisateurById($idutilisateur)=="transporteur") {
			
			$query ="SELECT count(*) AS count_valide
								FROM transport t
								JOIN reponsetr r ON ( t.idreponsetr = r.idreponsetr ) 
								JOIN contact c ON ( r.idcontact = c.idcontact )
								WHERE c.idcontact = $idutilisateur";

		}	
		else
		{
		$query ="
					SELECT count(*) AS count_valide
					FROM demandetr
					NATURAL JOIN contact
					WHERE contact.idutilisateur = $idutilisateur AND dtag = 'valider'";

		}
		

		$res = $this->listingDAO->getByCustomQuery($query); 

		return $res[0]->get("count_valide");
	
	}		
		
	function getNumberOfAdsInQueue($idutilisateur) { //demannde en attente
		
		$ugestion = new CUtilisateurGestion();
		if($ugestion->getTypeUtilisateurById($idutilisateur)=="transporteur") {
		
			$query ="SELECT count(*) as nbr_demande_attente
					FROM reponsetr 
					NATURAL JOIN contact 
					INNER JOIN demandetr ON (demandetr.iddemandetr = reponsetr.iddemandetr) 
					WHERE contact.idutilisateur = $idutilisateur AND dtag = 'newdemande_repondue'";
				
		}
		else {
			
			$query ="SELECT count(*)  as nbr_demande_attente
					FROM demandetr
					NATURAL JOIN contact
					WHERE contact.idutilisateur = $idutilisateur AND dtag = 'newdemande'";

		}

		$res = $this->listingDAO->getByCustomQuery($query); 
		return $res[0]->get("nbr_demande_attente");;
		
	}	
	
	
	function topNumberOfTransporteurReply($limit = "") {
	
	$query ="	SELECT r.idutilisateur,nomclient,count(nomclient) as nbrReponse FROM reponsetr r
			    INNER JOIN utilisateur u ON (r.idutilisateur = u.idutilisateur )
				group by nomclient
				ORDER BY nbrReponse 
				DESC ";
				if(!empty($limit))
	$query .=		"LIMIT $limit";
	

				

	$res = $this->listingDAO->getByCustomQuery($query); 			
	return $res;			
	}
		
		
	function getNumberOfCancelledAds($idutilisateur) {
				
				$query ="select count(*)  as nb_demande_abandonne from factures f
				INNER JOIN reponsetr r on ( f.idreponsetr = r.idreponsetr )
				INNER JOIN demandetr d on ( r.iddemandetr = d.iddemandetr )
				WHERE ( d.idutilisateur = $idutilisateur AND r.rtag = 'valider' AND f.cancelled=\"1\")";

		$res = $this->listingDAO->getByCustomQuery($query); 

		return $res[0]->get("nb_demande_abandonne");;
	}
		
		
		
		
	function getValidatedAdsWithLimitDate($idutilisateurtransporteur) {
		
		
		$query=
			"SELECT tab1.*, tab2.*, idutilisateurclient, nomclient AS nomutilisateur
			FROM (
				
				(
				SELECT idtransport, c1.idutilisateur AS idutilisateurclient, nomclient ,  TIMESTAMPADD(SQL_TSI_MONTH,1,d1.datearrive)  as datelimite  , d1.*
				FROM transport t1
				INNER JOIN demandetr d1 ON t1.iddemandetr = d1.iddemandetr
				INNER JOIN contact c1 ON d1.idcontact = c1.idcontact
				INNER JOIN utilisateur u1 ON c1.idutilisateur = u1.idutilisateur
				)tab1
			
				INNER JOIN (
				
				SELECT idtransport,  c2.idutilisateur AS idutilisateurtransporteur, r1.tarifttc, f.prixfacture, f.paye ,  f.cancelled
				FROM transport t2
				INNER JOIN reponsetr r1 ON t2.idreponsetr = r1.idreponsetr
				INNER JOIN factures f ON f.idreponsetr = r1.idreponsetr
				INNER JOIN contact c2 ON r1.idcontact = c2.idcontact
				)tab2 ON (tab1.idtransport = tab2.idtransport)
			)
			
			LEFT OUTER JOIN
			
				quotation ON ( tab1.idtransport = quotation.idtransport
				AND tab1.idutilisateurclient = quotation.idutilisateur2 )";

		$query.= " WHERE ( idutilisateurtransporteur = ".$idutilisateurtransporteur ." AND paye = 0 AND cancelled = 0 )";
		
	



		//	echo "<br />".$query."<br />";		
		//	echo "<br />".$countQuery."<br />";
		$res = $this->listingDAO->getByCustomQuery($query); 	


		return $res;
			
	}
}

?>