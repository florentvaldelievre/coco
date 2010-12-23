<?php

if(defined("__CMessageBoxVue"))
    return;

define("__CMessageBoxVue","");



class CMessageBoxVue
{
	//types de messages possibles
	static $type = array("info","erreur","validation");
 	var $msgStr;
	
	
	function __construct($msgType, $msgStr)
	{
		$this->msgStr = $msgStr;
		$this->msgType = $msgType;
		if(!array_search($msgType, self::$type )){
			echo "Type de message non defini ";
			$this->msgType = self::$type[0];
		}	
	}
	
	function display()
	{
		$this->{"display_".strval($this->msgType)}();
	}
	
	function display_info()
	{
		echo "<div class=\"panelcentre\" >";
		echo "<div class=\"boiteinfo\">";	
		echo "<div class=\"bandeauinfo\"><img src=\"./images/style1/exclamation-blue.gif\" alt=\"icon_exclamation-blue\" /></div> ";
		echo "<div class=\"boiteinfocontent\"><p>".$this->msgStr."</p>";
		echo "</div>";
		echo "<div class=\"footinfo clearboth\"><img class=\"alignright\" src=\"./images/style1/exclamation-blue.gif\" alt=\"icon_exclamation-blue\" /></div>";
		echo "</div>";
		echo "</div >";
	}
	
	function display_erreur()
	{
			echo "<div class=\"panelcentre\" >";
			echo "<div class=\"boiteko\">";
			echo "<div class=\"bandeauko\"><img src=\"./images/style1/exclamation-red.gif\" alt=\"icon_exclamation-red\" /></div> ";	
			echo "<div class=\"boitekocontent\"><p>".$this->msgStr."</p>";	
			echo "</div >";	
			echo "<div class=\"footko\"><img class=\"alignright\" src=\"./images/style1/exclamation-red.gif\" alt=\"icon_exclamation-red\" /></div>";	
			echo "</div>";
			echo "</div>";

	}
	
	function display_validation()
	{
			echo "<div class=\"panelcentre\" >";
			echo "<div class=\"boiteok\">";
			echo "<div class=\"bandeauok\"><img src=\"./images/style1/accept.gif\" alt=\"icon_accept\" /></div> ";
			echo "<div class=\"boiteokcontent\"><p>".$this->msgStr."</p>";
			echo "</div >";
			echo "<div class=\"footok\"><img class=\"alignright\" src=\"./images/style1/accept.gif\" alt=\"icon_accept\" /></div>";
			echo "</div>";
			echo "</div>";

	}	
}

?>