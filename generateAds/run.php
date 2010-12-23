<?php
    

    
   include_once("../global.php");
   include_once("CGenerateAds.php");
   include_once("CGenerateQuery.php");
   include_once("../libs/CObjetBddDAO.php");
    include_once("../libs/util.php");   
       include_once("../libs/CItineraireGestion.php"); 
          
   
	for($i=0; $i<$_POST["numberAds"] ; $i++ )
	{
	$CgenerateAds = new CGenerateAds();
	$CgenerateAds->generateTransfertAds(2);
	}

echo $_POST["numberAds"]." Annonces crées <br />";

?>
