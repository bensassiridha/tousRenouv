<?php 
$my = new mysql();

//$my->req('INSERT INTO ttre_tva VALUES("1","'.$my->net_input('Taux réduit').'","0")');
//$my->req('INSERT INTO ttre_tva VALUES("2","'.$my->net_input('Taux intermédiaire').'","0")');
//$my->req('INSERT INTO ttre_tva VALUES("3","'.$my->net_input('Taux normal').'","0")');

if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'modifier' :
			$req=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
			while ( $res=$my->arr($req) ) $my->req('UPDATE ttre_tva SET valeur = "'.$_POST['tva_'.$res['id'].''].'" WHERE id = '.$res['id'].' ');				
			rediriger('?contenu=tva&modifier=ok');
			break;
	}
}
else
{
	if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Tva a bien été modifiée.</p></div>';
	else $alert='<div id="note"></div>';
				
	$form = new formulaire('modele_1','?contenu=tva&action=modifier','<h2 class="titre_niv2">Modifier tva :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
	$form->vide($alert);
	$req=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
	while ( $res=$my->arr($req) ) $form->text(''.$res['titre'].'','tva_'.$res['id'].'','',1,$res['valeur']);
	$form->afficher('Modifier','modifier');
}
?>