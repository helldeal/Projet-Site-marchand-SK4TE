<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  $this->load->helper("url");

  if(isset($_SESSION['login'])) $username = $_SESSION['login']["email"]; 
  if(!isset($_SESSION['login'])||$_SESSION["login"]["status"]!="Administrator") $this->load->view('accessDenied');
else {
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href=<?= base_url() . CSS . "style.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "productstyle.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "headerstyle.css" ?>>
    <title>Modification utilisateur</title>
</head>
<body>
<p> <a href="<?=base_url()."index.php/Home/admin"?> "> Admin </a></p>
<form action="<?=base_url()."index.php/User/updateUser"?>" method="post">
  <input type="text" name="email" value="<?= $email ?>" readonly>
  <input type="text" name="pseudo" value="<?=$pseudo?>" required>
  <input type="text" name="password" value="" placeholder="password" required>
  <div>
  <?php if($status=="Administrator"){?>
    <input type="radio" id="visitor" name="status" value="Visitor" required  >
    <label for="visitor">Visitor</label>
    <input type="radio" id="administrator" name="status" value="Administrator" required checked>
    <label for="administrator">Admin</label>
    <?php }else{?>
    <input type="radio" id="visitor" name="status" value="Visitor" required checked >
    <label for="visitor">Visitor</label>
    <input type="radio" id="administrator" name="status" value="Administrator" required>
    <label for="administrator">Admin</label>
    <?php }?>
  </div>
  <!-- GERER LE CHANGEMENT DE STATUT -->
  <input type="submit">
</form>
</body>
</html>
<?php 
}
?>