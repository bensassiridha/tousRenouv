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
	
					<div class="wrapper">
						<div class="header-page">
							<div class="container">
								<div class="row">
									<h2>Nos services</h2>
								</div>
							</div>
						</div>

						<article class="services">
							<div class="container">
								<div class="row">
									<h3>
										<?php
											$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 2');
											echo $req['titre'];
										?>
									</h3>

									<p>
										<?php
											$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 2');
											echo $req['description'];
										?>
									</p>
									<img src="images/slider/serv1.jpg">
								</div>
							</div>
						</article>

						<article class="services">
							<div class="container">
								<div class="row">
									<h3>
										<?php
											$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 3');
											echo $req['titre'];
										?>
									</h3>

									<p>
										<?php
											$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 3');
											echo $req['description'];
										?>
									</p>
									<img src="images/slider/serv2.jpg">
								</div>
							</div>
						</article>

						<article class="services">
							<div class="container">
								<div class="row">
									<h3>
										<?php
											$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 4');
											echo $req['titre'];
										?>
									</h3>

									<p>
										<?php
											$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 4');
											echo $req['description'];
										?>
									</p>
									<img src="images/slider/serv3.jpg">
								</div>
							</div>
						</article>

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