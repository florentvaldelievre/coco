<?php

if(defined("__CMySQL"))
    return;

define("__CMySQL","");

include_once("CLog.php");

/**
 * @package MySQL
 */

/**
 * Une connection à un serveur Mysql
 *
 * @package MySQL
 */
class CMySQL
{
        /**
        * Handler de la connection
        * @var int
        */
        var $connexion_hdl=0;

        /**#@+
        * Paramétre de connexion
        * @var string
        */
	var $host;
	var $user;
	var $pass;
        /**#@+*/

        /**
        * Un journal d'erreur
        * @var CLog
        */
	var $ErrorLog;

        /**
        * Un journal courant
        * @var CLog
        */
	var $StandardLog;

	var $lastSelectNumberOfRows;
	
	var $noLimitNumberOfRows;


        /**
        * Constructeur de la classe
        * @var string $host,$user,$pass Informations de connexions
        */
    function CMySQL($host,$user,$pass)
    {
       // $this->ErrorLog = new CLog("Logs/MySQL_Error.log");
        //$this->ErrorLog->DeleteLog();

       //$this->StandardLog= new CLog("Logs/MySQL_Std.log");
        //$this->StandardLog->DeleteLog();

        $this->host = "localhost";
        $this->user = "chartercar";
        $this->pass = "passbdd";
    }

        /**
        * Ajoute une entrée au journal courant
        * @param string $msg le message a ajouté. Sous windows, la séquence '\r\n' dans un message provoque le retour à la ligne.
        */
	function StdLog($msg)
	{
		//$this->StandardLog->AddLog($msg);
	}

        /**
        * Ajoute une entrée au journal d'erreur
        * @param string $msg le message a ajouté. Sous windows, la séquence '\r\n' dans un message provoque le retour à la ligne.
        */
	function ErrLog($msg)
	{
		//$this->ErrorLog->AddLog($msg);
	}

        /**
        * Crée une connexion a un serveur
        * Une entrée dans un journal est crée
        * @return bool true si la connection est établie, false sinon
        */
	function connect()
	{

	$this->connexion_hdl = mysql_pconnect($this->host,$this->user,$this->pass,true);
		if($this->connexion_hdl)
		{
			$this->StdLog("Connection au serveur $this->host ( $this->user )");
			return true;
		}
		else
		{
			$this->ErrLog("Echec de la connection au serveur $this->host ( $this->user ): ".mysql_error());
                        return false;
		}
	}

        /**
        * Selection de la base de donnée
        * Une entrée dans un journal est crée
        * @return bool true si la séléction est possible, false sinon
        */
	function selectDB($database)
	{
		if(!$this->connexion_hdl)
		{
			$this->ErrLog("Echec de la séléction de la base $database\r\n - pas de connection"); 
			return false;
		}
		else
		{
			$res = mysql_select_db($database,$this->connexion_hdl);

			if($res == true) 
			{
				$this->StdLog("Selection de la base $database");
				return true;
			}
			else
			{
				$this->ErrLog("Echec de la séléction de la base $database\r\n - ".mysql_error());
				return false;
			}
		}
	}

        /**
        * Soumet une requéte au serveur
        * Une entrée dans un journal est crée
        * @return bool true si la requéte est éxecutée, false sinon
        */
	function query($query)
	{
		if(!$this->connexion_hdl)
		{
			//$this->ErrLog("Echec de la requete:\r\n - $query\r\n - pas de connection");
			return false;
		}
		else
		{
			$res = mysql_query($query , $this->connexion_hdl);

			if($res)
			{
				//$this->StdLog("Requete réussie:\r\n - $query");
				return $res;
			}
			else
			{
				//$this->ErrLog("Echec de la requete:\r\n - $query\r\n - ".mysql_error());
				return false;
			}
		}

	}

