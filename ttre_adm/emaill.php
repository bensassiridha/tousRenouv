<?php 
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$fichier1='';
				$handle = new Upload($_FILES['fichier1']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/email/');
					if ($handle->processed)
					{
						$fichier1  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$fichier2='';
				$handle = new Upload($_FILES['fichier2']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/email/');
					if ($handle->processed)
					{
						$fichier2  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$fichier3='';
				$handle = new Upload($_FILES['fichier3']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/email/');
					if ($handle->processed)
					{
						$fichier3  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$fichier4='';
				$handle = new Upload($_FILES['fichier4']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/email/');
					if ($handle->processed)
					{
						$fichier4  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$fichier5='';
				$handle = new Upload($_FILES['fichier5']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/email/');
					if ($handle->processed)
					{
						$fichier5  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$userd='';
				foreach ( $_POST['userd'] as $value )
				{
					$userd.=$value.'|';
				}
				$my->req('INSERT INTO ttre_emaill VALUES("",
										"'.$_SESSION['id_user'].'" ,
										"'.$userd.'" ,
										"'.$my->net_input($_POST['sujet']).'",
										"'.$my->net_textarea($_POST['contenu']).'",
										"'.$my->net_input($fichier1).'",
										"'.$my->net_input($fichier2).'",
										"'.$my->net_input($fichier3).'",
										"'.$my->net_input($fichier4).'",
										"'.$my->net_input($fichier5).'",
										"0" 
										)');
				rediriger('?contenu=emaill&ajouter=ok');
			}
			else
			{
				$str='';
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=1 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Général</span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=2 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Zone</span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=3 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Ajout</span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=6 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Super</span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=7 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Départements et villes</span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=8 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Gestion du Site</span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=4 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Gestion de prix </span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=9 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Espace particulier </span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=5 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Espace professionnel </span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=10 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Devis avec enchere </span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=11 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Devis avec achat imédiat </span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				$req = $my->req('SELECT * FROM ttre_users WHERE id_user > 1  AND profil=12 AND statut=1 ORDER BY nom ASC');
				if ( $my->num($req)>0 )
				{
					$str.='<p><span style="color:red;margin: 0 0 0 100px;" >Admin : Gestion des commandes </span><br />';
					while ( $res=$my->arr($req) ) 
					{
						$str.='<span class="test">
			          			  <input style="width:10px;" type="checkbox" name="userd[]" value="'.$res['id_user'].'"/>'.$res['nom'].'
			          		   </span>'."\n";
					}
					$str.='<br /><br /></p>';
				}
				
				$form = new formulaire('modele_1','?contenu=emaill&action=ajouter','','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->text('Sujet','sujet','',1);
				$form->tinyMCE('','contenu');
				$form->photo('Fichier 1','fichier1');
				$form->photo('Fichier 2','fichier2');
				$form->photo('Fichier 3','fichier3');
				$form->photo('Fichier 4','fichier4');
				$form->photo('Fichier 5','fichier5');
				$form->vide('<tr><td colspan="2">'.$str.'</td></tr>');
				$form->afficher('Envoyer','ajouter');
				echo '<p><a href="?contenu=emaill">Retour</a></p>';
			}
			break;
		case 'detail' :
			if ( isset($_GET['envoyer']) )
			{
				$temp=$my->req_arr('SELECT * FROM ttre_emaill WHERE id='.$_GET['id']);
				$user=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$temp['user'].' ');
				$userc=$my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$temp['user'].' ');
				
				$tab = split('[|]',$temp['userd']);
				foreach ( $tab as $value )
				{
					$userd=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$value.' ');
					$usercd=$my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$value.' ');
					
					$mail_client='contact@tousrenov.fr';
					$destinataire=$usercd['email'];
						
					$frontiere = '-----=' . md5(uniqid(mt_rand()));
					$headers = 'From: "'.$userd['nom'].'"<'.$mail_client.'> '."\n";
					$headers .= 'Return-Path: <'.$mail_client.'>'."\n";
					$headers .= 'MIME-Version: 1.0'."\n";
					$headers .= 'Content-Type: multipart/mixed; boundary="'.$frontiere.'"';
					
					$message = '';
					$message .= '--'.$frontiere."\n";
					$message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
					$message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
					
					$message .= $temp['contenu']."\n\n";
						
					// Pièce jointe
					if ( !empty($temp['fichier1']) ) 
					{
						$message .= '--'.$frontiere."\n";
							
						$file_type = mime_content_type('../upload/email/'.$temp['fichier1'].'');
							
						$message .= 'Content-Type: '.$file_type.'; name="../upload/email/'.$temp['fichier1'].'"'."\n";
						$message .= 'Content-Transfer-Encoding: base64'."\n";
						$message .= 'Content-Disposition:attachement; filename="'.$temp['fichier1'].'"'."\n\n";
						$message .= chunk_split(base64_encode(file_get_contents('../upload/email/'.$temp['fichier1'].'')))."\n";
					}
					if ( !empty($temp['fichier2']) ) 
					{
						$message .= '--'.$frontiere."\n";
							
						$file_type = mime_content_type('../upload/email/'.$temp['fichier2'].'');
							
						$message .= 'Content-Type: '.$file_type.'; name="../upload/email/'.$temp['fichier2'].'"'."\n";
						$message .= 'Content-Transfer-Encoding: base64'."\n";
						$message .= 'Content-Disposition:attachement; filename="'.$temp['fichier2'].'"'."\n\n";
						$message .= chunk_split(base64_encode(file_get_contents('../upload/email/'.$temp['fichier2'].'')))."\n";
					}
					if ( !empty($temp['fichier3']) ) 
					{
						$message .= '--'.$frontiere."\n";
							
						$file_type = mime_content_type('../upload/email/'.$temp['fichier3'].'');
							
						$message .= 'Content-Type: '.$file_type.'; name="../upload/email/'.$temp['fichier3'].'"'."\n";
						$message .= 'Content-Transfer-Encoding: base64'."\n";
						$message .= 'Content-Disposition:attachement; filename="'.$temp['fichier3'].'"'."\n\n";
						$message .= chunk_split(base64_encode(file_get_contents('../upload/email/'.$temp['fichier3'].'')))."\n";
					}
					if ( !empty($temp['fichier4']) ) 
					{
						$message .= '--'.$frontiere."\n";
							
						$file_type = mime_content_type('../upload/email/'.$temp['fichier4'].'');
							
						$message .= 'Content-Type: '.$file_type.'; name="../upload/email/'.$temp['fichier4'].'"'."\n";
						$message .= 'Content-Transfer-Encoding: base64'."\n";
						$message .= 'Content-Disposition:attachement; filename="'.$temp['fichier4'].'"'."\n\n";
						$message .= chunk_split(base64_encode(file_get_contents('../upload/email/'.$temp['fichier4'].'')))."\n";
					}
					if ( !empty($temp['fichier5']) ) 
					{
						$message .= '--'.$frontiere."\n";
							
						$file_type = mime_content_type('../upload/email/'.$temp['fichier5'].'');
							
						$message .= 'Content-Type: '.$file_type.'; name="../upload/email/'.$temp['fichier5'].'"'."\n";
						$message .= 'Content-Transfer-Encoding: base64'."\n";
						$message .= 'Content-Disposition:attachement; filename="'.$temp['fichier5'].'"'."\n\n";
						$message .= chunk_split(base64_encode(file_get_contents('../upload/email/'.$temp['fichier5'].'')))."\n";
					}
					// Fin
					
					$message .= '--'.$frontiere.'--'."\r\n";
					
					mail($destinataire,html_entity_decode($temp['sujet']),$message,$headers);
				}
				
				$my->req('UPDATE ttre_emaill SET envoyer	=	"1"  WHERE id = '.$_GET['id'].' ');				
				rediriger('?contenu=emaill');
			}
			else
			{
				$temp = $my->req_arr('SELECT * FROM ttre_emaill WHERE id='.$_GET['id'].' ');
				$user=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$temp['user'].' ');
				
				$tab = split('[|]',$temp['userd']);
				$nomd='';
				foreach ( $tab as $value )
				{
					$userd=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$value.' ');
					if ( $userd ) $nomd.=$userd['nom'].', ';
				}
				
				echo'<p>Sujet : '.$temp['sujet'].'</p><p>Contenu : '.$temp['contenu'].'</p>';
				echo'<p>User : '.$user['nom'].'</p><p>Destinataire : '.$nomd.'</p>';
				if ( !empty($temp['fichier1']) ) echo'<p>Fichier : <a target="_blanc" href="../upload/email/'.$temp['fichier1'].'"> '.$temp['fichier1'].'</a></p>';
				if ( !empty($temp['fichier2']) ) echo'<p>Fichier : <a target="_blanc" href="../upload/email/'.$temp['fichier2'].'"> '.$temp['fichier2'].'</a></p>';
				if ( !empty($temp['fichier3']) ) echo'<p>Fichier : <a target="_blanc" href="../upload/email/'.$temp['fichier3'].'"> '.$temp['fichier3'].'</a></p>';
				if ( !empty($temp['fichier4']) ) echo'<p>Fichier : <a target="_blanc" href="../upload/email/'.$temp['fichier4'].'"> '.$temp['fichier4'].'</a></p>';
				if ( !empty($temp['fichier5']) ) echo'<p>Fichier : <a target="_blanc" href="../upload/email/'.$temp['fichier5'].'"> '.$temp['fichier5'].'</a></p>';
				if ( $temp['envoyer']==0 ) 
					echo'<p><a href="?contenu=emaill&action=detail&envoyer=ok&id='.$_GET['id'].'">Envoyer le mail</a><br /><br /></p>';
				
				echo '<p><a href="?contenu=emaill">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$temp=$my->req_arr('SELECT * FROM ttre_emaill WHERE id='.$_GET['id'].' ');
			@unlink('../upload/email/'.$temp['fichier1']);
			@unlink('../upload/email/'.$temp['fichier2']);
			@unlink('../upload/email/'.$temp['fichier3']);
			@unlink('../upload/email/'.$temp['fichier4']);
			@unlink('../upload/email/'.$temp['fichier5']);
			$my->req('DELETE FROM ttre_emaill WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=emaill&supprimer=ok');
			break;	
	}
}
else
{
	echo '<h1>Gérer les emails</h1>';
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Cet email a bien été envoyé.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Cet email a bien été supprimé.</p></div>';
	echo '<p>Pour ajouter une autre email, cliquer <a href="?contenu=emaill&action=ajouter">ICI</a></p>';
	$req = $my->req('SELECT * FROM ttre_emaill ');
	if ( $my->num($req)>0 )
	{
		echo'
				<table id="liste_produits">
					<thead>
						<tr class="entete">
							<td>User</td>
							<td>Destinataire</td>
							<td>Sujet</td>
							<td>Statut</td>
							<td class="bouton">Détail</td>
							<td class="bouton">Supprimer</td>
						</tr>
					</thead>
					<tbody> 
			';
		while ( $res=$my->arr($req) )
		{
			$user=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$res['user'].' ');
			if ( $res['envoyer']==1 ) $stat='Mail envoyé'; else  $stat='Mail pas encore envoyé';
			$tab = split('[|]',$res['userd']);
			$nomd='';
			foreach ( $tab as $value )
			{
				$userd=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$value.' ');
				if ( $userd ) $nomd.=$userd['nom'].', ';
			}
			echo'
				<tr>
					<td>'.$user['nom'].'</td>
					<td>'.$nomd.'</td>
					<td>'.$res['sujet'].'</td>
					<td>'.$stat.'</td>
					<td class="bouton">
						<a href="?contenu=emaill&action=detail&id='.$res['id'].'">
						<img src="img/interface/btn_modifier.png" alt="Détail"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cet email ?\')) 
						{window.location=\'?contenu=emaill&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
						<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>
				';
		}
		echo'
				</tbody> 
				</table>
			';
	}
	else
	{
		echo '<p>Pas email ...</p>';
	}
}
?>
<style>
span.test{
	float: left;
	margin: 0 5px 10px 0;
	width: 200px;
}
</style>
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
		
$(document).ready(function() 
{
	/*$('form[name="ajouter"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !';this.titre.focus(); }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});	
	$('form[name="modifier"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !';this.titre.focus(); }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});*/	
});
</script>