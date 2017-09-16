<?php 
$my = new mysql();
$exi=$my->req('SELECT * FROM desponibilite_chat WHERE id_user='.$_SESSION['id_user'].' ');
if ( $my->num($exi)==0 )$my->req('INSERT INTO desponibilite_chat VALUES("'.$_SESSION['id_user'].'","")');

if ( isset($_POST['disp']) )
{
	$my->req('UPDATE desponibilite_chat SET desponibilite = "'.$my->net_input($_POST['disp']).'"  WHERE id_user = '.$_SESSION['id_user'].' ');
	rediriger('?contenu=chat');
}
else
{
	$tab=array(1=>'Oui',0=>'Non');
	$temp=$my->req_arr('SELECT * FROM desponibilite_chat WHERE id_user='.$_SESSION['id_user'].' ');
	$form = new formulaire('modele_1','?contenu=chat','','ajouter','','sub','txt','','txt_obl','lab_obl');
	$form->radio_cu('Disponibilité','disp',$tab,$temp['desponibilite']);
	$form->afficher1('Modifier');
}
echo'<br /><br />';





if ( isset($_SESSION['idf']) )
{
	$my->req('UPDATE fichiers_chat SET statut="1" WHERE id='.$_SESSION['idf'].' ' );
	unset($_SESSION['idf']);
}


$req=$my->req('SELECT * FROM fichiers_chat WHERE id_u='.$_SESSION['id_user'].' AND ( statut=1 OR statut=2 ) ');
while ( $res=$my->arr($req) )
{
	$user=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$_SESSION['id_user'].' ');
	if ( empty($res['tel']) && empty($res['email']) ) $info= '' ;
	if ( !empty($res['tel']) && !empty($res['email']) ) $info= ' ( '.$res['tel'].', '.$res['email'].' ) ' ;
	if ( !empty($res['tel']) && empty($res['email']) ) $info= ' ( '.$res['tel'].' ) ' ;
	if ( empty($res['tel']) && !empty($res['email']) ) $info= ' ( '.$res['email'].' ) ' ;
	echo'						
		<div id="wrapper">
			<div id="menu">
				<p class="welcome"><b>'.$user['nom'].'</b> chatter avec <b>'.$res['nom'].' '.$info.' </b></p>
				<p class="logout"><a id="exit_'.$res['id'].'" href="#">Exit Chat</a></p>
				<div style="clear:both"></div>
			</div>	
			<div id="chatbox_'.$res['id'].'" class="chatbox" ></div>
			
			<form name="message" action="">
				<input class="usermsg" type="text" id="usermsg_'.$res['id'].'" size="63" />
				<input class="submitmsg" type="submit"  id="submitmsg_'.$res['id'].'" value="Envoyer" />
			</form>
		</div><br /><br />
		';
	?>
	<script type="text/javascript">
	// jQuery Document
	$(document).ready(function()
	{
		element = document.getElementById('chatbox_<?php echo $res['id']; ?>');
		element.scrollTop = element.scrollHeight;
	
		//If user submits the form
		$('#submitmsg_<?php echo $res['id']; ?>').click(function()
		{	
			var clientmsg = $('#usermsg_<?php echo $res['id']; ?>').val();
			$.ajax({
				 type: 'post',
				 url: 'AjaxFichChat.php',
				 data: 'text='+clientmsg+'&idfich='+<?php echo $res['id']; ?>,
				 success: function(msg)
					{	
					 	$('#usermsg_<?php echo $res['id']; ?>').val('');
					}
			 });
			return false;
		});
		
		$('#usermsg_<?php echo $res['id']; ?>').keydown(function(event)
		{	
			if(event.keyCode == 13)
			{
				var clientmsg = $('#usermsg_<?php echo $res['id']; ?>').val();
				$.ajax({
					 type: 'post',
					 url: 'AjaxFichChat.php',
					 data: 'text='+clientmsg+'&idfich='+<?php echo $res['id']; ?>,
					 success: function(msg)
						{	
						 	$('#usermsg_<?php echo $res['id']; ?>').val('');
						}
				 });
				return false;
			}
		});
		
		//Load the file containing the chat log
		function loadLog()
		{		
			var oldscrollHeight = $('#chatbox_<?php echo $res['id']; ?>').attr('scrollHeight') - 20;
			$.ajax({
				 type: 'post',
				 url: 'AjaxFichChat.php',
				 data: 'affich=1&idfich='+<?php echo $res['id']; ?>,
				 success: function(msg)
					{		
					 	$('#chatbox_<?php echo $res['id']; ?>').html(msg);
						//Auto-scroll	
					 	var newscrollHeight = $('#chatbox_<?php echo $res['id']; ?>').attr('scrollHeight') - 20;
						if(newscrollHeight > oldscrollHeight){
							$('#chatbox_<?php echo $res['id']; ?>').animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
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
				 data: 'contenufich=1&idfich='+<?php echo $res['id']; ?>,
				 success: function(msg)
					{	
					 	if (msg==0)
						{
							$('#usermsg_<?php echo $res['id']; ?>').attr('disabled', 'disabled');
							$('#submitmsg_<?php echo $res['id']; ?>').attr('disabled', 'disabled');
						}
					}
			 });
		}
		setInterval (contenu_chat, 500);
		
		//If user wants to end session
		$('#exit_<?php echo $res['id']; ?>').click(function()
		{
			var exit = confirm('Etes-vous sur de vouloir quitter le chat ?');
			if(exit==true)
			{
				$.ajax({
					 type: 'post',
					 url: 'AjaxFichChat.php',
					 data: 'exit=1&idfich='+<?php echo $res['id']; ?>,
					 success: function(msg)
						{	
						 	window.location = 'index.php?contenu=chat';
						}
				 });	
			}
		});
		
	});
	</script>
	
	<?php
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




