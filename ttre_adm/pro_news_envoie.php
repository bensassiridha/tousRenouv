<?php 
$my = new mysql();


if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'envoyer' :
			if ( isset($_POST['envoie_newsletter']) )
			{
				/*include_once "phpmailer/class.phpmailer.php";
				$i=1;
				foreach ( $_POST['inscrits'] as $value )
				{
					$mail=  new PHPmailer();
					$mail->IsSMTP();
					$mail->IsHTML(true);
					$mail->FromName=$nom_client;
					$mail->From=$mail_client;
					$mail->Subject=$nom_client.' : Newsletter - '.date('d/m/Y',time());
					$mail->Body=stripslashes($_POST['contenu']);
					$mail->AddAddress($value);
					$envoi=$mail->Send();
					if ( $i%100==0 )
					{
						$mail->SmtpClose();
						unset($mail);
					}
					$i++;
				}*/
				
				/*foreach ( $_POST['inscrits'] as $value )
				{
					$headers ='From: "'.$nom_client.'"'."\n";
					$headers .='Reply-To: '.$mail_client.' '."\n";
					$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
					$headers .='Content-Transfer-Encoding: 8bit';
					mail($value, $_POST['titre'], $_POST['contenu'], $headers);
				}*/
				
				
				foreach ( $_POST['inscrits'] as $value )
				{
					$destinataire=$value;
					//$destinataire='bilelbadri@gmail.com';
					$email_expediteur='demandes@tousrenov.fr';
					$email_reply='demandes@tousrenov.fr';
					$titre_mail=$nom_client;
					$sujet=$_POST['titre'];
					
					$frontiere = '-----=' . md5(uniqid(mt_rand()));
					$headers = 'From: "'.$titre_mail.'" <'.$email_reply.'> '."\n";
					$headers .= 'Return-Path: <'.$email_reply.'>'."\n";
					$headers .= 'MIME-Version: 1.0'."\n";
					$headers .= 'Content-Type: multipart/mixed; boundary="'.$frontiere.'"';
					
					$message = '';
					$message .= '--'.$frontiere."\n";
					$message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
					$message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
					$message .= $_POST['contenu']."\n\n";
					
					$message .= '--'.$frontiere.'--'."\r\n";
					
					mail($destinataire,$sujet,$message,$headers);
				}
				
				rediriger('?contenu=pro_news_envoie&envoyer=ok');
				exit;
			}
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Envoyer Newsletter</h1>';
	$alert='';
	if ( isset($_GET['envoyer']) ) $alert='<div class="success"><p>Newsletter envoyée avec succés.</p></div>';
	
	$req=$my->req('SELECT * FROM ttre_client_pro WHERE newsletter=1 AND ( stat_valid_zone=1 OR stat_valid_general=1 ) ORDER BY email ASC');
	if ( $my->num($req)>0 )
	{
		$str='';
		while ( $res=$my->arr($req) )
		{
			$userprofil =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
			if ( $userprofil['profil']==1 )
			{
				$str.='<span class="test">
	          			  <input style="width:10px;" type="checkbox" checked="checked" name="inscrits[]" value="'.$res['email'].'"/>'.$res['email'].'
	          		   </span>'."\n";
			}
			elseif ( $userprofil['profil']==2 || $userprofil['profil']==6 )
			{
				/*$rs1=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$res['ville'].' ');
				$rs2=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs1['ville_departement'].' ');
				$rq1=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$_SESSION['id_user'].' AND zone='.$rs2['departement_id'].' ');
				if ( $my->num($rq1)>0 )*/
					
				$cd=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$res['id'].' '); $test=0;
				while ( $cdd=$my->arr($cd) )
				{
					$z=$my->req('SELECT * FROM ttre_users_zones WHERE zone='.$cdd['id_departement'].' AND id_user='.$_SESSION['id_user'].' ');
					if ( $my->num($z) ) $test=1 ;
				}
				if ( $test==1 )
				{
					$str.='<span class="test">
		          			  <input style="width:10px;" type="checkbox" checked="checked" name="inscrits[]" value="'.$res['email'].'"/>'.$res['email'].'
		          		   </span>'."\n";
				}
			}
		}
		$form = new formulaire('modele_1','?contenu=pro_news_envoie&action=envoyer','','','','sub','txt','','txt_obl','lab_obl');
		$form->vide($alert);
		$form->text('Titre','titre');
		$form->tinyMCE('','contenu');
		$form->vide('<tr><td colspan="2" style="text-align:center;"><button id="check_all" style="cursor:pointer" >Cocher tout</button>&nbsp;<button id="uncheck_all"  style="cursor:pointer" >Décocher tout</button></td></tr>');
		$form->vide('<tr><td colspan="2">'.$str.'</td></tr>');
		$form->afficher('Envoyer','envoie_newsletter');
		//ibrowser
		?>
		<script type="text/javascript" src="tinymce/tiny_mce.js"></script>
		<script type="text/javascript">
		tinyMCE.init({
			// General options
			
			mode : "textareas",
			language : "fr",
			theme : "advanced",
			plugins : "ibrowser,safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",
			height:"450px",
		    width:"600px",
			// Theme options
				theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|,code",
				theme_advanced_buttons2 : "cut,copy,paste,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,advhr",
				theme_advanced_buttons4 : "cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
					
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				relative_urls : false,
				convert_urls : false,
				document_base_url : <?php echo '"'.$url_site_client.'"' ; ?>,
				theme_advanced_resizing : false
		});
		function conf()
		{
			var test=false;
			var checkboxes=$('form :checkbox');
			
			for (var i = 0; i < checkboxes.length; i++) 
				if (checkboxes.get(i).checked === true){test=true; break;}
		
			if(test)return confirm("Etes vous sûr de voulouir envoyer la newsletter à la liste des inscrits ?");
			else {alert("Il faut selectionner au moin un destinataire ?"); return false;}
		}
		
		$('button#check_all').click(function () {$('form :checkbox').each(function(){this.checked = true;});return false; });
		$('button#uncheck_all').click(function () {$('form :checkbox').each(function(){this.checked = false;});return false; });
		</script>
		<style>
		span.test{
			float: left;
			margin: 0 5px 10px 0;
			width: 200px;
		}
		</style>
		<?php 	
	}
	else
	{
		echo'<p>Pas inscrits ...</p>';
	}
}
?>