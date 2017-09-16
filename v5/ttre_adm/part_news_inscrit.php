<?php 
$my = new mysql();


if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'supprimer' :
			$my->req('DELETE FROM ttre_inscrits_newsletters_part WHERE id="'.$_GET['id'].'"');
			rediriger('?contenu=part_news_inscrit&supprimer=ok');
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des inscrits</h1>';
	$alert='';
	if ( isset($_GET['supprimer']) ) $alert='<div class="success"><p>Cet inscrit a bien été supprimé.</p></div>';
	$req=$my->req('SELECT * FROM ttre_inscrits_newsletters_part ORDER BY email ASC');
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
						{window.location=\'?contenu=part_news_inscrit&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
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