<?php
/*$t='|3|5';
$tab_av=explode('|',$t);
print_r($tab_av);
for( $i=1;$i<(count($tab_av));$i++) echo $tab_av[$i].'++';*/

/*$QA[1]=11;
$QA[5]=55;
$QA[8]=88;
if ( array_search(565, $QA)!== false ) echo'true'; else echo 'false' ;*/
	
/*
$sujet = 'Sujet de l\'email';
$message = "Bonjour,d<br />
<strong>Ceci est un <span style='color:red'>message html </span>envoyé grâce à php.</strong><br />
merci :)";

$nom = 'bilel badri';
$destinataire = 'bilelbadri@gmail.com';
$mail_client = 'bilelbadri@gmail.fr';

$headers = "From: \" ".$nom." \"<".$destinataire.">\n";
$headers .= "Reply-To: ".$mail_client."\n";
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
mail($destinataire,$sujet,$message,$headers);
*/

require('mysql.php');$my=new mysql();

//echo'<pre>';print_r($_POST);echo'</pre>';

if ( isset($_POST['demande_devis']) )
{
	if ( $_POST['isEstimation']==1 ) $isEstimation='Des devis gratuits : vous rencontrez jusque quatre entreprises proches.';
	elseif ( $_POST['isEstimation']==2 ) $isEstimation='Des estimations de prix gratuites : les échanges avec les entreprises restent anonymes tant que vous le souhaitez.';
	$temp=$my->req_arr('SELECT * FROM ttre_domaines WHERE id_domaine='.$_POST['domaine'].' ');$domaine=$temp['titre_domaine'];
	$question='';
	$sqlProf='';foreach ( $_POST['prof']  as $key => $value ) $sqlProf.=' OR ( id_profession='.$value.' ) ';
	$sqlReal='';foreach ( $_POST['real']  as $key => $value ) $sqlReal.=' OR ( id_profession='.$value.' ) ';
	$req=$my->req('SELECT DISTINCT(id_question) FROM ttre_questions_devis WHERE ( id_domaine='.$_POST['domaine'].' ) '.$sqlProf.' '.$sqlReal.' ');
	while ( $res=$my->arr($req) ) 
	{
		$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
		if ( $quest['type_question']==1 ) $question.='<tr><td style="text-align: right;color:#941B80;width:400px;" >'.$quest['label_question'].' : </td><td>'.$_POST['quest_'.$res['id_question'].''].'</td></tr>'; 
		else 	
		{
			$option=$my->req_arr('SELECT * FROM ttre_questions_option WHERE id_option='.$_POST['quest_'.$res['id_question'].''].' ');
			$val='----';
			if ( $_POST['quest_'.$res['id_question'].'']!=-1 )
			{
				$val=$option['option_option'];
			}
			elseif ( $_POST['quest_'.$res['id_question'].'']==-1 )
			{
				$val='Autre, <span style="color:#941B80;" > Préciser </span> '.$_POST['preciser_'.$res['id_question'].''].' ';
			}
			$question.='<tr><td style="text-align: right;color:#941B80;width:400px;" >'.$quest['label_question'].' : </td><td>'.$val.'</td></tr>';
		}
	}
	if ( $_POST['typeDecoupage']==1 ) $typeDecoupage='Une seule entreprise réalise l\'ensemble de la prestation.';
	elseif ( $_POST['typeDecoupage']==2 ) $typeDecoupage='Découpage en lots : plusieurs entreprises réalisent la prestation.';
	elseif ( $_POST['typeDecoupage']==3 ) $typeDecoupage='Indifférent : entreprise seule ou découpage en lots.';
	$val_budget='';
	if ( $_POST['budget']!='' )	
		$val_budget='<tr><td style="text-align: right;color:#941B80;width:400px;" >Budget : </td><td>'.$_POST['budget'].' euros</td></tr>';
	$val_tels='';
	if ( $_POST['tels']!='' )	
		$val_tels='<tr><td style="text-align: right;color:#941B80;width:400px;" >Téléphone secondaire : </td><td>'.$_POST['tels'].'</td></tr>';
	$val_raisonSociale='';
	if ( $_POST['raisonSociale']!='' )	
		$val_raisonSociale='<tr><td style="text-align: right;color:#941B80;width:400px;" >Nom de l\'entreprise ou de l\'établissement publique : </td><td>'.$_POST['raisonSociale'].'</td></tr>';
			
	$message = '
			<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
					<title>TOUSRENOV</title>
				</head>
											
				<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
					<div id="corps" style="margin:0 auto; width:800px; height:auto;">
						<center><img src="http://creation-site-web-tunisie.net/trn/images/logo.png" /></center><br />
						<h1 style="background-color:#687189; color:#FFF; font-size:16px; text-align:center;">TOUSRENOV</h1>
								
						<p>Bonjour,</p>	
						
						<h2 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">Que souhaitez-vous ?</h2>																
						<div id="adresse" style="background-color:#E6E6E6; font-size:14px; padding:10px;">
							<table>
								<tr>
									<td colspan="2">'.$isEstimation.'</td>
								</tr>
							</table>
						</div>	
						
						<h2 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">Travaux à réaliser</h2>																
						<div id="adresse" style="background-color:#E6E6E6; font-size:14px; padding:10px;">
							<table>
								<tr>
									<td style="text-align: right;color:#941B80;width:400px;">Domaine : </td>
									<td style="width:400px;">'.$domaine.'</td>
								</tr>
								<tr>
									<td colspan="2" style="color:#941B80;"><br /></td>
								</tr>
								<tr>
									<td colspan="2" style="color:#941B80;">Questions : </td>
								</tr>
								'.$question.'
								<tr>
									<td colspan="2" style="color:#941B80;"><br /></td>
								</tr>
								<tr>
									<td style="text-align: right;color:#941B80;">Titre de votre demande de travaux : </td>
									<td>'.$_POST['titreDemande'].'</td>
								</tr>
								<tr>
									<td style="text-align: right;color:#941B80;">Description des tâches à réaliser : </td>
									<td>'.nl2br($_POST['corpsDemande']).'</td>
								</tr>
								<tr>
									<td colspan="2">'.$typeDecoupage.'</td>
								</tr>
							</table>
						</div>	
						
						<h2 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">Informations complémentaires</h2>																
						<div id="adresse" style="background-color:#E6E6E6; font-size:14px; padding:10px;">
							<table>
								<tr>
									<td style="text-align: right;color:#941B80;width:400px;">Délai de réalisation souhaité : </td>
									<td style="width:400px;">'.$_POST['delaisPrestation'].'</td>
								</tr>
								<tr>
									<td style="text-align: right;color:#941B80;">Nombre maximum de devis souhaités : </td>
									<td>'.$_POST['consultationsMaxi'].'</td>
									'.$val_budget.'
								</tr>
							</table>
						</div>	
						
						<h2 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">Coordonnées de client</h2>																
						<div id="adresse" style="background-color:#E6E6E6;font-size:14px; padding:10px;">
							<table>
								<tr>
									<td style="text-align: right;color:#941B80;width:400px;" >Nom : </td>
									<td style="width:400px;">'.$_POST['nom'].'</td>
								</tr>
								<tr>
									<td style="text-align: right;color:#941B80;" >Prénom : </td>
									<td>'.$_POST['prenom'].'</td>
								</tr>
								<tr>
									<td style="text-align: right;color:#941B80;" >Adresse, rue : </td>
									<td>'.$_POST['adresseRue'].'</td>
								</tr>
								<tr>
									<td style="text-align: right;color:#941B80;" >Ville : </td>
									<td>'.$_POST['ville'].'</td>
								</tr>
								<tr>
									<td style="text-align: right;color:#941B80;" >Code postal : </td>
									<td>'.$_POST['cp'].'</td>
								</tr>
								<tr>
									<td style="text-align: right;color:#941B80;" >Email : </td>
									<td>'.$_POST['email'].'</td>
								</tr>
								<tr>
									<td style="text-align: right;color:#941B80;">Téléphone Principal : </td>
									<td>'.$_POST['telp'].'</td>
								</tr>
								'.$val_tels.'
								'.$val_raisonSociale.'
							</table>
						</div>	
						
						<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
								<p style="padding-top:10px;">
									TOUSRENOV									
								</p>											
						</div>
					</div>
				</body>
			</html>
		';	
	
	
	$sujet = 'TOUSRENOV : DEVIS';
	
	$nom = $_POST['nom'];
	$mail_reply = $_POST['email'];
	//$mail_client = 'bilelbadri@gmail.com';
	$mail_client = 'contact@liweb-agency.net';
	
	$headers = "From: \" ".$nom." \"<".$mail_client.">\n";
	$headers .= "Reply-To: ".$mail_reply."\n";
	$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
	mail($mail_client,$sujet,$message,$headers);
			
	header("location:devis.php?demande=ok");exit;
}













