<?php

$this->load->helper("url");
if (isset($_SESSION['login'])) $username = $_SESSION['login']["email"];
if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator")
  redirect('Home/accessDenied', 'refresh');
else {
?>
  <!doctype html>
  <html lang="fr">

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href=<?= base_url() . CSS . "style.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "productstyle.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "headerstyle.css" ?>>
    <title>Add Promo</title>
  </head>

  <body>
    <p> <a href="<?= base_url() . "index.php/Home/admin" ?> "> Admin </a></p>
    <form action="<?= '../addPromoModel' ?>" method="post">
      <input type="text" name="promo" placeholder="Promotion Percentage (1..99)" required>
      <input type="hidden" name="id" value="<?= $id ?>">
      <input type="submit">
    </form>
    <?php
    if (isset($_GET['state'])) {
      if ($_GET['state'] == "success") {
    ?>
        <p class="state success">Brand added sucessfully !</p>
    <?php
      }
    }
    ?>

  </body>
  <style>
    body {
      background-color: #202020;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 10%;
      color: var(--font-color);
      gap: 25px;
    }

    input {
      padding: 10px 15px;
      border-radius: 30px;
      background-color: rgb(43, 43, 43);
      border: 0;
    }

    input[type="submit"] {
      background-color: rgb(80, 80, 80);
      color: var(--font-color);
    }
  </style>

  </html>
<?php
}
?>
