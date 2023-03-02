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
        <title>Session Over</title>
    </head>
    <body>
        <p class="state error">Zzzzzz</p>
        <p class="state error code">It'seems that your session has expired... Did you just passed out?</p>
        <?php $_SESSION["redirect"] = uri_string(); ?>
        <p> <a href="<?= base_url()?>"> Home </a></p>
    </body>
    
</html>