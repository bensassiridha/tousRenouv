<?php
    include('session.php');
    $title = "Devis Menuiserie";
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
       
            $sql= "SELECT * FROM categories_devis WHERE category_id = 2";
            $result = mysqli_query($conn,$sql);
       
       
            
                if($result->num_rows > 0){
                        
                   while($row = $result->fetch_assoc()){
                        $cat_name = $row["category"];                    
                        echo "<h2>".$cat_name."</h2>";
                    }
                    
                }
            
       
            $sql = 'SELECT * FROM demande_devis WHERE category_id = 2';
            $result = mysqli_query($conn,$sql);
            echo "<table class='table table-striped'>
                        <thead> 
                          <tr>
                            <th>ID</th>
                            <th>Civilite</th>
                            <th>Non</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Adresse</th> 
                            <th>Nombre de devis</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>";
            if ($result->num_rows > 0) {
                // output data of each row
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["id"]."</td>
                            <td>".$row["civilite"]."</td>
                            <td>".$row["nom"]."</td>
                            <td>".$row["prenom"]."</td>
                            <td>".$row["email"]."</td>
                            <td>".$row["adresse"]."</td>
                            <td>".$row["nombre"]."</td>
                            <td><a class='view' href='singledevis.php?id=".$row['id']."'><i class='fa fa-eye'></i></a>
                            <a class='delete' href='deldevis.php?id=".$row['id']."' onclick='return confirm('Are you sure you wish to delete this Record?');'><i class='fa fa-trash'></i></a></td>
                          </tr>";
                }
                echo "</tbody>
                  </table>";
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