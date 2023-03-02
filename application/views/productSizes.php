<?php

  $this->load->helper("url");
  $this->load->helper('form');
  if(isset($_SESSION['login'])) $username = $_SESSION['login']["pseudo"]; 
  if(!isset($_SESSION['login'])||$_SESSION["login"]["status"]!="Administrator")
    redirect('Home/accessDenied', 'refresh');
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href=<?= base_url() . CSS . "style.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "productstyle.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "headerstyle.css" ?>>
    <title>Descriptid Tailles</title>
</head>
<body>
<p> <a href="<?=base_url()."index.php/Home/admin"?> "> Admin </a></p>
<table>
  <thead>
    <tr>
      <th> Id </th>
      <th> Product Id </th>
      <th> Size </th>
      <th> Quantity </th>
      <th> Color </th>
      <th> Color Code </th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($informations as $info):?>
    <tr>
      <td> <?= $info->getId() ?> </td>
      <td> <?= $info->getProduct() ?> </td>
      <td> <?= $info->getSize() ?> </td>
      <td> <?= $info->getQuantity() ?> </td>
      <td> <?= $info->getColor() ?> </td>
      <td> <?= $info->getColorCode() ?> </td>
    </tr>
    <?php endforeach;
    ?>         
  </tbody>
</table>
</body>



