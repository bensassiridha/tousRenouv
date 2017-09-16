<?php
require('mysql.php');$my=new mysql();


include('inc/head.php');?>
	<body id="page1">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
<?php include('inc/galerie2.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
				<section id="content">
					<div class="wrapper">
						<article class="col-1">
							<div class="indent-left">
								<h2>Prix travaux</h2>



<style>
ul#menu_cat li {
	cursor:pointer;
	float:left;
	height:80px;
	min-width:72px;
	text-align:center;
	margin:0 1px 0 0;
	line-height:20px;
	width:100px;
	padding-left:1px;
	padding-right:1px;
	 -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
	margin-bottom:10px;
	font-size:12px;
}
ul#menu_cat li img{ margin-top:10px; height:30px;}
.classLiScat {
     cursor:pointer;
	float:left;
	height:80px;
	min-width:100px;
	text-align:center;
	margin:0 1px 0 0;
	line-height:20px;
	 -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
	font-size:12px;
	padding-left:1px;
	padding-right:1px;
}
.classLiScat img{ margin-top:10px; height:30px;}
</style>


<script src="panier.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	/*$(".class_cat").click(function () 
	{
		
	});*/
	
});
function affichSoucat(idC)
{
	$("[id^='li_cat_']").css("background","#F6A20E");
	$("#li_cat_"+idC+"").css("background","#0495CB");
	
	$("[id^='menu_scat_quest_']").css("display","none");
	if ( $("#menu_scat_quest_"+idC+"").html() ) 
	{
		$("#menu_scat_quest_"+idC+"").css("display","block");
	}
	else
	{
		$.ajax({
			 type: "post",
			 url: "Ajax.php",
			 data: "idCat="+idC+"&prix=affichScat",
			 success: function(msg)
				{	
					if (msg)
					{
						$("#menu_scat_quest").append(msg);
					}					 
				}
		});
	}
}
function affichQuest(idC,idSC)
{
	$("[id^='li_scat_"+idC+"']").css("background","#F6A20E");
	$("#li_scat_"+idC+"_"+idSC+"").css("background","#0495CB");

	$("[id^='question_"+idC+"_']").css("display","none");
	if ( $("#question_"+idC+"_"+idSC+"").html() ) 
	{
		$("#question_"+idC+"_"+idSC+"").css("display","block");
	}
	else
	{
		$.ajax({
			 type: "post",
			 url: "Ajax.php",
			 data: "idCat="+idC+"&idSCat="+idSC+"&prix=affichQuest",
			 success: function(msg)
				{	
					if (msg)
					{
						$("#menu_scat_quest_"+idC+"").append(msg);
					}					 
				}
		});
	}
}
function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script>




