<?php
require('mysql.php');$my=new mysql();
 include('inc/head.php');?>
	<body id="page1">
		<div class="extra">
			<div class="main">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
<?php include('inc/galerie2.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
					<div class="wrapper">
						<div class="header-page-part">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
								<div class="header-page">
									<h2>F.A.Q</h2>
									<div class="formulaire">
									<h6>Formulaire</h6>
										<ul>
											
										<?php 
											$req = $my->req('SELECT * FROM ttre_formulaire ORDER BY id DESC ');
											if ( $my->num($req)>0 )
											{
												while ( $res=$my->arr($req) )
												{
													echo'<li><a href="upload/fichiers/'.$res['fichier'].'" target="_blanc">'.$res['titre'].'</a></li>';
												}
											}
										?>
										
										</ul>
									</div>
									<div class="bttn-devis">
										<ul>
											<li><a href="devis.php"><i>Créer votre devis</i></a></li>
											<li><a href="prix-travaux.php"><i>Devis Immédiat</i></a></li>
										</ul>
									</div>
								</div>
								</div>
							</div>
							</div>
						</div>

						<div id="content">
							<div class="container">
								<div class="row">
								<div class="col-md-12">
<div class="question">
<ul>
<?php
$res=$my->req('SELECT * FROM ttre_faq order by id asc');
while($req=$my->arr($res))
{
echo '<li><a href="#faq'.$req['id'].'">'.$req['titre'].'</a></li>';
}
?>
</ul>
</div>
<div class="rep">
	<ul>
		<?php
		$res1=$my->req('SELECT * FROM ttre_faq order by id asc');
		while($req1=$my->arr($res1))
			{
				echo '<li><a name="faq'.$req1['id'].'">'.$req1['titre'].'</a></li>';
				echo '<li>'.$req1['description'].'</li>';
			}
		?>
	</ul>
</div>
</div>
<!-- 						</article>
<?php // include('inc/droite.php');?>
						</div>
					<div class="block"></div> -->
					</div>
								</div>
							</div>
						</div>
					</div>
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>