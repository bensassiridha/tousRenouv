<?php 
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouterCat' :
			if ( isset($_POST['ajouter']) )
			{
				$my->req('INSERT INTO ttre_doc VALUES("",
										"0",
										"'.$my->net_input($_POST['titre']).'",
										"",
										"" ,
										"" ,
										"" ,
										"" ,
										"" ,
										""
										)');
				rediriger('?contenu=doc&ajouter=ok');
			}
			else
			{
				$form = new formulaire('modele_1','?contenu=doc&action=ajouterCat','<h2 class="titre_niv2">Ajouter  :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				$form->text('Titre','titre','',1);
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=doc">Retour</a></p>';
			}
			break;
		case 'ajouterDoc' :
			if ( isset($_POST['ajouter']) )
			{
				$fichier1='';
				$handle = new Upload($_FILES['fichier1']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/doc/');
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
					$handle->Process('../upload/doc/');
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
					$handle->Process('../upload/doc/');
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
					$handle->Process('../upload/doc/');
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
					$handle->Process('../upload/doc/');
					if ($handle->processed)
					{
						$fichier5  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$my->req('INSERT INTO ttre_doc VALUES("",
										"'.$my->net_input($_GET['id']).'",
										"'.$my->net_input($_POST['titre']).'",
										"",
										"'.$_SESSION['id_user'].'" ,
										"'.$fichier1.'" ,
										"'.$fichier2.'" ,
										"'.$fichier3.'" ,
										"'.$fichier4.'" ,
										"'.$fichier5.'" 
										)');
				rediriger('?contenu=doc&ajouter=ok');
			}
			else
			{
				$form = new formulaire('modele_1','?contenu=doc&action=ajouterDoc&id='.$_GET['id'].'','<h2 class="titre_niv2">Ajouter  :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				$form->text('Titre','titre','',1);
				$form->photo('Fichier 1','fichier1');
				$form->photo('Fichier 2','fichier2');
				$form->photo('Fichier 3','fichier3');
				$form->photo('Fichier 4','fichier4');
				$form->photo('Fichier 5','fichier5');
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=doc">Retour</a></p>';
			}
			break;
		case 'modifierCat' :
			if ( isset($_POST['modifier']) )
			{
				$my->req('UPDATE ttre_doc SET
									titre		=	"'.$my->net_input($_POST['titre']).'" 
								WHERE id = '.$_GET['id'].' ');
				rediriger('?contenu=doc&action=modifierCat&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Cette fich a bien été modifiée.</p></div>';
				else $alert='<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_doc WHERE id='.$_GET['id'].' ');
				
				$form = new formulaire('modele_1','?contenu=doc&action=modifierCat&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide($alert);
				$form->text('Titre','titre','',1,$temp['titre']);
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=doc">Retour</a></p>';
			}
			break;
		case 'modifierDoc' :
			if ( isset($_POST['modifier']) )
			{
				$temp=$my->req_arr('SELECT * FROM ttre_doc WHERE id='.$_GET['id']);
				$fichier1=$temp['fichier1'];
				$handle = new Upload($_FILES['fichier1']);
				if ($handle->uploaded) 
				{
					$handle->Process('../upload/doc/');
					if ($handle->processed) 
					{
						@unlink('../upload/doc/'.$temp['fichier1']);
						$fichier1  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$fichier2=$temp['fichier2'];
				$handle = new Upload($_FILES['fichier2']);
				if ($handle->uploaded) 
				{
					$handle->Process('../upload/doc/');
					if ($handle->processed) 
					{
						@unlink('../upload/doc/'.$temp['fichier2']);
						$fichier2  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$fichier3=$temp['fichier3'];
				$handle = new Upload($_FILES['fichier3']);
				if ($handle->uploaded) 
				{
					$handle->Process('../upload/doc/');
					if ($handle->processed) 
					{
						@unlink('../upload/doc/'.$temp['fichier3']);
						$fichier3  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$fichier4=$temp['fichier4'];
				$handle = new Upload($_FILES['fichier4']);
				if ($handle->uploaded) 
				{
					$handle->Process('../upload/doc/');
					if ($handle->processed) 
					{
						@unlink('../upload/doc/'.$temp['fichier4']);
						$fichier4  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$fichier5=$temp['fichier5'];
				$handle = new Upload($_FILES['fichier5']);
				if ($handle->uploaded) 
				{
					$handle->Process('../upload/doc/');
					if ($handle->processed) 
					{
						@unlink('../upload/doc/'.$temp['fichier5']);
						$fichier5  = $handle->file_dst_name ;	          // Destination file name              
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
					}
				}
				$my->req('UPDATE ttre_doc SET 
									titre		=	"'.$my->net_input($_POST['titre']).'" ,
									fichier1		=	"'.$fichier1.'" , 
									fichier2		=	"'.$fichier2.'" , 
									fichier3		=	"'.$fichier3.'" , 
									fichier4		=	"'.$fichier4.'" , 
									fichier5		=	"'.$fichier5.'" 
								WHERE id = '.$_GET['id'].' ');				
				rediriger('?contenu=doc&action=modifierDoc&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if ( isset($_GET['supprfich']) )
				{
					$temp = $my->req_arr('SELECT * FROM ttre_doc WHERE id='.$_GET['id'].' ');
					@unlink('../upload/doc/'.$temp['fichier'.$_GET['supprfich'].'']);
					$my->req('UPDATE ttre_doc SET fichier'.$_GET['supprfich'].'	= "" WHERE id = '.$_GET['id'].' ');				
					rediriger('?contenu=doc&action=modifierDoc&id='.$_GET['id'].'&fichSuppr=ok');
				}
				
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Cette fich a bien été modifiée.</p></div>';
				elseif ( isset($_GET['fichSuppr']) ) $alert='<div id="note" class="success"><p>Cette fich a bien été supprimée.</p></div>';
				else $alert='<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_doc WHERE id='.$_GET['id'].' ');
				
				$form = new formulaire('modele_1','?contenu=doc&action=modifierDoc&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide($alert);
				$form->text('Titre','titre','',1,$temp['titre']);
				if ( !empty($temp['fichier1']) ) $form->vide('<tr><td></td><td><a href="../upload/doc/'.$temp['fichier1'].'" target="_blanc" /> '.$temp['fichier1'].'</a> - <a href="?contenu=doc&action=modifierDoc&id='.$_GET['id'].'&supprfich=1">Supp.</a></td></tr>');
				$form->photo('Fichier 1','fichier1');
				if ( !empty($temp['fichier2']) ) $form->vide('<tr><td></td><td><a href="../upload/doc/'.$temp['fichier2'].'" target="_blanc" /> '.$temp['fichier2'].'</a> - <a href="?contenu=doc&action=modifierDoc&id='.$_GET['id'].'&supprfich=2">Supp.</a></td></tr>');
				$form->photo('Fichier 2','fichier2');
				if ( !empty($temp['fichier3']) ) $form->vide('<tr><td></td><td><a href="../upload/doc/'.$temp['fichier3'].'" target="_blanc" /> '.$temp['fichier3'].'</a> - <a href="?contenu=doc&action=modifierDoc&id='.$_GET['id'].'&supprfich=3">Supp.</a></td></tr>');
				$form->photo('Fichier 3','fichier3');
				if ( !empty($temp['fichier4']) ) $form->vide('<tr><td></td><td><a href="../upload/doc/'.$temp['fichier4'].'" target="_blanc" /> '.$temp['fichier4'].'</a> - <a href="?contenu=doc&action=modifierDoc&id='.$_GET['id'].'&supprfich=4">Supp.</a></td></tr>');
				$form->photo('Fichier 4','fichier4');
				if ( !empty($temp['fichier5']) ) $form->vide('<tr><td></td><td><a href="../upload/doc/'.$temp['fichier5'].'" target="_blanc" /> '.$temp['fichier5'].'</a> - <a href="?contenu=doc&action=modifierDoc&id='.$_GET['id'].'&supprfich=5">Supp.</a></td></tr>');
				$form->photo('Fichier 5','fichier5');
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=doc">Retour</a></p>';
			}
			break;
		case 'supprimerCat' :
			$my->req('DELETE FROM ttre_doc WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=doc&supprimer=ok');
			break;	
		case 'supprimerDoc' :
			$temp=$my->req_arr('SELECT * FROM ttre_doc WHERE id='.$_GET['id'].' ');
			@unlink('../upload/doc/'.$temp['fichier1']);
			@unlink('../upload/doc/'.$temp['fichier2']);
			@unlink('../upload/doc/'.$temp['fichier3']);
			@unlink('../upload/doc/'.$temp['fichier4']);
			@unlink('../upload/doc/'.$temp['fichier5']);
			$my->req('DELETE FROM ttre_doc WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=doc&supprimer=ok');
			break;	
	}
}
else
{
	echo '<h1>Gérer les documents</h1>';
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Cette fich a bien été ajoutée.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Cette fich a bien été supprimée.</p></div>';
	
	$userrrr =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
	if ( $userrrr['profil']==1 )
	{
		echo '<p>Pour ajouter une autre categorie, cliquer <a href="?contenu=doc&action=ajouterCat">ICI</a></p>';
		$reqc = $my->req('SELECT * FROM ttre_doc WHERE idc=0 ');
		if ( $my->num($reqc)>0 )
		{
			while ( $resc=$my->arr($reqc) )
			{
				$sup='';
				$tt = $my->req('SELECT * FROM ttre_doc WHERE idc='.$resc['id'].' ');
				if ( $my->num($tt)==0 ) $sup='<a href="?contenu=doc&action=supprimerCat&id='.$resc['id'].'">Supp.</a>';
				echo'
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td>'.$resc['titre'].'</td>
								<td></td>
								<td></td>
								<td class="bouton"><a href="?contenu=doc&action=modifierCat&id='.$resc['id'].'">Modif.</a></td>
								<td class="bouton">'.$sup.'</td>
							</tr>
						</thead>
				';
				$reqd = $my->req('SELECT * FROM ttre_doc WHERE idc='.$resc['id'].' ');
				if ( $my->num($reqd)>0 )
				{
					echo'
							<thead>
								<tr class="entete">
									<td>Titre</td>
									<td>Fichier</td>
									<td>User</td>
									<td class="bouton">Modifier</td>
									<td class="bouton">Supprimer</td>
								</tr>
							</thead>
							<tbody> 
					';
					while ( $resd=$my->arr($reqd) )
					{
						$user=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$resd['id_user'].' ');
						$nom=$user['nom'];
						$fich='';
						if ( !empty($resd['fichier1']) ) $fich.='<a href="../upload/doc/'.$resd['fichier1'].'" target="_blanc" /> '.$resd['fichier1'].'</a>, ';
						if ( !empty($resd['fichier2']) ) $fich.='<a href="../upload/doc/'.$resd['fichier2'].'" target="_blanc" /> '.$resd['fichier2'].'</a>, ';
						if ( !empty($resd['fichier3']) ) $fich.='<a href="../upload/doc/'.$resd['fichier3'].'" target="_blanc" /> '.$resd['fichier3'].'</a>, ';
						if ( !empty($resd['fichier4']) ) $fich.='<a href="../upload/doc/'.$resd['fichier4'].'" target="_blanc" /> '.$resd['fichier4'].'</a>, ';
						if ( !empty($resd['fichier5']) ) $fich.='<a href="../upload/doc/'.$resd['fichier5'].'" target="_blanc" /> '.$resd['fichier5'].'</a>';
						echo'
							<tr>
								<td class="nom_prod">'.$resd['titre'].'</td>
								<td>'.$fich.'</td>
								<td>'.$nom.'</td>
								<td class="bouton">
									<a href="?contenu=doc&action=modifierDoc&id='.$resd['id'].'">
									<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
								</td>
								<td class="bouton">
									<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce doc ?\')) 
									{window.location=\'?contenu=doc&action=supprimerDoc&id='.$resd['id'].'\'}" title="Supprimer">
									<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
								</td>
							</tr>
							';
					}//fin resd
				}//fin reqd
				echo'
							<tr>
								<td colspan="4" style="border:0;"></td>
								<td class="bouton"><a href="?contenu=doc&action=ajouterDoc&id='.$resc['id'].'">Ajout. Doc.</a></td>
							</tr>
					</tbody> 
					</table><br />
					';
			}//fin resc
		}//fin $reqc
		else
		{
			echo '<p>Pas doc ...</p>';
		}
	}
	elseif ( $userrrr['profil']==2 || $userrrr['profil']==6 )
	{
		$reqc = $my->req('SELECT * FROM ttre_doc WHERE idc=0 ');
		if ( $my->num($reqc)>0 )
		{
			while ( $resc=$my->arr($reqc) )
			{
				$sup='';
				echo'
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td>'.$resc['titre'].'</td>
								<td></td>
								<td></td>
							</tr>
						</thead>
				';
				$reqd = $my->req('SELECT * FROM ttre_doc WHERE idc='.$resc['id'].' ');
				if ( $my->num($reqd)>0 )
				{
					echo'
							<thead>
								<tr class="entete">
									<td>Titre</td>
									<td>Fichier</td>
									<td>User</td>
								</tr>
							</thead>
							<tbody> 
					';
					while ( $resd=$my->arr($reqd) )
					{
						$user=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$resd['id_user'].' ');
						$nom=$user['nom'];
						$fich='';
						if ( !empty($resd['fichier1']) ) $fich.='<a href="../upload/doc/'.$resd['fichier1'].'" target="_blanc" /> '.$resd['fichier1'].'</a>, ';
						if ( !empty($resd['fichier2']) ) $fich.='<a href="../upload/doc/'.$resd['fichier2'].'" target="_blanc" /> '.$resd['fichier2'].'</a>, ';
						if ( !empty($resd['fichier3']) ) $fich.='<a href="../upload/doc/'.$resd['fichier3'].'" target="_blanc" /> '.$resd['fichier3'].'</a>, ';
						if ( !empty($resd['fichier4']) ) $fich.='<a href="../upload/doc/'.$resd['fichier4'].'" target="_blanc" /> '.$resd['fichier4'].'</a>, ';
						if ( !empty($resd['fichier5']) ) $fich.='<a href="../upload/doc/'.$resd['fichier5'].'" target="_blanc" /> '.$resd['fichier5'].'</a>';
						echo'
							<tr>
								<td class="nom_prod">'.$resd['titre'].'</td>
								<td>'.$fich.'</td>
								<td>'.$nom.'</td>
							</tr>
							';
					}//fin resd
				}//fin reqd
				echo'
							<tr>
								<td colspan="2" style="border:0;"></td>
								<td class="bouton"><a href="?contenu=doc&action=ajouterDoc&id='.$resc['id'].'">Ajout. Doc.</a></td>
							</tr>
					</tbody> 
					</table><br />
					';
			}//fin resc
		}//fin $reqc
		else
		{
			echo '<p>Pas doc ...</p>';
		}
		
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