<?php

if(defined("__CUtilisateurGestion"))
    return;

define("__CUtilisateurGestion","");

include_once("CUtilisateur.php");
include_once("CUtilisateurDAO.php");


class CUtilisateurGestion
{
    var $utilisateurDAO;
    var $mysql_res;

    function CUtilisateurGestion($mysql_res="")
    {
    	$this->mysql_res=$mysql_res;
        $this->utilisateurDAO = new CUtilisateurDAO($mysql_res);
    }
    
    /*
     * renvoie l'idutilisateur correspondant a l'utilisateur passé en parametre
     * @param : varchar $utilisateur
     * @return : CobjetBdd $idutilisateur
     */
    function getIdUtilisateur($utilisateur)
    {
    	$utilisateurDAO =  new CUtilisateurDAO($this->mysql_res);
		$utilisateur = $utilisateurDAO->getBy(array("nomclient" => $utilisateur));	
		$idutilisateur = $utilisateur->get("idutilisateur");	
    	return $idutilisateur;
    }
    
    
    function getNameUtilisateurById($idutilisateur) {
    	
    	$uDAO = new CObjetBddDAO("utilisateur",$GLOBALS['mysql']);
    	$query="SELECT * FROM contact " .
				"NATURAL JOIN utilisateur " .
				"WHERE utilisateur.idutilisateur = $idutilisateur";
		$res =	$uDAO->getByCustomQuery($query);
		return $res[0]->get("nomclient");
			

    }
     
      function getNicknameUtilisateurById($idutilisateur) {
    	
    	$uDAO = new CObjetBddDAO("utilisateur",$GLOBALS['mysql']);
    	$query="SELECT * FROM contact " .
				"NATURAL JOIN utilisateur " .
				"WHERE utilisateur.idutilisateur = $idutilisateur";
		$res =	$uDAO->getByCustomQuery($query);
		return $res[0]->get("prenom");
			

    }
    
        /*
     * renvoie le type d'utilisateur ( client ou transporteur ) selon son nom
     * @param : varchar $utilisateur 
     * @return : String : client/transporteur
     */
    function getTypeUtilisateur($utilisateur)
    {
    	
    	
    	$uDAO = new CObjetBddDAO("utilisateur",$GLOBALS['mysql']);
    	$query = "SELECT typeutilisateur from utilisateur
		  		 NATURAL JOIN contact c where c.username = '$utilisateur'";
		$res =	$uDAO->getByCustomQuery($query);
		return $res[0]->get("typeutilisateur");
    	
    	
    }
    
    function getTypeUtilisateurById($idutilisateur) {
    	
        	$uDAO = new CObjetBddDAO("utilisateur",$GLOBALS['mysql']);
	    	$query = "SELECT typeutilisateur from utilisateur	
					WHERE idutilisateur=$idutilisateur";
		$res =	$uDAO->getByCustomQuery($query);
		return $res[0]->get("typeutilisateur");
    }
    
    
    /**
     * renvoie l id de l'utilisateur client ayant posté une annonce
     * @param : varchar $iddemandetr id de l annonce 
     * @return : int   idutilisateur du client
     */
    function getIdFromDemandeTr($iddemandetr)
    {
    	    	$uDAO = new CObjetBddDAO("utilisateur",$GLOBALS['mysql']);
    	$query = "SELECT idutilisateur from utilisateur
		   		NATURAL JOIN demandetr c where iddemandetr = $iddemandetr";
		$res =	$uDAO->getByCustomQuery($query);

		if($res)
			return $res[0]->get("idutilisateur");
		else
			return $res;
    }
    
     /**
     * renvoie l id de l'utilisateur transporteur ayant valider une annonce
     * @param : varchar $iddemandetr id de l annonce 
     * @return : int   idutilisateur du transporteur
     */
    function getIdFromDemandeTrValide($iddemandetr)
    {
    	    	$uDAO = new CObjetBddDAO("utilisateur",$GLOBALS['mysql']);
    	//$query = "SELECT r.idutilisateur from reponsetr r JOIN demandetr d ON r.iddemandetr = d.iddemandetr
		//   WHERE iddemandetr = $iddemandetr AND rtag = 'valide'"  ;
		$query = "SELECT r.idutilisateur FROM reponsetr r JOIN transport t ON r.iddemandetr = t.iddemandetr
		   WHERE t.iddemandetr = $iddemandetr"  ;
		$res =	$uDAO->getByCustomQuery($query);
		//echo "<br> $query <br>";
		if($res)
			return $res[0]->get("idutilisateur");
		else
			return $res;
    }



    
    
}

?>