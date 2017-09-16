<?php
	// session_start();
	require('mysql.php');
	require('formulaire.php');
	require('fonctions.php');
	include("inc/inc_photo_bg.php");
	?>
<?php
					if (!empty($_SESSION['login']))
 						{
        				rediriger('index.php');
						}   
				else
				 {
	
					if(isset($_POST['login']) && isset($_POST['pwd']))
                    {
						if(!empty($_POST['login']) && !empty($_POST['pwd']))
                        {
                            $login = $_POST['login'];
                            $pwd = md5($_POST['pwd']);
							$conn = new mysql();
							$my = new mysql();
                            $data = $conn->req_obj("SELECT login, password, nom FROM ttre_users WHERE login='$login'");
                            $verif = $my->req_arr("SELECT * FROM ttre_users WHERE login='$login'");
                            if($data->login == $login && $data->password == $pwd)
                            {   //$_SESSION['admin'] = $verif['statut'];
                                $_SESSION['login'] = $data->nom;
                                if($data->login == 'liweb' or $data->login == 'aroua')
                                {
                                    $_SESSION['login_type'] = 1;
                                }
                                else
                                {
                                    $_SESSION['login_type'] = 0;
                                }
                                echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php" </SCRIPT>';
                                exit;
                            }
                            else
                            {
                                header("location: connect.php?erreur=1");
                                echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="connect.php" </SCRIPT>';
                                exit;
                            }	
                        }
                        else
                        {
                                header("location: connect.php?erreur=1");
                            echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="connect.php" </SCRIPT>';
                            exit;
                        }
                    }
                    else
                    {
                            echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="connect.php" </SCRIPT>';
					}
					}
					?>			