<?php 
$CatID=0;$ScatID=0;
$reqCat=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY id ASC');$liCat='';$liste_tbody='';
if ( $my->num($reqCat)>0 )
{
	$i=1;
	while ( $resCat=$my->arr($reqCat) )
	{
		$style='style="background:#F6A20E;color:#fff;"';
		if ( isset($_GET['id']) )
		{
			$CatID=$_GET['id'];
			if ( $_GET['id']==$resCat['id'] ) $style='style="background:#0495CB; "';
		}
		/*else 
		{
			if ( $i==1 ) { $style='style="background:#0495CB;color:#fff;"';$CatID=$resCat['id_categorie'];$i=2; }
		}*/
		$logo='';
		if ( $resCat['id']==1 ) $logo='<img src="catLogo/1.png" />';
		elseif ( $resCat['id']==2 ) $logo='<img src="catLogo/3.png" />';
		elseif ( $resCat['id']==3 ) $logo='<img src="catLogo/4.png" />';
		elseif ( $resCat['id']==4 ) $logo='<img src="catLogo/7.png" />';
		elseif ( $resCat['id']==5 ) $logo='<img src="catLogo/9.png" />';
		elseif ( $resCat['id']==6 ) $logo='<img src="catLogo/10.png" />';
		$liCat.='
			<li id="li_cat_'.$resCat['id'].'" onClick="affichSoucat('.$resCat['id'].')" '.$style.'">
				'.$logo.' <br /> '.$resCat['titre'].' 
			</li>';
		$liste_tbody.='<tbody id="panier_'.$resCat['id'].'" style="display:none;"></tbody>';
	}
}
$liScat='';
/*
$reqScat=$my->req('SELECT * FROM ttre_categories WHERE parent_categorie='.$CatID.' ORDER BY id_categorie ASC');
if ( $my->num($reqScat)>0 )
{
	$i=1;
	while ( $resScat=$my->arr($reqScat) )
	{
		$style='style="background:#F6A20E;color:#fff;"';
		if ( $i==1 ) { $style='style="background:#0495CB;color:#fff;"';$ScatID=$resScat['id_categorie'];$i=2; }
		$logo='';
		if ( $resScat['id_categorie']==35 ) $logo='<img src="scatLogo/1/mur.png" />';
		elseif ( $resScat['id_categorie']==36 ) $logo='<img src="scatLogo/1/porte.png" />';
		elseif ( $resScat['id_categorie']==37 ) $logo='<img src="scatLogo/1/dalle.png" />';
		elseif ( $resScat['id_categorie']==38 ) $logo='<img src="scatLogo/1/plancher.png" />';
		elseif ( $resScat['id_categorie']==39 ) $logo='<img src="scatLogo/1/terassement.png" />';
		elseif ( $resScat['id_categorie']==26 ) $logo='<img src="catLogo/3.png" />';
		elseif ( $resScat['id_categorie']==27 ) $logo='<img src="scatLogo/2/fenetre.png" />';
		elseif ( $resScat['id_categorie']==28 ) $logo='<img src="scatLogo/2/porte.png" />';
		elseif ( $resScat['id_categorie']==29 ) $logo='<img src="scatLogo/2/porte_fenetre.png" />';
		elseif ( $resScat['id_categorie']==30 ) $logo='<img src="scatLogo/2/escalier.png" />';
		elseif ( $resScat['id_categorie']==31 ) $logo='<img src="scatLogo/2/placard.png" />';
		elseif ( $resScat['id_categorie']==32 ) $logo='<img src="scatLogo/2/portail.png" />';
		elseif ( $resScat['id_categorie']==33 ) $logo='<img src="scatLogo/2/garage.png" />';
		elseif ( $resScat['id_categorie']==34 ) $logo='<img src="scatLogo/2/velux.png" />';
		elseif ( $resScat['id_categorie']==11 ) $logo='<img src="scatLogo/3/carrelage.png" />';
		elseif ( $resScat['id_categorie']==12 ) $logo='<img src="scatLogo/3/parquet.png" />';
		elseif ( $resScat['id_categorie']==13 ) $logo='<img src="scatLogo/3/dallage.png" />';
		elseif ( $resScat['id_categorie']==14 ) $logo='<img src="scatLogo/3/moquette.png" />';
		elseif ( $resScat['id_categorie']==15 ) $logo='<img src="scatLogo/3/chape.png" />';
		elseif ( $resScat['id_categorie']==7 ) $logo='<img src="scatLogo/4/peinture.png" />';
		elseif ( $resScat['id_categorie']==8 ) $logo='<img src="scatLogo/4/enduit.gif" />';
		elseif ( $resScat['id_categorie']==9 ) $logo='<img src="scatLogo/4/papier peint.png" />';
		elseif ( $resScat['id_categorie']==10 ) $logo='<img src="scatLogo/4/ravalement.png" />';
		elseif ( $resScat['id_categorie']==20 ) $logo='<img src="scatLogo/5/douche.png" />';
		elseif ( $resScat['id_categorie']==21 ) $logo='<img src="scatLogo/5/baignoire.png" />';
		elseif ( $resScat['id_categorie']==22 ) $logo='<img src="scatLogo/5/evier.png" />';
		elseif ( $resScat['id_categorie']==23 ) $logo='<img src="scatLogo/5/wc.png" />';
		elseif ( $resScat['id_categorie']==24 ) $logo='<img src="scatLogo/5/tuiyau.png" />';
		elseif ( $resScat['id_categorie']==25 ) $logo='<img src="scatLogo/5/Ballon.png" />';
		elseif ( $resScat['id_categorie']==16 ) $logo='<img src="catLogo/10.png" />';
		elseif ( $resScat['id_categorie']==17 ) $logo='<img src="scatLogo/6/prise.png" />';
		elseif ( $resScat['id_categorie']==18 ) $logo='<img src="scatLogo/6/Eclairage.png" />';
		elseif ( $resScat['id_categorie']==19 ) $logo='<img src="scatLogo/6/tableau.png" />';
		$liScat.='
			<li id="li_scat_'.$CatID.'_'.$resScat['id_categorie'].'" onClick="affichQuest('.$CatID.','.$resScat['id_categorie'].')" class="classLiScat" '.$style.'>
				'.$logo.' <br /> '.$resScat['titre_categorie'].'
			</li>';
	}
}
*/
$affichQ='';
/*
$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$ScatID.' ORDER BY id_question ASC ');
while ( $res=$my->arr($req) )
{
	if ( $res['id_question']!=8 )
	{
		$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
		if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$CatID.','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
		else 
		{
			$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$CatID.','.$res['id_question'].');" ><option value="0"></option>';
			$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
			while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
			$champ.='</select>';
		}
		$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
	}
}
*/
echo'
	<form method="POST" action="devis.php" />
		<ul id="menu_cat" style="height:55px;">'.$liCat.'</ul>
		<div style="clear:both;"></div>
		<div id="menu_scat_quest">
			<div id="menu_scat_quest_'.$CatID.'">
				<ul id="ul_scat_'.$CatID.'" style="height:55px;">'.$liScat.'</ul>
				<div style="clear:both;"></div>
				<div id="question_'.$CatID.'_'.$ScatID.'">'.$affichQ.'</div>
			</div>
		</div>
		<input style="display:none;" type="submit" id="ajout_prestation" name="ajout_prestation" value="Demandez des devis pour cette prestation" />
	</form>
	
	<div class="visibleQ" id="de">
		<table id="panier" summary="D" >
			<thead>
			  	<tr>
			     	<th rowspan="3" colspan="3">Total évaluation de devis <span class="fontReduced85 blueDialog">(<i>Ne remplace pas un vrai devis</i>)</span><br><br><span class="fontReduced85"> (*) : tva à 10% si locaux à usage d\'habitation achevés depuis plus de 2 ans</span></th>
			     	<th>Total TTC :</th>
			     	<th id="totalTTC" class="n">0.00</th>
			  	</tr>
			  	<tr>
			     	<th>TVA 20%(*) :</th>
			     	<th id="totalTVA" class="n">0.00</th>
			  	</tr>
			  	<tr>
			     	<th>Total HT :</th>
			     	<th id="totalHT" class="n">0.00</th>
			  	</tr>
		  	</thead>
		  	<tbody id="d">
		    	<tr style="height:10px;">
		    	 	<th id="des">Description</th>
		     		<th id="u">Unité</th>
				    <th id="q">Quantité</th>
				    <th id="puh">Prix unitaire HT</th>
				    <th id="ph">Prix HT</th>
		    	</tr>
		  	</tbody>	
		  	'.$liste_tbody.'
		</table>
	</div>
