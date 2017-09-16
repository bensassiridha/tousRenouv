<?php 
$my = new mysql();


if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				for($i=1;$i<11;$i++)
				{
					if ( !empty($_POST['email_'.$i.'']) )
						$my->req('INSERT INTO ttre_inscrits_newsletters VALUES("","'.$my->net_input($_POST['email_'.$i.'']).'" )');
				}
				rediriger('?contenu=news_inscrit&ajouter=ok');
			}
			else
			{
				echo '<div id="note"></div>';
				$form = new formulaire('modele_2','?contenu=news_inscrit&action=ajouter','','ajouter','','sub','txt','','txt_obl','lab_obl');
				for($i=1;$i<11;$i++)
				$form->text('Email '.$i.' ','email_'.$i.'','',1);
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=news_inscrit">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_inscrits_newsletters WHERE id="'.$_GET['id'].'"');
			rediriger('?contenu=news_inscrit&supprimer=ok');
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des inscrits</h1>';
	$alert='';
	if ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Cet inscrit a bien été supprimé.</p></div>';
	if ( isset($_GET['ajouter']) ) echo '<div class="valid_box">Cet email a bien été ajouté.</div>';
	echo '<p>Pour ajouter un email, cliquer <a href="?contenu=news_inscrit&action=ajouter">ICI</a></p>';
	$req=$my->req('SELECT * FROM ttre_inscrits_newsletters ORDER BY email ASC');
	if ( $my->num($req)>0 )
	{
		echo'
			<table id="liste_produits">
				<tr class="entete">
					<td>Email</td>
					<td class="bouton">Supprimer</td>
				</tr>';
		while ( $res=$my->arr($req) )
		{
			echo'
				<tr>
					<td class="nom_prod">'.$res['email'].'</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cet inscrit ?\'))
						{window.location=\'?contenu=news_inscrit&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
						<img src="img/icone_delete.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>
			';
		}
		echo'</table>';
	}
	else
	{
		echo'<p>Pas inscrits ...</p>';
	}
}
?>