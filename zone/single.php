<?php
session_start();
require('mysql.php');$my=new mysql();

  $id = $_GET['id'];

if (isset($_GET['id'])) {

  // Getting & cleaning value from url
  $id = mysql_escape_string($_GET['id']);
 // Getting data from table

  $query = "SELECT * FROM ttre_conseil WHERE id = $id";
  $result = mysql_query($query);

  // Checking weather we have results from table
  if (!empty($result)) {
    while ($row = mysql_fetch_array($result)) {
      $photo='../upload/conseils/_no_1.jpg';
    if ( !empty($row['photo']) ) $photo='../upload/conseils/1920X800/'.$row['photo'];
       
        $pageTitle =  $row['titre']; 
      // do operations with your data
    }
  } else {
    echo 'no results';
  }
} else {
  echo 'no pid';
}



 include('inc/head.php');?>
	<body>
<!--==============================header=================================-->
			
<?php include('inc/entete.php');?>
		
<!--==============================aside================================-->


<?php
  $id = $_GET['id'];

if (isset($_GET['id'])) {

  // Getting & cleaning value from url
  $id = mysql_escape_string($_GET['id']);
 // Getting data from table

  $query = "SELECT * FROM ttre_conseil WHERE id = $id";
  $result = mysql_query($query);

  // Checking weather we have results from table
  if (!empty($result)) {
    while ($row = mysql_fetch_array($result)) {
      $photo='../upload/conseils/_no_1.jpg';
    if ( !empty($row['photo']) ) $photo='../upload/conseils/1920X800/'.$row['photo'];
    echo'

<div class="single-post-thumb">
<img src="'.$photo.'">
  <div class="container">
    <div class="row">
      
      <h1>'.$row['titre'].'</h1> 
    </div>
  </div>
</div>


    <div class="container">
    <div class="row">
      <div>'.$row['description'].'</div>
      <div class="col-md-12">
          <div class="get-quote">           
            <div class="quote-img">
              <img src="../images/images/conseil-man-small.png" >
            </div>
            <div class="quote-text">
                <h2>Devis Travaux Rénovation</h2>
                <p>Votre devis détaillée en ligne : Créer votre devis et ayez une estimations rapide de vos travaux</p>
            </div>
            <div class="quote-btns">
                <a href="devis.php" class="create">Créer votre devis</a>
                <a href="prix-travaux.php" class="get">Devis Immédiat</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    ';
     
      // do operations with your data
    }
  } else {
    echo 'no results';
  }
} else {
  echo 'no pid';
}


?>






<!--==============================footer=================================-->
<?php include('inc/pied.php');?>

	</body>
</html>