';
?>
<style>
#de {
    width: 100%;
}
#de table {
    border: 1px solid #000000;
    border-collapse: collapse;
    font-family: arial,sans-serif;
    width: 100%;
	font-size: 11px;
}
#de td, th {
    border-collapse: collapse;
    padding: 5px;
}
#de th {
    border: 1px solid #000000;
}
#de td {
    border-left: 1px solid #000000;
    padding-left: 20px;
}
#de thead th {
    background: none repeat scroll 0 0 #FFFFFF;
    padding: 1px 1px 1px 3px;
    text-align: left;
}
#de tbody th {
    background: none repeat scroll 0 0 #FFFFFF;
    font-size: 83%;
    padding: 2px 2px 2px 4px;
    text-align: left;
}
#de tbody tr.stot th {
    background: none repeat scroll 0 0 #F7EFDA;
    font-size: 100%;
    padding: 5px 5px 5px 14px;
}
#des {
    width: 215px;
}
#u, #q {
    width: 10px;
}
#puh {
    width: 10px;
}
#ph {
    width: 10px;
}
</style>

<!--<div class="visibleQ" id="de">-->
<!--	<table summary="D" >-->
<!--		<thead>-->
<!--		  	<tr>-->
<!--		     	<th rowspan="3" colspan="3">Total évaluation de devis <span class="fontReduced85 blueDialog">(<i>Ne remplace pas un vrai devis</i>)</span><br><br><span class="fontReduced85"> (*) : tva à 7% si locaux à usage d'habitation achevés depuis plus de 2 ans</span></th>-->
<!--		     	<th>Total TTC :</th>-->
<!--		     	<th id="totalTTC" class="n">0</th>-->
<!--		  	</tr>-->
<!--		  	<tr>-->
<!--		     	<th>TVA 19,6%(*) :</th>-->
<!--		     	<th id="totalTVA" class="n">0</th>-->
<!--		  	</tr>-->
<!--		  	<tr>-->
<!--		     	<th>Total HT :</th>-->
<!--		     	<th id="totalHT" class="n">0</th>-->
<!--		  	</tr>-->
<!--	  	</thead>-->
<!--	  	<tbody id="d">-->
<!--	    	<tr style="height:10px;">-->
<!--	    	 	<th id="des">Description</th>-->
<!--	     		<th id="u">Unité</th>-->
<!--			    <th id="q">Quantité</th>-->
<!--			    <th id="puh">Prix unitaire HT</th>-->
<!--			    <th id="ph">Prix HT</th>-->
<!--	    	</tr>-->
<!--	  	</tbody>-->
<!--	  	<tbody id="de8">-->
<!--	  		<tr class="stot">-->
<!--	  			<th colspan="3">Maçonnerie</th>-->
<!--	  			<th>sous-total HT</th>-->
<!--	  			<th class="n">150.00</th>-->
<!--	  		</tr>-->
<!--	  		<tr id="de8.2">-->
<!--	  			<td>Fourniture et pose d'un mur de soutènement en béton banché avec fondations</td>-->
<!--	  			<td>m2</td>-->
<!--	  			<td class="n">1.00</td>-->
<!--	  			<td class="n">150.00</td>-->
<!--	  			<td class="n">150.00</td>-->
<!--	  		</tr>-->
<!--	  	</tbody>-->
<!--	</table>-->
<!--</div>-->









</div>
						</article>
<?php include('inc/droite.php');?>
						</div>
					<div class="block"></div>
				</section>
			</div>
		</div>
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>



