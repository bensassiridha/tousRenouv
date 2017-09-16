<?php
$my = new mysql();
if ( isset($_POST['modifier']) )
{
	$temp=$my->req_arr('SELECT * FROM logo WHERE id=1 ');
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
		$handle->Process('../upload/logo/original/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.   
		
		
		$handle->image_ratio_no_zoom_in = true;
		$handle->image_resize           = true;
		$handle->image_x                = 150;
		$handle->image_y                = 100;
		$handle->Process('../upload/logo/150X100/');
		if ($handle->processed) 
		{
			@unlink('../upload/logo/original/'.$temp['photo']);
			@unlink('../upload/logo/150X100/'.$temp['photo']);
			$image  = $handle->file_dst_name ;	          // Destination file name              
			$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
		}
	}
	$my->req('UPDATE logo SET photo	=	"'.$image.'" WHERE id = 1 ');				
	rediriger('?contenu=logo&modifier=ok');
}
else
{
	if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Ce logo a bien été modifié.</p></div>';
	$temp = $my->req_arr('SELECT * FROM logo WHERE id=1 ');
	$form = new formulaire('modele_1','?contenu=logo','<h2 class="titre_niv2">Modifier logo :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
	$form->vide($alert);
	$form->vide('<tr><td></td><td><img src="../upload/logo/150X100/'.$temp['photo'].'"/></td></tr>');
	$form->photo('Photo','photo');
	$form->afficher('Modifier','modifier');
	echo '<p><a href="?contenu=annonce">Retour</a></p>';
}
?>
