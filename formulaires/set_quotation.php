 
<?
   include_once("include/include_listing.php");	
      
function affichageTypeUtilisateur($bddtype)
{
	if($bddtype == "client"){
		return "l'utilisateur";
	}
	else if($bddtype == "tranporteur"){
		return "l'autocariste";
	}
}    


//vérification log
if(!isset($_SESSION['username'])) {  echo "Vous devez etre loggé"; return; }

//controle de l'identité de l'utilisateur
$utilgestion = new CUtilisateurGestion($mysql_res="");
if(isTransporteur($_SESSION["typeutilisateur"]))
{
	$idutilisateur2 = $utilgestion->getIdFromDemandeTrValide($_GET["iddemandetr"]);
}
if(isUtilisateur($_SESSION["typeutilisateur"]))
{
	$idutilisateur2 = $utilgestion->getIdFromDemandeTr($_GET["iddemandetr"]);
}

if(!checkuser($_SESSION["idutilisateur"], $idutilisateur2)){  
	echo "accès interdit"; return;
} 



$utilisateurDAO =  new CUtilisateurDAO($GLOBALS['mysql']);
$idutilisateurCourant = $_SESSION["idutilisateur"];
$utilisateurEvalue = $utilisateurDAO->getById($_GET["idutilisateur2"]);

$quotationGestion = new CQuotationGestion($GLOBALS['mysql']);
		
						
if(isset($_POST['validerform']))
{
	
	/*
	 * TODO , TO FIX pb avec les POST et les GET , quelques fois ça ne marche pas.
	 */
	$res = $quotationGestion->nouvelleQuotation($_POST['transport'], $idutilisateurCourant, $_POST['utilisateur'],$_POST['note'],$_POST['commentaire']);
	
	
	if(empty($res))
	{
	
	   include("formulaires/quotation_fin.php");
       quotationFinKo($_SESSION["typeutilisateur"]);
 return;
	}
	else
	{            
	   include("formulaires/quotation_fin.php");
       quotationFinOk($_SESSION["typeutilisateur"]);
           
	}

}
else
{

?>

	    <div class="panelcentre">
        <div class="boiteform">
        <div class="bandeauform">
         <h4>Evaluation</h4>
        </div>			

        <form name="quotation" id="quotation" method="post" target="_self" action="">
            <div class="corpForm"><br />
                <fieldset>
                            
                  
	                    <br />
							<p>
							Laisser une evaluation sur <? affichageTypeUtilisateur($utilisateurEvalue->get("typeutilisateur")); ?> <span class="important"> <? echo $utilisateurEvalue->get("nomclient");?> </span
							<input type="hidden" name="utilisateur" readonly="readonly" value="<?echo $_GET["idutilisateur2"]; ?>" />
							pour le <span class="important"> transport <?echo $_GET["iddemandetr"]; ?></span>
							<input type="hidden" name="transport" readonly="readonly" value="<?echo $_GET["idtransport"]; ?>" />
						
							</p>
							
							<br />
  						
	                        <p>
	                            <label for="note" class="oblig">Note :</label>
                                <select name="note" title="note" id="note">
	                            <?
									$tab = Array(1,2,3,4,5);
                                    	for($i=count($tab)-1; $i>=0; $i--) {
                            	            echo "<option value=\"$tab[$i]\">$tab[$i]</option>";
                                        }
                                ?>
                                </select> 
                                <a href="javascript:void(0);" onclick="return  overlib('<br>5<br/> équivaut a la meilleur evaluation possible, <br>1<br/> à la plus mauvaise', parent.CAPTION, '<strong>Echelle de notation</strong>',parent.CAPTIONPADDING,'4',parent.FGCOLOR, '#FDFDFD',parent.WIDTH, '350',parent.STICKY,parent.CGBACKGROUND,'images/shade_caption.gif',parent.CLOSECLICK,parent.CLOSECOLOR,'#132884', parent.TEXTSIZE,'10px',OFFSETX, -150);"  onmouseout="nd();"><img src=images/interrogation.gif></a>                     
                            </p>
                                                                           
                        	<p>
    	                   		<label for="comment" class="oblig">commentaire :</label> 
        					</p>
                            
							<textarea name="commentaire" wrap="virtual" rows="8" cols="40"></textarea>					
					
				</fieldset>
               
                <div class="piedForm">
                	<input type="reset" name="reset" id="reset" value="Annuler" />
                	<input type="hidden" name="accessfrom" value="<?echo $_GET["accessfrom"]; ?>" />
                	<input type="hidden" name="validerform" value="1"/>
            	    <input type="submit" name="validerclient" id="valid" value="Valider" />
         		</div>    
   
        	</div>
        </form>
        </div>
        </div>
 <?
}
?>