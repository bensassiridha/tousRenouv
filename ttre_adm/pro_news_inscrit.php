<?php 
$my = new mysql();


if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'supprimer' :
			$my->req('UPDATE ttre_client_pro SET newsletter = 0 WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=pro_news_inscrit&supprimer=ok');
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des inscrits</h1>';
	$alert='';
	if ( isset($_GET['supprimer']) ) $alert='<div class="success"><p>Cet inscrit a bien été supprimé.</p></div>';
	$req=$my->req('SELECT * FROM ttre_client_pro WHERE newsletter=1 AND ( stat_valid_zone=1 OR stat_valid_general=1 ) ORDER BY email ASC');
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
			$userprofil =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
			if ( $userprofil['profil']==1 )
			{
				echo'
					<tr>
						<td class="nom_prod">'.$res['email'].'</td>
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cet inscrit ?\'))
							{window.location=\'?contenu=pro_news_inscrit&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
							<img src="img/icone_delete.png" alt="Supprimer" border="0" /></a>
						</td>
					</tr>
				';
			}
			elseif ( $userprofil['profil']==2 || $userprofil['profil']==6 )
			{
				/*$rs1=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$res['ville'].' ');
				$rs2=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs1['ville_departement'].' ');
				$rq1=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$_SESSION['id_user'].' AND zone='.$rs2['departement_id'].' ');
				if ( $my->num($rq1)>0 )*/
					
				$cd=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$res['id'].' '); $test=0;
				while ( $cdd=$my->arr($cd) )
				{
					$z=$my->req('SELECT * FROM ttre_users_zones WHERE zone='.$cdd['id_departement'].' AND id_user='.$_SESSION['id_user'].' ');
					if ( $my->num($z) ) $test=1 ;
				}	
				if ( $test==1 )
				{
					echo'
						<tr>
							<td class="nom_prod">'.$res['email'].'</td>
							<td class="bouton">
								<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cet inscrit ?\'))
								{window.location=\'?contenu=pro_news_inscrit&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
								<img src="img/icone_delete.png" alt="Supprimer" border="0" /></a>
							</td>
						</tr>
					';
				}
			}
		}
		echo'</table>';
	}
	else
	{
		echo'<p>Pas inscrits ...</p>';
	}
}
?>