include('inc/head.php');?>
	<body id="page1">
		<div class="extra">
			<div class="main">
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
								<h2>Devis</h2>







<script type="text/javascript">
$(document).ready(function() {

	/*a='|2|3|4|5|6|aaa';
	tab=a.split('|');alert(tab.length);//7
	alert(tab[0]);alert(tab[6]);*/

	$('select[name="domaine"]').change(function ()
	{
		if( $(this).val()!=0 ) $("#pro_rea").css("display","");
		else  $("#pro_rea").css("display","none");  

		ancienDomaine=$('input[name="hiddenDomaineID"]').val();
		newDomaine=$(this).val();
		if ( ($("#quest").html())!="" )
		{
			 $.ajax({
				 type: "post",
				 url: "Ajax.php",
				 data: "ad="+ancienDomaine+"&nd="+newDomaine+"&devis=modifDomaine",
				 success: function(msg)
					{	
						if (msg)
						{
							tab=msg.split('|');
							formquest=tab.length-1;
							for(var i=1;i<formquest;i++)
							{
								$("#question_"+tab[i]+"").remove();
							}
							$(tab[formquest]).prependTo("#quest");
						}					 
					}
			});
		}
		$('input[name="hiddenDomaineID"]').val(newDomaine);
	});	
	$("#btnAjoutProf").click(function () 
	{
		av_aj_p='';
		$("select[id='prof'] option").each(function() {
			av_aj_p=av_aj_p + '|' + $(this).val();
	    });
		//alert(av_aj_p);
		op_s='';
		$("select[id='prof_all'] option:selected").each(function() {
			op_s=op_s + '|' + $(this).val();
	    });
		//alert(op_s);
	    var selectedItem = $("#prof_all option:selected");
	    $("#prof").append(selectedItem);

	    av_aj_r='';
		$("select[id='real'] option").each(function() {
			av_aj_r=av_aj_r + '|' + $(this).val();
	    });
		//alert(av_aj_r);
		
	    ad=0;
		if ( ($("#quest").html())=="" ) ad=1;
	    domaineValue=$("select[name='domaine']").val();
	    $.ajax({
			 type: "post",
			 url: "Ajax.php",
			 data: "sav="+av_aj_p+"&ops="+op_s+"&rrr="+av_aj_r+"&devis=ajoutProf&affichDomaine="+ad+"&idD="+domaineValue,
			 success: function(msg)
				{	
					if (msg)
					{
						$("#quest").append(msg);
					}					 
				}
		});
	   /* ap_aj_p='';
		$("select[id='prof'] option").each(function() {
			ap_aj_p=ap_aj_p + '|' + $(this).val();
	    }); */
	    //alert(ap_aj_p);
	});
	$("#btnSupprProf").click(function () 
	{
		/*av_sp_p='';
		$("select[id='prof'] option").each(function() {
			av_sp_p=av_sp_p + '|' + $(this).val();
	    });*/
		//alert(av_sp_p);

		op_s='';
		$("select[id='prof'] option:selected").each(function() {
			op_s=op_s + '|' + $(this).val();
	    });
		//alert(op_s);
		
	    var selectedItem = $("#prof option:selected");
	    $("#prof_all").append(selectedItem);
	    
	    ap_sp_p='';
		$("select[id='prof'] option").each(function() {
			ap_sp_p=ap_sp_p + '|' + $(this).val();
	    }); 
	    //alert(ap_sp_p);

		ap_sp_r='';
		$("select[id='real'] option").each(function() {
			ap_sp_r=ap_sp_r + '|' + $(this).val();
	    }); 
	    //alert(ap_sp_r);
	    
		domaineValue=$("select[name='domaine']").val();
	    $.ajax({
			 type: "post",
			 url: "Ajax.php",
			 data: "sap="+ap_sp_p+"&ops="+op_s+"&rrr="+ap_sp_r+"&devis=supprProf&idD="+domaineValue,
			 success: function(msg)
				{	
					if (msg)
					{
						tab=msg.split('|');
						formquest=tab.length-1;
						for(var i=1;i<=formquest;i++)
						{
							$("#question_"+tab[i]+"").remove();
						}
					}					 
				}
		});
	});
	$("#btnAjoutReal").click(function () 
	{
		av_aj_r='';
		$("select[id='real'] option").each(function() {
			av_aj_r=av_aj_r + '|' + $(this).val();
	    });
		//alert(av_aj_r);
		op_s='';
		$("select[id='real_all'] option:selected").each(function() {
			op_s=op_s + '|' + $(this).val();
	    });
		//alert(op_s);
	    var selectedItem = $("#real_all option:selected");
	    $("#real").append(selectedItem);

	    av_aj_p='';
		$("select[id='prof'] option").each(function() {
			av_aj_p=av_aj_p + '|' + $(this).val();
	    });
		//alert(av_aj_p);
		
	    ad=0;
		if ( ($("#quest").html())=="" ) ad=1;
	    domaineValue=$("select[name='domaine']").val();
	    $.ajax({
			 type: "post",
			 url: "Ajax.php",
			 data: "sav="+av_aj_r+"&ops="+op_s+"&ppp="+av_aj_p+"&devis=ajoutReal&affichDomaine="+ad+"&idD="+domaineValue,
			 success: function(msg)
				{	
					if (msg)
					{
						$("#quest").append(msg);
					}					 
				}
		});
	   /* ap_aj_r='';
		$("select[id='real'] option").each(function() {
			ap_aj_r=ap_aj_r + '|' + $(this).val();
	    }); */
	    //alert(ap_aj_r);
	});
	$("#btnSupprReal").click(function () 
	{
		/*av_sp_r='';
		$("select[id='real'] option").each(function() {
			av_sp_r=av_sp_r + '|' + $(this).val();
	    });*/
		//alert(av_sp_r);

		op_s='';
		$("select[id='real'] option:selected").each(function() {
			op_s=op_s + '|' + $(this).val();
	    });
		//alert(op_s);
		
	    var selectedItem = $("#real option:selected");
	    $("#real_all").append(selectedItem);
	    
	    ap_sp_r='';
		$("select[id='real'] option").each(function() {
			ap_sp_r=ap_sp_r + '|' + $(this).val();
	    }); 
	    //alert(ap_sp_r);

		ap_sp_p='';
		$("select[id='prof'] option").each(function() {
			ap_sp_p=ap_sp_p + '|' + $(this).val();
	    }); 
	    //alert(ap_sp_p);

		domaineValue=$("select[name='domaine']").val();
	    $.ajax({
			 type: "post",
			 url: "Ajax.php",
			 data: "sap="+ap_sp_r+"&ops="+op_s+"&ppp="+ap_sp_p+"&devis=supprReal&idD="+domaineValue,
			 success: function(msg)
				{	
					if (msg)
					{
						tab=msg.split('|');
						formquest=tab.length-1;
						for(var i=1;i<=formquest;i++)
						{
							$("#question_"+tab[i]+"").remove();
						}
					}					 
				}
		});
	});

	$('form[name="form_devis"]').submit(function ()
	{
		mes_erreur='';
		if( $.trim(this.domaine.value)==0 ) { mes_erreur+='<p>Il faut choisir le champ Domaine !</p>'; }
		ap_sp_p='';
		$("select[id='prof'] option").each(function() {
			ap_sp_p=ap_sp_p + '|' + $(this).val();
	    });
		ap_sp_r='';
		$("select[id='real'] option").each(function() {
			ap_sp_r=ap_sp_r + '|' + $(this).val();
	    });
		if( ap_sp_p=='' && ap_sp_r=='' ) { mes_erreur+='<p>Il faut choisir au moins une profession ou une réalisation !</p>'; }
		if( !$.trim(this.titreDemande.value) ) { mes_erreur+='<p>Il faut entrer le champ Titre de votre demande de travaux !</p>'; }
		if( !$.trim(this.corpsDemande.value) ) { mes_erreur+='<p>Il faut entrer le champ Description des tâches à réaliser !</p>'; }
		if( !$.trim(this.consultationsMaxi.value) ) { mes_erreur+='<p>Il faut entrer le champ Nombre maximum de devis souhaités !</p>'; }
		if( !$.trim(this.rechercheLocalisationSubString.value) ) { mes_erreur+='<p>Il faut entrer le champ Localité ou code postal !</p>'; }
		if( !$.trim(this.nom.value) ) { mes_erreur+='<p>Il faut entrer le champ Nom !</p>'; }
		if( !$.trim(this.prenom.value) ) { mes_erreur+='<p>Il faut entrer le champ Prénom !</p>'; }
		if( !$.trim(this.adresseRue.value) ) { mes_erreur+='<p>Il faut entrer le champ Numéro, rue !</p>'; }
		if( !$.trim(this.ville.value) ) { mes_erreur+='<p>Il faut entrer le champ Ville !</p>'; }
		if( !$.trim(this.cp.value) ) { mes_erreur+='<p>Il faut entrer le champ Code postal !</p>'; }
		if( !$.trim(this.email.value) ) { mes_erreur+='<p>Il faut entrer le champ Email !</p>'; }
		else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.email.value))) { mes_erreur+='<p>Votre Adresse Email est incorrect !</p>'; } }
		if( !$.trim(this.telp.value) ) { mes_erreur+='<p>Il faut entrer le champ Téléphone principal !</p>'; }
		
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});
	
});
function affichPreciser ( id , val )
{
	if ( val==(-1) ) $("#span_"+id+"").css("display","");
	else $("#span_"+id+"").css("display","none");
}
</script>
<?php 
$tab_domaine=array();$tab_profession=array();$tab_realisation=array();$tab_quest=array();
if ( isset($_POST['ajout_prestation']) )
{
	foreach ( $_POST['quest'] as $key => $value )
	{
		if ( $value )
		{
			$req1=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$key.' ');
			while ( $res1=$my->arr($req1) )
			{
				if ( $res1['id_domaine']!=0 ) 
					if (  array_search($res1['id_domaine'],$tab_domaine ) === false )
					{
						$tab_domaine[]=$res1['id_domaine'];
						$req2=$my->req('SELECT * FROM ttre_questions_devis WHERE id_domaine='.$res1['id_domaine'].' ');
						while ( $res2=$my->arr($req2) )
						{
							if (  array_search($res2['id_question'],$tab_quest ) === false )
								$tab_quest[]=$res2['id_question'];
						}
					}
				if ( $res1['id_profession']!=0 ) 
					if (  array_search($res1['id_profession'],$tab_profession ) === false )
					{
						$tab_profession[]=$res1['id_profession'];
						$req2=$my->req('SELECT * FROM ttre_questions_devis WHERE id_profession='.$res1['id_profession'].' ');
						while ( $res2=$my->arr($req2) )
						{
							if (  array_search($res2['id_question'],$tab_quest ) === false )
								$tab_quest[]=$res2['id_question'];
						}
					}
				if ( $res1['id_realisation']!=0 ) 
					if (  array_search($res1['id_realisation'],$tab_realisation ) === false )
					{
						$tab_realisation[]=$res1['id_realisation'];
						$req2=$my->req('SELECT * FROM ttre_questions_devis WHERE id_realisation='.$res1['id_realisation'].' ');
						while ( $res2=$my->arr($req2) )
						{
							if (  array_search($res2['id_question'],$tab_quest ) === false )
								$tab_quest[]=$res2['id_question'];
						}
					}
			}
		}
	}
	
	/*
	echo'<pre>';print_r($tab_profession);echo'</pre>';
	echo'<pre>';print_r($tab_realisation);echo'</pre>';
	echo'<pre>';print_r($tab_quest);echo'</pre>';
	*/
}

