<?php
    session_start();
    include("mysql.php");

    $title = "Tousrenov &rsaquo; Log In";
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        
        $sql = "SELECT * FROM users WHERE username = '$username' and password='$password'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        $count = mysqli_num_rows($result);
        
        if($count == 1){
            //session_register("username");
            $_SESSION['username'] = $username;
            
            header("location: index.php");
        }else{
            $error = "Your username or password is invalid";
        }
    }

    include_once('includes/header.php');
?>


    <div class="login">
        <div class="logo">
        <img src="images/logo.png" alt="Devis gratuit en ligne et sans aucun engagement. Chiffrer le coût de vos travaux de rénovation ou de construction">
        </div>
        
        <div class="login-form">
        
        <form action="" method="post">
            <input type="text" name="username" id="username" placeholder="Username" >
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="submit" value="Login" >
        </form>
        </div>
    </div>

