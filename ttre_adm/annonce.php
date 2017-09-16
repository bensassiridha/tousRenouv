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

<script type="text/javascript" src="ordre/ui.core.js"></script>
<script type="text/javascript" src="ordre/ui.sortable.js"></script>
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
					$handle->image_x                = 800;        // destination image width (default: 150)             
					$handle->image_y                = 600;        // destination image height (default: 150)
					$handle->Process('../upload/annonces/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   
					
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 268;
					$handle->image_y                = 197;
					$handle->Process('../upload/annonces/268X197/');
					
//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 100;
					$handle->image_y                = 100;
					$handle->Process('../upload/annonces/100X100/');
					if ($handle->processed) 
					{
						$image  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$fichier='';
				$handle = new Upload($_FILES['fichier']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/annonces/fichiers/');
					if ($handle->processed)
					{
						$fichier  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$ordre= $my->req_obj('SELECT max( ordre ) AS tot FROM ttre_annonces');
				if ($ordre) $ordre = $ordre->tot; else $ordre=0;
				
				$my->req('INSERT INTO ttre_annonces VALUES("",
										"'.$my->net_input($_POST['titre']).'",
										"'.$my->net_tinyMCE($_POST['description']).'",
										"'.$my->net_input($_POST['url']).'",
										"'.$image.'",
										"'.$fichier.'",
										"0" ,
										"'.($ordre+1).'"
										)');
				rediriger('?contenu=annonce&ajouter=ok');
			}
			else
			{
				$form = new formulaire('modele_1','?contenu=annonce&action=ajouter','<h2 class="titre_niv2">Ajouter Annonce :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				$form->text('Titre','titre','',1);
				$form->tinyMCE('Description','description');
				$form->text('Url','url','',1);
				$form->photo('Photo','photo');
				$form->photo('Fichier','fichier');
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=annonce">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$temp=$my->req_arr('SELECT * FROM ttre_annonces WHERE id='.$_GET['id']);
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
					$handle->image_x                = 800;        // destination image width (default: 150)             
					$handle->image_y                = 600;        // destination image height (default: 150)
					$handle->Process('../upload/annonces/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   
					
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 268;
					$handle->image_y                = 197;
					$handle->Process('../upload/annonces/268X197/');
					
//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 100;
					$handle->image_y                = 100;
					$handle->Process('../upload/annonces/100X100/');
					if ($handle->processed) 
					{
						@unlink('../upload/annonces/800X600/'.$temp['photo']);
						@unlink('../upload/annonces/268X197/'.$temp['photo']);
						@unlink('../upload/annonces/100X100/'.$temp['photo']);
						$image  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$fichier=$temp['fichier'];
				$handle = new Upload($_FILES['fichier']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/annonces/fichiers/');
					if ($handle->processed)
					{
						@unlink('../upload/annonces/fichiers/'.$temp['fichier']);
						$fichier  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$my->req('UPDATE ttre_annonces SET 
									titre		=	"'.$my->net_input($_POST['titre']).'" ,
									description	=	"'.$my->net_tinyMCE($_POST['description']).'" ,
									url			=	"'.$my->net_input($_POST['url']).'" ,
									photo		=	"'.$image.'" ,
									fichier		=	"'.$fichier.'"
								WHERE id = '.$_GET['id'].' ');				
				rediriger('?contenu=annonce&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if (isset($_GET['supprphoto'] ))
				{
					$temp=$my->req_arr('SELECT * FROM ttre_annonces WHERE id='.$_GET['id']);
					@unlink('../upload/annonces/800X600/'.$temp['photo']);
					@unlink('../upload/annonces/268X197/'.$temp['photo']);
					@unlink('../upload/annonces/100X100/'.$temp['photo']);
					$my->req('UPDATE ttre_annonces SET photo="" WHERE id = "'.$_GET['id'].'" ' );
					rediriger('?contenu=annonce&action=modifier&id='.$_GET['id'].'&photosuppr=ok');
					exit;
				}
				if (isset($_GET['supprfichier'] ))
				{
					$temp=$my->req_arr('SELECT * FROM ttre_annonces WHERE id='.$_GET['id']);
					@unlink('../upload/annonces/fichiers/'.$temp['fichier']);
					$my->req('UPDATE ttre_annonces SET fichier="" WHERE id = "'.$_GET['id'].'" ' );
					rediriger('?contenu=annonce&action=modifier&id='.$_GET['id'].'&fichiersuppr=ok');
					exit;
				}
				
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Cette annonce a bien été modifiée.</p></div>';
				else if ( isset($_GET['photosuppr']) ) $alert='<div id="note" class="success"><p>Cette photo a bien été suprimée.</p></div>';
				else if ( isset($_GET['fichiersuppr']) ) $alert='<div id="note" class="success"><p>Cette fichier a bien été suprimée.</p></div>';
				else $alert='<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_annonces WHERE id='.$_GET['id'].' ');
				$photo='img/no_foto_150X150.jpg';$supprimerphoto='';
				if ( !empty($temp['photo']) )
				{
					$photo='../upload/annonces/100X100/'.$temp['photo'];
					$supprimerphoto='
							<a class="lien_1" href="#" onclick="
								if(confirm(\'Etes vous certain de vouloir supprimer cette photo ?\')) 
								{window.location=\'?contenu=annonce&action=modifier&supprphoto=1&id='.$temp['id'].'\'}">
								Supprimer
							</a>
					';
				}
				$fichier='';$supprimerfichier='';
				if ( !empty($temp['fichier']) )
				{
					$fichier='../upload/annonces/fichiers/'.$temp['fichier'];
					$supprimerfichier='
							<a class="lien_1" href="#" onclick="
								if(confirm(\'Etes vous certain de vouloir supprimer cette fichier ?\')) 
								{window.location=\'?contenu=annonce&action=modifier&supprfichier=1&id='.$temp['id'].'\'}">
								Supprimer
							</a>
					';
				}
				
				$form = new formulaire('modele_1','?contenu=annonce&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier annonce :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide($alert);
				$form->text('Titre','titre','',1,$temp['titre']);
				$form->tinyMCE('Description','description',str_replace('<br />','',$temp['description']));
				$form->text('Url','url','',1,$temp['url']);
				$form->vide('<tr><td></td><td><img src="'.$photo.'"/> '.$supprimerphoto.'</td></tr>');
				$form->photo('Photo','photo');
				$form->vide('<tr><td></td><td><a href="../upload/annonces/fichiers/'.$temp['fichier'].'" target="_blanc">'.$temp['fichier'].'</a> '.$supprimerfichier.'</td></tr>');
				$form->photo('Fichier','fichier');
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=annonce">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$temp=$my->req_arr('SELECT * FROM ttre_annonces WHERE id='.$_GET['id'].' ');
			@unlink('../upload/annonces/800X600/'.$temp['photo']);
			@unlink('../upload/annonces/268X197/'.$temp['photo']);
			@unlink('../upload/annonces/100X100/'.$temp['photo']);
			@unlink('../upload/annonces/fichiers/'.$temp['fichier']);
			$my->req('DELETE FROM ttre_annonces WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=annonce&supprimer=ok');
			break;	
		case 'ordre' :
			foreach ($_POST['ordre'] as $key=>$value)
				$my->req('UPDATE ttre_annonces SET ordre="'.$my->net($key).'" WHERE id='.$my->net($value));
			rediriger('?contenu=annonce&ordre=ok');
			break;
	}
}
else
{
	echo '<h1>Gérer les annonces</h1>';
	if ( isset($_GET['ordre']) ) echo '<div class="success"><p>L\'ordre a bien été modifié.</p></div>';
	elseif ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Cette annonce a bien été ajoutée.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Cette annonce a bien été supprimée.</p></div>';
	echo '<p>Pour ajouter une autre annonce, cliquer <a href="?contenu=annonce&action=ajouter">ICI</a></p>';
	$req = $my->req('SELECT * FROM ttre_annonces ORDER BY ordre ASC');
	if ( $my->num($req)>0 )
	{
		echo'
			<form method="POST" action="?contenu=annonce&action=ordre" >
				<table id="liste_produits">
					<thead>
						<tr class="entete">
							<td>Titre</td>
							<td>User</td>
							<td class="bouton">Modifier</td>
							<td class="bouton">Supprimer</td>
							<td class="bouton">Ordre</td>
						</tr>
					</thead>
					<tbody> 
			';
		while ( $res=$my->arr($req) )
		{
			$nom='Admin';
			if ( $res['id_user']!=0 ) 
			{
				$user=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$res['id_user'].' ');
				$nom=$user['nom'];
			}
			echo'
				<tr>
					<td class="nom_prod">'.$res['titre'].'</td>
					<td>'.$nom.'</td>
					<td class="bouton">
						<a href="?contenu=annonce&action=modifier&id='.$res['id'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette annonce ?\')) 
						{window.location=\'?contenu=annonce&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
						<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
					</td>
					<td class="bouton" style="cursor: move;">
						<img src="ordre/cursor_move.gif" alt="Mover" border="0" />
						<input type="hidden" name="ordre[]" value="' . $res ['id'] . '" />
					</td>	
				</tr>
				';
		}
		echo'
				</tbody> 
				</table>
			<input type="submit"  value="Modifier l\'ordre" style="margin:10px 0 0 250px;"/>
			</form>	
			';
	}
	else
	{
		echo '<p>Pas annonce ...</p>';
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

$(function() {

	// Return a helper with preserved width of cells
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};

	$("#liste_produits tbody tr").css('background-color','#FFF');
	$("#liste_produits tbody").sortable({
		helper: fixHelper, placeholder: 'ui-state-highlight'  
	}).disableSelection();
   
});

</script>