$partie_domaine='Domaine * : <select name="domaine" ><option value="0"></option>';
$req_domaine=$my->req('SELECT * FROM ttre_domaines ORDER BY titre_domaine ASC');
if ( $my->num($req_domaine)>0 )
{
	while ( $res_domaine=$my->arr($req_domaine) )
	{
		$sel=''; if ( isset($_POST['ajout_prestation']) ) if ( $res_domaine['id_domaine']==1 ) $sel='selected="selected"';
		$partie_domaine.='<option value="'.$res_domaine['id_domaine'].'" '.$sel.' >'.$res_domaine['titre_domaine'].'</option>';
	}
}
$partie_domaine.='</select><input type="hidden" name="hiddenDomaineID" value="0" />';

$partie_profession='';
$req_profession=$my->req('SELECT * FROM ttre_professions ORDER BY titre_profession ASC');
if ( $my->num($req_profession)>0 )
{
	$partie_profession.='Choisir au moins une profession ou une réalisation * : <br />';
	$partie_profession.='<div style="width:220px;height:180px;float:left;" >Professions : <br /><select id="prof_all" name="prof_all" multiple="multiple" style="width:210px;height:147px;" >';
	while ( $res_profession=$my->arr($req_profession) )
	{
		if (  array_search($res_profession['id_profession'],$tab_profession ) === false )
			$partie_profession.='<option value="'.$res_profession['id_profession'].'" >'.$res_profession['titre_profession'].'</option>';
	}
	$partie_profession.='</select></div>
	<div style="float:left;width:46px;padding-top:50px;height:130px;;"><br />
        <input type="button" id="btnAjoutProf" value=">>" /> <br />
        <input type="button" id="btnSupprProf" value="<<" />
    </div>
	';
	$partie_profession.='<div style="width:190px;height:180px;float:left;" >Votre selection : <br /><select id="prof" name="prof[]" multiple="multiple" style="height:147px;" >';
	$req_profession=$my->req('SELECT * FROM ttre_professions ORDER BY titre_profession ASC');
	while ( $res_profession=$my->arr($req_profession) )
	{
		if (  array_search($res_profession['id_profession'],$tab_profession ) !== false )
			$partie_profession.='<option value="'.$res_profession['id_profession'].'" >'.$res_profession['titre_profession'].'</option>';
	}
	$partie_profession.='</select></div><div style="clear:both;"></div> ';
}
$partie_realisation='';
$req_realisation=$my->req('SELECT * FROM ttre_realisations ORDER BY titre_realisation ASC');
if ( $my->num($req_realisation)>0 )
{
	$partie_realisation.='<div style="width:220px;height:180px;float:left;" >Réalisations : <br /><select id="real_all" name="real_all" multiple="multiple" style="width:210px;height:147px;" >';
	while ( $res_realisation=$my->arr($req_realisation) )
	{
		if (  array_search($res_realisation['id_realisation'],$tab_realisation ) === false )
			$partie_realisation.='<option value="'.$res_realisation['id_realisation'].'" >'.$res_realisation['titre_realisation'].'</option>';
	}
	$partie_realisation.='</select></div>
	<div style="float:left;width:46px;padding-top:50px;height:130px;;"><br />
        <input type="button" id="btnAjoutReal" value=">>" /> <br />
        <input type="button" id="btnSupprReal" value="<<" />
    </div>
	';
	$partie_realisation.='<div style="width:190px;height:180px;float:left;" >Votre selection : <br /><select id="real" name="real[]" multiple="multiple" style="height:147px;" >';
	$req_realisation=$my->req('SELECT * FROM ttre_realisations ORDER BY titre_realisation ASC');
	while ( $res_realisation=$my->arr($req_realisation) )
	{
		if (  array_search($res_realisation['id_realisation'],$tab_realisation ) !== false )
			$partie_realisation.='<option value="'.$res_realisation['id_realisation'].'" >'.$res_realisation['titre_realisation'].'</option>';
	}
	$partie_realisation.='</select></div><div style="clear:both;"></div> ';
}
$liste_quest='';
$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_domaine=1 ORDER BY id_question ASC ');
while ( $res=$my->arr($req) )
{
	$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
	if ( $quest['type_question']==1 ) $champ='<input type="text" name="quest_'.$res['id_question'].'" />';
	else 
	{
		$champ='<select name="quest_'.$res['id_question'].'" onchange="affichPreciser('.$res['id_question'].',this.value);" ><option value="0"></option>';
		$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
		while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
		$champ.='<option value="-1">Autre</option></select><span id="span_'.$res['id_question'].'" style="display:none;"> Préciser <input type="text" name="preciser_'.$res['id_question'].'" /></span>';
	}
	$liste_quest.='<div id="question_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</div>';
}
for ( $i=0;$i<count($tab_quest);$i++ )
{
	if ( isset($_POST['quest'][$tab_quest[$i]]) )
	{
		$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$tab_quest[$i].' ');
		if ( $quest['type_question']==1 ) $champ='<input type="text" name="quest_'.$quest['id_question'].'" value="'.$_POST['quest'][$tab_quest[$i]].'" />';
		else 
		{
			$champ='<select name="quest_'.$quest['id_question'].'" onchange="affichPreciser('.$quest['id_question'].',this.value);" ><option value="0"></option>';
			$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$quest['id_question'].' ORDER BY id_option ASC');
			while ( $res_option=$my->arr($req_option) ) 
			{
				$sel='';if ( $_POST['quest'][$tab_quest[$i]]==$res_option['id_option'] ) $sel='selected="selected"';
				$champ.='<option value="'.$res_option['id_option'].'" '.$sel.'>'.$res_option['option_option'].'</option>';
			}
			$champ.='<option value="-1">Autre</option></select><span id="span_'.$quest['id_question'].'" style="display:none;"> Préciser <input type="text" name="preciser_'.$quest['id_question'].'" /></span>';
		}
		$liste_quest.='<div id="question_'.$quest['id_question'].'">'.$quest['label_question'].' '.$champ.'</div>';
	}
	else
	{
		$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$tab_quest[$i].' ');
		if ( $quest['type_question']==1 ) $champ='<input type="text" name="quest_'.$quest['id_question'].'" />';
		else 
		{
			$champ='<select name="quest_'.$quest['id_question'].'" onchange="affichPreciser('.$quest['id_question'].',this.value);" ><option value="0"></option>';
			$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$quest['id_question'].' ORDER BY id_option ASC');
			while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
			$champ.='<option value="-1">Autre</option></select><span id="span_'.$quest['id_question'].'" style="display:none;"> Préciser <input type="text" name="preciser_'.$quest['id_question'].'" /></span>';
		}
		$liste_quest.='<div id="question_'.$quest['id_question'].'">'.$quest['label_question'].' '.$champ.'</div>';
	}
}

