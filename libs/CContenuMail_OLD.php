<?php
class CContenuMail {
	
	
	
	public static function ContenuMailRefusAnnonceTransporteur($info_client) {
	$contenu= "<html>
					
					<head>
					<meta http-equiv=Content-Type content=\"text/html; charset=UTF-8\">
					<meta name=Generator content=\"Microsoft Word 12 (filtered)\">
					<title>Waydev Mail</title>
					<style>
					<!--
					 /* Font Definitions */
					 @font-face
						{font-family:\"Cambria Math\";
						panose-1:2 4 5 3 5 4 6 3 2 4;}
					@font-face
						{font-family:Tahoma;
						panose-1:2 11 6 4 3 5 4 4 2 4;}
					@font-face
						{font-family:Verdana;
						panose-1:2 11 6 4 3 5 4 4 2 4;}
					 /* Style Definitions */
					 p.MsoNormal, li.MsoNormal, div.MsoNormal
						{margin:0cm;
						margin-bottom:.0001pt;
						font-size:12.0pt;
						font-family:\"Times New Roman\",\"serif\";}
					a:link, span.MsoHyperlink
						{color:#650696;
						text-decoration:underline;}
					a:visited, span.MsoHyperlinkFollowed
						{color:#650696;
						text-decoration:underline;}
					p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
						{mso-style-link:\"Texte de bulles Car\";
						margin:0cm;
						margin-bottom:.0001pt;
						font-size:8.0pt;
						font-family:\"Tahoma\",\"sans-serif\";}
					span.TextedebullesCar
						{mso-style-name:\"Texte de bulles Car\";
						mso-style-link:\"Texte de bulles\";
						font-family:\"Tahoma\",\"sans-serif\";}
					p.msochpdefault, li.msochpdefault, div.msochpdefault
						{mso-style-name:msochpdefault;
						margin-right:0cm;
						margin-left:0cm;
						font-size:10.0pt;
						font-family:\"Times New Roman\",\"serif\";}
					.MsoChpDefault
						{font-size:10.0pt;}
					@page Section1
						{size:595.3pt 841.9pt;
						margin:70.85pt 70.85pt 70.85pt 70.85pt;}
					div.Section1
						{page:Section1;}
					-->
					</style>
					
					<link rel=\"important stylesheet\" href=\"chrome://messenger/skin/messageBody.css\">
					</head>
					
					<body lang=FR link=\"#650696\" vlink=\"#650696\" bottomMargin=0 alink=\"#650696\"
					leftmargin=0 topmargin=0 rightMargin=0 marginheight=0 marginwidth=0>
					
					<div class=Section1>
					
					<div align=center>
					
					<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=499
					 style='width:374.1pt'>
					 <tr>
					  <td valign=top style='background:#650696;padding:.75pt .75pt .75pt .75pt'>
					  <div align=center>
					  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
					   style='background:white'>
					   <tr>
					    <td colspan=2 style='padding:0cm 0cm 0cm 0cm'>
					    <p class=MsoNormal><a href=\"http://zaibe.ath.cx/image001.gif\"><span
					    style='color:windowtext;text-decoration:none'><img border=0 width=548
					    height=71 src=\"http://zaibe.ath.cx/image001.gif\" alt=\"\"></span></a></p>
					    </td>
					    <td style='padding:0cm 0cm 0cm 0cm'></td>
					    <td style='padding:0cm 0cm 0cm 0cm'></td>
					   </tr>
					   <tr>
					    <td style='padding:0cm 0cm 0cm 0cm'></td>
					    <td valign=top style='padding:0cm 0cm 0cm 0cm'>
					    <div align=center>
					    <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=444
					     style='width:333.0pt;margin-left:6.8pt'>
					     <tr>
					      <td width=444 valign=top style='width:333.0pt;padding:0cm 0cm 0cm 0cm'>
					      <p class=MsoNormal><span style='font-size:10.0pt;font-family:\"Verdana\",\"sans-serif\";
					      color:#650696'>Votre réponsen°a pas été retenue&nbsp;!</span></p>
					      </td>
					     </tr>
					     <tr style='height:3.75pt'>
					      <td width=444 style='width:333.0pt;padding:0cm 0cm 0cm 0cm;height:3.75pt'></td>
					     </tr>
					     <tr>
					      <td width=444 style='width:333.0pt;padding:0cm 0cm 0cm 0cm'>
					      <p class=MsoNormal><a href=\"http://zaibe.ath.cx/image002.gif\"><span
					      style='color:windowtext;text-decoration:none'><img border=0 width=442
					      height=1 src=\"http://zaibe.ath.cx/image002.gif\"
					      alt=\"\"></span></a></p>
					      </td>
					     </tr>
					     <tr style='height:15.0pt'>
					      <td width=444 style='width:333.0pt;padding:0cm 0cm 0cm 0cm;height:15.0pt'></td>
					     </tr>
					     <tr>
					      <td width=444 valign=top style='width:333.0pt;padding:0cm 0cm 0cm 0cm'>
					      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>&nbsp;</span></p>
					      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>Nous avons le regret de vous informer que le voyageur n°a pas pu
					      faire suite à votre réponse concernant la demande de transport n°".$info_client[0]->get("iddemandetr")."</span></p>
					      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>&nbsp;</span></p>
					      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>Soit votre réponse a expirée (48h sans validation de la part
					      voyageur).</span></p>
					      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>Soit il a choisi un autre transporteur et donc mis fin é
					      votre réponse.</span></p>
					      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>&nbsp;</span></p>
					      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>Bonne journée<br>
					      <br>
					      L'Equipe Waydev</span></p>
					      </td>
					     </tr>
					     <tr style='height:11.25pt'>
					      <td width=444 style='width:333.0pt;padding:0cm 0cm 0cm 0cm;height:11.25pt'></td>
					     </tr>
					    </table>
					    </div>
					    </td>
					    <td colspan=2 style='padding:0cm 0cm 0cm 0cm'></td>
					    <td style='padding:0cm 0cm 0cm 0cm'></td>
					   </tr>
					   <tr>
					    <td style='padding:0cm 0cm 0cm 0cm'></td>
					    <td style='padding:0cm 0cm 0cm 0cm'></td>
					    <td colspan=2 style='padding:0cm 0cm 0cm 0cm'></td>
					    <td style='padding:0cm 0cm 0cm 0cm'></td>
					   </tr>
					  </table>
					  </div>
					  </td>
					 </tr>
					</table>
					
					</div>
					
					<p class=MsoNormal>&nbsp;</p>
					
					</div>
					
					</body>
					
					</html>";
					
					return $contenu;

			}
	
	
	
	public static function ContenuMailValidationAnnonce($info_client,$info_transporteur,$etapes,$type_user) {


		 
		$contenu =
		
							" <html>
					
					<head>
					<meta http-equiv=Content-Type content=\"text/html; charset=UTF-8\">
					<meta name=Generator content=\"Microsoft Word 12 (filtered)\">
					<title>Waydev Mail</title>
					<style>
					<!--
					 /* Font Definitions */
					 @font-face
						{font-family:\"Cambria Math\";
						panose-1:2 4 5 3 5 4 6 3 2 4;}
					@font-face
						{font-family:Tahoma;
						panose-1:2 11 6 4 3 5 4 4 2 4;}
					@font-face
						{font-family:Verdana;
						panose-1:2 11 6 4 3 5 4 4 2 4;}
					 /* Style Definitions */
					 p.MsoNormal, li.MsoNormal, div.MsoNormal
						{margin:0cm;
						margin-bottom:.0001pt;
						font-size:12.0pt;
						font-family:\"Times New Roman\",\"serif\";}
					a:link, span.MsoHyperlink
						{color:#650696;
						text-decoration:underline;}
					a:visited, span.MsoHyperlinkFollowed
						{color:#650696;
						text-decoration:underline;}
					p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
						{mso-style-link:\"Texte de bulles Car\";
						margin:0cm;
						margin-bottom:.0001pt;
						font-size:8.0pt;
						font-family:\"Tahoma\",\"sans-serif\";}
					span.TextedebullesCar
						{mso-style-name:\"Texte de bulles Car\";
						mso-style-link:\"Texte de bulles\";
						font-family:\"Tahoma\",\"sans-serif\";}
					p.msochpdefault, li.msochpdefault, div.msochpdefault
						{mso-style-name:msochpdefault;
						margin-right:0cm;
						margin-left:0cm;
						font-size:10.0pt;
						font-family:\"Times New Roman\",\"serif\";}
					.MsoChpDefault
						{font-size:10.0pt;}
					@page Section1
						{size:595.3pt 841.9pt;
						margin:70.85pt 70.85pt 70.85pt 70.85pt;}
					div.Section1
						{page:Section1;}
					-->
					</style>
					
					<link rel=\"important stylesheet\" href=\"chrome://messenger/skin/messageBody.css\">
					</head>
					
					<body lang=FR link=\"#650696\" vlink=\"#650696\" bottomMargin=0 alink=\"#650696\"
					leftmargin=0 topmargin=0 rightMargin=0 marginheight=0 marginwidth=0>
					
					<div class=Section1>
					
					<div align=center>
					
					<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=499
					 style='width:374.1pt'>
					 <tr>
					  <td valign=top style='background:#650696;padding:.75pt .75pt .75pt .75pt'>
					  <div align=center>
					  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=547
					   style='width:410.1pt;background:white'>
					   <tr>
					    <td width=546 colspan=2 style='width:409.5pt;padding:0cm 0cm 0cm 0cm'>
					    <p class=MsoNormal><a href=\"http://zaibe.ath.cx/image001.gif\"><span
					    style='color:windowtext;text-decoration:none'><img border=0 width=544
					    height=71 src=http://zaibe.ath.cx/image001.gif alt=\"\"></span></a></p>
					    </td>
					    <td style='padding:0cm 0cm 0cm 0cm'></td>
					    <td style='padding:0cm 0cm 0cm 0cm'></td>
					   </tr>
					   <tr>
					    <td width=7 style='width:4.9pt;padding:0cm 0cm 0cm 0cm'></td>
					    <td valign=top style='padding:0cm 0cm 0cm 0cm'>
					    <div align=center>
					    <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=430
					     style='width:322.3pt;margin-left:6.8pt'>
					     <tr>
					      <td width=430 valign=top style='width:322.3pt;padding:0cm 0cm 0cm 0cm'>
					      <p class=MsoNormal><span style='font-size:10.0pt;font-family:\"Verdana\",\"sans-serif\";
					      color:#650696'>";

					if($type_user==1)
					{
						$contenu.="UN CLIENT A REPONDU A VOTRE ANNONCE !";		
					}
					else
					{						
						$contenu.="VOUS AVEZ ACCEPTE L'OFFRE DU TRANSPORTEUR";
					}


					$contenu.="</span></p>
					      </td>
					     </tr>
					     <tr style='height:3.75pt'>
					      <td width=430 style='width:322.3pt;padding:0cm 0cm 0cm 0cm;height:3.75pt'></td>
					     </tr>
					     <tr>
					      <td width=430 style='width:322.3pt;padding:0cm 0cm 0cm 0cm'>
					      <p class=MsoNormal><a href=\"http://zaibe.ath.cx/image002.gif\"><span
					      style='color:windowtext;text-decoration:none'><img border=0 width=442
					      height=1 src=http://zaibe.ath.cx/image002.gif
					      alt=\"\"></span></a></p>
					      </td>
					     </tr>
					     <tr style='height:15.0pt'>
					      <td width=430 style='width:322.3pt;padding:0cm 0cm 0cm 0cm;height:15.0pt'></td>
					     </tr>
					     <tr>
					      <td width=430 valign=top style='width:322.3pt;padding:0cm 0cm 0cm 0cm'>
					      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>";


					if($type_user==1)
					{
						$contenu.="Cher(ére) Transporteur";
						$contenu.=" <br>
      							Un voyageur a accepté votre annonce au tarif de </span><b><span
      							style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";color:red'>".$info_transporteur[0]->get("tarifttc")."€</span></b></p>";
					}
					else
					{						
						$contenu.="Cher(ére) Client";
						$contenu.="<br>
      							Vous avez accepté l'annonce du transporteur au tarif de </span><b><span
      							style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";color:red'>".$info_transporteur[0]->get("tarifttc")."€</span></b></p>";
				
					}
					
					$contenu.=" <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>Ce mail a pour but de vous mettre en relation afin que vous
					      puissiez prendre contact.</span></p>
					      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\"'>&nbsp;</span></p>
					      <p class=MsoNormal><b><span style='font-size:8.0pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>";
					      
				   	if($type_user==1)
					{
						$contenu.="Récapitulatif de la demande du voyageur&nbsp;:</span></b></p>";
					}
					else
					{
						$contenu.="Récapitulatif de votre demande&nbsp;:</span></b></p>";
					}
					
					$contenu.="<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
					       width=435 style='width:326.25pt'>
					       <tr>
					        <td style='background:#650696;padding:.75pt .75pt .75pt .75pt'>
					        <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
					         width=433 style='width:324.75pt;background:#FEF4E9'>
					         <tr>
					          <td width=433 style='width:324.75pt;padding:0cm 0cm 0cm 0cm'>
					          <div align=center>
					          <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
					           width=\"100%\" style='width:100.0%'>
					           <tr style='height:1.0pt'>
					            <td width=\"100%\" style='width:100.0%;padding:0cm 0cm 0cm 0cm;
					            height:1.0pt'>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					            color:black'>Type de transport&nbsp;: ".$info_client[0]->get("typetransport")."</span></p>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					            color:black'>Etapes&nbsp;: ";
					
								foreach($etapes as $etape)
								{
									
									$contenu.=$etape->get("ville")."&nbsp;";
								}
						
						$contenu .= "</span></p>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";";
					            
					            if($info_client[0]->get("aller_retour"))
					            {
					            	/*
					            	 * Voyager aller
					            	 */
					            	$contenu.="color:black'>Date de départ aller&nbsp;: ".$info_client[0]->get("datedepart")." à ".$info_client->get("heuredepart")."</span></p>
							            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
							            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
							            color:black'>Date d'arrivée aller&nbsp;: ".$info_client[0]->get("datearrive")." à ".$info_client->get("heurearrive")."</span></p>
							            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
							            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";";
					           		/*
					           		 * Voyage retour
					           		 */
					           		$contenu.="color:black'>Date de départ retour&nbsp;: ".$info_client[0]->get("datedepartR")." à ".$info_client[0]->get("heuredepartR")."</span></p>
							            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
							            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
							            color:black'>Date d'arrivée retour&nbsp;: ".$info_client[0]->get("datearriveR")." à ".$info_client[0]->get("heurearriveR")."</span></p>
							            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
							            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";";
					           
					            }
					            else
					            {
					            	$contenu.="color:black'>Date de départ aller&nbsp;: ".$info_client[0]->get("datedepart")." à ".$info_client[0]->get("heuredepart")."</span></p>
							            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
							            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
							            color:black'>Date d'arrivée aller&nbsp;: ".$info_client[0]->get("datearrive")." à ".$info_client[0]->get("heurearrive")."</span></p>
							            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
							            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";";	
					            }
								
								
							  $contenu.=" color:black'>Kilométrage &nbsp;: ".$info_client[0]->get("kilometragealler")."</span></p>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					            color:black'>Type car&nbsp;: Excursion</span></p>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					            color:black'>Capacité nécessaire&nbsp;: ".$info_client[0]->get("capacitenecessaire")."</span></p>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					            color:black'>Nombre de bus&nbsp;: ".$info_client[0]->get("nbrbus")."</span></p>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					            color:black'>Places par bus&nbsp;: ".$info_client[0]->get("placesparbus")."</span></p>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					            color:black'>Repas non pris en charge&nbsp;: ".$info_client[0]->get("nbrrepastotal")."</span></p>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					            color:black'>Nuit(s) non prise(s) en charges&nbsp;: ".$info_client[0]->get("nbrnuittotal")."</span></p>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					            color:black'>Informations complémentaires&nbsp;: ".$info_client[0]->get("dcommentaires")."</span></p>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'>&nbsp;</p>
					            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
					            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					            color:black'>Tarif &nbsp;: ".$info_client[0]->get("tarifadopte")."€</span></p>
					            </td>
					           </tr>
					          </table>
					          </div>
					          </td>
					         </tr>
					        </table>
					        </td>
					       </tr>
					      </table>
					      <p class=MsoNormal><b><span style='font-size:8.0pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>&nbsp;</span></b><span style='font-size:7.5pt;font-family:
					      \"Verdana\",\"sans-serif\";color:black'>&nbsp;</span></p>
					      <p class=MsoNormal><b><span style='font-size:8.0pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>";
					
					
				  if($type_user==1)
					{
						
						$contenu.="Coordonnées du client&nbsp;:</span></b></p>";
						$contenu.=" </td>
						     </tr>
						     <tr style='height:56.2pt'>
						      <td width=430 valign=top style='width:322.3pt;padding:0cm 0cm 0cm 0cm;
						      height:56.2pt'>
						      <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						       width=435 style='width:326.25pt'>
						       <tr style='height:56.05pt'>
						        <td style='background:#650696;padding:.75pt .75pt .75pt .75pt;
						        height:56.05pt'>
						        <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						         width=433 style='width:324.75pt;background:#FEF4E9'>
						         <tr>
						          <td width=433 style='width:324.75pt;padding:0cm 0cm 0cm 0cm'>
						          <div align=center>
						          <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						           width=\"100%\" style='width:100.0%'>
						           <tr style='height:2.0cm'>
						            <td width=\"100%\" valign=top style='width:100.0%;padding:0cm 0cm 0cm 0cm;
						            height:2.0cm'>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";	
									 color:black'>Nom du client&nbsp;: ".$info_client[0]->get("nomclient")."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Mail du client&nbsp;: ".$info_client[0]->get("mail")."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Téléphone fixe&nbsp;: ".$info_client[0]->get("telephone")."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Téléphone portable&nbsp;: ".$info_client[0]->get("portable")."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Fax&nbsp;: ".$info_client[0]->get("fax")."</span></p>";
					}
					else
					{
						$contenu.="Coordonnées du transporteur&nbsp;:</span></b></p>";
						$contenu.=" </td>
						     </tr>
						     <tr style='height:56.2pt'>
						      <td width=430 valign=top style='width:322.3pt;padding:0cm 0cm 0cm 0cm;
						      height:56.2pt'>
						      <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						       width=435 style='width:326.25pt'>
						       <tr style='height:56.05pt'>
						        <td style='background:#650696;padding:.75pt .75pt .75pt .75pt;
						        height:56.05pt'>
						        <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						         width=433 style='width:324.75pt;background:#FEF4E9'>
						         <tr>
						          <td width=433 style='width:324.75pt;padding:0cm 0cm 0cm 0cm'>
						          <div align=center>
						          <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						           width=\"100%\" style='width:100.0%'>
						           <tr style='height:2.0cm'>
						            <td width=\"100%\" valign=top style='width:100.0%;padding:0cm 0cm 0cm 0cm;
						            height:2.0cm'>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";	
									 color:black'>Nom du voyageur&nbsp;: ".$info_transporteur[0]->get("nomclient")."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Mail du voyageur&nbsp;: ".$info_transporteur[0]->get("mail")."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Téléphone fixe&nbsp;: ".$info_transporteur[0]->get("telephone")."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Téléphone portable&nbsp;: ".$info_transporteur[0]->get("portable")."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Fax&nbsp;: ".$info_transporteur[0]->get("fax")."</span></p>";
						           
						
					}
					
					$contenu.= "</td>
						           </tr>
						          </table>
						          </div>
						          </td>
						         </tr>
						        </table>
						        </td>
						       </tr>
						      </table>
						      </td>
						     </tr>
						     <tr>
						      <td width=430 valign=top style='width:322.3pt;padding:0cm 0cm 0cm 0cm'>
						      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						      color:black'>&nbsp;</span></p>
						      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						      color:black'>Vous pouvez dés à présent prendre contact avec lui afin de
						      confirmer ses informations.<br>
						      Bon voyage,<br>
						      <br>
						      L'Equipe Waydev</span></p>
						      </td>
						     </tr>
						     <tr style='height:11.25pt'>
						      <td width=430 style='width:322.3pt;padding:0cm 0cm 0cm 0cm;height:11.25pt'></td>
						     </tr>
						    </table>
						    </div>
						    </td>
						    <td style='padding:0cm 0cm 0cm 0cm'></td>
						    <td style='padding:0cm 0cm 0cm 0cm'></td>
						   </tr>
						   <tr>
						    <td width=7 style='width:4.9pt;padding:0cm 0cm 0cm 0cm'></td>
						    <td width=539 style='width:404.6pt;padding:0cm 0cm 0cm 0cm'></td>
						    <td width=0 style='width:.3pt;padding:0cm 0cm 0cm 0cm'></td>
						    <td width=0 style='width:.3pt;padding:0cm 0cm 0cm 0cm'></td>
						   </tr>
						  </table>
						  </div>
						  </td>
						 </tr>
						</table>
						
						</div>
						
						<p class=MsoNormal>&nbsp;</p>
						
						</div>
						
						</body>
						
						</html>";
					

			return $contenu;		
				
					
						}
						
						
		
	public static function ContenuMailReponseTransporteur($info_client,$info_transporteur,$etape) {
		
	

		$contenu = "<html>
					
					<head>
					<meta http-equiv=Content-Type content=\"text/html; charset=UTF-8\">
					<meta name=Generator content=\"Microsoft Word 12 (filtered)\">
					<title>Waydev Mail</title>
					<style>
					<!--
					 /* Font Definitions */
					 @font-face
						{font-family:\"Cambria Math\";
						panose-1:2 4 5 3 5 4 6 3 2 4;}
					@font-face
						{font-family:Tahoma;
						panose-1:2 11 6 4 3 5 4 4 2 4;}
					@font-face
						{font-family:Verdana;
						panose-1:2 11 6 4 3 5 4 4 2 4;}
					 /* Style Definitions */
					 p.MsoNormal, li.MsoNormal, div.MsoNormal
						{margin:0cm;
						margin-bottom:.0001pt;
						font-size:12.0pt;
						font-family:\"Times New Roman\",\"serif\";}
					a:link, span.MsoHyperlink
						{color:#650696;
						text-decoration:underline;}
					a:visited, span.MsoHyperlinkFollowed
						{color:#650696;
						text-decoration:underline;}
					p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
						{mso-style-link:\"Texte de bulles Car\";
						margin:0cm;
						margin-bottom:.0001pt;
						font-size:8.0pt;
						font-family:\"Tahoma\",\"sans-serif\";}
					span.TextedebullesCar
						{mso-style-name:\"Texte de bulles Car\";
						mso-style-link:\"Texte de bulles\";
						font-family:\"Tahoma\",\"sans-serif\";}
					p.msochpdefault, li.msochpdefault, div.msochpdefault
						{mso-style-name:msochpdefault;
						margin-right:0cm;
						margin-left:0cm;
						font-size:10.0pt;
						font-family:\"Times New Roman\",\"serif\";}
					.MsoChpDefault
						{font-size:10.0pt;}
					@page Section1
						{size:595.3pt 841.9pt;
						margin:70.85pt 70.85pt 70.85pt 70.85pt;}
					div.Section1
						{page:Section1;}
					-->
					</style>
					
					<link rel=\"important stylesheet\" href=\"chrome://messenger/skin/messageBody.css\">
					</head>
					
					<body lang=FR link=\"#650696\" vlink=\"#650696\" bottomMargin=0 alink=\"#650696\"
					leftmargin=0 topmargin=0 rightMargin=0 marginheight=0 marginwidth=0>
					
					<div class=Section1>
					
					<div align=center>
					
					<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=499
					 style='width:374.1pt'>
					 <tr>
					  <td valign=top style='background:#650696;padding:.75pt .75pt .75pt .75pt'>
					  <div align=center>
					  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=547
					   style='width:410.1pt;background:white'>
					   <tr>
					    <td width=546 colspan=2 style='width:409.5pt;padding:0cm 0cm 0cm 0cm'>
					    <p class=MsoNormal><a href=\"http://zaibe.ath.cx/image001.gif\"><span
					    style='color:windowtext;text-decoration:none'><img border=0 width=544
					    height=71 src=\"http://zaibe.ath.cx/image001.gif\" alt=\"header_mail2.gif\"></span></a></p>
					    </td>
					    <td style='padding:0cm 0cm 0cm 0cm'></td>
					    <td style='padding:0cm 0cm 0cm 0cm'></td>
					   </tr>
					   <tr>
					    <td width=7 style='width:4.9pt;padding:0cm 0cm 0cm 0cm'></td>
					    <td valign=top style='padding:0cm 0cm 0cm 0cm'>
					    <div align=center>
					    <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=430
					     style='width:322.3pt;margin-left:6.8pt'>
					     <tr>
					      <td width=430 valign=top style='width:322.3pt;padding:0cm 0cm 0cm 0cm'>
					      <p class=MsoNormal><span style='font-size:10.0pt;font-family:\"Verdana\",\"sans-serif\";
					      color:#650696'>UN TRANSPORTEUR A REPONDU A VOTRE ANNONCE&nbsp;!</span></p>
					      </td>
					     </tr>
					     <tr style='height:3.75pt'>
					      <td width=430 style='width:322.3pt;padding:0cm 0cm 0cm 0cm;height:3.75pt'></td>
					     </tr>
					     <tr>
					      <td width=430 style='width:322.3pt;padding:0cm 0cm 0cm 0cm'>
					      <p class=MsoNormal><a href=\"http://zaibe.ath.cx/image002.gif\"><span
					      style='color:windowtext;text-decoration:none'><img border=0 width=442
					      height=1 src=\"http://zaibe.ath.cx/image002.gif\"
					      alt=\"http://zaibe.ath.cx/image002.gif\"></span></a></p>
					      </td>
					     </tr>
					     <tr style='height:15.0pt'>
					      <td width=430 style='width:322.3pt;padding:0cm 0cm 0cm 0cm;height:15.0pt'></td>
					     </tr>
					     <tr>
					      <td width=430 valign=top style='width:322.3pt;padding:0cm 0cm 0cm 0cm'>
					      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
					      color:black'>Cher(ére) Client, <br>
					      <br>
					      Un transporteur a répondu à votre annonce n°". $info_transporteur["iddemandetr"] ." au tarif de  </span><b><span
					      style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";color:red'>". $info_transporteur["tarifttc"] ."€</span></b></p>
						
							<p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\"'>&nbsp;</span></p>
						      <p class=MsoNormal><b><span style='font-size:8.0pt;font-family:\"Verdana\",\"sans-serif\";
						      color:black'>Récapitulatif de votre demande :</span></b></p>
						      <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						       width=435 style='width:326.25pt'>
						
						       <tr>
						        <td style='background:#650696;padding:.75pt .75pt .75pt .75pt'>
						        <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						         width=433 style='width:324.75pt;background:#FEF4E9'>
						         <tr>
						          <td width=433 style='width:324.75pt;padding:0cm 0cm 0cm 0cm'>
						          <div align=center>
						          <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						           width=\"100%\" style='width:100.0%'>
						           <tr style='height:1.0pt'>
						            <td width=\"100%\" style='width:100.0%;padding:0cm 0cm 0cm 0cm;
						            height:1.0pt'>
						
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Type de transport&nbsp;: ". $info_client["infos"]["typetransport"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Etapes&nbsp;: ";
						            
						           foreach($etape as $key)
									{
									  $contenu.= $key->get("ville")."&nbsp;&nbsp;";							
									}
						            $contenu.="</span></p>";
						           

								$contenu.= "	 <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Date de départ&nbsp;: ". $info_client["infos"]["datedepart"] ." à ". $info_client["infos"]["heuredepart"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Date d'arrivée&nbsp;: ". $info_client["infos"]["datearrive"] ." à ". $info_client["infos"]["heurearrive"] ."</span></p>";
						           
									if(($info_client["infos"]["typetrajet"]=="aller_retour") && ($info_client["infos"]["typetransport"]=="transfert"))
									{
							  
							  $contenu.= "<p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Date de départ voyage retour &nbsp;: ". $info_client["infos"]["datedepartR"] ." à ". $info_client["infos"]["heuredepartR"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Date d'arrivée voyage retour &nbsp;: ". $info_client["infos"]["datearriveR"] ." à ". $info_client["infos"]["heurearriveR"] ."</span></p>
									<p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Kilométrage aller&nbsp;:". $info_client["infos"]["kilometragealler"] ."km</span></p>";
									}
							  $contenu.= "<p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Kilométrage &nbsp;: ". $info_client["infos"]["kilometragealler"] ."km</span></p>
						
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Type car&nbsp;: ". $info_client["infos"]["typecar"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Capacité nécessaire&nbsp;: ". $info_client["infos"]["capacitenecessaire"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Nombre de bus&nbsp;: ". $info_client["infos"]["nbrbus"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Places par bus&nbsp;: ". $info_client["infos"]["placesparbus"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Repas non pris en charge&nbsp;: ". $info_client["infos"]["nbrrepastotal"] ."</span></p>
						
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Nuit(s) non prise(s) en charges&nbsp;:". $info_client["infos"]["nbrnuittotal"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Informations complémentaires&nbsp;: ". $info_client["infos"]["dcommentaires"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'>&nbsp;</p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Votre tarif&nbsp;: ". $info_client["infos"]["tarifadopte"] ."€</span></p>
						            </td>
						           </tr>
						
						          </table>
						          </div>
						          </td>
						         </tr>
						        </table>
						        </td>
						       </tr>
						      </table>
						      <p class=MsoNormal><b><span style='font-size:8.0pt;font-family:\"Verdana\",\"sans-serif\";
						      color:black'>&nbsp;</span></b><span style='font-size:7.5pt;font-family:
						      \"Verdana\",\"sans-serif\";color:black'>&nbsp;</span></p>
						
						      <p class=MsoNormal><b><span style='font-size:8.0pt;font-family:\"Verdana\",\"sans-serif\";
						      color:black'>Réponse du transporteur&nbsp;:</span></b></p>
						      </td>
						     </tr>
						     <tr style='height:56.2pt'>
						      <td width=430 valign=top style='width:322.3pt;padding:0cm 0cm 0cm 0cm;
						      height:56.2pt'>
						      <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						       width=435 style='width:326.25pt'>
						       <tr style='height:56.05pt'>
						        <td style='background:#650696;padding:.75pt .75pt .75pt .75pt;
						        height:56.05pt'>
						
						        <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						         width=433 style='width:324.75pt;background:#FEF4E9'>
						         <tr>
						          <td width=433 style='width:324.75pt;padding:0cm 0cm 0cm 0cm'>
						          <div align=center>
						          <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						           width=\"100%\" style='width:100.0%'>
						           <tr style='height:2.0cm'>
						            <td width=\"100%\" valign=top style='width:100.0%;padding:0cm 0cm 0cm 0cm;
						            height:2.0cm'>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Nombre de bus&nbsp;: ". $info_transporteur["nbrcar"] ."</span></p>
						
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Places par bus&nbsp;:  ". $info_transporteur["capacitecar"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Equipement(s) particulier(s)&nbsp;:  ". $info_transporteur["equipement"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Informations complémentaires&nbsp;:  ". $info_transporteur["rcommentaires"] ."</span></p>
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'>&nbsp;</p>
						
						            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
						            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:black'>Tarif du transporteur&nbsp;: </span><b><span
						            style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						            color:red'> ". $info_transporteur["tarifttc"] ."€</span></b></p>
						            </td>
						           </tr>
						          </table>
						          </div>
						          </td>
						         </tr>
						
						        </table>
						        </td>
						       </tr>
						      </table>
						      </td>
						     </tr>
						     <tr>
						      <td width=430 valign=top style='width:322.3pt;padding:0cm 0cm 0cm 0cm'>
						      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						      color:black'>&nbsp;</span></p>
						
						      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
						      color:black'>votre compte a été mis à jour, aller vérifier sur : http://zaibe.ath.cx/chartercar/<br>
						      <br>
						      L'Equipe Waydev</span></p>
						      </td>
						     </tr>
						     <tr style='height:11.25pt'>
						      <td width=430 style='width:322.3pt;padding:0cm 0cm 0cm 0cm;height:11.25pt'></td>
						     </tr>
						
						    </table>
						    </div>
						    </td>
						    <td style='padding:0cm 0cm 0cm 0cm'></td>
						    <td style='padding:0cm 0cm 0cm 0cm'></td>
						   </tr>
						   <tr>
						    <td width=7 style='width:4.9pt;padding:0cm 0cm 0cm 0cm'></td>
						    <td width=539 style='width:404.6pt;padding:0cm 0cm 0cm 0cm'></td>
						
						    <td width=0 style='width:.3pt;padding:0cm 0cm 0cm 0cm'></td>
						    <td width=0 style='width:.3pt;padding:0cm 0cm 0cm 0cm'></td>
						   </tr>
						  </table>
						  </div>
						  </td>
						 </tr>
						</table>
						
						</div>
						
						<p class=MsoNormal>&nbsp;</p>
						
						</div>
						
						</body>
						
						</html>";



		return $contenu;
		
		
	}				
						
						
	public static function ContenuMailModificationAnnonceTransporteur($info_transporteur) {
		
		$contenu =
		"<html>

				<head>
				<meta http-equiv=Content-Type content=\"text/html; charset=UTF-8\">
				<meta name=Generator content=\"Microsoft Word 12 (filtered)\">
				<title>Waydev Mail</title>
				<style>
				<!--
				 /* Font Definitions */
				 @font-face
					{font-family:\"Cambria Math\";
					panose-1:2 4 5 3 5 4 6 3 2 4;}
				@font-face
					{font-family:Tahoma;
					panose-1:2 11 6 4 3 5 4 4 2 4;}
				@font-face
					{font-family:Verdana;
					panose-1:2 11 6 4 3 5 4 4 2 4;}
				 /* Style Definitions */
				 p.MsoNormal, li.MsoNormal, div.MsoNormal
					{margin:0cm;
					margin-bottom:.0001pt;
					font-size:12.0pt;
					font-family:\"Times New Roman\",\"serif\";}
				a:link, span.MsoHyperlink
					{color:#650696;
					text-decoration:underline;}
				a:visited, span.MsoHyperlinkFollowed
					{color:#650696;
					text-decoration:underline;}
				p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
					{mso-style-link:\"Texte de bulles Car\";
					margin:0cm;
					margin-bottom:.0001pt;
					font-size:8.0pt;
					font-family:\"Tahoma\",\"sans-serif\";}
				span.TextedebullesCar
					{mso-style-name:\"Texte de bulles Car\";
					mso-style-link:\"Texte de bulles\";
					font-family:\"Tahoma\",\"sans-serif\";}
				p.msochpdefault, li.msochpdefault, div.msochpdefault
					{mso-style-name:msochpdefault;
					margin-right:0cm;
					margin-left:0cm;
					font-size:10.0pt;
					font-family:\"Times New Roman\",\"serif\";}
				.MsoChpDefault
					{font-size:10.0pt;}
				@page Section1
					{size:595.3pt 841.9pt;
					margin:70.85pt 70.85pt 70.85pt 70.85pt;}
				div.Section1
					{page:Section1;}
				-->
				</style>
				
				<link rel=\"important stylesheet\" href=\"chrome://messenger/skin/messageBody.css\">
				</head>
				
				<body lang=FR link=\"#650696\" vlink=\"#650696\" bottomMargin=0 alink=\"#650696\"
				leftmargin=0 topmargin=0 rightMargin=0 marginheight=0 marginwidth=0>
				
				<div class=Section1>
				
				<div align=center>
				
				<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=499
				 style='width:374.1pt'>
				 <tr>
				  <td valign=top style='background:#650696;padding:.75pt .75pt .75pt .75pt'>
				  <div align=center>
				  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
				   style='background:white'>
				   <tr>
				    <td colspan=2 style='padding:0cm 0cm 0cm 0cm'>
				    <p class=MsoNormal><a href=\"http://zaibe.ath.cx/image001.gif\"><span
				    style='color:windowtext;text-decoration:none'><img border=0 width=548
				    height=71 src=\"http://zaibe.ath.cx/image001.gif\" alt=\"header_mail2.gif\"></span></a></p>
				    </td>
				    <td style='padding:0cm 0cm 0cm 0cm'></td>
				    <td style='padding:0cm 0cm 0cm 0cm'></td>
				   </tr>
				   <tr>
				    <td style='padding:0cm 0cm 0cm 0cm'></td>
				    <td valign=top style='padding:0cm 0cm 0cm 0cm'>
				    <div align=center>
				    <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=444
				     style='width:333.0pt;margin-left:6.8pt'>
				     <tr>
				      <td width=444 valign=top style='width:333.0pt;padding:0cm 0cm 0cm 0cm'>
				      <p class=MsoNormal><span style='font-size:10.0pt;font-family:\"Verdana\",\"sans-serif\";
				      color:#650696'>UN TRANSPORTEUR A MODIFIE SON ANNONCE!</span></p>
				      </td>
				     </tr>
				     <tr style='height:3.75pt'>
				      <td width=444 style='width:333.0pt;padding:0cm 0cm 0cm 0cm;height:3.75pt'></td>
				     </tr>
				     <tr>
				      <td width=444 style='width:333.0pt;padding:0cm 0cm 0cm 0cm'>
				      <p class=MsoNormal><a href=\"http://zaibe.ath.cx/image002.gif\"><span
				      style='color:windowtext;text-decoration:none'><img border=0 width=442
				      height=1 src=\"http://zaibe.ath.cx/image002.gif\"
				      alt=\"http://zaibe.ath.cx/image002.gif\"></span></a></p>
				      </td>
				     </tr>
				     <tr style='height:15.0pt'>
				      <td width=444 style='width:333.0pt;padding:0cm 0cm 0cm 0cm;height:15.0pt'></td>
				     </tr>
				     <tr>
				      <td width=444 valign=top style='width:333.0pt;padding:0cm 0cm 0cm 0cm'>
				      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				      color:black'>&nbsp;</span></p>
				      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				      color:black'>Un transporteur a modifié son annonce, voici sa nouvelle
				      annonce</span></p>
				      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				      color:black'>&nbsp;</span></p>
				      <p class=MsoNormal><b><span style='font-size:8.0pt;font-family:\"Verdana\",\"sans-serif\";
				      color:black'>Annonce du transporteur&nbsp;:</span></b></p>
				      <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
				       width=435 style='width:326.25pt'>
				       <tr>
				        <td style='background:#650696;padding:.75pt .75pt .75pt .75pt'>
				        <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
				         width=433 style='width:324.75pt;background:#FEF4E9'>
				         <tr>
				          <td width=433 style='width:324.75pt;padding:0cm 0cm 0cm 0cm'>
				          <div align=center>
				          <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
				           width=\"100%\" style='width:100.0%'>
				           <tr style='height:1.0pt'>
				            <td width=\"100%\" style='width:100.0%;padding:0cm 0cm 0cm 0cm;
				            height:1.0pt'>
				            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
				            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				            color:black'>Nombre de bus&nbsp;: ". $info_transporteur["nbrcar"] ."</span></p>
				            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
				            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				            color:black'>Places par bus&nbsp;: ". $info_transporteur["capacitecar"] ."</span></p>
				            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
				            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				            color:black'>Equipement(s) particulier(s)&nbsp;: ". $info_transporteur["equipement"] ."</span></p>
				            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
				            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				            color:black'>Condition de paiement&nbsp;: ". $info_transporteur["conditions"] ."</span></p>
				            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
				            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				            color:black'>Informations complémentaires&nbsp;: ". $info_transporteur["rcommentaires"] ."</span></p>
				            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
				            text-indent:-.6pt'>&nbsp;</p>
				            <p class=MsoNormal style='margin-left:9.35pt;text-align:justify;
				            text-indent:-.6pt'><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				            color:black'>Tarif du transporteur&nbsp;: </span><b><span
				            style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				            color:red'>". $info_transporteur["tarifttc"] ."€</span></b></p>
				            </td>
				           </tr>
				          </table>
				          </div>
				          </td>
				         </tr>
				        </table>
				        </td>
				       </tr>
				      </table>
				      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				      color:black'>&nbsp;</span></p>
				      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				      color:black'>&nbsp;</span></p>
				      <p class=MsoNormal><span style='font-size:7.5pt;font-family:\"Verdana\",\"sans-serif\";
				      color:black'>Bonne journée<br>
				      <br>
				      L'Equipe Waydev</span></p>
				      </td>
				     </tr>
				     <tr style='height:11.25pt'>
				      <td width=444 style='width:333.0pt;padding:0cm 0cm 0cm 0cm;height:11.25pt'></td>
				     </tr>
				    </table>
				    </div>
				    </td>
				    <td colspan=2 style='padding:0cm 0cm 0cm 0cm'></td>
				    <td style='padding:0cm 0cm 0cm 0cm'></td>
				   </tr>
				   <tr>
				    <td style='padding:0cm 0cm 0cm 0cm'></td>
				    <td style='padding:0cm 0cm 0cm 0cm'></td>
				    <td colspan=2 style='padding:0cm 0cm 0cm 0cm'></td>
				    <td style='padding:0cm 0cm 0cm 0cm'></td>
				   </tr>
				  </table>
				  </div>
				  </td>
				 </tr>
				</table>
				
				</div>
				
				<p class=MsoNormal>&nbsp;</p>
				
				</div>
				
				</body>
				
				</html>";

return $contenu;
		
	}
	
	
}
						



			
						
?>
