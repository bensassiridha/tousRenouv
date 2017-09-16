<script type="text/javascript" src="admin/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
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
<script type="text/javascript">
function addRowToTable()
{
  var tbl = document.getElementById('tblSample');
  var n = 10;
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow-1;
  if ( iteration <= n )
  {
  var row = tbl.insertRow(lastRow);
  
  $("#tblSample tr:last").css("background-color","#E5E5E5");
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration);
  cellLeft.appendChild(textNode);
    /*
  //right cell
  var cellRight = row.insertCell(1);
  var el = document.createElement('input');
  el.type = 'text';
  el.name = 'txtRow' + iteration;
  el.id = 'txtRow' + iteration;
  el.size = 20;
  el.setAttribute('class','txt') ;  
  el.onkeypress = keyPressTest;
  cellRight.appendChild(el);
  */
  // select cell
 var cellCenterSel = row.insertCell(1);
      var sel = document.createElement('input');
      //sel.type = 'file';
      sel.name = 'titrephoto' + iteration;
//    sel.size = 20;
      sel.className='txt';
      cellCenterSel.appendChild(sel);
      
      /* 
      var cellRightSel = row.insertCell(2);
      var sel = document.createElement('textarea');
      //sel.type = 'file';
      sel.name = 'description' + iteration;
      sel.id = 'description' + iteration;
      sel.cols = '20';
      sel.rows = '3';
//    sel.size = 20;
      sel.className='txt';
      cellRightSel.appendChild(sel);
      */

      // select cell
      
      var cellRightSel = row.insertCell(2);
      var sel = document.createElement('input');
      sel.type = 'file';
      sel.name = 'fileRow' + iteration;
      sel.id = 'fileRow' + iteration;
      sel.size = 20;
      sel.className='txt';
      cellRightSel.appendChild(sel);
  document.getElementById('nbre').value = iteration;
}else{
      alert('Maximum dix photos');
  }}
function keyPressTest(e, obj)
{
  var validateChkb = document.getElementById('chkValidateOnKeyPress');
  if (validateChkb.checked) {
    var displayObj = document.getElementById('spanOutput');
    var key;
    if(window.event) {
      key = window.event.keyCode; 
    }
    else if(e.which) {
      key = e.which;
    }
    var objId;
    if (obj != null) {
      objId = obj.id;
    } else {
      objId = this.id;
    }
    displayObj.innerHTML = objId + ' : ' + String.fromCharCode(key);
  }
}
function removeRowFromTable()
{
  var tbl = document.getElementById('tblSample');
  var lastRow = tbl.rows.length;
  if (lastRow > 3) tbl.deleteRow(lastRow - 1);
  document.getElementById('nbre').value = lastRow-2 ;
}
function openInNewWindow(frm)
{
  // open a blank window
  var aWindow = window.open('', 'TableAddRowNewWindow',
   'scrollbars=yes,menubar=yes,resizable=yes,toolbar=no,width=400,height=400');
   
  // set the target to the blank window
  frm.target = 'TableAddRowNewWindow';
  
  // submit
  frm.submit();
}
function validateRow(frm)
{
  var chkb = document.getElementById('chkValidate');
  if (chkb.checked) {
    var tbl = document.getElementById('tblSample');
    var lastRow = tbl.rows.length - 1;
    var i;
    for (i=1; i<=lastRow; i++) {
      var aRow = document.getElementById('txtRow' + i);
      if (aRow.value.length <= 0) {
        alert('Row ' + i + ' is empty');
        return;
      }
    }
  }
  openInNewWindow(frm);
}

</script><?php

$rand = substr(mt_rand(),1,5);

$my = new mysql();

			if(!empty($_POST['titre']))
			{

				
			$req_ajout_cat = $my->req("	INSERT INTO ttre_faq VALUES('','".$my->net($_POST['titre'])."','".$my->net($_POST['rep'])."')");
						if(!$req_ajout_cat)
							{
								echo '<script> alert ("Erreur de dialogue avec la base de donnÃ©es.");</script>';
							}
							else
							{
								echo '<script> alert ("Les données ont  bien \351t\351 Ajout\351e.");</script>';
								echo '<script>document.location.href="javascript:history.go(-1)" </script>';
								exit;
							}
			}
			else
			{
				
								
				# formulaire de modification
$tab = array();

				$form = new formulaire('modele_1','?contenu=ajout_faq','','','','sub','txt','','txt_obl','lab_obl');
						$form->text('Question','titre','',1);
						$form->tinyMCE('Reponse','rep','');
	$form->vide('</table></td></tr>');
	
	
	
								/*  $form->vide('<input type="hidden" name="nbre" id="nbre" value="1" >
								<tr><td colspan="2">
								<table border="1" id="tblSample" >
								<tr><td colspan="2">
								<p>
								<input type="button" value="+ photo" onclick="addRowToTable();" />
								<input type="button" value="- photo" onclick="removeRowFromTable();" />
								</p>
								</td></tr>
								<tr style="text-align:center; background-color:#D3DCE3;">
								<th>N°</td>
								<th>titre</td>
								<th>photo</td>
								</tr>
								
								<tr  style="background-color:#E5E5E5;">
								<td >1</td>
								<td>
								<input name="titrephoto1" class="txt" id="titrephoto1" type="text" />
								</td>
								<td>
								<input name="fileRow1" class="txt" id="fileRow1" type="file" size="20" maxlength="100000" accept="text/*" />
								</td>
								</tr>
								</table><table></tr></table><br><br><br>');*/
				$form->afficher('Enregistrer');
			}
		

?>