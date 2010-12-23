<?php

	
		
		
if(!empty($_POST["marqueurTypeUser"]))
{

	$redirurl = reconstruireUrl($_POST["marqueurPage"]);
	include("formulaires/choiceredirectmessage.php");
}

?>
