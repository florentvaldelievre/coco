<?
if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé en tant qu'autocariste pour répondre à cette annonce"; return; }
   
include_once("libs/mailmanager.php");

    	$infos["cancelled"]=1;

 
$query_add_cancelled_tag = 	"SELECT * FROM `factures` f
							inner join transport t on (f.idreponsetr = t.idreponsetr )
							inner join demandetr d on (t.iddemandetr = d.iddemandetr )
							inner join contact c on (f.idutilisateur = c.idutilisateur )
							where (d.idutilisateur = ".$_SESSION['idutilisateur']."  AND t.iddemandetr=".$_GET['idtr'].")";




  	
  	 	     	$fDAO = new CObjetBddDAO("factures",$GLOBALS['mysql']); 
				$add_tag = $fDAO->getByCustomQuery($query_add_cancelled_tag);     
				$dTR = $fDAO->getBy( Array( 'idreponsetr' => $add_tag[0]->get("idreponsetr")));
			   
			   if($dTR->get("paye") || $dTR->get("cancelled")) //si c deja payé ou deja abandonné
				{
					echo "Deja payée ou abandonnée";
				}
			   	else
			   	{
			   	$dTR->set($infos);
			    $fDAO->update($dTR);
				$contenu="Motif d'annulation :".$_SESSION["cancelcomment"]."";
				$expediteur = "easyway";
                $objet="Le voyageur a abandonné l'annonce n°".$_GET['idtr'];							
     			$singleton = MailManager::getInstance();
     			$singleton->Envoi_mail($add_tag[0]->get("mail"),$contenu,$objet);
     			$singleton->ClearAddresses();

			    $_POST['url']="index.php?action=listing_valider_c";
				$_POST['message']="Votre annonce vient d'être abandonnée. Le transporteur en sera notifié par email";


                include("formulaires/redirectMessage.php");	
			   	}


?>