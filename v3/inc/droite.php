						<article class="col-2">
						<div class="column-1111">
							<div class="box">
								<div class="aligncenter">
									<h4>Particulier</h4>
								</div>
								<div class="box-bg maxheight">
									<div class="padding">
										<h6 class="color-1">Devis Travaux R&eacute;novation</h6>
										<!--<div class="choix2">
										<a href="prix-travaux.php?id=1"><div class="batiment2">Ma&ccedil;onnerie</div></a>
										<a href="prix-travaux.php?id=2"><div class="menui2">Menuiserie</div></a>
										<a href="prix-travaux.php?id=3"><div class="moq2">Rev&ecirc;tement de sol</div></a>
										<a href="prix-travaux.php?id=4"><div class="tapi2">Rev&ecirc;tement de murs et plafond</div></a>
										<a href="prix-travaux.php?id=5"><div class="plomb2">Plomberie</div></a>
										<a href="prix-travaux.php?id=6"><div class="elec2">&eacute;lectricit&eacute;</div></a>
										</div>-->
									</div>
									<div class="aligncenter">
										<p><a class="acp" href="espace_particulier.php">Acces particulier</a></p>
										<p><a class="button" href="devis.php">Creer Votre devis</a></p>
										<p><a href="prix-travaux.php"><img src="images/inst.png" alt="" height="80" /></a></p>
									</div>
								</div>
							</div>
						</div>
						<div class="column-1111">
							<div class="box">
								<div class="aligncenter">
									<h4>Entreprise</h4>
								</div>
								<div class="box-bg">
									<div class="padding">
										<h6 class="color-1">Devenez Partenaire !</h6>
										<p>Gestion facile et rapide de vos devis , factures ...</p>
									</div>
									<div class="aligncenter">
										<p><a class="acp" href="espace_professionnel.php">Acces pro</a></p>
										<a class="button" href="espace_professionnel.php">Creer votre compte</a>
									</div>
								</div>
							</div>
						</div>							
						
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
                             <h7>Inscription newsletter</h7>
							<div class="wrapper indent-bot">
								<div class="extra-wrap text-1">
									<div class="margin-top">
										<br/><h6>Recevez Nos actualit&eacute;s</h6>
									<form name="formnewsletter" action="" method="post" onSubmit="return validermail(this);" >
									<input name="email" name="email" type="text" class="inp" />
								<input class="button" name="EnvoiNewsletter_inscrit" type="submit" value="Inscription" />
								<input class="button" name="EnvoiNewsletter_desinscrit" type="submit" value="Désincription" />
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
							
							
						