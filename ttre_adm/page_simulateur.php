<?php
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
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
					$handle->Process('../upload/simulateur/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.
						
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 420;
					$handle->image_y                = 200;
					$handle->Process('../upload/simulateur/420X200/');
						
					//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 540;
					$handle->image_y                = 250;
					$handle->Process('../upload/simulateur/540X250/');
					if ($handle->processed)
					{
						$image  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$my->req('INSERT INTO ttre_simulateur VALUES("",
										"'.$my->net_input($_POST['titre']).'" ,
										"'.$my->net_input($_POST['url']).'" ,
										"'.$image.'"
										)');
				rediriger('?contenu=simulateur&ajouter=ok');
			}
			else
			{
				echo '<div id="note"></div>';
				$form = new formulaire('modele_2','?contenu=simulateur&action=ajouter','','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->text('Titre','titre','',1);
				$form->text('Url','url','',1);
				$form->photo('Photo','photo');
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=simulateur">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$temp=$my->req_arr('SELECT * FROM ttre_simulateur WHERE id='.$_GET['id']);
				$image=$temp['photo'];
				$handle = new Upload($_FILES['photo']);
				if ($handle->uploaded)
				{
					///$handle->file_name_body_pre     = 'News_';    // prepends to the name body (default: '')
					//$handle->image_ratio_crop       = true;       // t3abi alcadre wa tkos zayed
					//$handle->image_ratio_fill       = true;       // tkos wa t3abi transparent nakes
					//$handle->image_ratio            = true;       // resize image conserving the original sizes ratio(default: false)
					$handle->image_ratio_no_zoom_in = true;       // same as image_ratio, but won't resize if the source image is smaller than image_x  x image_y  (default: false)
					$handle->image_resize           = true;       // determines is an image will be resized (default: false)
					$handle->image_x                = 800;        // destination image width (default: 150)
					$handle->image_y                = 600;        // destination image height (default: 150)
					$handle->Process('../upload/simulateur/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.
						
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 420;
					$handle->image_y                = 200;
					$handle->Process('../upload/simulateur/420X200/');
						
					//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 540;
					$handle->image_y                = 250;
					$handle->Process('../upload/simulateur/540X250/');
					if ($handle->processed)
					{
						@unlink('../upload/simulateur/800X600/'.$temp['photo']);
						@unlink('../upload/simulateur/420X200/'.$temp['photo']);
						@unlink('../upload/simulateur/540X250/'.$temp['photo']);
						$image  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$my->req('UPDATE ttre_simulateur SET 
								titre			=	"'.$my->net_input($_POST['titre']).'" ,
								url				=	"'.$my->net_input($_POST['url']).'" ,
								photo			=	"'.$image.'" 
										WHERE id = "'.$_GET['id'].'" ');			
				rediriger('?contenu=simulateur&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if (isset($_GET['supprphoto'] ))
				{
					$temp=$my->req_arr('SELECT * FROM ttre_simulateur WHERE id='.$_GET['id']);
					@unlink('../upload/simulateur/800X600/'.$temp['photo']);
					@unlink('../upload/simulateur/420X200/'.$temp['photo']);
					@unlink('../upload/simulateur/540X250/'.$temp['photo']);
					$my->req('UPDATE ttre_simulateur SET photo="" WHERE id = "'.$_GET['id'].'" ' );
					rediriger('?contenu=simulateur&action=modifier&id='.$_GET['id'].'&modifier=ok');
					exit;
				}
				
				if ( isset($_GET['modifier']) ) echo '<div id="note" class="valid_box">Cet url a bien été modifié.</div>';
				else echo '<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_simulateur WHERE id='.$_GET['id'].' ');
				$photo='img/no_foto_150X150.jpg';$supprimerphoto='';
				if ( !empty($temp['photo']) )
				{
					$photo='../upload/simulateur/540X250/'.$temp['photo'];
					$supprimerphoto='
							<a class="lien_1" href="#" onclick="
								if(confirm(\'Etes vous certain de vouloir supprimer cette photo ?\'))
								{window.location=\'?contenu=simulateur&action=modifier&supprphoto=1&id='.$temp['id'].'\'}">
								Supprimer
							</a>
					';
				}
				$form = new formulaire('modele_2','?contenu=simulateur&action=modifier&id='.$_GET['id'].'','','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->text('Titre','titre','',1,$temp['titre']);
				$form->text('Url','url','',1,$temp['url']);
				$form->vide('<tr><td></td><td><img src="'.$photo.'"/> '.$supprimerphoto.'</td></tr>');
				$form->photo('Photo','photo');
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=simulateur">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$temp = $my->req_arr('SELECT * FROM ttre_simulateur WHERE id='.$_GET['id'].' ');
			@unlink('../upload/simulateur/800X600/'.$temp['photo']);
			@unlink('../upload/simulateur/420X200/'.$temp['photo']);
			@unlink('../upload/simulateur/540X250/'.$temp['photo']);
			$my->req('DELETE FROM ttre_simulateur WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=simulateur&supprimer=ok');
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des simulateurs</h1>';
	if ( isset($_GET['ajouter']) ) echo '<div class="valid_box">Cet url a bien été ajouté.</div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="valid_box">Cet url a bien été supprimé.</div>';
	echo '<p>Pour ajouter un url, cliquer <a href="?contenu=simulateur&action=ajouter">ICI</a></p>';
	$req = $my->req('SELECT * FROM ttre_simulateur ORDER BY id DESC ');
	if ( $my->num($req)>0 )
	{
		echo'
			<table id="liste_produits">
				<tr class="entete">
					<td>Titre</td>
					<td>Url</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
		while ( $res=$my->arr($req) )
		{
			echo'
				<tr>
					<td class="nom_prod">'.$res['titre'].'</td>
					<td class="nom_prod">'.$res['url'].'</td>
					<td class="bouton">
						<a href="?contenu=simulateur&action=modifier&id='.$res['id'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cet url ?\')) 
						{window.location=\'?contenu=simulateur&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
						<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>
				';
		}
		echo'</table>';
	}
	else
	{
		echo '<p>Pas url ...</p>';
	}
}
?>
 <script type="text/javascript"> 
$(document).ready(function() {
	$('form[name="ajouter"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !'; }
		else if( !$.trim(this.url.value) ) { mes_erreur+='Il faut choisir un Url !'; }
		if ( mes_erreur ) { $("#note").addClass("error_box");$("#note").html(mes_erreur); return(false); }
	});
	$('form[name="modifier"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !'; }
		else if( !$.trim(this.url.value) ) { mes_erreur+='Il faut choisir un Url !'; }
		if ( mes_erreur ) { $("#note").addClass("error_box");$("#note").html(mes_erreur); return(false); }
	});
});
 </script> 






