<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        // Skin options
        skin : "o2k7",
        skin_variant : "silver",
        // Example content CSS (should be your site CSS)
        content_css : "css/example.css",
        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",
        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
});
</script>
<?php
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$image='';
				$handle = new Upload($_FILES['photo']);
				if ($handle->uploaded) 
				{
					//$handle->file_name_body_pre     = 'News_';    // prepends to the name body (default: '') 
					//$handle->image_ratio_crop       = true;       // t3abi alcadre wa tkos zayed
					//$handle->image_ratio_fill       = true;       // tkos wa t3abi transparent nakes
					//$handle->image_ratio            = true;       // resize image conserving the original sizes ratio(default: false)
					$handle->image_ratio_no_zoom_in = true;       // same as image_ratio, but won't resize if the source image is smaller than image_x  x image_y  (default: false)
					$handle->image_resize           = true;       // determines is an image will be resized (default: false) 
					$handle->image_x                = 1920;        // destination image width (default: 197)             
					$handle->image_y                = 800;        // destination image height (default: 197)
					$handle->Process('../upload/conseils/1920X800/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   

					$handle->image_ratio_no_zoom_in = true;       // same as image_ratio, but won't resize if the source image is smaller than image_x  x image_y  (default: false)
					$handle->image_resize           = true;       // determines is an image will be resized (default: false) 
					$handle->image_x                = 800;        // destination image width (default: 197)             
					$handle->image_y                = 600;        // destination image height (default: 197)
					$handle->Process('../upload/conseils/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   
					
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 268;
					$handle->image_y                = 197;
					$handle->Process('../upload/conseils/268X197/');
					
//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 100;
					$handle->image_y                = 100;
					$handle->Process('../upload/conseils/100X100/');
					if ($handle->processed) 
					{
						$image  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$my->req('INSERT INTO ttre_conseil VALUES("",
										"'.$my->net_input($_POST['titre']).'",
										"'.$my->net_tinyMCE($_POST['description']).'",
										"'.$image.'"
										)');
				rediriger('?contenu=conseil&ajouter=ok');
			}
			else
			{
				$form = new formulaire('modele_1','?contenu=conseil&action=ajouter','<h2 class="titre_niv2">Ajouter conseil :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				$form->text('Titre','titre','',1);
				$form->tinyMCE('Description','description');
				$form->photo('Photo','photo');
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=conseil">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$temp=$my->req_arr('SELECT * FROM ttre_conseil WHERE id='.$_GET['id']);
				$image=$temp['photo'];
				$handle = new Upload($_FILES['photo']);
				if ($handle->uploaded) 
				{
					//$handle->file_name_body_pre     = 'News_';    // prepends to the name body (default: '') 
					//$handle->image_ratio_crop       = true;       // t3abi alcadre wa tkos zayed
					//$handle->image_ratio_fill       = true;       // tkos wa t3abi transparent nakes
					//$handle->image_ratio            = true;       // resize image conserving the original sizes ratio(default: false)

$handle->image_ratio_no_zoom_in = true;       // same as image_ratio, but won't resize if the source image is smaller than image_x  x image_y  (default: false)
					$handle->image_resize           = true;       // determines is an image will be resized (default: false) 
					$handle->image_x                = 800;        // destination image width (default: 197)             
					$handle->image_y                = 600;        // destination image height (default: 197)
					$handle->Process('../upload/conseils/1920X800/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   

					$handle->image_ratio_no_zoom_in = true;       // same as image_ratio, but won't resize if the source image is smaller than image_x  x image_y  (default: false)
					$handle->image_resize           = true;       // determines is an image will be resized (default: false) 
					$handle->image_x                = 800;        // destination image width (default: 197)             
					$handle->image_y                = 600;        // destination image height (default: 197)
					$handle->Process('../upload/conseils/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   
					
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 268;
					$handle->image_y                = 197;
					$handle->Process('../upload/conseils/268X197/');
					
//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 100;
					$handle->image_y                = 100;
					$handle->Process('../upload/conseils/100X100/');
					if ($handle->processed) 
					{
						@unlink('../upload/conseils/1920X800/'.$temp['photo']);
						@unlink('../upload/conseils/800X600/'.$temp['photo']);
						@unlink('../upload/conseils/268X197/'.$temp['photo']);
						@unlink('../upload/conseils/100X100/'.$temp['photo']);
						$image  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$my->req('UPDATE ttre_conseil SET 
									titre		=	"'.$my->net_input($_POST['titre']).'" ,
									description	=	"'.$my->net_tinyMCE($_POST['description']).'" ,
									photo		=	"'.$image.'" 
								WHERE id = '.$_GET['id'].' ');				
				rediriger('?contenu=conseil&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if (isset($_GET['supprphoto'] ))
				{
					$temp=$my->req_arr('SELECT * FROM ttre_conseil WHERE id='.$_GET['id']);
					@unlink('../upload/conseils/1920X800/'.$temp['photo']);
					@unlink('../upload/conseils/800X600/'.$temp['photo']);
					@unlink('../upload/conseils/268X197/'.$temp['photo']);
					@unlink('../upload/conseils/100X100/'.$temp['photo']);
					$my->req('UPDATE ttre_conseil SET photo="" WHERE id = "'.$_GET['id'].'" ' );
					rediriger('?contenu=conseil&action=modifier&id='.$_GET['id'].'&photosuppr=ok');
					exit;
				}
				
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Cette conseil a bien été modifiée.</p></div>';
				else if ( isset($_GET['photosuppr']) ) $alert='<div id="note" class="success"><p>Cette photo a bien été suprimée.</p></div>';
				else $alert='<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_conseil WHERE id='.$_GET['id'].' ');
				$photo='img/no_foto_150X150.jpg';$supprimerphoto='';
				if ( !empty($temp['photo']) )
				{
					$photo='../upload/conseils/100X100/'.$temp['photo'];
					$supprimerphoto='
							<a class="lien_1" href="#" onclick="
								if(confirm(\'Etes vous certain de vouloir supprimer cette photo ?\')) 
								{window.location=\'?contenu=conseil&action=modifier&supprphoto=1&id='.$temp['id'].'\'}">
								Supprimer
							</a>
					';
				}
				
				$form = new formulaire('modele_1','?contenu=conseil&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier conseil :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide($alert);
				$form->text('Titre','titre','',1,$temp['titre']);
				$form->tinyMCE('Description','description',str_replace('<br />','',$temp['description']));
				$form->vide('<tr><td></td><td><img src="'.$photo.'"/> '.$supprimerphoto.'</td></tr>');
				$form->photo('Photo','photo');
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=conseil">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$temp=$my->req_arr('SELECT * FROM ttre_conseil WHERE id='.$_GET['id'].' ');
			@unlink('../upload/conseils/1920X800/'.$temp['photo']);
			@unlink('../upload/conseils/800X600/'.$temp['photo']);
			@unlink('../upload/conseils/268X197/'.$temp['photo']);
			@unlink('../upload/conseils/100X100/'.$temp['photo']);
			$my->req('DELETE FROM ttre_conseil WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=conseil&supprimer=ok');
			break;	
	}
}
else
{
	echo '<h1>Gérer les conseils</h1>';
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Cette conseil a bien été ajoutée.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Cette conseil a bien été supprimée.</p></div>';
	echo '<p>Pour ajouter une autre conseil, cliquer <a href="?contenu=conseil&action=ajouter">ICI</a></p>';
	$req = $my->req('SELECT * FROM ttre_conseil ');
	if ( $my->num($req)>0 )
	{
		echo'
				<table id="liste_produits">
					<thead>
						<tr class="entete">
							<td>Titre</td>
							<td class="bouton">Modifier</td>
							<td class="bouton">Supprimer</td>
						</tr>
					</thead>
					<tbody> 
			';
		while ( $res=$my->arr($req) )
		{
			echo'
				<tr>
					<td class="nom_prod">'.$res['titre'].'</td>
					<td class="bouton">
						<a href="?contenu=conseil&action=modifier&id='.$res['id'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette conseil ?\')) 
						{window.location=\'?contenu=conseil&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
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
		echo '<p>Pas conseil ...</p>';
	}
}
?>
<script type="text/javascript">
$(document).ready(function() 
{
	$('form[name="ajouter"]').submit(function ()
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
	});	
});
</script>