<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('url');
$this->load->library('session');
$username = 'null';
if ($this->session->has_userdata("login"))
    $username = $_SESSION['login']["email"];
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href=<?= base_url() . CSS . "style.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "script.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "headerstyle.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "productstyle.css" ?>>
    <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
    <title>SKATE</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <article class="default-product">
        <div class="container">
            <section id="product" class="product">
                <div class="left-container">
                    <div class="container-image">
                        <div class="product-image">
                            <?php $allpictures = $product->getPictures();
                            foreach ($allpictures as $picture) : ?>
                                <div id="small-img" class="small-img" style="background-image: url('<?= base_url() . 'public/img/products/' . $picture ?>')"></div>
                            <?php endforeach ?>
                        </div>
                        <div class="focus-product-image">
                            <div class="img" id="focus-image"></div>
                        </div>
                    </div>
                </div>
                <div class="right-container">
                    <div class="id">
                        <p><?= $this->ProductModel->findBrandbyId($product->getBrand()) ?></p>
                        <h3><?= $product->getName() ?></h3>
                        <p id="numprod" class="numprod" value="<?= $product->getId() ?>">No. de produit: <?= $product->getId() ?></p>
                    </div>
                    <div class="price">
                        <?php if (get_class($product) == "PromotionProductEntity") { ?>
                            <p class="promo"><?= $product->getPrice() ?>€</p>
                            <p class="promo"><?= $product->getNewPrice() ?>€</p>
                            <p class="promo">-<?= $product->promotion() ?>%</p>
                        <?php } else { ?>
                            <p><?= $product->getPrice() ?>€</p>
                        <?php } ?>
                        <p class="tva">INC. TVA</p>
                    </div>
                    <?php if (isset($_SESSION['login']) && $_SESSION["login"]["status"] == "Administrator"){?>
                    <a href="<?= base_url() . 'index.php/Product/update/' . $product->getId() ?>" class="update"><p style="color: var(--admin-icon-color); background: rgb(255, 208, 0,0.2); border-radius: 15px; padding: 10px; width: 80px;">Update</p></a>
                    <?php }?>
                    <form class="shopping" action="<?= base_url() . 'index.php/Product/addToCart/' . $product->getId() ?>" method="post">
                        <div class="color">
                            <div>
                                <h4>Couleurs: </h4>
                                <!-- =========================Ajouté le nom de la couleur============================= -->
                                <?php if (isset($_GET["color"])) { ?>
                                    <p><?= $_GET["color"] ?></p>
                                <?php } ?>
                            </div>
                            <div class="color-picker-container">
                                <?php
                                foreach ($allInformations as $color) {
                                    if (array_values($color)[0]["size"] != null) {
                                ?>
                                        <?php if (isset($_GET["color"])&& in_array($_GET["color"],array_keys($allInformations)) && $allInformations[$_GET["color"]] == $color) { ?>
                                            <a class="picker" style="border:3px solid white;background-color: <?= array_values($color)[0]["colorCode"]; ?>
                                " title="<?= array_search($color, $allInformations) ?>" href="<?= base_url() . 'index.php/' . uri_string() . '?color=' . array_search($color, $allInformations) ?>"></a>
                                        <?php } else { ?>
                                            <a class="picker" style="background-color: <?= array_values($color)[0]["colorCode"]; ?>
                                " title="<?= array_search($color, $allInformations) ?>" href="<?= base_url() . 'index.php/' . uri_string() . '?color=' . array_search($color, $allInformations) ?>"></a>
                                <?php }
                                    }
                                } ?>
                            </div>
                        </div>

                        <!--  SIZE  -->


                        <select id="sizeSelector" name="<?= "size" ?>">
                            <?php
                            if (!isset($_GET["color"])) {
                            ?>
                                <option value=""><?= "Choisir une couleur" ?></option>
                            <?php
                            } else {
                            ?>
                                <option selected="selected" disabled="true" value="NULL"> Choisir une taille </option>
                                <?php
                                if (isset($_GET["color"])&& in_array($_GET["color"],array_keys($allInformations))){

                                    foreach ($allInformations[$_GET["color"]] as $info) {
                                ?>
                                    <option <?php if (isset($_GET["size"]) && $_GET["size"] == $info["size"]) echo "selected" ?> value="<?= $info["size"] ?>"><?= $info["size"] ?></option>
                            <?php }
                                }
                            } ?>
                        </select>
                        <?php
                        if (isset($_GET["size"])) {
                            if (isset($_GET["color"])&& in_array($_GET["color"],array_keys($allInformations))){
                                if(in_array($_GET["size"],array_keys($allInformations[$_GET["color"]]))){
                                    if ($allInformations[$_GET["color"]][$_GET["size"]]["quantity"] != 0) {
                        ?>
                                <input type="hidden" name="color" value="<?= $_GET["color"] ?>">
                                <button class="addToCart" type="submit">
                                    <img src=<?= base_url() . "public\img\logo_cart.svg" ?> alt="">
                                    AJOUTER AU PANIER
                                </button>
                            <?php
                            }}}
                            ?>
                            <?php
                            if (isset($_GET["color"])&& in_array($_GET["color"],array_keys($allInformations))){
                                if(in_array($_GET["size"],array_keys($allInformations[$_GET["color"]]))){
                                    if ($allInformations[$_GET["color"]][$_GET["size"]]["quantity"] == 0) {
                            ?>
                                <button type="text" disabled>
                                    RUPTURE DE STOCK
                                </button>
                            <?php
                            }}}
                        } else {
                            if (isset($_GET["size"])) {
                            ?>
                                <button type="text" disabled>
                                    Choisir une taille
                                </button>
                            <?php
                            } else {
                            ?>
                                <button type="text" disabled>
                                    Choisir une couleur
                                </button>
                        <?php
                            }
                        }
                        $_SESSION["redirect"] = uri_string();
                        ?>
                    </form>
                    <div class="description-container">
                        <div class="collapsable">
                            <a class="title" onclick="collapse_description()">
                                <p>Description</p>
                                <span class="arrow" id="description-arrow"></span>
                            </a>
                            <div class="collapse" id="description">
                                <p><?= $product->getDescription() ?></p>
                            </div>
                        </div>
                        <div class="collapsable">
                            <a class="title" onclick="collapse_brand()">
                                <p>Marque</p>
                                <span class="arrow" id="collapse-brand-arrow"></span>
                            </a>
                            <div class="collapse" id="collapse-brand">
                                <p><?= $this->ProductModel->findBrandbyId($product->getBrand()) ?></p>
                            </div>
                        </div>
                        <div class="collapsable">
                            <a class="title" onclick="collapse_shipping()">
                                <p>Livraison</p>
                                <span class="arrow" id="shipping-arrow"></span>
                            </a>
                            <div class="collapse" id="shipping">
                                <p>Livraison gratuite, retour gratuits. <a href="<?= base_url()."index.php/Home/deliveryInfo"?>">Plus d'infos sur la Livraison</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </article>
    <?php include 'cartSide.php'; ?>
    <?php include 'footer.php'; ?>
    <script src=<?= base_url() . JS . "displayProduct.js" ?>></script>
</body>

</html>