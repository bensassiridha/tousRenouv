<?php
require('mysql.php');$my=new mysql();
 include('inc/head.php');?>
	<body id="page1">
		<div class="extra">
			<div class="main">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
		
			</header>
<!--==============================aside================================-->
				<aside>
					<div class="wrapper">
						<div class="column-11">
							<div class="box">
								<div class="aligncenter">
									<h4>Particulier</h4>
								</div>
								<div class="box-bg maxheight">
									<div class="padding">
										<h6 class="color-1">Devis Travaux R&eacute;novation</h6>
										<!--<div class="choix">
										<a href="prix-travaux.php?id=1"><div class="batiment">Ma&ccedil;onnerie</div></a>
										<a href="prix-travaux.php?id=2"><div class="menui">Menuiserie</div></a>
										<a href="prix-travaux.php?id=3"><div class="moq">Rev&ecirc;tement de sol</div></a>
										<a href="prix-travaux.php?id=4"><div class="tapi">Rev&ecirc;tement de murs et plafond</div></a>
										<a href="prix-travaux.php?id=5"><div class="plomb">Plomberie</div></a>
										<a href="prix-travaux.php?id=6"><div class="elec">&eacute;lectricit&eacute;</div></a>
										</div>-->
									</div>
									<div class="aligncenter">
									<p>Votre devis d&eacute;taill&eacute; en ligne: cr&eacute;er votre et ayez une estimations rapide de vos travaux  </p>
										<p><a class="acp" href="#">Acces particulier</a></p>
										<p><a class="button" href="devis.php">Creer Votre devis</a></p>
										<p><a href="prix-travaux.php"><img src="images/inst.png" alt="" height="100" /></a></p>
									</div>
								</div>
							</div>
						</div>
						<div class="column-1">
							<div class="box">
								<div class="aligncenter">
									<h4>Entreprise</h4>
								</div>
								<div class="box-bg maxheight">
									<div class="padding">
										<h6 class="color-1">Devenez Partenaire !</h6>
										<p>Gestion facile et rapide de vos devis , factures ...</p>
										<p align="center"><img src="images/part.png"  height="100" alt="" /></p>
									</div>
									<div class="aligncenter">
										<p><a class="acp" href="#">Acces pro</a></p>
										<a class="button" href="#">Creer votre compte</a>
									</div>
								</div>
							</div>
						</div>
			<div class="rech"><strong>Recherche par Mot cl&eacute;</strong>
			<form name="form1" action="" method="get">
			<input class="inp" name="nom" type="text" />
			<input class="button2" name="submit" type="submit" value="OK" /></form>		
			</div>
			<div class="rech"><strong>Recherche par activit&eacute;</strong>
			<form name="form2" action="" method="get">
			<select class="inp2" name="activite">
			<option>S&eacute;lectionner</option>
			<option>Peinture</option>
			<option>Menuiserie</option>
			<option>Carrelage</option>
			<option>Moquette</option>
			</select>
			<input class="button2" name="submit" type="submit" value="OK" /></form>	
			</div>			
			<div class="rech2"><strong>Inscription newsletter</strong>
			<form name="form3" action="" method="get">
			<input name="nom" type="text" class="inp" />
			<input class="button2" name="submit" type="submit" value="OK" /></form>
			</div>					</div>
				</aside>
<!--==============================content================================-->
				<section id="content">
					<div class="wrapper">
						<article class="col-111">
							<div class="indent-left">
								
<?php
$req=$my->req_arr('SELECT * FROM ttre_presentation WHERE id = 1');
//echo $req['description'];
?>
</div>
						</article>
						</div>
					<div class="block"></div>
				</section>
			</div>
		</div>
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>