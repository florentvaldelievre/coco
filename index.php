<?



if(isset($_POST['save_me'])) {
	
	setcookie("login", $_POST['user'], (time() + 680400));
	setcookie("pass", $_POST['password'], (time() + 680400));  
}	

else if($_POST['valide'] && (!isset($_POST['save_me']))) //si on valide sans avoir cocher la case , on vire les cookies
{

	setcookie("login", "", (time() - 3600));
	setcookie("pass", "" , (time() - 3600));  
}
   
   
   include_once("global.php"); 
   session_start();
    


   ini_set("url_rewriter.tags","a=href,area=href,frame=src,iframe=src,input=src");





    if(isset($_POST['action']))
    {
       $action = $_POST['action'];
    }
    else if(isset($_GET['action']))
    {
        $action = $_GET['action'];
    }
    else
    {
        $action = "accueil";
    }



    
    if( $action == "destroy" )
    {
        $_SESSION = array();
        session_destroy();
        setcookie("login", "", (time() - 3600));   
        setcookie("pass", "", (time() - 3600));  
    }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
<head><title><? echo $title[$_GET['action']] ?></title>
<meta name="Description" content="Vous cherchez une location de bus ou de car pour organiser un voyage, Waybus permet la relation entre transporteurs et voyageurs pour leur sejour, circuit ou balade" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<meta http-equiv="Content-Script-Type" content="application/javascript; charset=UTF-8">
<meta name="robots" content="index,all" />
<meta name="Keywords" content="WEI, Week-ends d'integration, sejour, étudiants, voyage, voyageurs, transporteurs, autocaristes, transport, bus, car, gratuitement, location d'autocar, organiser, circuit, devis"/>
<link rel="alternate" type="application/rss+xml" title="RSS" href="Rss/waybus.xml"></link>
<link href="styles/easyway_style1.css" rel="styleSheet" type="text/css"></link>
<link rel="stylesheet" type="text/css" media="all" href="styles/themeAquaCalendar.css" title="Aqua" />

 
  <script type="text/javascript" src="javascript/calendar.js"></script>
  <script type="text/javascript" src="javascript/overlibmws.js"></script>
  <script type="text/javascript" src="javascript/overlibmws_print.js"></script>
  <script type="text/javascript" src="javascript/overlibmws_draggable.js"></script>    
  <script type="text/javascript" src="javascript/overlibmws_filter.js"></script>
  <script type="text/javascript" src="javascript/overlibmws_bubble.js"></script>
  <script type="text/javascript" src="javascript/collapse.js"></script>
  <script type="text/javascript" src="javascript/inscription.js"></script>
  <script type="text/javascript" src="javascript/forms_effect.js"></script>
  <script type="text/javascript" src="javascript/util.js"></script>    
  <script type="text/javascript" src="javascript/ajax/autocomplete-3-2.js"></script>
  <script type="text/javascript" src="javascript/autocomplete/prototype.js"></script>
  <script type="text/javascript" src="javascript/autocomplete/effects.js"></script>
  <script type="text/javascript" src="javascript/autocomplete/controls.js"></script>
  <script type="text/javascript" src="javascript/autocomplete/voyage.js"></script>    

      

</head>
<body class="tundra">

<div class="page">
       
    <div id="leftmenu">

		 <div id="logo_gauche"><a href="index.php"><img src="images/logo.jpg" width="250px" alt="logo" /> βeta</a></div> 
	 
		  <ul id="rubrique-haut">
		 
		          <li>
		            <a href="index.php?action=reglementation">Réglementation</a>
		          </li>
		          <li>
		            <a href="index.php?action=faq">FAQ</a>
		          </li>
		        
		          <li>
		            <a href="index.php?action=commentcamarche">Comment le site fonctionne</a>
		          </li>
		          
		          	<li class="dernier">
		            <a href="index.php?action=demonstration">Démonstration</a>
		          </li>
				
		   </ul>
   
		
 
 
   </div>
 

<div class="clearhack"/>

  <div class="barre_menu"></div>
    

 
  <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>


    <? 

     if( $action == "login" )
{
       include_once "formulaires/login.php";
}
   
    
    
    include_once("frames/haut.php"); ?>
    <table class="mainframe" align="center" border="0" cellpadding="0" cellspacing="8" width="950">
       <tr>    
			 <td width="200" valign="top">
			 	<? include_once("frames/gauche.php");  ?>
			 </td> 
		     <td width="750" valign="top"><br/>
		   		<? include_once("frames/centre.php"); ?>
		     </td>
       </tr>
    </table>

<!--
  <script language="JavaScript" type="text/javascript">checkDisabledStatus();</script>
-->
 
 <div id="footer">
 	© 2008 Waybus. Tous Droits Réservés.
</div>
 

 </div>
</body>
</html>