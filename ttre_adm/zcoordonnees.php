<?php
$my = new mysql();

$test = $my->req('SELECT * FROM ttre_zcoordonnees WHERE id='.$_SESSION['id_user'].' ');
if ( $my->num($req)==0 ) $my->req('INSERT INTO ttre_zcoordonnees VALUES("'.$_SESSION['id_user'].'","","","" )');

if ( isset($_POST['modifier']) )
{
	$temp=$my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_SESSION['id_user']);
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
		$handle->Process('../upload/zcoordonnees/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.
			
		$handle->image_ratio_no_zoom_in = true;
		$handle->image_resize           = true;
		$handle->image_x                = 310;
		$handle->image_y                = 280;
		$handle->Process('../upload/zcoordonnees/310X280/');
			
		//					$handle->image_ratio_no_zoom_in = true;
		$handle->image_ratio_x          = true;
		$handle->image_resize           = true;
		$handle->image_x                = 100;
		$handle->image_y                = 100;
		$handle->Process('../upload/zcoordonnees/100X100/');
		if ($handle->processed)
		{
			@unlink('../upload/zcoordonnees/800X600/'.$temp['photo']);
			@unlink('../upload/zcoordonnees/310X280/'.$temp['photo']);
			@unlink('../upload/zcoordonnees/100X100/'.$temp['photo']);
			$image  = $handle->file_dst_name ;	          // Destination file name
			$handle-> Clean();                           // Deletes the uploaded file from its temporary location
		}
	}
	$my->req('UPDATE ttre_zcoordonnees SET 
					email			=	"'.$my->net_input($_POST['email']).'" ,
					tel				=	"'.$my->net_input($_POST['tel']).'" ,
					photo			=	"'.$image.'" 
							WHERE id = "'.$_SESSION['id_user'].'" ');			
	rediriger('?contenu=zcoordonnees&modifier=ok');
}
else
{
	if (isset($_GET['supprphoto'] ))
	{
		$temp=$my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_SESSION['id_user']);
		@unlink('../upload/zcoordonnees/800X600/'.$temp['photo']);
		@unlink('../upload/zcoordonnees/310X280/'.$temp['photo']);
		@unlink('../upload/zcoordonnees/100X100/'.$temp['photo']);
		$my->req('UPDATE ttre_zcoordonnees SET photo="" WHERE id = "'.$_SESSION['id_user'].'" ' );
		rediriger('?contenu=zcoordonnees&photosuppr=ok');
		exit;
	}
	//echo '<h1 style="margin-top:0;" >Gérer la liste des coordonnées</h1>';
	if ( isset($_GET['modifier']) ) echo '<div id="note" class="valid_box">Cette coordonnée a bien été modifiée.</div>';
	else if ( isset($_GET['photosuppr']) ) $alert='<div id="note" class="success"><p>Cette photo a bien été suprimée.</p></div>';
	else echo '<div id="note"></div>';
	$temp = $my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_SESSION['id_user'].' ');
	$photo='img/no_foto_310X280.jpg';$supprimerphoto='';
	if ( !empty($temp['photo']) )
	{
		$photo='../upload/zcoordonnees/310X280/'.$temp['photo'];
		$supprimerphoto='
							<a class="lien_1" href="#" onclick="
								if(confirm(\'Etes vous certain de vouloir supprimer cette photo ?\'))
								{window.location=\'?contenu=zcoordonnees&supprphoto=1\'}">
								Supprimer
							</a>
					';
	}
	$form = new formulaire('modele_2','?contenu=zcoordonnees&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier coordonnée :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
	$form->text('Email','email','',1,$temp['email']);
	$form->text('Tel','tel','',1,$temp['tel']);
	$form->vide('<tr><td></td><td><img src="'.$photo.'"/> '.$supprimerphoto.'</td></tr>');
	$form->photo('Photo','photo');
	$form->afficher('Modifier','modifier');
}
?>






