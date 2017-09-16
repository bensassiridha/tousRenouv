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
					$handle->Process('../upload/services/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   
					
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 555;
					$handle->image_y                = 150;
					$handle->Process('../upload/services/555X150/');
					
//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 100;
					$handle->image_y                = 100;
					$handle->Process('../upload/services/100X100/');
					if ($handle->processed) 
					{
						$image  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$imagei='';
				$handle = new Upload($_FILES['photoi']);
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
					$handle->Process('../upload/services/800X600i/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   
					
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 350;
					$handle->image_y                = 240;
					$handle->Process('../upload/services/350X240i/');
					
//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 100;
					$handle->image_y                = 100;
					$handle->Process('../upload/services/100X100i/');
					if ($handle->processed) 
					{
						$imagei  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$my->req('INSERT INTO ttre_service VALUES("",
										"'.$my->net_input($_POST['titre']).'",
										"'.$my->net_textarea($_POST['description']).'",
										"'.$_SESSION['id_user'].'" ,
										"'.$image.'" ,
										"'.$imagei.'"
										)');
				rediriger('?contenu=zservice&ajouter=ok');
			}
			else
			{
				$form = new formulaire('modele_1','?contenu=zservice&action=ajouter','<h2 class="titre_niv2">Ajouter service :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				$form->text('Titre','titre','',1);
				$form->textarea('Description','description');
				$form->photo('Photo','photo');
				$form->photo('Photo de la page index','photoi');
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=zservice">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$temp=$my->req_arr('SELECT * FROM ttre_service WHERE id='.$_GET['id']);
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
					$handle->Process('../upload/services/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   
					
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 555;
					$handle->image_y                = 150;
					$handle->Process('../upload/services/555X150/');
					
//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 100;
					$handle->image_y                = 100;
					$handle->Process('../upload/services/100X100/');
					if ($handle->processed) 
					{
						@unlink('../upload/services/800X600/'.$temp['photo']);
						@unlink('../upload/services/555X150/'.$temp['photo']);
						@unlink('../upload/services/100X100/'.$temp['photo']);
						$image  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$imagei=$temp['photoi'];
				$handle = new Upload($_FILES['photoi']);
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
					$handle->Process('../upload/services/800X600i/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   
					
					$handle->image_ratio_no_zoom_in = true;
					$handle->image_resize           = true;
					$handle->image_x                = 350;
					$handle->image_y                = 240;
					$handle->Process('../upload/services/350X240i/');
					
//					$handle->image_ratio_no_zoom_in = true;
					$handle->image_ratio_x          = true;
					$handle->image_resize           = true;
					$handle->image_x                = 100;
					$handle->image_y                = 100;
					$handle->Process('../upload/services/100X100i/');
					if ($handle->processed) 
					{
						@unlink('../upload/services/800X600i/'.$temp['photoi']);
						@unlink('../upload/services/350X240i/'.$temp['photoi']);
						@unlink('../upload/services/100X100i/'.$temp['photoi']);
						$imagei  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$my->req('UPDATE ttre_service SET 
									titre		=	"'.$my->net_input($_POST['titre']).'" ,
									description	=	"'.$my->net_textarea($_POST['description']).'" ,
									photo		=	"'.$image.'" ,
									photoi		=	"'.$imagei.'" 
								WHERE id = '.$_GET['id'].' ');				
				rediriger('?contenu=zservice&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if (isset($_GET['supprphoto'] ))
				{
					$temp=$my->req_arr('SELECT * FROM ttre_service WHERE id='.$_GET['id']);
					@unlink('../upload/services/800X600/'.$temp['photo']);
					@unlink('../upload/services/555X150/'.$temp['photo']);
					@unlink('../upload/services/100X100/'.$temp['photo']);
					$my->req('UPDATE ttre_service SET photo="" WHERE id = "'.$_GET['id'].'" ' );
					rediriger('?contenu=zservice&action=modifier&id='.$_GET['id'].'&photosuppr=ok');
					exit;
				}
				if (isset($_GET['supprphotoi'] ))
				{
					$temp=$my->req_arr('SELECT * FROM ttre_service WHERE id='.$_GET['id']);
					@unlink('../upload/services/800X600i/'.$temp['photoi']);
					@unlink('../upload/services/350X240i/'.$temp['photoi']);
					@unlink('../upload/services/100X100i/'.$temp['photoi']);
					$my->req('UPDATE ttre_service SET photoi="" WHERE id = "'.$_GET['id'].'" ' );
					rediriger('?contenu=zservice&action=modifier&id='.$_GET['id'].'&photosuppr=ok');
					exit;
				}
				
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Cette service a bien été modifiée.</p></div>';
				else if ( isset($_GET['photosuppr']) ) $alert='<div id="note" class="success"><p>Cette photo a bien été suprimée.</p></div>';
				else $alert='<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_service WHERE id='.$_GET['id'].' ');
				$photo='img/no_foto_150X150.jpg';$supprimerphoto='';
				if ( !empty($temp['photo']) )
				{
					$photo='../upload/services/100X100/'.$temp['photo'];
					$supprimerphoto='
							<a class="lien_1" href="#" onclick="
								if(confirm(\'Etes vous certain de vouloir supprimer cette photo ?\')) 
								{window.location=\'?contenu=zservice&action=modifier&supprphoto=1&id='.$temp['id'].'\'}">
								Supprimer
							</a>
					';
				}
				$photoi='img/no_foto_150X150.jpg';$supprimerphotoi='';
				if ( !empty($temp['photoi']) )
				{
					$photoi='../upload/services/100X100i/'.$temp['photoi'];
					$supprimerphotoi='
							<a class="lien_1" href="#" onclick="
								if(confirm(\'Etes vous certain de vouloir supprimer cette photo ?\')) 
								{window.location=\'?contenu=zservice&action=modifier&supprphotoi=1&id='.$temp['id'].'\'}">
								Supprimer
							</a>
					';
				}
				
				$form = new formulaire('modele_1','?contenu=zservice&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier service :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide($alert);
				$form->text('Titre','titre','',1,$temp['titre']);
				$form->textarea('Description','description',str_replace('<br />','',$temp['description']));
				$form->vide('<tr><td></td><td><img src="'.$photo.'"/> '.$supprimerphoto.'</td></tr>');
				$form->photo('Photo','photo');
				$form->vide('<tr><td></td><td><img src="'.$photoi.'"/> '.$supprimerphotoi.'</td></tr>');
				$form->photo('Photo de la page index','photoi');
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=zservice">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$temp=$my->req_arr('SELECT * FROM ttre_service WHERE id='.$_GET['id'].' ');
			@unlink('../upload/services/800X600/'.$temp['photo']);
			@unlink('../upload/services/555X150/'.$temp['photo']);
			@unlink('../upload/services/100X100/'.$temp['photo']);
			@unlink('../upload/services/800X600i/'.$temp['photoi']);
			@unlink('../upload/services/350X240i/'.$temp['photoi']);
			@unlink('../upload/services/100X100i/'.$temp['photoi']);
			$my->req('DELETE FROM ttre_service WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=zservice&supprimer=ok');
			break;	
	}
}
else
{
	echo '<h1>Gérer les services</h1>';
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Cette service a bien été ajoutée.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Cette service a bien été supprimée.</p></div>';
	echo '<p>Pour ajouter une autre service, cliquer <a href="?contenu=zservice&action=ajouter">ICI</a></p>';
	$req = $my->req('SELECT * FROM ttre_service WHERE id_user='.$_SESSION['id_user'].' ');
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
						<a href="?contenu=zservice&action=modifier&id='.$res['id'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette service ?\')) 
						{window.location=\'?contenu=zservice&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
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
		echo '<p>Pas service ...</p>';
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