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
        <link rel="stylesheet" href=<?=base_url().CSS."user.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."script.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."headerstyle.css" ?>>
        <title>Mon magasin</title>
    </head>
    <body>
        <p class="state error">How did you get there?</p>
        <p class="state error code">Something wrong append with the tokens. Your link may has expired</p>
        <?php $_SESSION["redirect"] = uri_string(); ?>
    </body>
    
</html>
