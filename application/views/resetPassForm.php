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
    <body>
        <?php
        $selector=$_GET["selector"];
        $validator=$_GET["validator"];

        if (empty($selector) || empty($validator)){
            echo "ERROR : Tokens error...";
        } else {
            if ((ctype_xdigit($selector) !== false) && ((ctype_xdigit($selector) !== false))) {
                ?>
                <div class="resetpass-container">
                    <div class="consigne">Choisissez un nouveau mot de passe !</div>
                    <form method="POST" action="<?=base_url()."index.php/User/resetPassword"?>">
                        <input type="hidden" name="selector" value="<?=$selector?>">
                        <input type="hidden" name="validator" value="<?=$validator?>">
                        <input id="password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="pass" placeholder="New password" required>
                        
                        <span>8 caractères minimum dont: 1 maj, 1 min, 1 chiffre.</span>
                        <input id="confirm_password" type="password" name="pass_repeat" placeholder="Comfirm password" required>
                                    <span>Vos mots de passe ne correspondent pas.</span>
                        <button class="form-submit" type="submit" name="reset_pass_submit">Envoyer</button>
                    </form>
                    </div>
                    <?php
                    if (isset($_GET['state'])){
                        if ($_GET['state']=="fail"){
                        ?>
                            <p class="state error">Oops, something wrong appened... :</p>
                        <?php
                            if ($_GET['error']==1){
                        ?>
                                <p class="state error">Passwords aren't the sames</p>
                        <?php
                            } else if ($_GET['error']==2){
                        ?>
                                <p class="state error">An issue occured with the tokens. If this issue still persists, please contact our support. </p>
                        <?php
                            } else if ($_GET['error']==3){
                        ?>
                                <p class="state error">Seems that your account has been permanentely suspended or definitely deleted. Pleas contact support to solve this issue.</p>
                        <?php
                            }
                        }
                    }
                    ?>

                    <?php
            } else {
                echo "ERROR : Tokens at wrong format...";
            }
        }

        ?>
        
        <?php $_SESSION["redirect"] = uri_string(); ?>
        <?php include 'footer.php';?>
    </body>
    
</html>
