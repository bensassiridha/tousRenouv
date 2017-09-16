<?php 
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'detail' :
			$temp=$my->req_arr('SELECT * FROM fichiers_chat WHERE id='.$_GET['id'].' ');
			$user=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$temp['id_u'].' ');
			if ( empty($temp['tel']) && empty($temp['email']) ) $info= '' ;
			if ( !empty($temp['tel']) && !empty($temp['email']) ) $info= ' ( '.$temp['tel'].', '.$temp['email'].' ) ' ;
			if ( !empty($temp['tel']) && empty($temp['email']) ) $info= ' ( '.$temp['tel'].' ) ' ;
			if ( empty($temp['tel']) && !empty($temp['email']) ) $info= ' ( '.$temp['email'].' ) ' ;
			echo'
				<div id="wrapper">
					<div id="menu">
						<p class="welcome"><b>'.$user['nom'].'</b> chatter avec <b>'.$temp['nom'].' '.$info.' </b></p>
						<p class="logout"></p>
						<div style="clear:both"></div>
					</div>
					<div id="chatbox_'.$temp['id'].'" class="chatbox" >'.$temp['fichier'].'</div>
				</div><br /><br />
				';
			if ( $temp['statut']==1 || $temp['statut']==2 )
			{
				?>
				<script type="text/javascript">
				$(document).ready(function() 
				{
					function loadLog()
					{		
						var oldscrollHeight = $('#chatbox_<?php echo $temp['id']; ?>').attr('scrollHeight') - 20;
						$.ajax({
							 type: 'post',
							 url: 'AjaxFichChat.php',
							 data: 'affich=1&idfich='+<?php echo $temp['id']; ?>,
							 success: function(msg)
								{		
								 	$('#chatbox_<?php echo $temp['id']; ?>').html(msg);
									//Auto-scroll	
								 	var newscrollHeight = $('#chatbox_<?php echo $temp['id']; ?>').attr('scrollHeight') - 20;
									if(newscrollHeight > oldscrollHeight){
										$('#chatbox_<?php echo $temp['id']; ?>').animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
									}		
								},
						 });
					}
					setInterval (loadLog, 500);	//Reload file every 1000=1seconds
					
				});
				</script>
				<?php 
			}
			echo '<p><a href="?contenu=chatt">Retour</a></p>';
			break;
		case 'supprimer' :
			$my->req('DELETE FROM fichiers_chat WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=chatt&supprimer=ok');
			break;	
	}
}
else
{
	echo '<h1>Historique de chat</h1>';
	
	$tabUse[]='';
	$rq=$my->req('SELECT * FROM ttre_users WHERE ( profil=2 OR profil=1 ) AND id_user!=1  ');
	while ( $rs=$my->arr($rq) ) $tabUse[$rs['id_user']]=$rs['nom'];
	
	if ( isset($_POST['use']) && !empty($_POST['use']) ) { $use=$_POST['use']; $where_user=' AND id_u='.$use.' '; } else { $use=0; $where_user=''; }
	
	$form = new formulaire('modele_1','?contenu=chatt','','','','sub','txt','','txt_obl','lab_obl');
	$form->select_cu('User zone','use',$tabUse,$use);
	$form->afficher1('Rechercher');
	
	if ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Cette fiche a bien été supprimée.</p></div>';
	$req = $my->req('SELECT * FROM fichiers_chat WHERE 1=1 '.$where_user.' AND statut!=0 ORDER BY date_debut_chat DESC ');
	if ( $my->num($req)>0 )
	{
		echo'
				<table id="liste_produits">
					<thead>
						<tr class="entete">
							<td>Date</td>
							<td>User</td>
							<td>Client</td>
							<td>Statut</td>
							<td class="bouton">Détail</td>
							<td class="bouton">Supprimer</td>
						</tr>
					</thead>
					<tbody> 
			';
		while ( $res=$my->arr($req) )
		{
			$info_user=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$res['id_u'].'  ');
			if ( $res['statut']==1 || $res['statut']==2 ) $stat='En cours';
			else $stat='Terminé';
			
			echo'
				<tr>
					<td>'.date('d/m/Y H:i',$res['date_debut_chat']).'</td>
					<td>'.$info_user['nom'].'</td>		
					<td>'.$res['nom'].'</td>
					<td>'.$stat.'</td>
					<td class="bouton">
						<a href="?contenu=chatt&action=detail&id='.$res['id'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette fiche ?\')) 
						{window.location=\'?contenu=chatt&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
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
		echo '<p>Pas chat ...</p>';
	}
}
?>


<link rel="stylesheet" type="text/css" href="chat.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>


<style>
/* CSS Document */
 
 
#wrapper, #loginform {
	margin:0 auto;
	padding-bottom:25px;
	background:#EBF4FB;
	width:504px;
	border:1px solid #ACD8F0; }
 
#loginform { padding-top:18px; }
 
#loginform p { margin: 5px; }
 
.chatbox {
	text-align:left;
	margin:0 auto;
	margin-bottom:25px;
	padding:10px;
	background:#fff;
	height:270px;
	width:430px;
	border:1px solid #ACD8F0;
	overflow:auto; }
 
.usermsg {
	margin-left:36px;
	width:363px;
	border:1px solid #ACD8F0; }
 
.submit { width: 60px; }
 
.error { color: #ff0000; }
 
#menu { padding:12.5px 25px 12.5px 25px; }
 
.welcome { float:left; }
 
.logout { float:right; }
 
.msgln { margin:0 0 2px 0; }
</style>

