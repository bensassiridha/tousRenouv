<?php
require('inc/session.php');

//print_r($_POST);

if ( isset($_POST['submit_chatter']) )
{
	$req=$my->req('SELECT * FROM ttre_connection_admin C , ttre_users U, desponibilite_chat D
					WHERE C.id_user=U.id_user AND U.id_user=D.id_user AND ( U.profil=2 OR U.profil=1 )
					AND C.fin=0 AND D.desponibilite=1 AND U.id_user!=1 AND U.id_user='.$_POST['user'].'  ');
	if ( $my->num($req)>0 )
	{
		$user =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_POST['user'].'"');
		$text=stripslashes(htmlspecialchars('Bonjour, je suis votre conseiller en travaux de Sandra Berthier Courtage. Que puis-je pour vous ?'));
		$text_ajout='<div class="msgln">('.date("H:i").') <b>'.$user['nom'].'</b>: '.$text.'<br /></div>';
		$my->req('INSERT INTO fichiers_chat VALUES("","'.$_POST['nom'].'","'.$my->net($_POST['tel']).'","'.$my->net($_POST['email']).'","'.$_POST['user'].'","'.time().'","'.$my->net_tinyMCE($text_ajout).'","0")');
		$_SESSION['id_fichier_chat']=mysql_insert_id();
	}
	header("location:chat.php");
}





$pageTitle = "Chat"; 

include('inc/head.php');?>
	<body id="page2">
<!--==============================header=================================-->
<?php // include('inc/entete.php');?>
<?php // include('inc/galerie2.php');?>
<!--==============================header=================================-->
				<div class="wrapper">
				
				
					<!-- 
					<div class="head-page-style5 subtitle">
						<div class="container">
							<div class="row">
							<div class="col-md-12">
								<h2>Chat</h2>
								<div class="formulaire">
									<h6>Formulaire</h6>
										<ul>
											
										<?php 
											$req = $my->req('SELECT * FROM ttre_formulaire ORDER BY id DESC ');
											if ( $my->num($req)>0 )
											{
												while ( $res=$my->arr($req) )
												{
													echo'<li><a target="_blanc" href="upload/fichiers/'.$res['fichier'].'">'.$res['titre'].'</a></li>';
												}
											}
										?>
										</ul>
									</div>
								</div>
							</div>
						</div>
									<div class="search-btn" >
										<a href="recherche.php">Recherche</a>
									</div>						
					</div>
					
					-->

					<div id="content">
						<div class="container">
							<div class="row">


							
							
