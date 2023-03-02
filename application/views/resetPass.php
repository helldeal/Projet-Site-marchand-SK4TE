<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?>
<!doctype html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href=<?=base_url().CSS."style.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."forgotpass.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."script.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."headerstyle.css" ?>>
        <title>Mon magasin</title>
    </head>
    <body><a href="<?= base_url()."index.php/User/login" ?>" class="return-home" >
                
                <div class="arrow"></div>
                <div>Retour</div>
            
            </a>
        <div class="resetpass-container">
            
            <div class="consigne">Entrez l'adresse mail de votre compte. <br> Un email va vous être envoyé à cette adresse <br>où vous pourrez changer votre mot de passe.</div>

            <form method="POST" action="<?=base_url()."index.php/User/forgotPasswordEmail"?>">
                <input type="text" placeholder="Entrez votre email" name="email">
                <button class="form-submit" type="submit" name="reset_request">Envoyer</button>
            </form>

            <?php
                if (isset($_GET['state'])){
                    if ($_GET['state']=="success"){
                    ?>
                        <p class="state success">Un email viens de vous être envoyé...</p>
                    <?php
                    } else if ($_GET['state']=="fail"){
                    ?>
                        <p class="state error">Oops, something wrong appened... :</p>
                    <?php
                        if ($_GET['error']==1){
                    ?>
                            <p class="state error">The following account doesn't seems to exist </p>
                    <?php
                        }
                    }
                }
            ?>
        </div>
        <?php $_SESSION["redirect"] = uri_string(); ?>
        <?php include 'footer.php';?>
    </body>
    
</html>
