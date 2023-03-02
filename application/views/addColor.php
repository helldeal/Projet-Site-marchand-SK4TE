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
    <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
    <title>New Color</title>
  </head>

  <body>
    <a href="<?= base_url() . "index.php/Home/admin" ?> " class="nav-admin"> Admin </a>
    <form action="<?= '../addColorModel/' . $productId ?>" method="post">
      <div class="form">
        <input class="color-name" type="text" name="colorName" placeholder="Color Name" required>
        <input id="color-picker" type="color" name="colorCode">
        <input type="submit">
      </div>
    </form>
    <?php
    if (empty($colors)) {
    ?>
      <div class="existing-colors">
        <h1>No colors exists... Let's add one!</h1>
      </div>
    <?php
    } else {
    ?>
      <div class="existing-colors">
        <h1>Select an existing color...</h1>
        <div class="list-colors">


          <?php
          foreach ($colors as $color) {
          ?>
            <a class="single-color" href="<?= '../addExistingColor/' . $productId . '/' . trim($color->getCode(), "#") . '/' . $color->getName() ?>">
              <div class="color-circle" style="background-color:<?= $color->getCode() ?>;"></div>
              <p><?= $color->getName() ?></p>
            </a>
        <?php
          }
        }
        ?>
        </div>
      </div>
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
    }

    .nav-admin {
      font-size: 50px;
      border-bottom: 2px solid var(--border-element-color);
      padding: 5px 15px 15px 5px;
      letter-spacing: 10px;
      font-weight: 900;
      margin-bottom: 20px;
    }

    input {
      padding: 10px 15px;
      border-radius: 30px;
      background-color: rgb(43, 43, 43);
      border: 0;
      color: var(--font-color);
    }

    input:nth-of-type(2) {
      padding: 0;
    }

    h1 {
      color: white;
      font-size: 25px;
    }

    .form {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .color-name {
      height: 25px;
    }

    #color-picker {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      background-color: transparent;
      border: none;
      height: 45px;
      width: 45px;
    }

    #color-picker::-webkit-color-swatch {
      border-radius: 15px;
      border: none;
    }

    .existing-colors {
      margin: 20px;
      padding: 40px 30px;
      border-radius: 20px;
    }

    .color-circle {
      height: 45px;
      width: 45px;
      border-radius: 100%;
    }

    .single-color {
      display: flex;
      gap: 35px;
      flex-direction: row;
      align-items: center;
      margin: 20px;
    }
  </style>

  </html>
<?php
}
?>
