<?php
    include('session.php');

    $delete = ($_GET['id']);
    mysqli_query($conn, "DELETE FROM demande_devis WHERE id = '$delete'") or die(mysqli_error($conn));  	
	
	header("Location: index.php");
    
           ?>                        
