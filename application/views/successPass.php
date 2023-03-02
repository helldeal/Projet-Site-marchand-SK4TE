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
        <div class="resetpass-container">
        <p class="state success">Votre mot de passe a bien été modifié!</p></div>
        <?php $_SESSION["redirect"] = uri_string(); ?>
        <?php include 'footer.php';?>
    </body>
    
</html>