        /**
        * Un "SELECT * " sur une jointure de tables
        * @param string|array $tables une ou plusieurs tables
        * @param array        $infos  liste des relations champ = valeur demandées
        * @return array|int   un tableau contenant un tuple au format champ => valeur, ou 0 si impossible
        */
	function select_one($tables,$infos=array())
	{
		if(!is_array($tables))
		{
			$tables=array($tables);
		}

		$tables_list="";

		$first=true;
		foreach( $tables as $key => $value )
		{
			if($first == true)
			{
				$first = false;
			}
			else
			{
				$tables_list .= ", ";
			}
			$tables_list .= "$value";
		}

		$where_list="";

		$first=true;
		foreach( $infos as $key => $value )
		{
			if($first == true)
			{
				$first = false;
				$where_list .= "WHERE ";
			}
			else
			{
				$where_list .= " AND ";
			}
			$where_list .= "$key = '".addslashes($value)."'";
		}

		$query = "SELECT * FROM $tables_list $where_list LIMIT 1";
		
		$res = $this->query($query);
		
		if($res)
		{
			$this->lastSelectNumberOfRows = mysql_num_rows($res);
		}
		else
		{
		 	$this->lastSelectNumberOfRows = 0;
		}

		if($res)
		{
			return mysql_fetch_assoc($res);
		}
		else
		{
			return 0;
		}
	}

        /**
        * Un "SELECT * " sur une jointure de tables
        * @param string|array $tables une ou plusieurs tables
        * @param array        $infos  liste des relations champ = valeur demandée
        * @param string       $orderby  champ selon lequel est trié la table resultat
        * @return array|int   une liste de tableau contenant un tuple au format champ => valeur, ou 0 si impossible
        */
	function select_all($tables,$infos=array(),$orderby="",$limitRawCount="", $limitOffset="")
	{
		
			
		if(!is_array($tables))
		{
			$tables=array($tables);
		}
		
	
		$tables_list = "";

		$first = true;
		foreach( $tables as $key => $value )
		{
			if($first == true)
			{
				$first = false;
			}
			else
			{
				$tables_list .= ", ";
			}
			$tables_list .= "$value";
		}

		$where_list="";

		$first=true;

		if(isset($infos))
		{
			foreach( $infos as $key => $value )
			{
				if($first == true)
				{
					$first = false;
					$where_list .= "WHERE ";
				}
				else
				{
					$where_list .= " AND ";
				}
				$where_list .= "$key = '".addslashes($value)."'";
			}
		}

		$orderby_list="";

		if(empty($orderby))
		{
			$orderby_list="ORDER BY id".$tables[0];
		}
		else
		{
			//TODO : orderby multiples
			$orderby_list = $orderby;
		}
		
		$limit_list = "";
		
		if(!empty($limitRawCount))
		{	
			if(!empty($limitOffset))
			{
				$limit_list += 'LIMIT ' + $limitOffset + ',' + $limitRawCount;
			}
			else
			{
				$limit_list += 'LIMIT ' + $limitRawCount;
			}
		}

		$query = "SELECT * FROM $tables_list $where_list $orderby_list $limit_list";
		//echo "<br/> query : $query <br/>";
		$res = $this->query($query);

		if($res)
		{
			$array = array();
			while( $tab = mysql_fetch_assoc($res) )
			{
                $array[] = $tab;
			}
			$this->lastSelectNumberOfRows = mysql_num_rows($res);
			return $array;
		}
		else
		{
			$this->lastSelectNumberOfRows = 0;
			return array();
		}
	}

        /*
        * Insere un unique tuple dans une table de la base
        * @param string $table  la table de destination
        * @param array  $values le tuple au format champ => valeur
        */
	function insert($table,$values)
	{
		$field_list="";
		$value_list="";

		$first=true;

		foreach( $values as $key => $value )
		{
			if($first == true)
			{
				$first = false;
			}
			else
			{
				$field_list .= ", ";
				$value_list .= ", ";
			}
			$field_list .= "$key";
			$value_list .= "'".mysql_real_escape_string($value)."'";
		}

		$query = "INSERT INTO $table ($field_list) VALUES ($value_list);";
		//dbug($query);
		return $this->query($query);
	}

