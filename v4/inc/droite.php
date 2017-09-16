						<article class="col-2">
						
						
<!-- 						<h7>Rechercher une entreprise</h7> -->
<!-- 							<div class="wrapper indent-bot"> -->
<!-- 								<div class="extra-wrap text-1"> -->
<!-- 									<div class="margin-top"> -->
<!-- 										<br/><h6>Recherche par Mot cl&eacute;</h6> -->
<!-- 									<form name="form1" action="" method="get"> -->
<!-- 									<input class="inp" name="nom" type="text" /> -->
<!-- 								<input class="button" name="submit" type="submit" value="OK" /></form> -->
<!-- 								</div> -->
<!-- 								</div> -->
<!-- 							</div> -->
							
							
<!-- 							<div class="wrapper"> -->
<!-- 								<div class="extra-wrap text-1"> -->
<!-- 									<div class="margin-top"> -->
<!-- 										<br/><h6>Recherche par activit&eacute;</h6> -->
<!-- 									<form name="form2" action="" method="get"> -->
<!-- 								<select class="inp2" name="activite"> -->
<!-- 								<option>S&eacute;lectionner</option> -->
<!-- 								<option>Peinture</option> -->
<!-- 								<option>Menuiserie</option> -->
<!-- 								<option>Carrelage</option> -->
<!-- 								<option>Moquette</option> -->
<!-- 								</select> -->
<!-- 								<input class="button" name="submit" type="submit" value="OK" /></form> -->
<!-- 									</div> -->
<!-- 								</div> -->
<!-- 							</div> -->
							
							
							
							
							
<script type="text/javascript">
	function validermail(formnewsletter)
	{
		var mailValue = formnewsletter.email.value; 
		if( ! $.trim(mailValue) || mailValue=="E-mail" )
    	{
    		alert("Veuillez renseigner votre Email");
    		formnewsletter.email.focus();
    		return false;
    	}
    	else
        {
    		var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
    		if(!exp.test(mailValue))
    		{	
    			alert("votre mail est incorrect !");
    			formnewsletter.email.focus(); 
    			return false ;
    		}
    	}
	}
</script>  							

							<div class="wrapper indent-bot">
								<div class="extra-wrap text-1">
									<div class="margin-top newsletter">
										
									<form name="formnewsletter" action="" method="post" onSubmit="return validermail(this);" >
										<input name="email" name="email" type="text" class="inp" placeholder="Recevez Nos actualit&eacute;s"/>
										<input class="button" name="EnvoiNewsletter_inscrit" type="submit" value="Ok" />
									<!-- <input class="button" name="EnvoiNewsletter_desinscrit" type="submit" value="Désincription" /> -->
									</form>
									</div>
								</div>
							</div>						
							
							
							
							</article>
							
<?php 
if ( isset($_POST['EnvoiNewsletter_inscrit']) )
{
	$email = $_POST['email'];
	$result=$my->req_arr('SELECT * FROM ttre_inscrits_newsletters WHERE email="'.$my->net($email).'"');
	if ( ! $result )
	{
		$my->req('INSERT INTO ttre_inscrits_newsletters VALUES ("","'.$my->net($email).'")');
		echo '<script>alert("Votre adresse email a bien été enregistrée.")</script>';
	}
	else
	{
		echo '<script>alert("Vous êtes déja inscrit.")</script>';
	}
}
if ( isset($_POST['EnvoiNewsletter_desinscrit']) )
{
	$email = $_POST['email'];
	$my->req('DELETE FROM ttre_inscrits_newsletters WHERE email="'.$my->net($email).'" ');
	echo '<script>alert("Votre adresse email a bien été supprimée.")</script>';
}
?>  							
							
							
						