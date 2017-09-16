<?php
    include('session.php');
    $title = "Tableau de bord";
    include_once('includes/header.php');
?>     
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="top-navbar">
                            <div class="col-md-2">
                                <div class="row">
                                    <div class="logo">
                                        <a href="index.php"><img src="images/logo.png" ></a>
                                    </div>
                                </div>
                            </div>
                            <div class="user">
                                <div class="thumbnail"><img src="images/user.jpg"></div>
                                <span>Welcome <?php echo $login_session; ?></span>
                                <span class="logout"><a href = "logout.php"><i class="fa fa-sign-out"></i></a></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="row">
                        <div class="main-navbar">
                            <nav>
                                <ul>
                                    <li>
                                        <a href="index.php"><i class="menu-icon fa fa-dashboard"></i>Tableau de bord</a>
                                    </li>
                                    <li>
                                        <a href="maconnerie-devis.php">
                                            <i class="menu-icon"><img src="images/icons/Maconnorie.png" ></i>Maçonnerie
                                        </a>
                                    </li>
                                    <li>
                                        <a href="menuiserie-devis.php">
                                            <i class="menu-icon"><img src="images/icons/Menuiserie.png" ></i> Menuiserie
                                        </a>
                                    </li>
                                    <li>
                                        <a href="sol-devis.php">
                                            <i class="menu-icon"><img src="images/icons/sol.png" ></i>Revêtement de Sol
                                        </a>
                                    </li>
                                    <li>
                                        <a href="mursplafond-devis.php">
                                            <i class="menu-icon"><img src="images/icons/Murs.png" ></i> Murs et Plafond
                                        </a>
                                    </li>
                                    <li>
                                        <a href="plomberie-devis.php">
                                            <i class="menu-icon"><img src="images/icons/Plomberie.png" ></i> Plomberie
                                        </a>
                                    </li>
                                    <li>
                                        <a href="electricite-devis.php">
                                            <i class="menu-icon"><img src="images/icons/Electricite.png" ></i> Electricité
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-10">
                    <div class="">
                        <div class="content">
                            
            <?php 
            if ( isset($_GET['id']) ){
                $id = ($_GET['id']);

            }
            $sql = 'SELECT * FROM demande_devis WHERE id = "'.$id.'" ';
            $result = mysqli_query($conn,$sql);
            echo "<div class='quote clearfix'>";
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo " 
                        
                            <div class='col-md-6'>
                                <div class='row'>
                                    <div class='info-client'>
                                        <ul>
                                            <li><h3 class='name'>".$row["nom"]."  ".$row["prenom"]."</h3></li>
                                            <li><span>Email: ".$row["email"]."</span></li>
                                            <li><span>Téléphone: ".$row["phone"]."</span></li>
                                            <li><span>Adresse: ".$row["adresse"].", ".$row["ville"]."</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='row'>
                                    <div class='info-devis'>
                                        <ul>
                                            <li><h3>N° De Demande ".$row["devis_id"]."</h3></li>
                                            <li><span>Date</span></li>
                                            <li><span>Nombre de devis: ".$row["nombre"]."</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-12'>
                                <div class='row'>
                                    <div class='quote-title'>
                                        <h2>Demande devis </h2>
                                        <span>Delais de Réalisation ".$row["period"]."</span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-12'>
                                <div class='row'>
                                    <div class='quote-details clearfix'>
                                        <div class='details'>
                                            <div class=''>
                                                <label>Vous êtes</label>
                                                <span>".$row["spec"]."</span>
                                            </div>
                                        </div>
                                        <div class='details'>
                                            <div class=''>
                                                <label>Type de travaux</label>
                                                <span>".$row["travaux"]."</span>
                                            </div>
                                        </div>
                                        <div class='details'>
                                            <div class=''>
                                                <label>Type de bâtiment</label>
                                                <span>".$row["batiment"]."</span>
                                            </div>
                                        </div>
                                        <div class='details'>
                                            <div class=''>
                                                <label>Disponibilite</label>
                                                <span>".$row["disponibility"]."</span>
                                            </div>
                                        </div>
                                        <div class='details'>
                                            <div class=''>
                                                <label>Jusqu'a</label>
                                                <span>".$row["until"]."</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-12'>
                                <div class='row'>
                                    <div class='devis-content'>
                                        <label>Message</label>
                                        <p>".$row["content"]."</p>
                                    </div>
                                </div>
                            </div>
                        
                    ";
                }
            } else {
                echo "0 results";
            }
            echo "</div>";
                   ?>                        
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
       
   </body>
   
</html>