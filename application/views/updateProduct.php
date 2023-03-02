<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper("url");
$this->load->helper('form');

if ($this->session->has_userdata('login')) $username = $this->session->login['pseudo'];
if (!$this->session->has_userdata("login") || $this->session->login['status'] != "Administrator") $this->load->view('accessDenied');
else {
?>
  <!doctype html>
  <html lang="fr">

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href=<?= base_url() . CSS . "style.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "productstyle.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "headerstyle.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . JS . "product.js" ?>>
    <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
    <title>Modification produit</title>
  </head>

  <body>
    <a href="<?= base_url() . "index.php/Home/admin" ?> " class="nav-admin"> Admin </a>
    <div class="container">

      <p class="pictures-title">Pictures</p>
      <div class="pictures">
        <?php
        foreach ($allpictures as $picture) : ?>
          <div class="item">
            <img class="img" id="fileOpen" src=<?= base_url() . 'public/img/products/' . $picture ?>>
            <?php echo form_open_multipart('Product/updatePictureOfProduct/' . $id . "/" . $picture, 'id="add-pic"'); ?>
            <input class="file" id="file" type="file" name="userfile" class="userfile" data-multiple-caption="{count} files selected" multiple>
            <button id="add-btn">
              Valider
            </button>
            <div>
            </div>
            </form>
            <?php
              if ($picture!="error/null.jpg") {
            ?>
            <a href="<?= base_url() . 'index.php/Product/deletePictureOfProduct/' . $id . "/" . $picture ?>">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" height="40" width="40">
                <path fill="#d93125" d="M8.78842 5.03866C8.86656 4.96052 8.97254 4.91663 9.08305 4.91663H11.4164C11.5269 4.91663 11.6329 4.96052 11.711 5.03866C11.7892 5.11681 11.833 5.22279 11.833 5.33329V5.74939H8.66638V5.33329C8.66638 5.22279 8.71028 5.11681 8.78842 5.03866ZM7.16638 5.74939V5.33329C7.16638 4.82496 7.36832 4.33745 7.72776 3.978C8.08721 3.61856 8.57472 3.41663 9.08305 3.41663H11.4164C11.9247 3.41663 12.4122 3.61856 12.7717 3.978C13.1311 4.33745 13.333 4.82496 13.333 5.33329V5.74939H15.5C15.9142 5.74939 16.25 6.08518 16.25 6.49939C16.25 6.9136 15.9142 7.24939 15.5 7.24939H15.0105L14.2492 14.7095C14.2382 15.2023 14.0377 15.6726 13.6883 16.0219C13.3289 16.3814 12.8414 16.5833 12.333 16.5833H8.16638C7.65805 16.5833 7.17054 16.3814 6.81109 16.0219C6.46176 15.6726 6.2612 15.2023 6.25019 14.7095L5.48896 7.24939H5C4.58579 7.24939 4.25 6.9136 4.25 6.49939C4.25 6.08518 4.58579 5.74939 5 5.74939H6.16667H7.16638ZM7.91638 7.24996H12.583H13.5026L12.7536 14.5905C12.751 14.6158 12.7497 14.6412 12.7497 14.6666C12.7497 14.7771 12.7058 14.8831 12.6277 14.9613C12.5495 15.0394 12.4436 15.0833 12.333 15.0833H8.16638C8.05588 15.0833 7.94989 15.0394 7.87175 14.9613C7.79361 14.8831 7.74972 14.7771 7.74972 14.6666C7.74972 14.6412 7.74842 14.6158 7.74584 14.5905L6.99681 7.24996H7.91638Z" clip-rule="evenodd" fill-rule="evenodd"></path>
              </svg> 
            </a>
            <?php }?>
          </div>
        <?php
        endforeach
        ?>
      </div>

      <div class="title-container">
        <p>Informations</p>
        <p>Ajouter une nouvelle image</p>
      </div>
      <div class="main-form-container">
        <form class="main-form" action="<?= './../../product/updateProduct' ?>" method="post">
          <p>ID :</p>
          <input type="text" name="id" value="<?= $id ?>" readonly>
          <p>Nom :</p>
          <input type="text" name="name" value="<?= $name ?>" placeholder="name" required>
          <p>Marque :</p>
          <select name="brand" required>
            <?php foreach ($brands as $brand) { ?>
              <option value="<?= $brand->getId() ?>" <?php if ($brand->getId() == $actualBrand) echo "selected='selected'" ?>><?= $brand->getName() ?></option>
            <?php } ?>
          </select>
          <p>Categories :</p>
          <select name="category">
            <option value="999"></option>
            <?php foreach ($categories as $category) { ?>
              <option value="<?= $category->getId() ?>" <?php if ($category->getId() == $actualCategory) echo "selected='selected'" ?>><?= $category->getName() ?></option>
            <?php } ?>
          </select>
          <p>Prix :</p>
          <input type="text" name="price" value="<?= floatval($price) ?>" placeholder="price" required>
          <p>Description :</p>
          <input type="text" name="description" value="<?= $description ?>" placeholder="Description">
          <input type="submit">
        </form>
        <div class="newpicture">
          <table>
            <tbody>
              <td>
                <?php echo form_open_multipart('Product/addPictureOfProduct/' . $id); ?> New Picture
                <input id="file" type="file" name="userfile" required>
                <br>
                <br>
                <?php
                if (sizeof($allpictures) != 1 or $allpictures[0] != "error/null.jpg") { ?>
                  <label>Position de la nouvelle image</label>
                  <br>
                  <br>
                  <?php for ($i = 1; $i < sizeof($allpictures) + 2; $i++) { ?>
                    <label><?= $i ?></label>
                    <input type="radio" id="<?= $i ?>" name="pos" value="<?= $i ?>" required>
                    <br>
                <?php
                  }
                }
                ?>
                <br>
                <br>
                <input type="submit" value="Valider la nouvelle image">
                </form>
            </tbody>
          </table>
        </div>
      </div>






      <!------------------------------- SIZES ------------------->
      <div class="sizes">
        <a class="addColor" href="<?= base_url() . "index.php/Product/addColor/" . $id ?>">
          <span class="addColor-text">NEW COLOR</span>
        </a>
        <br>
        <br>
        <?php foreach ($sizes as $color) { ?>
          <div class="color-info">
            <div class="color-details">
              <div class="color-circle" style="background-color: <?= $color[0]["colorCode"] ?>"> </div>
              <p><?= $color[0]["color"] ?></p>
            </div>
            <div class="sizes-of-color">
              <?php
              $factory = new ProductInfosFactory;
              $sizeObject = $factory->infosFactory($color[0]);
              if (get_class($sizeObject) != "ProductInfosColor") {
                foreach ($color as $size) { 
                  
                  ?>
                  <form method="POST" action="<?= base_url() . "index.php/Product/updateQuantity/" . $size["id"] ?>">
                    <div class="size-of-color">
                      <div class="size"><?= $size["size"] ?></div>

                      <!-----BOUTTON DELETE----->
                      <a class="tooltip" href="<?= base_url() . 'index.php/Product/deleteSize/' . $size['id'] ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" height="30" width="30">
                          <path fill="#d93125" d="M8.78842 5.03866C8.86656 4.96052 8.97254 4.91663 9.08305 4.91663H11.4164C11.5269 4.91663 11.6329 4.96052 11.711 5.03866C11.7892 5.11681 11.833 5.22279 11.833 5.33329V5.74939H8.66638V5.33329C8.66638 5.22279 8.71028 5.11681 8.78842 5.03866ZM7.16638 5.74939V5.33329C7.16638 4.82496 7.36832 4.33745 7.72776 3.978C8.08721 3.61856 8.57472 3.41663 9.08305 3.41663H11.4164C11.9247 3.41663 12.4122 3.61856 12.7717 3.978C13.1311 4.33745 13.333 4.82496 13.333 5.33329V5.74939H15.5C15.9142 5.74939 16.25 6.08518 16.25 6.49939C16.25 6.9136 15.9142 7.24939 15.5 7.24939H15.0105L14.2492 14.7095C14.2382 15.2023 14.0377 15.6726 13.6883 16.0219C13.3289 16.3814 12.8414 16.5833 12.333 16.5833H8.16638C7.65805 16.5833 7.17054 16.3814 6.81109 16.0219C6.46176 15.6726 6.2612 15.2023 6.25019 14.7095L5.48896 7.24939H5C4.58579 7.24939 4.25 6.9136 4.25 6.49939C4.25 6.08518 4.58579 5.74939 5 5.74939H6.16667H7.16638ZM7.91638 7.24996H12.583H13.5026L12.7536 14.5905C12.751 14.6158 12.7497 14.6412 12.7497 14.6666C12.7497 14.7771 12.7058 14.8831 12.6277 14.9613C12.5495 15.0394 12.4436 15.0833 12.333 15.0833H8.16638C8.05588 15.0833 7.94989 15.0394 7.87175 14.9613C7.79361 14.8831 7.74972 14.7771 7.74972 14.6666C7.74972 14.6412 7.74842 14.6158 7.74584 14.5905L6.99681 7.24996H7.91638Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </a>
                      <!-----NOUVELLE QUANTITE----->
                      <div>
                        Quantité :
                      </div>
                      <div><?= $size["quantity"] ?></div>
                      <input type="text" pattern="[0-9]{1,}" name="<?= "qty" ?>" placeholder="Nouvelle Quantité" required>
                      <input type="submit">
                    </div>
                  </form>
              <?php
                }
              }
              ?>
              <br>
              <br>
              <form method="POST" action="<?= base_url() . "index.php/Product/addSize/" . $id ?>">
                <div class="size-of-color">
                  <div>
                    Ajouter une taille :
                  </div>
                  <?php
                  $factory = new ProductInfosFactory;
                  $sizeObject = $factory->infosFactory($color[0]);
                  if (get_class($sizeObject) == 'ProductInfosShoes') { ?>
                    <input type="text" name="<?= "size" ?>" placeholder="Nouvelle Taille (42, 43, 44...)" title="Size should be like => 42, 43, 44..." pattern="[0-9]{2}">
                  <?php } else if (get_class($sizeObject) == 'ProductInfosClothes') {
                  ?>
                    <input type="text" name="<?= "size" ?>" placeholder="Nouvelle Taille (M, L, XL...)" title="Size should be like => M, L, XL..." pattern="[A-Z]{1,3}">
                  <?php } else if (get_class($sizeObject) == 'ProductInfosInches') {
                  ?>
                    <input type="text" name="<?= "size" ?>" placeholder="Nouvelle Taille (8in, 8.2in...)" title="Size should follow model '7in', '7.5in'" pattern="[0-9]{1,2}.[0-9]{1}in">
                  <?php } else if (get_class($sizeObject) == 'ProductInfosMillimeters') {
                  ?>
                    <input type="text" name="<?= "size" ?>" placeholder="Nouvelle Taille (45mm, 50mm...)" title="Size should follow model '40mm', '45mm'" pattern="[0-9]{1,5}mm">
                  <?php } else {
                  ?>
                    <input type="text" name="<?= "size" ?>" placeholder="Nouvelle Taille" title="Choose a size format (XL / 43)">
                  <?php } ?>
                  <input type="hidden" name="productId" value="<?= $color[0]["productId"] ?>">
                  <input type="hidden" name="color" value="<?= $color[0]["color"] ?>">
                  <input type="hidden" name="colorCode" value="<?= $color[0]["colorCode"] ?>">
                  <input type="submit">
                </div>
              </form>

              <br>
              <br>
            </div>
          </div>
        <?php }
        $_SESSION["redirect"] = uri_string();
        ?>

        <br>
        <br>
        <?php
        if (!isset($promo)) {
        ?>

          <a class="addPromo" href="<?= base_url() . "index.php/Product/addPromotion/" . $id ?>">
            <span class="addColor-text">NEW PROMOTION</span>
          </a>
        <?php
        } else {
        ?>
          <div class="promo">
            <p>Promotion :</p>
            <div>
              <?php
              echo $promo;
              ?>%
              <a class="tooltip" href="<?= base_url() . 'index.php/Product/deletePromo/' . $id ?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" height="30" width="30">
                  <path fill="#d93125" d="M8.78842 5.03866C8.86656 4.96052 8.97254 4.91663 9.08305 4.91663H11.4164C11.5269 4.91663 11.6329 4.96052 11.711 5.03866C11.7892 5.11681 11.833 5.22279 11.833 5.33329V5.74939H8.66638V5.33329C8.66638 5.22279 8.71028 5.11681 8.78842 5.03866ZM7.16638 5.74939V5.33329C7.16638 4.82496 7.36832 4.33745 7.72776 3.978C8.08721 3.61856 8.57472 3.41663 9.08305 3.41663H11.4164C11.9247 3.41663 12.4122 3.61856 12.7717 3.978C13.1311 4.33745 13.333 4.82496 13.333 5.33329V5.74939H15.5C15.9142 5.74939 16.25 6.08518 16.25 6.49939C16.25 6.9136 15.9142 7.24939 15.5 7.24939H15.0105L14.2492 14.7095C14.2382 15.2023 14.0377 15.6726 13.6883 16.0219C13.3289 16.3814 12.8414 16.5833 12.333 16.5833H8.16638C7.65805 16.5833 7.17054 16.3814 6.81109 16.0219C6.46176 15.6726 6.2612 15.2023 6.25019 14.7095L5.48896 7.24939H5C4.58579 7.24939 4.25 6.9136 4.25 6.49939C4.25 6.08518 4.58579 5.74939 5 5.74939H6.16667H7.16638ZM7.91638 7.24996H12.583H13.5026L12.7536 14.5905C12.751 14.6158 12.7497 14.6412 12.7497 14.6666C12.7497 14.7771 12.7058 14.8831 12.6277 14.9613C12.5495 15.0394 12.4436 15.0833 12.333 15.0833H8.16638C8.05588 15.0833 7.94989 15.0394 7.87175 14.9613C7.79361 14.8831 7.74972 14.7771 7.74972 14.6666C7.74972 14.6412 7.74842 14.6158 7.74584 14.5905L6.99681 7.24996H7.91638Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
              </a>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
    <style>
      body {
        background-color: #202020;
        max-width: 100vw;
      }

      .nav-admin {
        font-size: 50px;
        border-bottom: 2px solid var(--border-element-color);
        padding: 5px 15px 15px 5px;
        letter-spacing: 10px;
        font-weight: 900;
      }

      .container {
        width: 90%;
        display: flex;
        flex-direction: column;
        margin: auto;
      }

      .pictures-title {
        font-size: 35px;
        letter-spacing: 10px;
        font-weight: 900;
        color: var(--font-color);
        margin-top: 20px;
      }

      .pictures {
        display: grid;
        width: 100%;
        grid-template-columns: auto auto;
        column-gap: 30px;
        row-gap: 30px;
        padding: 20px;
      }

      .pictures .item {
        width: 100%;
        display: flex;
        color: var(--font-color);
        align-items: center;
        justify-content: center;
        border-radius: 30px;
        background-color: rgb(38, 38, 38);
        border: 1px solid var(--border-element-color);
      }

      .pictures .item form {
        display: flex;
        gap: 5%;
        height: 100%;
        padding: 5% 0 5% 0;
        align-items: center;
      }

      /* .pictures .item form input {
        border-radius: 3px;
        background-color: var(--classic-blue-color);
        display: flex;
        font-size: 15px;
        color: var(--font-color);
        padding: 5px;
        gap: 5px;
      } */

      .pictures #add-btn {
        border: none;
        padding: 13px;
        color: rgb(51, 215, 82);
        background-color: rgb(51, 255, 82, 0.15);
        border-radius: 30px;
        font-size: 20px;
      }

      .pictures  a{
        background-color: rgba(237, 77, 77, 0.08);
        padding: 6px;
        border-radius: 15px;
      }


      .title-container {
        display: flex;
        justify-content: space-between;
        font-size: 35px;
        letter-spacing: 10px;
        font-weight: 900;
        color: var(--font-color);
        margin-top: 20px;
        width: 80%;
      }

      .main-form-container {
        width: 100%;
        padding: 5%;
        display: flex;
        justify-content: space-evenly;
      }

      .main-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        width: 100%;
      }

      .main-form p {
        color: var(--font-color-grey);
      }

      .main-form input {
        padding: 10px 15px;
        border-radius: 30px;
        background-color: rgb(43, 43, 43);
        border: 0;
        color: var(--font-color);
        width: 80%;
      }

      .main-form input[type="submit"] {
        background-color: var(--classic-blue-color);
        cursor: pointer;
      }

      .main-form select {
        padding: 10px 15px;
        border-radius: 30px;
        background-color: rgb(43, 43, 43);
        border: 0;
        color: var(--font-color-lightgrey);
        width: 80%;
      }

      .newpicture {
        width: 100%;
        color: var(--font-color);
        padding: 5%;
        display: flex;
        flex-direction: column;
        align-items: center;
        border-left: 1px solid var(--border-element-color);
      }

      .newpicture input[type="submit"] {
        padding: 10px 15px;
        border-radius: 30px;
        background-color: var(--classic-blue-color);
        border: none;
        cursor: pointer;
        color: var(--font-color);
      }

      .img {
        width: 200px;
        margin: 15px;
        border-radius: 30px;
      }

      .sizes {
        margin: 20px;
        padding: 40px 30px;
        border-radius: 20px;
      }

      .sizes input {
        padding: 10px 15px;
        border-radius: 30px;
        background-color: rgb(43, 43, 43);
        border: 0;
        color: var(--font-color);
      }
      
      .sizes input[type="submit"] {
        background-color: rgb(80, 80, 80);
        color: var(--font-color);
      }

      .color-details {
        width: 200px;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
        color: white;
      }

      .color-circle {
        width: 30px;
        height: 30px;
        border-radius: 15px;
        background-color: red;
      }

      .sizes-of-color {
        padding: 20px 40px;
        color: white;
        font-size: 22px;
        display: flex;
        flex-direction: column;
      }

      .size-of-color {
        color: white;
        font-size: 22px;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
      }

      .size {
        margin: 20px 0px;
        margin-right: 50px;
      }

      .tooltip {
        height: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 10px;
        border: 0px solid transparent;
        background-color: rgba(237, 77, 77, 0.08);
        border-radius: 16px;
        transition: all 0.2s linear;
      }

      .tooltip:hover {
        box-shadow: 3.4px 2.5px 4.9px rgba(0, 0, 0, 0.025),
          8.6px 6.3px 12.4px rgba(0, 0, 0, 0.035),
          17.5px 12.8px 25.3px rgba(0, 0, 0, 0.045),
          36.1px 26.3px 52.2px rgba(0, 0, 0, 0.055),
          99px 72px 143px rgba(0, 0, 0, 0.08);
      }

      .tooltip {
        position: relative;
        display: inline-block;
      }

      .addColor,
      .addPromo {
        align-items: center;
        background-image: linear-gradient(144deg, var(--classic-blue-color), var(--classic-blue-color) 50%, var(--classic-blue-color));
        border: 0;
        border-radius: 8px;
        box-shadow: rgba(151, 65, 252, 0.2) 0 15px 30px -5px;
        box-sizing: border-box;
        color: #FFFFFF;
        display: flex;
        font-family: Phantomsans, sans-serif;
        font-size: 18px;
        justify-content: center;
        line-height: 1em;
        width: 170px;
        padding: 3px;
        text-decoration: none;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        white-space: nowrap;
        cursor: pointer;
        transition: all .3s;
      }

      .addPromo {
        width: 220px;
      }

      .addColor:active,
      .addPromo:active,
      button:hover {
        outline: 0;
      }

      .addColor span,
      .addPromo span {
        background-color: rgb(5, 6, 45);
        padding: 16px 24px;
        border-radius: 6px;
        width: 100%;
        height: 100%;
        transition: 300ms;
      }

      .addColor:hover span,
      .addPromo:hover span {
        background: none;
      }

      .addColor:active,
      .addPromo:active {
        transform: scale(0.9);
      }

      .color-info {
        margin-bottom: 5%;
        border-bottom: 1px solid var(--border-element-color);
      }

      .promo {
        color: var(--font-color);
        font-size: 25px;
      }
    </style>
    <script>
      function replacePic() {
        document.getElementById("add-pic").submit();
      }

      function getFile() {
        document.getElementById("fileOpen").click();
      }
    </script>
  </body>

  </html>
<?php } ?>