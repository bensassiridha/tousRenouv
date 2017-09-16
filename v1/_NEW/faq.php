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
								<h2>F. a .q</h2>
								<div class="question"><ul>
<?php
$res=$my->req('SELECT * FROM ttre_faq order by id asc');
while($req=$my->arr($res))
{
echo '<li><a href="#faq'.$req['id'].'">'.$req['titre'].'</a></li>';
}
?>
</ul></div>
<div class="rep"><ul><?php
$res1=$my->req('SELECT * FROM ttre_faq order by id asc');
while($req1=$my->arr($res1))
{
echo '<li><a name="faq'.$req1['id'].'">'.$req1['titre'].'</a></li>';
echo '<li>'.$req1['description'].'</li>';
}
?>
</ul></div>
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