<?php 




    //require_once("all_includes.php"); 
	require_once("xmlwriterclass.php");
	require_once("rss_writer_class.php");




        $dtrDAO = new CObjetBddDAO("demandetr",$GLOBALS['mysql']);
        $rtrDAO = new CObjetBddDAO("reponsetr",$GLOBALS['mysql']);


       	$listingGestion = new CListingGestion($GLOBALS['mysql']);
       	$itineraireGestion = new CItineraireGestion($GLOBALS['mysql']);     	
	    $liste_demandetr = $listingGestion->consulterAnnonces(null,null,null,$url);
	    
		$url = new CGererURL();
		CFilterOrderBy::setDefault($url);
		CFilterOrderAscending::setDefault($url);

	/*
	 * 
	 * *  First create an object of the class.
	 */
	$rss_writer_object=&new rss_writer_class;
	
	/*
	 *  Choose the version of specification that the generated RSS document should conform.
	 */
	$rss_writer_object->specification='1.0';
	
	/*
	 *  Specify the URL where the RSS document will be made available.
	 */
	$rss_writer_object->about="http://".$_SERVER['HTTP_HOST']."/Rss/waybus.xml";
	
	/*
	 *  Specify the URL of an optional XSL stylesheet.
	 *  This lets the document be rendered automatically in XML capable browsers.
	 */
	//$rss_writer_object->stylesheet='http://www.phpclasses.org/rss1html.xsl';
	
	/*
	 *  You may declare additional namespaces that enable the use of more property
	 *  tags defined by extension modules of the RSS specification.
	 */
	$rss_writer_object->rssnamespaces['dc']='http://purl.org/dc/elements/1.1/';
	
	/*
	 *  Define the properties of the channel.
	 */
	$properties=array();
	$properties['description']='Cliquer sur un lien pour pouvoir y repondre';
	$properties['link']=$GLOBALS['url_server'];
	$properties['title']='Liste des annonces disponibles';
	$properties['dc:date']=Date('d/m/Y H:i:s');
	$rss_writer_object->addchannel($properties);
	
	/*
	 *  If your channel has a logo, before adding any channel items, specify the logo details this way.
	 */
//	$properties=array();
//	$properties['url']='http://www.phpclasses.org/graphics/logo.gif';
//	$properties['link']='http://www.phpclasses.org/';
//	$properties['title']='PHP Classes repository logo';
//	$properties['description']='Repository of components and other resources for PHP developers';
//	$rss_writer_object->addimage($properties);
	
	/*
	 *  Then add your channel items one by one.
	 */
				foreach( $liste_demandetr as $demandetr )
				{

				    $listeEtapes = $itineraireGestion->getItineraire($demandetr->get("iddemandetr"));
					$properties=array();
					$properties['description']=CAffichageAnnonceVoyageur::getInfoAnnonceVoyageur($demandetr,$listeEtapes);
					$properties['link']="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?action=repondreannonce&iddemandetr=".$demandetr->get("iddemandetr");
					$properties['title']=$demandetr->get("typetransport")." n°". $demandetr->get("iddemandetr");
					$properties['dc:date']=$demandetr->get("date");
					$rss_writer_object->additem($properties);
	
				}

	
	/*
	 *  When you are done with the definition of the channel items, generate RSS document.
	 */
	if($rss_writer_object->writerss($output))
	{

		$fp = fopen("Rss/waybus.xml", 'w+');
		fputs($fp, $output);
		fclose($fp);

	}
	else
	{
		
		/*
		 *  If there was an error, output it as well.
		 */
		Header('Content-Type: text/plain');
		echo ('Error: '.$rss_writer_object->error);
	}



						//CAffichageAnnonceVoyageur::getInfoAnnonceVoyageur($demandetr);




?>