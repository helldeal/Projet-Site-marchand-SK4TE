<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
$username='null';
if(isset($_SESSION['login'])) $username = $_SESSION['login']["pseudo"]; 
?>
<!doctype html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href=<?=base_url().CSS."style.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."script.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."headerstyle.css" ?>>
        <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
        <title>SKATE</title>
    </head>

    <body>
        <div id="contentlogin">
            <div class="box-connexion" >
                <a href="<?= base_url() ?>" class="return-home" >
                
                    <div class="arrow"></div>
                    <div >Acceuil</div>
                
                </a>
                <div id="log-title">
                    <div id="log-conn"></div>
                    <div id="log-sign"></div>
                </div>
                <div class="select-log">
                    <div class="select-log-conn">
                        <a href="#form-connexion" id="button-conn">Connexion</a>
                        <div id="border-conn-title"></div>
                        
                    </div>
                    <div class="select-log-sign">
                        <a href="#form-sign"  id="button-sign">Inscription</a>
                        <div id="border-sign-title"></div>
                    </div>
                </div>
                <ul class="slides-container"> <!-- slides contenant les deux formulaires (inscription et connexion)-->
                    <li class="slide"><!-- formulaire de connexion-->
                    
                        <form id="form-connexion" action="<?= base_url()."index.php/User/loginCheck" ?>" method="post" style="scroll-margin-top: 1000px;">
                            <div class="div-form">
                                <div>
                                    <label for="identifiant">Identifiant</label>
                                    <input type="text" id="formconn" name="login" placeholder=" " required>
                                </div>
                                <div>
                                    <label for="mdp">Mot de passe</label>
                                    <input type="password"  id="formconn" name="password" placeholder=" "  required>
                                    <a class="forget-pass" href="<?=base_url()."index.php/User/forgotPassword"?>">Mot de passe oublié ?</a>
                                    <?php
                                    if(isset($_GET["error"])&& $_GET["error"]=="invalid"){ ?>
                                    <span class="error-connexion">Email ou mot de passe incorrect</span>
                                    <?php } ?>
                                </div>
                                <button class="form-submit" type="submit">Connexion</button>
                                
                            </div>
                        </form>
                    </li>
                    <li class="slide"> <!-- formulaire d'inscription-->
                        <form id="form-sign" action="<?= base_url()."index.php/User/signinCheck" ?>" method="post" style="scroll-margin-top: 1200px;">
                            <div class="div-form">
                                <div>
                                    <label  for="identifiant">Identifiant</label>
                                    <input  type="email" class="id-sign" id="forminscr" placeholder="exemple@mail.com" name="email" required>
                                    <span>Veuillez entrer une adresse mail.</span>
                                </div>
                                <div>
                                    <label  for="mdp">Mot de passe</label>
                                    <input  type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="pass-sign" id="password"  name="password" placeholder=" "  required>
                                    
                                    <span>8 caractères minimum dont: 1 maj, 1 min, 1 chiffre.</span>
                                </div>
                                <div>
                                    <label  for="cmdp">Confirmer Mot de passe</label>
                                    <input  type="password" class="confirm-pass-sign" id="confirm_password" placeholder=" " name="confpassword" required>
                                    <span>Vos mots de passe ne correspondent pas.</span>
                                </div>
                                <button class="form-submit" type="submit">Inscription</button>
                                                    
                            </div>
                        </form>
                    </li>
                </ul> 
            </div>
        </div>
        <?php $this->session->set_userdata('redirect', uri_string()); ?>
        <?php include 'footer.php';?>
    </body>
    
</html>
