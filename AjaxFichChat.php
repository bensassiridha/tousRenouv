<?php
session_start();
header("Content-Type:text/plain; charset=iso-8859-1");
require('mysql.php');
$my=new mysql();

if ( isset($_SESSION['id_fichier_chat']) )
{
	if ( isset($_POST['text']) )
	{
		if ( !empty($_POST['text']) )
		{
			$temp=$my->req_arr('SELECT * FROM fichiers_chat WHERE id='.$_SESSION['id_fichier_chat'].' ');
			if ( $temp['statut']==2 )
			{
				$text=stripslashes(htmlspecialchars($_POST['text']));
				$text_ajout='<div class="msgln">('.date("H:i").') <b>'.$temp['nom'].'</b>: '.$text.'<br /></div>';
				$texte=$temp['fichier'].$text_ajout;
				$my->req('UPDATE fichiers_chat SET fichier="'.$my->net_tinyMCE($texte).'" WHERE id='.$_SESSION['id_fichier_chat'].' ');
			}
		}
	}
	elseif ( isset($_POST['affich']) )
	{
		$file=$my->req_arr('SELECT * FROM fichiers_chat WHERE id='.$_SESSION['id_fichier_chat'].' ');
		echo $file['fichier'];
	}
	elseif ( isset($_POST['contenufich']) )
	{
		$fichchat=$my->req_arr('SELECT * FROM fichiers_chat WHERE id='.$_SESSION['id_fichier_chat']);
		if ( $fichchat['statut']==3 )
		{
			//unset($_SESSION['id_fichier_chat']);
			echo '0';
		}
		else echo '1';
	}
	elseif ( isset($_POST['exit']) )
	{
		$file=$my->req_arr('SELECT * FROM fichiers_chat WHERE id='.$_SESSION['id_fichier_chat'].' ');
		$texte=$file['fichier'].'<div class="msgln" style="color:#071B8B;"><i>'.$file['nom'].' a quitté(e) le chat.</i><br></div>';
		$my->req('UPDATE fichiers_chat SET statut="3", fichier="'.$my->net_tinyMCE($texte).'" WHERE id='.$_SESSION['id_fichier_chat'].' ' );
		unset($_SESSION['id_fichier_chat']);
	}

}
?>