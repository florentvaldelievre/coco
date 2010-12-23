<?php

if(defined("__CObjetBddDAO"))
    return;

define("__CObjetBddDAO","");

include_once("CMySQL.php");
include_once("CObjetBdd.php");

 
/**
 * @package ObjetBddDAO
 */

/**
 * CObjetBddDAO gére l'acces aux données (DAO) liées à un objet CObjetBdd
 * On assume que le champ identifiant est la concaténation de "id" et de $table
 * @package ObjetBddDAO
 */

 
class CObjetBddDAO
{
        /**
        * Une ressource CMySQL
        * @var CMySQL
        */
	var $mysql_res;

        /**
        * La table contenant les données
        * @var string
        */
	var $table;     //la table correspondante a l'objet
	

/* TO DO
 *  integrer la la fonction mysql LIMIT  ( $start, $end, $increment,)
 *   concatenation d'une chaine $limit dans les function de selection  ( getBy, getAllBy, getByCustomQuery)
 */

        /**#@+
         * paramétres de connexion par défault
         * @var string
         *@TODO mettre dans un fichier de conf
         */
        var $DEFAULT_SERVER='localhost';
        var $DEFAULT_USER="root";
        var $DEFAULT_PASS='';
        var $DEFAULT_DB="iod";
        /**#@-*/

        /**
        * Constructeur de la classe
        * @param string $table     table de la base sur laquelle les accés seront effectués.
        * @param CMySQL $mysql_res connexion à un serveur mysql. Si ce paramétre est omis ou nul, une connexion est crée par défault
        */
	function CObjetBddDAO($table,$mysql_res='')
	{
		$this->table = $table;
        if($mysql_res)
		{
			$this->mysql_res = $mysql_res;
		}
		else
		{
			$this->mysql_res = new CMySQL($this->DEFAULT_SERVER,$this->DEFAULT_USER,$this->DEFAULT_PASS);
			$this->mysql_res->connect();
			$this->mysql_res->selectDB($this->DEFAULT_DB);
		}
	}

    function copyInfos($objet,$infos)
    {
        $objet->set($infos);
        return $objet;
    }

    /**
        * Cherche un enregistrement selon une liste de propriétés
        * @param  array $infos liste des relations $champ = $valeur demandées
        * @return CObjetBdd    un objet satisfaisant les critéres de la recherche
        */
    function getAllBytmp($infos)
    {
        $tables = array($this->table);
       	
        $sqlresultarray = $this->mysql_res->select_all($tables, $infos);

        $return_list=array();
        if($sqlresultarray)
        {
            foreach( $sqlresultarray as $sqlresult )
            {
            $objetbdd = new CObjetBdd();
            $objetbdd = $this->copyInfos($objetbdd,$sqlresult);
            $return_list[] = $objetbdd;
            }
            return $return_list;
        }
        else
        {
            return 0;
        }
    }
    
    /**
    * Cherche un enregistrement selon une liste de propriétés
    * @param  array $infos liste des relations $champ = $valeur demandées
    * @param  CResultLimiter $resultLimiter le gestionnaire d intervalle de résultats
    * @return CObjetBdd    un objet satisfaisant les critéres de la recherche
    */
    
    
    function getAllBy($infos, $resultLimiter = null)
    {
        $tables = array($this->table);

       	if(!empty($resultLimiter))
       	{
       	 	$sqlresultarray = $this->mysql_res->select_all($tables, $infos, $resultLimiter->get('rangesize'), $resultLimiter->get('limitMin'));
       	}
       	else
       	{
       		$sqlresultarray = $this->mysql_res->select_all($tables, $infos);
       	}
       	
        $return_list=array();
        if($sqlresultarray)
        {
            foreach( $sqlresultarray as $sqlresult )
            {
            $objetbdd = new CObjetBdd();
            $objetbdd = $this->copyInfos($objetbdd,$sqlresult);
            $return_list[] = $objetbdd;
            }
            return $return_list;
        }
        else
        {
            return 0;
        }
    }
    
    

