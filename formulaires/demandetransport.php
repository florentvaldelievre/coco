



<?
if(!(isset($_SESSION['username']) && $_SESSION["typeutilisateur"] == "client")) { 

	include "./formulaires/inscriptionclientredir.php"; 
}
	

if(isset($_SESSION['username'])) {

?>
                            <fieldset>
                                <legend>Type de transport </legend><br/>
                                <div class="listechoix">
                                      <?

                                                 echo "<br/>";    
                                                 echo "<input type=\"radio\" name=\"typetransport[]\" id=\"transfert\"  onclick=\" location='index.php?action=transfert'\" value=\"transfert\">transfert<br/>";
                                                 echo "<input type=\"radio\" name=\"typetransport[]\" id=\"dispo\"  onclick=\" location='index.php?action=dispo'\" value=\"dispo\">disponibilité<br/>";
                                                 echo "<input type=\"radio\" name=\"typetransport[]\" id=\"sejour\"  onclick=\" location='index.php?action=sejour'\" value=\"sejour\">Séjour<br/>";

                                     ?>
                                  </div>     
    <br />                             
                                 
<div class="panelcentre" >


<div class="boiteinfo">

<div class="bandeauinfo"><img src="./images/style1/exclamation-blue.gif" alt="icon_exclamation-blue" /></div> 

<div class="boiteinfocontent">

	<p>         

<strong>Transfert</strong>:<br /> 
- Le transfert est utilisé pour transporter des voyageurs d'un point A vers un point B <strong>(A-&gt;B)</strong> avec possibilité d'enregistrer un retour <strong>(A-&gt;B,B-&gt;A)</strong>
<br /><br />
<strong>Disponibilité</strong>:<br /> 
- La disponibilité permet de transporter des voyageurs sur la journée suivant un itinéraire  <strong>(A-&gt;B-&gt;...)</strong><br><br>
<strong>Séjour</strong>:<br />- Le séjour est la méme chose que la disponibilité à la différence que le conducteur passe un repos exterieur obligatoire	

 </p>

</div>
<div class="footinfo clearboth"><img class="alignright" src="./images/style1/exclamation-blue.gif" alt="icon_exclamation-blue" /></div>

</div>


</div >                         
                                 
                                </fieldset>






<?
}
?>