<script type="text/javascript">
$(document).ready(function() 
{								
	$('form[name="form_chat"]').submit(function ()
	{
		mes_erreur='';
		if( !$('input[name="user"]').is(':checked') ) { mes_erreur+='<span>Il faut choisir un personne !</span>'; }
		else if( !$.trim(this.nom.value) ) { mes_erreur+='<span>Il faut entrer le champ Nom !</span>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});							
});
</script> 								
							
<?php 
echo'<div style="margin:100px 0 0 0;" ></div>';


//echo 'mm'.$_SESSION['id_fichier_chat'];


$req=$my->req('SELECT DISTINCT ( C.id_user ) FROM ttre_connection_admin C , ttre_users U, desponibilite_chat D
					WHERE C.id_user=U.id_user AND U.id_user=D.id_user AND U.profil=2 
					AND C.fin=0 AND D.desponibilite=1  ');

$reqg=$my->req('SELECT DISTINCT ( C.id_user ) FROM ttre_connection_admin C , ttre_users U, desponibilite_chat D
					WHERE C.id_user=U.id_user AND U.id_user=D.id_user AND U.profil=1
					AND C.fin=0 AND D.desponibilite=1 AND U.id_user!=1 ');

if ( $my->num($req)>0 || $my->num($reqg)>0 )
{
	$form='<div style="margin-left:200px;" ><div id="note"style="width:300px;margin:0;" ></div>
			<br /><form method="post" name="form_chat" >';
	if ( $my->num($req)>0 )
	{
		$form.='<br /><p>La listes des représentants :</p>';
		while ( $res=$my->arr($req) )
		{
			$util=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$res['id_user'].' ');
			$reqd = $my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$res['id_user'].' ');$dep='';
			while ( $resd=$my->arr($reqd) )
			{
				$temp=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$resd['zone'].' ');
				$dep.=$temp['departement_nom'].', ';
			}
			$form.='<p><input type="radio" name="user" value="'.$res['id_user'].'" /> '.$util['nom'].' représentant du '.$dep.'</p>';
		}
	}
	if ( $my->num($reqg)>0 )
	{
		$form.='<br /><p>La listes des administrateurs :</p>';
		while ( $resg=$my->arr($reqg) )
		{
			$util=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$resg['id_user'].' ');
			$form.='<p><input type="radio" name="user" value="'.$resg['id_user'].'" /> '.$util['nom'].'</p>';
		}
	}
	$form.='<p>Votre nom : <input type="text" name="nom" /></p>
			<p>Votre téléphone : <input type="text" name="tel" /></p>
			<p>Votre Email : <input type="text" name="email" /></p>
			<input name="submit_chatter" type="submit" value="Demamde de chat" /></form></div>';
}
else
{
	$form='<div style="margin-left:200px;" >
			<p>Tous nos conseillers en travaux sont indisponibles.</p>
			<p>Pous toutes vos questions contactez nous sur <a href="http://www.tousrenov.fr/contact.php">contact@tousrenov.fr</a></p>
		   </div>';
}


if ( !isset($_SESSION['id_fichier_chat']) )
{
	echo $form ;
}
else
{
	$temp=$my->req_arr('SELECT * FROM fichiers_chat WHERE id='.$_SESSION['id_fichier_chat'].' AND statut!=3 ');
	if ( ! $temp )
	{
		echo $form ;
	}
	elseif ( $temp['statut']==0 )
	{
		echo'
			<p style="text-align: center; margin:50px 0 0 0;"><i>Ne quitter pas, le chat sera disponible dans quelques instants</i></p>
			<p style="text-align: center; margin:15px 0 0 0;"><img src="../ajax-loader.gif" /></p>
			' ;
	}
	elseif ( $temp['statut']==2 )
	{
		$temp=$my->req_arr('SELECT * FROM fichiers_chat WHERE id='.$_SESSION['id_fichier_chat'].' ');
		echo'
			<div id="wrapper">
				<div id="menu">
					<p class="welcome">Bienvenu, <b>'.$temp['nom'].'</b></p>
					<p class="logout"><a id="exit" href="#">Exit Chat</a></p>
					<div style="clear:both"></div>
				</div>	
				<div id="chatbox">'.$temp['fichier'].'</div>
				
				<form name="message" action="">
					<input name="usermsg" type="text" id="usermsg" size="63" />
					<input name="submitmsg" type="submit"  id="submitmsg" value="Envoyer" />
				</form>
			</div>
			';
	}
}
?>							
							


<link rel="stylesheet" type="text/css" href="chat.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
$(document).ready(function()
{
	element = document.getElementById('chatbox');
	element.scrollTop = element.scrollHeight;

	//If user submits the form
	$("#submitmsg").click(function()
	{	
		var clientmsg = $('#usermsg').val();
		$.ajax({
			 type: 'post',
			 url: 'AjaxFichChat.php',
			 data: 'text='+clientmsg,
			 success: function(msg)
				{	
				 	$('#usermsg').val('');
				}
		 });
		return false;
	});
	
	$('#usermsg').keydown(function(event)
	{	
		if(event.keyCode == 13)
		{
			var clientmsg = $('#usermsg').val();
			$.ajax({
				 type: 'post',
				 url: 'AjaxFichChat.php',
				 data: 'text='+clientmsg,
				 success: function(msg)
					{	
					 	$('#usermsg').val('');
					}
			 });
			return false;
		}
	});
	
	//Load the file containing the chat log
	function loadLog()
	{		
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
		$.ajax({
			 type: 'post',
			 url: 'AjaxFichChat.php',
			 data: 'affich=1',
			 success: function(msg)
				{		
				 	$('#chatbox').html(msg);
					//Auto-scroll	
				 	var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
					if(newscrollHeight > oldscrollHeight){
						$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
					}		
				},
		 });
	}
	setInterval (loadLog, 500);	//Reload file every 1000=1seconds

	function contenu_chat()
	{
		$.ajax({
			 type: 'post',
			 url: 'AjaxFichChat.php',
			 data: 'contenufich=1',
			 success: function(msg)
				{	
				 	if (msg==0)
					{
						$('#usermsg').attr('disabled', 'disabled');
						$('#submitmsg').attr('disabled', 'disabled');
					}
				}
		 });
	}
	setInterval (contenu_chat, 500);
	
	//If user wants to end session
	$('#exit').click(function()
	{
		var exit = confirm('Etes-vous sur de vouloir quitter le chat ?');
		if(exit==true)
		{
			$.ajax({
				 type: 'post',
				 url: 'AjaxFichChat.php',
				 data: 'exit=1',
				 success: function(msg)
					{	
					 	window.location = 'chat.php';
					}
			 });	
		}
	});
	
});
</script>

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
 
#chatbox {
	text-align:left;
	margin:0 auto;
	margin-bottom:25px;
	padding:10px;
	background:#fff;
	height:270px;
	width:430px;
	border:1px solid #ACD8F0;
	overflow:auto; }
 
#usermsg {
	margin-left:36px;
	width:363px;
	border:1px solid #ACD8F0; }
 
#submit { width: 60px; }
 
.error { color: #ff0000; }
 
#menu { padding:12.5px 25px 12.5px 25px; }
 
.welcome { float:left; }
 
.logout { float:right; }
 
.msgln { margin:0 0 2px 0; }
</style>






<br /><br /><br /><br /><br />


							</div>
						</div>
					</div>
				</div>	


<?php // include('inc/pied.php');?>
	</body>
</html>
