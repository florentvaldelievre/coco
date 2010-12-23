<?php

if(defined("__CLog"))
    return;

define("__CLog","");

/**
 * @package Log
 */

/**
 * Classe de gestion de journaux
 *
 * @package Log
 */
class CLog
{
        /**
        * La liste des messages
        * @var array
        */
	var $log;
        /**
        * Le nombre de message
        * @var int
        */
	var $nb_log;

        /**
        * Si true, le journal est sauvegardé a chaque modification.
        * @var bool
        */
	var $b_auto_save = true;
        /**
        * Si true, la sauvegarde se fait a la suite des messages précedents. Sinon le journal est effacé avant la sauvegarde.
        * @var bool
        */
        var $b_append = true;
        /**
        * Fichier dans lequel est sauvegardé le journal
        */
        var $save_file;
        /**
        * Index du dernier message sauvegardé dans $log
        */
        var $save_index;

        /**
        * Constructeur de la classe
        * @param string $file Fichier dans lequel sera sauvegardé le journal
        */
	function CLog($file="")
	{
		$this->save_file = $file;
	}

        /**
        * Efface le journal
        */
	function DeleteLog()
	{
		$Fp = fopen($this->save_file,"w");
		fclose($Fp);
	}

        /**
        * Enregistre le journal
        * Si b_append est défine comme false, le journal est d'abord effacé.
        * Si b_auto_save est défine comme true, cette fonction est appelée a la suite des fonctions: AddLog
        */
	function SaveLog()
	{
		if($this->b_append == true)
		{
			$Fp = fopen($this->save_file,"a");
		}
		else
		{
			$Fp = fopen($this->save_file,"w");
		}

		for($i=$this->save_index;$i<$this->nb_log;$i++)
		{
			fwrite($Fp,$this->log[$i]['date'].": ".$this->log[$i]['msg']."\r\n");
			$this->save_index = $this->nb_log;
		}

		fclose($Fp);
	}

        /**
        * Ajoute une entrée dans le journal, précédée de la date
        * Si b_auto_save est défine comme true, le journal est ensuite sauvegardé
        * @param string $msg le message a ajouté. Sous windows, la séquence '\r\n' dans un message provoque le retour à la ligne.
        */
	function AddLog($msg)
	{
		$this->log[$this->nb_log]['msg'] = $msg;
		$this->log[$this->nb_log]['date'] = date("d/m/y H:i:s");

		$this->nb_log++;

		if($this->b_auto_save == true)
		{
			$this->SaveLog();
		}
	}
}

?>