        /**
        * Cherche un enregistrement selon une liste de propriétés
        * @param  array $infos liste des relations $champ = $valeur demandées
        * @return CObjetBdd    un objet satisfaisant les critéres de la recherche
        */
	function getBy($infos)
	{
		$tables = array($this->table);
		$sqlresult = $this->mysql_res->select_one($tables, $infos);

		$objetbdd = new CObjetBdd();

		if($sqlresult)
		{
			$objetbdd = $this->copyInfos($objetbdd,$sqlresult);
			return $objetbdd;
		}
		else
		{
			return 0;
		}
	}

    /**
    * Cherche un enregistrement selon son id
    * @param  int $id      un identifiant valide ( >0 )
    * @return CObjetBdd    un objet satisfaisant les critéres de la recherche
    */
    function getById($id)
    {
            return $this->getBy( array( "id".$this->table => $id  ));
    }
    
    /**
    * renvoie la valeur max d un champ
    * @param  string nom du champ
    * @return value la valeur maximum
    */
    function getMax($field)
    {
    	$out = $this->mysql_res->selectMax($this->table,$field);
    	return $out;
    }
   
    /**
    * renvoie la valeur min d un champ
    * @param  string nom du champ
    * @return value la valeur minimum
    */
    function getMin($field)
    {
    	    $out = $this->mysql_res->selectMin($this->table,$field); 
    		return $out;
    } 
        

        /**
        * Insére un objet dans la table
        * @param CObjetBdd $objetbdd l'objet à insérer
        */
	function insert($objetbdd)
	{
            if($this->mysql_res->insert($this->table,$objetbdd->infos) == false)
            {
            	return false;
            }
            else
            {
            	return mysql_insert_id($this->mysql_res->connexion_hdl);
            }
	}

        /**
        * Met un enregistrement à jour
        * @param CObjetBdd $objetbdd l'objet modifié
        */
	function update($objetbdd)
	{
        $id = "id".$this->table;
        $where=array();
        $where[$id] = $objetbdd->infos[$id];
          
        return $this->mysql_res->update($this->table,$objetbdd->infos,$where);
	}

    /**
    * Supprime un enregistrement de la table
    * @param CObjetBdd $objetbdd l'objet a supprimé
    */
    function _delete($objetbdd)
    {
       $id = "id".$this->table;
       $where=array();
       $where[$id] = $objetbdd->infos[$id];
       $this->mysql_res->delete_one($this->table,$where);
    }

    function getByCustomQuery($query, $resultLimiter = null)
    {  
       	if(!empty($resultLimiter))
       	{
       	 	$sqlresultarray = $this->mysql_res->custom_query($query, $resultLimiter->rangeSize, $resultLimiter->limitMin);	 	
 
       	}
       	else
       	{
       		$sqlresultarray = $this->mysql_res->custom_query($query);
       	}

       $return_list=array();
       if($sqlresultarray)
       {
           foreach( $sqlresultarray as $sqlresult )
           {
           $objetbdd = new CObjetBdd();
           $objetbdd = $this->copyInfos($objetbdd,$sqlresult);
           $return_list[] = $objetbdd;
           }
           return $return_list;
       }
       else
       {
           return NULL;
       }
    }
    
    function doCustomQuery($query)
    {
    	return $this->mysql_res->query($query);
    }
    
    function lastQueryNumberOfRows()
    {
    	return $this->mysql_res->lastSelectNumberOfRows;
    }
    
    function noLimitNumberOfRows()
    {
    	return $this->mysql_res->noLimitNumberOfRows;
    }
    
    
    /**
    * Retourne le noms des champs de la table
    * @return  string array : tableau contenant les
    */
    function getFiedsName()
    {
    	//SHOW COLUMNS FROM CLIENT 
    }

}
?>