$partie_question='<div id="quest">'.$liste_quest.'</div>';







$alert='<br /><div id="note"></div><br />';
if ( isset($_GET['demande']) ) $alert='<br /><div id="note" class="success"><p>La demande a bien été envoyée.</p>
<p><a href="#">Se connecter</a> ou <a href="#">Créer un compte</a></p></div><br />';
			



$style='style="display:none;"'; if ( isset($_POST['ajout_prestation']) ) $style='style="display:;"';
$formulaire=$partie_domaine.'<div id="pro_rea" '.$style.' >'.$partie_profession.$partie_realisation.$partie_question.'</div>';

echo'
<form method="POST" name="form_devis">
	<div>Les champs suivis d\'une * sont obligatoires.</div>
	<br />

	<div>Que souhaitez-vous ? *<br />
		<input type="radio" name="isEstimation" value="1" checked="checked" /> Des devis gratuits : vous rencontrez jusque quatre entreprises proches.<br />
		<input type="radio" name="isEstimation" value="2" /> Des estimations de prix gratuites : les échanges avec les entreprises restent anonymes tant que vous le souhaitez.<br /><br />
	</div>
	<div>Travaux à réaliser<br />
	'.$formulaire.'
	<br /><br />
		Titre de votre demande de travaux * : <input type="text" id="titreDemande" name="titreDemande" /><br />
		Description des tâches à réaliser ( donner toutes les précisions utiles : dimensions, état ... )* : <textarea id="corpsDemande" name="corpsDemande" type="text"></textarea><br />
		<input type="radio" name="typeDecoupage" value="1" checked="checked" />Une seule entreprise réalise l\'ensemble de la prestation.<br />
		<input type="radio" name="typeDecoupage" value="2" />Découpage en lots : plusieurs entreprises réalisent la prestation.<br />
		<input type="radio" name="typeDecoupage" value="3" />Indifférent : entreprise seule ou découpage en lots.
	</div>
	<br />
	<div>
		Informations complémentaires<br />
		Délai de réalisation souhaité * : <select id="delaisPrestation" name="delaisPrestation">
											<option value="1" selected="selected" >Dès que possible</option>
											<option value="2">D\'ici 3 mois</option>
											<option value="3">D\'ici 6 mois</option>
											<option value="4">Dans plus de 6 mois</option>
											<option value="5">Urgent</option>
										  </select><br />
		Nombre maximum de devis souhaités (maximum 4) * : <input type="text" id="consultationsMaxi" name="consultationsMaxi" /><br />							  
		Budget ( facultatif ) : <input type="text" id="budget" name="budget" /> Euros
	</div>
	<br />
	<div>Localité où les travaux auront lieu<br />
		Localité ou code postal (sélectionner dans liste de suggestions) * : <input type="text" id="rechercheLocalisationSubString" name="rechercheLocalisationSubString" />
	</div>
	<br />
	<div>Vos coordonnées<br />
		Seuls des professionnels que vous souhaitez rencontrer (au plus 4) auront accès à vos coordonnées.<br />
		Nom * : <input type="text" id="nom" name="nom" /><br />
		Prénom * : <input type="text" id="prenom" name="prenom" /><br />
		Numéro, rue * : <input type="text" id="adresseRue" name="adresseRue" /><br />
		Ville * : <input type="text" id="ville" name="ville" /><br />
		Code postal (5 chiffres) * : <input type="text" id="cp" name="cp" /><br />
		Email * : <input type="text" id="email" name="email" /><br />
		Téléphone principal (fixe si possible) (10 chiffres) * : <input type="text" id="telp" name="telp" /><br />
		Téléphone secondaire : <input type="text" id="tels" name="tels" /><br />
		Si vous représentez une entreprise, ou un établissement publique, indiquez son nom :<br />
		Nom de l\'entreprise ou de l\'établissement publique : <input type="text" id="raisonSociale" name="raisonSociale" /><br />
	</div>
	<br />
	<input type="submit" value="Valider" name="demande_devis" />
</form>
'.$alert.'
	';
//	<div>Mot de passe<br />
//		Mot de passe (6 caractères min. dont au moins un chiffre) * : <input type="text" id="mdp" name="mdp" /><br />
//		Confirmation du mot de passe * : <input type="text" id="mdpc" name="mdpc" /><br />
//	</div>
?>














































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