        /**
        * Modifie un tuple dans une table de la base
        * @param string $table la table de destination
        * @param array  $infos le tuple au format champ => valeur
        * @param array  $where liste des relations champ = valeur à vérifier
        */
        function update($table,$infos,$where)
        {
          
            $where_list="";
            $first=true;
            foreach( $where as $key => $value )
            {
                if($first == true)
                {
                    $first = false;
                    $where_list .= "WHERE ";
                }
                else
                {
                    $where_list .= " AND ";
                }
                $where_list .= "$key = '".mysql_real_escape_string($value)."'";
            }

            $value_list="";
            $first=true;
            foreach( $infos as $key => $value )
            {
                if($first == true)
                {
                    $first = false;
                }
                else
                {
                    $value_list .= " , ";
                }
                
                $value_list .= "$key = '".mysql_real_escape_string($value)."'";
            }

            $query = "UPDATE $table SET $value_list $where_list LIMIT 1";
            //dbug($query);
            return $this->query($query);
 			

        }

        /**
        * Supprime un unique tuple d'une table de la base
        * @param string $table la table de destination
        * @param array  $where liste des relations champ = valeur à vérifier
        */
        function delete_one($table,$where)
        {
            $where_list="";
            $first=true;
            foreach( $where as $key => $value )
            {
                if($first == true)
                {
                    $first = false;
                    $where_list .= "WHERE ";
                }
                else
                {
                    $where_list .= " AND ";
                }
                $where_list .= "$key = '".addslashes($value)."'";
            }

            $query = "DELETE FROM $table $where_list LIMIT 1";
            return $this->query($query);
        }

        /**
        * Supprime plusieurs tuples d'une table de la base
        * @param string $table la table de destination
        * @param array  $where liste des relations champ = valeur à vérifier
        */
        function delete_all($table,$where)
        {
            $where_list="";
            $first=true;
            foreach( $where as $key => $value )
            {
                if($first == true)
                {
                    $first = false;
                    $where_list .= "WHERE ";
                }
                else
                {
                    $where_list .= " AND ";
                }
                $where_list .= "$key = '".addslashes($value)."'";
            }

            $query = "DELETE FROM $table $where_list";
            return $this->query($query);
        }


        /**
        * Execute une requete sql
        * @param string $query la requete
        */
        function custom_query($query, $limitRawCount="", $limitOffset="")
        {  
                $limit_list = "";
		
				if($limitRawCount!="")
				{	
					if($limitOffset!="")
					{
						$limit_list .= 'LIMIT '. $limitOffset .','. $limitRawCount;
					}
					else
					{
						
						$limit_list .= 'LIMIT '. $limitRawCount;
					}
				}
				$query_limit = "$query $limit_list";

                    	
				if(!empty($limit_list)) //si il y a resultLimiter , on veux aussi connaitre le nbr total de rows
	           	    $this->noLimitNumberOfRows =  mysql_num_rows($this->query($query));      
                
                $res = $this->query($query_limit);


                if($res)
                {
                        $array = array();
                        while( $tab = mysql_fetch_assoc($res) )
                        {
                			$array[] = $tab;

                        }
                        $this->lastSelectNumberOfRows = mysql_num_rows($res);

                        return $array;

                }
                else
                {
                        $this->lastSelectNumberOfRows = 0;
                        return array();
                }
        }
        
        /**
        * Execute une requete sql avec fonction d'agrégation
        * @param string table de la requete
        * @param string champ de la table
        * @param string fonction a appliquer sur le champ
        */
        function selectFunc($table, $field, $function)
        {
        	$query = "SELECT ".$function."(".$field.") FROM ".$table;
        	$sqlresults = $this->query($query);
        	if($sqlresults)
        	{
        		$res = mysql_fetch_array($sqlresults);
        		return $res[0];
        	}
        	else
        	{
        		return 0;
        	}
        }
        
        /**
        * Execute une requete sql max
        * @param string table de la requete
        * @param string champ de la table
        */
        function selectMax($table, $field)
        {
        	return $this->selectFunc($table, $field,"MAX");
        }
        
        /**
        * Execute une requete sql min
        * @param string table de la requete
        * @param string champ de la table
        */
        function selectMin($table, $field)
        {
        	return $this->selectFunc($table, $field,"MIN");
        }

		/**
		 * Demarre une transaction
		 */        
	    function startTransaction()
		{
			$this->query("START TRANSACTION");
		}
	
		 /**
		 * valide la transaction
		 */
		function commit()
		{
			$this->query("COMMIT");
		}
	
		 /**
		 * annule la transaction
		 */
		function rollback()
		{
			$this->query("ROLLBACK");
		}
   
}

?>
