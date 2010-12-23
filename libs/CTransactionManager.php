<?php

if(defined("__CTransactionManager"))
    return;

define("__CTransactionManager","");

include_once("CMySQL.php");

/**
 * @package CTransactionManager
 */

/**
 * CTransactionManager permet la manipulation des Transaction SQL
 * @package ObjetBddDAO
 */
class CTransactionManager
{

    /**
    * Une ressource CMySQL
    * @var CMySQL
    */
	var $mysql_res;
	
	/**
	 *  Renseigne sur l etat du mode transaction
	 * @var bool
	 */
	var $transactionMode;

	/**
	 *  Renseigne sur le résultat de l'execution des requetes sql en mode transaction
	 * @var bool
	 */
	var $queryErr;



    /**
    * Constructeur de la classe
    * @param CMySQL $mysql_res connexion à un serveur mysql. Si ce paramétre est omis ou nul, une connexion est crée par défault
    */
	function CTransactionManager($mysql_res='')
	{
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
		
		$this->transactionMode = false;
		$this->queryErr = false;
	}

	/**
	 * Demarre une transaction
	 * @return bool true si la transaction a démmarer avec succès, false sinon
	 */
	function startTransaction()
	{
		if(!$this->isInTransaction())
		{
			$this->transactionMode=true;
			$this->queryErr = false;
			return $this->mysql_res->startTransaction();
		}
		return false;
	}

	 /**
	 * valide la transaction
	 */
	function commit()
	{
		if($this->isInTransaction())
		{
			$this->transactionMode=false;
			return $this->mysql_res->commit();
		}
		return false;
	}

	 /**
	 * annule la transaction
	 */
	function rollback()
	{
		if($this->isInTransaction())
		{
			$this->transactionMode=false;
			return $this->mysql_res->rollback();
		}
		return false;
	}
	
	/**		 
	 * @return bool
	 */
	function isInTransaction()
	{
		return $this->transactionMode;
	}
	
	function setQueryErr()
	{
		$this->queryErr = true;
	}

	function getQueryErr()
	{
		return $this->queryErr;
	}

}
?>