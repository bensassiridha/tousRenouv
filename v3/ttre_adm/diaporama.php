<?php
$my = new mysql();
if ( !empty($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'modifier_diap' :
			if ( isset($_POST['modifier']) )
			{
				$req = $my->req('SELECT * FROM ttre_diaporama WHERE idg='.$_GET['id'].' ORDER BY id ASC');
				if ( $my->num($req)>0 )
				{
					$i=0;
					while ( $res=$my->arr($req) )
					{
						$i++;
						$my->req('UPDATE ttre_diaporama SET lien = "'.$_POST['Lien'.$i.''].'" WHERE id='.$res['id'].'' );
						$image = $res['photo'];
						$handle = new Upload($_FILES['Photo'.$i]);
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
							$handle->Process('../upload/diaporamas/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.
								
							$handle->image_ratio_no_zoom_in = true;
							$handle->image_resize           = true;
							$handle->image_x                = 150;
							$handle->image_y                = 150;
							$handle->Process('../upload/diaporamas/150X150/');
								
							$handle->image_ratio_no_zoom_in = true;
							$handle->image_resize           = true;
							$handle->image_x                = 100;
							$handle->image_y                = 100;
							$handle->Process('../upload/diaporamas/100X100/');
							if ($handle->processed)
							{
								@unlink('../upload/diaporamas/800X600/'.$res['photo']);
								@unlink('../upload/diaporamas/150X150/'.$res['photo']);
								@unlink('../upload/diaporamas/100X100/'.$res['photo']);
								$image  = $handle->file_dst_name ;	          // Destination file name
								$handle-> Clean();                           // Deletes the uploaded file from its temporary location
								$my->req('UPDATE ttre_diaporama SET photo= "'.$image.'" WHERE id='.$res['id'].'' );
							}
						}
					}
				}
				for ($i = 1; $i <= $_POST['nbrPhoto']; $i++)
				{
					$image ='';
					$handle = new Upload($_FILES['Photo_'.$i]);
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
						$handle->Process('../upload/diaporamas/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.
				
						$handle->image_ratio_no_zoom_in = true;
						$handle->image_resize           = true;
						$handle->image_x                = 150;
						$handle->image_y                = 150;
						$handle->Process('../upload/diaporamas/150X150/');
				
						$handle->image_ratio_no_zoom_in = true;
						$handle->image_resize           = true;
						$handle->image_x                = 100;
						$handle->image_y                = 100;
						$handle->Process('../upload/diaporamas/100X100/');
						if ($handle->processed)
						{
							$image  = $handle->file_dst_name ;	          // Destination file name
							$handle-> Clean();                           // Deletes the uploaded file from its temporary location
							$my->req('INSERT INTO ttre_diaporama VALUES("","'.$_GET['id'].'","'.$image.'","'.$_POST['Lien_'.$i.''].'")');
						}
					}
				}
				rediriger('?contenu=diaporama&action=modifier_diap&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if ( isset($_GET['supprgal']) )
				{
					$prod = $my->req_arr('SELECT * FROM ttre_diaporama WHERE id='.$_GET['supprgal']);
					@unlink('../upload/diaporamas/800X600/'.$prod['photo']);
					@unlink('../upload/diaporamas/150X150/'.$prod['photo']);
					@unlink('../upload/diaporamas/100X100/'.$prod['photo']);
					$my->req('DELETE FROM ttre_diaporama WHERE id='.$_GET['supprgal']);
					rediriger('?contenu=diaporama&action=modifier_diap&id='.$_GET['id'].'&photosuppr=ok');
				}
				
				$alert='';
				if ( isset($_GET['modifier']) ) $alert='<div class="valid_box">Cette diaporama a bien été modifiée.</div>';
				elseif ( isset($_GET['photosuppr']) ) $alert='<div id="note" class="success"><p>La photo a bien été supprimée.</p></div>';
				
				$photo_existe='';
				$req=$my->req('SELECT * FROM ttre_diaporama WHERE idg='.$_GET['id'].' ORDER BY id ASC');
				$n=$my->num($req);
				if ( $n>0 )
				{
					$photo_existe.='
									<table>
										<tr style="background-color:#D3DCE3;">
											<th align="center"><label>Lien</label></th>
											<th align="center"><label>Photo</label></th>
											<th align="center"><label>Modifier ( 700X90 )</label></th>
											<th align="center"><label>Supprimer</label></th>
										</tr>
									</tr>
								  ';
					$j=0;
					while ( $res=$my->arr($req) )
					{
						$j++ ;
						$photo_existe.='
						 			<tr style="background-color:#E5E5E5;">
										<td style="text-align: center;">
											<input type="text" name="Lien'.$j.'" value="'.$res['lien'].'"  />
										</td>
										<td style="text-align: center;">
											<img src="../upload/diaporamas/100X100/'.$res['photo'].'"  />
										</td>
										<td>
											<input type="file" name="Photo'.$j.'"   />
										</td>
										<td align="center">
											<a class="lien_1" href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette photo ?\'))
												{window.location=\'?contenu=diaporama&action=modifier_diap&id='.$_GET['id'].'&supprgal='.$res['id'].'\'}" class="lien_1">
												Supprimer
											</a>
										</td>
									</tr>
										 ';
							
					}
					$photo_existe.='</table>';
				}
				
				$form = new formulaire('modele_2','?contenu=diaporama&action=modifier_diap&id='.$_GET['id'].'','','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note">'.$alert.'</div>');
				$form->vide('
							<tr>
								<td>Photos :</td>
								<td>
									'.$photo_existe.'
									<input type="hidden" name="nbrPhoto" id="nbrPhoto" value="1" >
									<table style="text-align:center;" id="tblPhoto" >
										<tr>
											<td colspan="2" style="text-align:center;">
												<input type="button" value="[+]" onclick="addRowToTablePhoto();"  style="cursor:pointer"/>
												<input type="button" value="[-]" onclick="removeRowFromTablePhoto();"  style="cursor:pointer"/>
											</td>
										</tr>
										<tr style="text-align:center; background-color:#D3DCE3;">
											<th>N°</td>
											<th>Lien</td>
											<th>Photo ( 700X90 )</td>
										</tr>
										<tr style="background-color:#E5E5E5;">
											<td>1</td>
											<td><input type="text" name="Lien_1" /></td>
											<td><input type="file" name="Photo_1" /></td>
										</tr>
									</table>
								</td>
							</tr>
							');
				$form->afficher('Enregistrer','modifier');
				echo '<p><a href="?contenu=diaporama">Retour</a></p>';
			}
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la diaporama</h1>';
	echo'
		<table id="liste_produits">
			<tr class="entete">
				<td>Titre</td>
				<td class="bouton">Modifier</td>
			</tr>
			<tr>
				<td>Diaporama</td>
				<td class="bouton">
					<a href="?contenu=diaporama&action=modifier_diap&id=1">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
				</td>
			</tr>
		</table>
		';
}	
?>




<script type="text/javascript">
function addRowToTablePhoto()
{
  	var tbl = document.getElementById('tblPhoto');
 	var lastRow = tbl.rows.length;
  	var iteration = lastRow-1;
  
  	var row = tbl.insertRow(lastRow);
  	$("#tblPhoto tr:last").css("background-color","#E5E5E5");
  	  
	var cellLeft = row.insertCell(0);
	var textNode = document.createTextNode(iteration);
	cellLeft.appendChild(textNode);

	var cellRightSel = row.insertCell(1);
  	var el=$('<input type="text" name="Lien_'+iteration+'" />');
  	$(cellRightSel).append(el);
	
	var cellRightSel = row.insertCell(2);
  	var el=$('<input type="file" name="Photo_'+iteration+'" />');
  	$(cellRightSel).append(el);
	
	document.getElementById('nbrPhoto').value = iteration;
}
function removeRowFromTablePhoto()
{
  	var tbl = document.getElementById('tblPhoto');
  	var lastRow = tbl.rows.length;
  	if (lastRow > 3) 
  	{
      	tbl.deleteRow(lastRow - 1);
      	document.getElementById('nbrPhoto').value --;
  	}
}
function addRowToTablePhotoo()
{
  	var tbl = document.getElementById('tblPhoto');
 	var lastRow = tbl.rows.length;
  	var iteration = lastRow-1;
  
  	var row = tbl.insertRow(lastRow);
  	$("#tblPhoto tr:last").css("background-color","#E5E5E5");
  	  
	var cellLeft = row.insertCell(0);
	var textNode = document.createTextNode(iteration);
	cellLeft.appendChild(textNode);

	var cellRightSel = row.insertCell(1);
  	var el=$('<input type="file" name="Photo_'+iteration+'" />');
  	$(cellRightSel).append(el);
	
	document.getElementById('nbrPhoto').value = iteration;
}
</script>

