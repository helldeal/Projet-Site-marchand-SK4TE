<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('url');

$username = 'null';
if (isset($_SESSION['login']))
  $username = $_SESSION['login']["email"];
?>




<!DOCTYPE html>
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

  <div class="contentloc">
    <div class="loc">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1172.6564562249637!2d-1.5451388196136222!3d47.22316822634775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4805f03e0b932da7%3A0xda6ed724fef282a3!2sIUT%20de%20Nantes%20-%20Campus%20de%20Nantes!5e0!3m2!1sfr!2sfr!4v1673520451052!5m2!1sfr!2sfr" 
        width="600" height="450" style="border:0;padding:50px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <span></span>
    <div class="infoloc">
        <h1>Localisation & Contact</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus. Tortor consequat id porta nibh. Massa sapien faucibus et molestie. Porta non pulvinar neque laoreet suspendisse interdum consectetur. Id velit ut tortor pretium viverra suspendisse potenti. Porttitor massa id neque aliquam vestibulum morbi blandit cursus risus. Risus quis varius quam quisque id diam vel quam elementum. Vel pharetra vel turpis nunc eget lorem dolor sed viverra. Cursus turpis massa tincidunt dui ut ornare lectus. Magna fringilla urna porttitor rhoncus dolor purus non enim. Vitae aliquet nec ullamcorper sit amet risus nullam eget felis. Feugiat sed lectus vestibulum mattis.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus. Tortor consequat id porta nibh. Massa sapien faucibus et molestie. Porta non pulvinar neque laoreet suspendisse interdum consectetur. Id velit ut tortor pretium viverra suspendisse potenti. Porttitor massa id neque aliquam vestibulum morbi blandit cursus risus. Risus quis varius quam quisque id diam vel quam elementum. Vel pharetra vel turpis nunc eget lorem dolor sed viverra. Cursus turpis massa tincidunt dui ut ornare lectus. Magna fringilla urna porttitor rhoncus dolor purus non enim. Vitae aliquet nec ullamcorper sit amet risus nullam eget felis. Feugiat sed lectus vestibulum mattis.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus. Tortor consequat id porta nibh. Massa sapien faucibus et molestie. Porta non pulvinar neque laoreet suspendisse interdum consectetur. Id velit ut tortor pretium viverra suspendisse potenti. Porttitor massa id neque aliquam vestibulum morbi blandit cursus risus. Risus quis varius quam quisque id diam vel quam elementum. Vel pharetra vel turpis nunc eget lorem dolor sed viverra. Cursus turpis massa tincidunt dui ut ornare lectus. Magna fringilla urna porttitor rhoncus dolor purus non enim. Vitae aliquet nec ullamcorper sit amet risus nullam eget felis. Feugiat sed lectus vestibulum mattis.</p>
    </div>
  </div>
  
  <style>
    .contentloc{  
      background-color: var(--shiping);
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: center
      flex-wrap: wrap;
      min-height: 100vh;
    }
    .contentloc span{
      border: 1px solid gray;
      display: block;
      height: 500px;
    }
    .loc{
      width:40%;
      padding:5%;
      padding-top:150px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .infoloc{
      width:60%;
      padding:5%;
      padding-top:150px;
      display: flex;
      flex-direction: column;
      align-items: start;
      justify-content: center;
    }
    .infoloc p{
      padding:20px;
    }
    .infoloc h1{
      padding:20px;
    }
    @media screen and (max-width: 1500px){
    .contentloc{
        flex-direction: column;
    }
    .infoloc , .loc{
        width: 100%;
        min-height: 80%;
    }
    .contentloc span{
      display: none;
    }
}
    
  </style>
  <?php include 'header.php'; ?>
  <?php $_SESSION["redirect"] = uri_string(); ?>
  <?php include 'cartSide.php'; ?>
  <?php include 'footer.php'; ?>
</body>

</html>