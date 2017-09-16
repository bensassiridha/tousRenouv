<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        // Skin options
        skin : "o2k7",
        skin_variant : "silver",
        // Example content CSS (should be your site CSS)
        content_css : "css/example.css",
        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",
        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
});
</script>
<?php
$my = new mysql();
if (!empty($_GET['action']))
	{$req_cat 	=  $my->req('SELECT * FROM ttre_conseil WHERE id="'.$_GET['id'].'"');
	$cat		=  $my->arr($req_cat);
	switch($_GET['action'])
	{       case 'modifier' :
			if(!empty($_POST['description']))
			{
			$req_ajout_cat = $my->req("update ttre_conseil
			set description =  '".$my->net($_POST["description"])."' where id=".$_GET["id"]);
			if(!$req_ajout_cat)
			{
			echo '<script> alert ("Erreur de dialogue avec la base de données.");</script>';
			}
			else
			{
			echo '<script> alert ("Les données ont bien \351t\351 modifiée.");</script>';
			echo '<script>document.location.href="?contenu=gestion_conseil" </script>';
			exit;
			}
			}
			else
			{
			$form = new formulaire('modele_1','?contenu=gestion_conseil&action=modifier&id='.$_GET['id'],'<h2 class="titre_niv2">Modifier '.$cat['titre'].' :</h2>','','','sub','txt','','txt_obl','lab_obl');
			$form->tinyMCE('description','description',$cat['description']);
			$form->afficher('Enregistrer les modifications');
			}
			break;
	}
}
else
{
echo '<h1>G&eacute;rer la page Conseils</h1>';
echo '
<table id="liste_produits">
<tr class="entete">
<td>Titre</td>
<td class="bouton">Modifier</td>
</tr>';
$req_cat = $my->req('SELECT * FROM ttre_conseil ');
while($infos_cat = $my->arr($req_cat))
{
echo '
<tr>
<td class="nom_prod">'.$infos_cat['titre'].'</td>
<td class="bouton">
<a href="?contenu=gestion_conseil&action=modifier&id='.$infos_cat['id'].'">
<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
</td>

</tr>
';				
}
echo '</table>';
}	
?>