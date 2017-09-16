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
                            
                            <h2>Tableau de bord</h2>
                            
                            <!-- NOMBRE DE DEVIS POUR MACONNERIE -->
                            <?php 
                                $sql="SELECT * FROM demande_devis WHERE category_id = 1";

                                if ($result=mysqli_query($conn,$sql))
                                    {
                                        // Return the number of rows in result set
                                        $rowcount=mysqli_num_rows($result);
                                            echo "<div class='col-md-2'>
                                                    <div class='quote-number quote1'>
                                                        <img src='images/icons/Maconnorie.png'>
                                                        <h3>Devis<br/>Maçonnerie</h3>
                                                        <span>".$rowcount."</span>
                                                        <div class='border-effect'></div>
                                                    </div>
                                            </div>";
                                        // Free result set
                                        mysqli_free_result($result);
                                    }
                            ?>
                            
                            
                            <!-- NOMBRE DE DEVIS POUR MACONNERIE -->
                            <?php 
                                $sql="SELECT * FROM demande_devis WHERE category_id = 2";

                                if ($result=mysqli_query($conn,$sql))
                                    {
                                        // Return the number of rows in result set
                                        $rowcount=mysqli_num_rows($result);
                                            echo "<div class='col-md-2'>
                                                    <div class='quote-number quote2'>
                                                        <img src='images/icons/Menuiserie.png'>
                                                        <h3>Devis<br/>Menuiserie</h3>
                                                        <span>".$rowcount."</span>
                                                        <div class='border-effect'></div>
                                                    </div>
                                            </div>";
                                        // Free result set
                                        mysqli_free_result($result);
                                    }
                            ?>
                            
                            <!-- NOMBRE DE DEVIS POUR MACONNERIE -->
                            <?php 
                                $sql="SELECT * FROM demande_devis WHERE category_id = 3";

                                if ($result=mysqli_query($conn,$sql))
                                    {
                                        // Return the number of rows in result set
                                        $rowcount=mysqli_num_rows($result);
                                            echo "<div class='col-md-2'>
                                                    <div class='quote-number quote3'>
                                                        <img src='images/icons/sol.png'>
                                                        <h3>Devis<br/>Revêtement de Sol</h3>
                                                        <span>".$rowcount."</span>
                                                        <div class='border-effect'></div>
                                                    </div>
                                            </div>";
                                        // Free result set
                                        mysqli_free_result($result);
                                    }
                            ?>
                            
                            <!-- NOMBRE DE DEVIS POUR MACONNERIE -->
                            <?php 
                                $sql="SELECT * FROM demande_devis WHERE category_id = 4";

                                if ($result=mysqli_query($conn,$sql))
                                    {
                                        // Return the number of rows in result set
                                        $rowcount=mysqli_num_rows($result);
                                            echo "<div class='col-md-2'>
                                                    <div class='quote-number quote4'>
                                                        <img src='images/icons/Murs.png'>
                                                        <h3>Devis<br/>de Murs & Plafond</h3>
                                                        <span>".$rowcount."</span>
                                                        <div class='border-effect'></div>
                                                    </div>
                                            </div>";
                                        // Free result set
                                        mysqli_free_result($result);
                                    }
                            ?>
                            
                            <!-- NOMBRE DE DEVIS POUR MACONNERIE -->
                            <?php 
                                $sql="SELECT * FROM demande_devis WHERE category_id = 5";

                                if ($result=mysqli_query($conn,$sql))
                                    {
                                        // Return the number of rows in result set
                                        $rowcount=mysqli_num_rows($result);
                                            echo "<div class='col-md-2'>
                                                    <div class='quote-number quote5'>
                                                        <img src='images/icons/Plomberie.png'>
                                                        <h3>Devis<br/>Plomberie</h3>
                                                        <span>".$rowcount."</span>
                                                        <div class='border-effect'></div>
                                                    </div>
                                            </div>";
                                        // Free result set
                                        mysqli_free_result($result);
                                    }
                            ?>
                            
                            <!-- NOMBRE DE DEVIS POUR MACONNERIE -->
                            <?php 
                                $sql="SELECT * FROM demande_devis WHERE category_id = 6";

                                if ($result=mysqli_query($conn,$sql))
                                    {
                                        // Return the number of rows in result set
                                        $rowcount=mysqli_num_rows($result);
                                            echo "<div class='col-md-2'>
                                                    <div class='quote-number quote6'>
                                                        <img src='images/icons/Electricite.png'>
                                                        <h3>Devis<br/>Electricité</h3>
                                                        <span>".$rowcount."</span>
                                                        <div class='border-effect'></div> 
                                                    </div>
                                            </div>";
                                        // Free result set
                                        mysqli_free_result($result);
                                    }
                            ?>
<?php 
   
            $sql = 'SELECT * FROM demande_devis';
            $result = mysqli_query($conn,$sql);
            
            if ($result->num_rows > 0) {
                // output data of each row
                echo "<div><table class='table table-striped'>
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Civilite</th>
                            <th>Non</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Nombre de devis</th>
                            <th>Téléphone</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["id"]."</td>
                            <td>".$row["civilite"]."</td>
                            <td>".$row["nom"]."</td>
                            <td>".$row["prenom"]."</td>
                            <td>".$row["email"]."</td>
                            <td>".$row["adresse"]."</td>
                            <td>".$row["nombre"]."</td>
                            <td>".$row["phone"]."</td>
                            <td><a class='view' href='singledevis.php?id=".$row['id']."'><i class='fa fa-eye'></i></a>
                            <a class='delete' href='deldevis.php?id=".$row['id']."' onclick='return confirm('Are you sure you wish to delete this Record?');'><i class='fa fa-trash'></i></a></td>
                          </tr>";
                }
                echo "</tbody>
                  </table></div>";
            } else {
                echo "0 results";
            }
                   ?>                        
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
      
   </body>
   
</html>