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
				$ordre= $my->req_obj('SELECT max( ordre ) AS tot FROM ttre_categories');
				if ($ordre) $ordre = $ordre->tot; else $ordre=0;
				
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
					$handle->Process('../upload/logosSousCateg/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   
					
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 200;
					$handle->image_y                = 200;
					$handle->Process('../upload/logosSousCateg/200X200/');
					
//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 50;
					$handle->image_y                = 30;
					$handle->Process('../upload/logosSousCateg/50X30/');
					if ($handle->processed) 
					{
						$image  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				
				$my->req('INSERT INTO ttre_categories VALUES("",
										"'.$my->net_input($_POST['idcat']).'" ,
										"'.$my->net_input($_POST['titre']).'",
										"'.$image.'",
										"'.($ordre+1).'"
										)');
				rediriger('?contenu=souscategorie&cat='.$_POST['idcat'].'&ajouterSCat=ok');
			}
			else
			{
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
				while ( $res=$my->arr($req) ) $tabCat[$res['id']]=$res['titre'];
				
				$form = new formulaire('modele_1','?contenu=souscategorie&action=ajouter','<h2 class="titre_niv2">Ajouter sous catégorie :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				$form->select('Catégorie','idcat',$tabCat,'',1);
				$form->text('Titre','titre','',1);
				$form->photo('Photo','photo');
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=categorie">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$temp=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$_GET['id']);
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
					$handle->Process('../upload/logosSousCateg/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   
					
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 200;
					$handle->image_y                = 200;
					$handle->Process('../upload/logosSousCateg/200X200/');
					
//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 50;
					$handle->image_y                = 30;
					$handle->Process('../upload/logosSousCateg/50X30/');
					if ($handle->processed) 
					{
						@unlink('../upload/logosSousCateg/800X600/'.$temp['photo']);
						@unlink('../upload/logosSousCateg/200X200/'.$temp['photo']);
						@unlink('../upload/logosSousCateg/50X30/'.$temp['photo']);
						$image  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				
				$my->req('UPDATE ttre_categories SET 
									parent		=	"'.$my->net_input($_POST['idcat']).'" ,
									titre		=	"'.$my->net_input($_POST['titre']).'" ,
									photo		=	"'.$image.'"
								WHERE id = '.$_GET['id'].' ');				
				rediriger('?contenu=souscategorie&action=modifier&cat='.$_GET['cat'].'&&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if (isset($_GET['supprphoto'] ))
				{
					$temp=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$_GET['id']);
					@unlink('../upload/logosSousCateg/800X600/'.$temp['photo']);
					@unlink('../upload/logosSousCateg/200X200/'.$temp['photo']);
					@unlink('../upload/logosSousCateg/50X30/'.$temp['photo']);
					$my->req('UPDATE ttre_categories SET photo="" WHERE id = "'.$_GET['id'].'" ' );
					rediriger('?contenu=souscategorie&action=modifier&cat='.$_GET['cat'].'&id='.$_GET['id'].'&photosuppr=ok');
					exit;
				}
				
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Cette sous catégorie a bien été modifiée.</p></div>';
				else if ( isset($_GET['photosuppr']) ) $alert='<div id="note" class="success"><p>Cette photo a bien été suprimée.</p></div>';
				else $alert='<div id="note"></div>';
				
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
				while ( $res=$my->arr($req) ) $tabCat[$res['id']]=$res['titre'];
				
				$temp = $my->req_arr('SELECT * FROM ttre_categories WHERE id='.$_GET['id'].' ');
				$photo='img/no_foto_150X150.jpg';$supprimerphoto='';
				if ( !empty($temp['photo']) )
				{
					$photo='../upload/logosSousCateg/200X200/'.$temp['photo'];
					$supprimerphoto='
							<a class="lien_1" href="#" onclick="
								if(confirm(\'Etes vous certain de vouloir supprimer cette photo ?\')) 
								{window.location=\'?contenu=souscategorie&action=modifier&cat='.$_GET['cat'].'&supprphoto=1&id='.$temp['id'].'\'}">
								Supprimer
							</a>
					';
				}
				//$supprimerphoto='';
				
				$form = new formulaire('modele_1','?contenu=souscategorie&action=modifier&cat='.$_GET['cat'].'&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier catégorie :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide($alert);
				$form->select_cu('Catégorie','idcat',$tabCat,$temp['parent'],'',1);
				$form->text('Titre','titre','',1,$temp['titre']);
				$form->vide('<tr><td></td><td><img src="'.$photo.'"/> '.$supprimerphoto.'</td></tr>');
				$form->photo('Photo','photo');
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=souscategorie&cat='.$_GET['cat'].'">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$temp=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$_GET['id'].' ');
			@unlink('../upload/logosSousCateg/800X600/'.$temp['photo']);
			@unlink('../upload/logosSousCateg/200X200/'.$temp['photo']);
			@unlink('../upload/logosSousCateg/50X30/'.$temp['photo']);
			$my->req('DELETE FROM ttre_categories WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=souscategorie&cat='.$_GET['cat'].'&supprimerCat=ok');
			break;	
		case 'ordre' :
			foreach ($_POST['ordre'] as $key=>$value)
				$my->req('UPDATE ttre_categories SET ordre="'.$my->net($key).'" WHERE id='.$my->net($value));
			rediriger('?contenu=souscategorie&cat='.$_POST['idcat'].'&ordre=ok');
			break;
	}
}
else
{
	$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
	if ( $my->num($req)>0 )
	{
		echo '<h1>Gérer les sous catégories</h1>';
		if ( isset($_GET['ordre']) ) echo '<div class="success"><p>L\'ordre a bien été modifié.</p></div>';
		elseif ( isset($_GET['ajouterSCat']) ) echo '<div class="success"><p>La sous catégorie a bien été ajoutée.</p></div>';
		elseif ( isset($_GET['supprimerSCat']) ) echo '<div class="success"><p>La sous catégorie a bien été supprimée.</p></div>';
		echo '<p>Pour ajouter une autre sous catégorie, cliquer <a href="?contenu=souscategorie&action=ajouter">ICI</a></p>';
		
		while ( $res=$my->arr($req) ) $tabCat[$res['id']]=$res['titre'];
		
		$temp=$my->req_arr('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');$parent=$temp['id'];
		if ( isset($_POST['cat']) ) $parent=$_POST['cat'];
		elseif ( isset($_GET['cat']) ) $parent=$_GET['cat'];
		
		$form = new formulaire('modele_1','?contenu=souscategorie','','','','sub','txt','','txt_obl','lab_obl');
		$form->select_cu('Rechercher par catégorie','cat',$tabCat,$parent,'form.submit()');
		$form->afficher_simple();
		
		$req = $my->req('SELECT * FROM ttre_categories WHERE parent='.$parent.' ORDER BY ordre ASC ');
		if ( $my->num($req)>0 )
		{
			echo'
				<form method="POST" action="?contenu=souscategorie&action=ordre" >
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td>Titre</td>
								<td class="bouton">Modifier</td>
								<td class="bouton">Supprimer</td>
								<td class="bouton">Ordre</td>
							</tr>
						</thead>
						<tbody> 
				';
			while ( $res=$my->arr($req) )
			{
				$td_suprimer='
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette sous catégorie ?\')) 
							{window.location=\'?contenu=souscategorie&action=supprimer&cat='.$parent.'&id='.$res['id'].'\'}" title="Supprimer">
							<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
						</td>
							  ';
				$req_part=$my->req('SELECT * FROM ttre_categories WHERE parent='.$res['id'].' ');
				$req_quest=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$res['id'].' ');
				if ( $my->num($req_part)>0 || $my->num($req_quest)>0 ) $td_suprimer='<td class="bouton"></td>';
				echo'
					<tr>
						<td class="nom_prod">'.$res['titre'].'</td>
						<td class="bouton">
							<a href="?contenu=souscategorie&action=modifier&cat='.$parent.'&id='.$res['id'].'">
							<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
						</td>
						'.$td_suprimer.'
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
					<input id="idcat" name="idcat" value="'.$parent.'" type="hidden" />
					<input type="submit"  value="Modifier l\'ordre" style="margin:10px 0 0 250px;"/>
				</form>
				';
		}
		else
		{
			echo '<p>Pas sous catégories ...</p>';
		}
	}
	else
	{
		echo '<p>Il faut ajouter des catégories ...</p>';
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