<?php 
				$form = new formulaire('modele_1','?contenu=ajout_annonce','','','','sub','txt','','txt_obl','lab_obl');
				
	                    $form->select_cu('Sélectionner un gouvernorat','gouvernorat',$ville,'',1);
	                    $form->select('Sélectionner le secteur','secteur',$cats);
				        $form->datepicker('Date ','date','',true);
				        $form->datepicker1('Date ','date','',true);
						$form->text('Titre ','titre_fr','',1);
						$form->tinyMCE('Description ','description_fr','');
						//$form->photo('Photo du projet ','photo');
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
?>