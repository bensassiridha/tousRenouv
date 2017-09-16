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
								<h2>Presentation Tousrenov</h2>
<?php
$req=$my->req_arr('SELECT * FROM ttre_presentation WHERE id = 1');
echo $req['description'];
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