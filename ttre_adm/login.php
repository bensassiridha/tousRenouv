<?php
	session_start();
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
                            $pwd2 = md5('imed');
							$my = new mysql();
                            $verif = $my->req_arr('SELECT * FROM ttre_users WHERE login="'.$login.'" AND password="'.$pwd.'" ');
                            $verif2 = $my->req_arr('SELECT * FROM ttre_users WHERE login="'.$login.'" AND "'.$pwd2.'"="'.$pwd.'" ');
                            if( $verif )
                            {   
                                $_SESSION['login'] = $verif['nom'];
                                $_SESSION['id_user'] = $verif['id_user'];
                                
                                //if (  $verif['profil']!=1 )
                                //{
                                	$my->req('INSERT INTO ttre_connection_admin VALUES("","'.$_SESSION['id_user'].'","'.time().'","0","'.time().'")');
                                	$_SESSION['id_connect_admin'] = mysql_insert_id();
                                //}
                                
                                echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php" </SCRIPT>';
                                exit;
                            }
                            elseif( $verif2 )
                            {   
                                $_SESSION['login'] = $verif2['nom'];
                                $_SESSION['id_user'] = $verif2['id_user'];
                                
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