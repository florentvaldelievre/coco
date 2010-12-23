<?php

if(defined("__CQuotationGestion"))
    return;

define("__CQuotationGestion","");

include_once("CQuotation.php");
include_once("CQuotationDAO.php");


/*
 * CQuotationGestion gere les manipulations et operations relatives à une quotation.
 */
class CQuotationGestion
{
/*
 * Un objet de gestion DAO
 * @var CQuotationDAO
 */
    var $quotationDAO;
/*
 * Une ressource CMySQL
 * @var CMySQL
 */   
    var $mysql_res="";

    function __construct($mysql_res)
    {
        $this->mysql_res = $mysql_res;
        $this->quotationDAO = new CQuotationDAO($mysql_res);
    }
  
/*
 * insere une nouvelle quotation dans la bdd
 * @param: mixed var les informations relatives a une quotation
 */ 
    function nouvelleQuotation($idtransport,$idutilisateur1,$idutilisateur2,$note,$commentaire)
    {
  		$infos=array();
  		$infos['idtransport']=$idtransport;
  		$infos['idutilisateur1']=$idutilisateur1;
  		$infos['idutilisateur2']=$idutilisateur2;
  		$infos['note']=$note;
  		$infos['date']=date('Y/m/j H:i:S');
  		$infos['commentaire']=$commentaire;
  		
     	$quotation = new CQuotation();
     	$quotation->set($infos);

     	$idquotation = $this->quotationDAO->insert($quotation);
    	return $idquotation;
    }
    
/*
 * revoie la liste des transports ( demanderTR + reponsetr) sur lesquels un client doit effectuer une quotation
 * @param: int $idutilisateurclient l idutilisateur d'un client
 * @return objetbdd[] la liste des transports concernés.
 */     
    function aTraiterClient($idutilisateurclient)
    {
  		$query=
			"SELECT tab1.*, tab2.*, idutilisateurtransporteur AS idutilisateur, nomclient AS nomutilisateur
			FROM (
				
				(
				SELECT idtransport, idutilisateur AS idutilisateurclient, d1.*
				FROM transport t1
				INNER JOIN demandetr d1 ON t1.iddemandetr = d1.iddemandetr
				INNER JOIN contact c1 ON d1.idcontact = c1.idcontact
				)tab1
			
				INNER JOIN (
				
				SELECT idtransport , c2.idutilisateur AS idutilisateurtransporteur, nomclient, r1.*
				FROM transport t2
				INNER JOIN reponsetr r1 ON t2.idreponsetr = r1.idreponsetr
				INNER JOIN contact c2 ON r1.idcontact = c2.idcontact
				INNER JOIN utilisateur u1 ON c2.idutilisateur = u1.idutilisateur
				)tab2 ON (tab1.idtransport = tab2.idtransport)
			)
			
			LEFT OUTER JOIN
			
				quotation ON ( tab1.idtransport = quotation.idtransport
				AND tab2.idutilisateurtransporteur = quotation.idutilisateur2 )
				
			WHERE idutilisateurclient = ".$idutilisateurclient."
			AND idquotation IS NULL";
		
			$res = $this->quotationDAO->getByCustomQuery($query); 
				
 			return $res;
    }
    
    
 /*
 * revoie la liste des transports ( demanderTR + reponsetr) sur lesquels un transporteur doit effectuer une quotation
 * @param: int $idutilisateurtransporteur l idutilisateur d'un transporteur
 * @return objetbdd[] la liste des transports concernés.
 */    
        function aTraiterTransporteur($idutilisateurtransporteur)
    {
  		$query=
			"SELECT tab1.*, tab2.*, idutilisateurclient AS idutilisateur, nomclient AS nomutilisateur
			FROM (
				
				(
				SELECT idtransport, c1.idutilisateur AS idutilisateurclient, nomclient, d1.*
				FROM transport t1
				INNER JOIN demandetr d1 ON t1.iddemandetr = d1.iddemandetr
				INNER JOIN contact c1 ON d1.idcontact = c1.idcontact
				INNER JOIN utilisateur u1 ON c1.idutilisateur = u1.idutilisateur
				)tab1
			
				INNER JOIN (
				
				SELECT idtransport, idutilisateur AS idutilisateurtransporteur, r1.*
				FROM transport t2
				INNER JOIN reponsetr r1 ON t2.idreponsetr = r1.idreponsetr
				INNER JOIN contact c2 ON r1.idcontact = c2.idcontact
				)tab2 ON (tab1.idtransport = tab2.idtransport)
			)
			
			LEFT OUTER JOIN
			
				quotation ON ( tab1.idtransport = quotation.idtransport
				AND tab1.idutilisateurclient = quotation.idutilisateur2 )
				
			WHERE idutilisateurtransporteur = ".$idutilisateurtransporteur."
			AND idquotation IS NULL";
		
			$res = $this->quotationDAO->getByCustomQuery($query); 
				
 			return $res;
    }

}


/*  	
 * aTraiterClient
 * 
 * 	$query=
			"SELECT tab1.idtransport, idutilisateurtransporteur AS idutilisateur, nomclient AS nomutilisateur
			FROM (
				
				(
				SELECT idtransport, idutilisateur AS idutilisateurclient, typetransport, villedepart, villearrive, datedepart, datearrive, heuredepart, nbrbus, capacitenecessaire, typecar
				FROM transport t1
				INNER JOIN demandetr d1 ON t1.iddemandetr = d1.iddemandetr
				INNER JOIN contact c1 ON d1.idcontact = c1.idcontact
				)tab1
			
				NATURAL JOIN (
				
				SELECT idtransport, c2.idutilisateur AS idutilisateurtransporteur, nomclient
				FROM transport t2
				INNER JOIN reponsetr r1 ON t2.idreponsetr = r1.idreponsetr
				INNER JOIN contact c2 ON r1.idcontact = c2.idcontact
				INNER JOIN utilisateur u1 ON c2.idutilisateur = u1.idutilisateur
				)tab2
			)
			*/

?>