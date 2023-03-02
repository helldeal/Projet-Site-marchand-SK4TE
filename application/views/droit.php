<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
$username = 'null';
if (isset($_SESSION['login']))
  $username = $_SESSION['login']["email"];
?>
<!doctype html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href=<?=base_url().CSS."style.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."script.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."droit.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."headerstyle.css" ?>>
        <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
        <title>SKATE</title>
    </head>

    <body>
        <div class="droit-container">
            <div class="droit-titre">Mentions légales</div>
            <div class="droit-lorem">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus. Tortor consequat id porta nibh. Massa sapien faucibus et molestie. Porta non pulvinar neque laoreet suspendisse interdum consectetur. Id velit ut tortor pretium viverra suspendisse potenti. Porttitor massa id neque aliquam vestibulum morbi blandit cursus risus. Risus quis varius quam quisque id diam vel quam elementum. Vel pharetra vel turpis nunc eget lorem dolor sed viverra. Cursus turpis massa tincidunt dui ut ornare lectus. Magna fringilla urna porttitor rhoncus dolor purus non enim. Vitae aliquet nec ullamcorper sit amet risus nullam eget felis. Feugiat sed lectus vestibulum mattis. Egestas diam in arcu cursus. Nibh mauris cursus mattis molestie a iaculis at erat. Quisque id diam vel quam elementum pulvinar etiam non quam. Sodales ut eu sem integer. Nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae. Sollicitudin ac orci phasellus egestas tellus rutrum. Purus ut faucibus pulvinar elementum integer enim neque. Ipsum faucibus vitae aliquet nec. Elementum nisi quis eleifend quam adipiscing vitae proin. Sit amet nisl suscipit adipiscing bibendum est. Semper eget duis at tellus at urna condimentum. Sit amet purus gravida quis blandit turpis cursus in hac. Mattis aliquam faucibus purus in massa tempor. Non arcu risus quis varius quam quisque id diam. In eu mi bibendum neque egestas congue quisque egestas diam. Ultrices neque ornare aenean euismod. Sed risus pretium quam vulputate dignissim.</div>
        </div>
    
    <?php include 'header.php';?>
        <?php $_SESSION["redirect"] = uri_string(); ?>
        <?php include 'cartSide.php'; ?>
        <?php include 'footer.php';?>
    </body>
    
</html>