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
				<section id="content">
					<div class="wrapper">
						<article class="col-1">
							<div class="indent-left">
								<h2>Formulaires</h2>











<?php 
$req = $my->req('SELECT * FROM ttre_formulaire ORDER BY id DESC ');
if ( $my->num($req)>0 )
{
	while ( $res=$my->arr($req) )
	{
		echo'<p><a href="upload/fichiers/'.$res['fichier'].'" target="_blanc">'.$res['titre'].'</a></p>';
	}
}
?>

































</div>
						</article>
<?php include('inc/droite.php');?>
						</div>
					<div class="block"></div>
				</section>
			</div>
		</div>
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>