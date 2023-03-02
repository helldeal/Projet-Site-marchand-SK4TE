<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('url');
$this->load->model('ProductModel');

$username = 'null';
if (isset($_SESSION['login'])) $username = $_SESSION['login']["email"];

?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
    <title>Catalogue</title>
    <link rel="stylesheet" href=<?= base_url() . CSS . "style.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "productstyle.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "headerstyle.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "catalog.css" ?>>
    <link rel="stylesheet" href=<?= base_url() . CSS . "script.css" ?>>
</head>

<body>
    <div id="filter2"></div>
    <div class="catalog">
        <a id="filter-arrow" onclick="showfilter()"></a>
        <a id="filter-arrow-hide" onclick="hidefilter()"></a>
        <div class="filter-menu">
            <ul class="filter-container">
                <li>
                    <button type="button" id="collapse-categories-button" onclick="collapse_category()">
                        <h5>Catérogies</h5>
                        <span class="arrow categories-arrow"></span>
                    </button>
                    <div id="collapse-categories">
                        <?php
                        foreach ($categories as $category) :
                        ?>
                            <a onclick="checkCategories('<?= $category->getId() ?>','<?= $_GET['query'] ?>' )" class="" <?php if (isset($_GET["cat"]) && in_array(str_replace("#", "", $category->getId()), explode("x", $_GET["cat"]))) echo "style='background-color: rgb(70, 142, 235); '" ?>>
                                <?= $category->getName() ?>
                            </a>
                        <?php
                        endforeach
                        ?>
                    </div>
                </li>
                <li>
                    <button type="button" id="collapse-colors-button" onclick="collapse_colors()">
                        <h5>Couleurs</h5>
                        <span class="arrow colors-arrow"> </span>
                    </button>
                    <div id="collapse-colors">
                        <?php
                        foreach ($colors as $color) :

                        ?>
                            <a onclick="checkColors('<?= $color->getCode() ?>','<?= $_GET['query'] ?>')" class="red" <?php if (isset($_GET["col"]) && in_array(str_replace("#", "", $color->getCode()), explode("x", $_GET["col"]))) echo "style='background-color: rgb(70, 142, 235); '" ?>>
                                <span class="circle-color" style="background-color: <?= $color->getCode(); ?>"></span>
                                <?= $color->getName() ?>
                            </a>
                        <?php
                        endforeach
                        ?>
                    </div>
                </li>
                <li>
                    <button type="button" id="collapse-brands-button" onclick="collapse_brands()">
                        <h5>Marques</h5>
                        <span class="arrow brands-arrow"></span>
                    </button>
                    <div id="collapse-brands">
                        <?php
                        foreach ($brands as $brand) :
                            if ($this->ProductModel->isBrandUse($brand->getId())) {
                        ?>
                                <a onclick="checkBrands('<?= $brand->getId() ?>','<?= $_GET['query'] ?>')" <?php if (isset($_GET["brd"]) && in_array($brand->getId(), explode("x", $_GET["brd"]))) echo "style='background-color:rgb(70, 142, 235);'" ?>><?= $brand->getName() ?>
                                </a>
                        <?php
                            }
                        endforeach
                        ?>

                    </div>
                </li>
                <!-- <li>
                    <button type="button" id="collapse-tailles-button" onclick="collapse_tailles()">
                        <h5>Tailles</h5>
                        <span class="arrow tailles-arrow"></span>
                    </button>
                    <div id="collapse-tailles">
                        <div class="clothes">

                            <input type="checkbox" value="<?= "XXS," . $_GET["query"] ?>" id="<?= "sizexxs" ?>" <?php if (isset($_GET["size"]) && in_array("XXS", explode("y", $_GET["size"]))) echo "checked"; ?> />
                            <label for="sizexxs">
                                XXS
                            </label>
                            <input type="checkbox" value="<?= "XS," . $_GET["query"] ?>" id="<?= "sizexs" ?>" <?php if (isset($_GET["size"]) && in_array("XS", explode("y", $_GET["size"]))) echo "checked"; ?> />
                            <label for="sizexs">
                                XS
                            </label>
                            <input type="checkbox" value="<?= "S," . $_GET["query"] ?>" id="<?= "sizes" ?>" <?php if (isset($_GET["size"]) && in_array("S", explode("y", $_GET["size"]))) echo "checked"; ?> />
                            <label for="sizes">S
                            </label>
                            <input type="checkbox" value="<?= "M," . $_GET["query"] ?>" id="<?= "sizem" ?>" <?php if (isset($_GET["size"]) && in_array("M", explode("y", $_GET["size"]))) echo "checked"; ?> />
                            <label for="sizem">M
                            </label>
                            <input type="checkbox" value="<?= "L," . $_GET["query"] ?>" id="<?= "sizel" ?>" <?php if (isset($_GET["size"]) && in_array("L", explode("y", $_GET["size"]))) echo "checked"; ?> />
                            <label for="sizel">L
                            </label>
                            <input type="checkbox" value="<?= "XL," . $_GET["query"] ?>" id="<?= "sizexl" ?>" <?php if (isset($_GET["size"]) && in_array("XL", explode("y", $_GET["size"]))) echo "checked"; ?> />
                            <label for="sizexl">XL
                            </label>
                            <input type="checkbox" value="<?= "XXL," . $_GET["query"] ?>" id="<?= "sizexxl" ?>" <?php if (isset($_GET["size"]) && in_array("XXL", explode("y", $_GET["size"]))) echo "checked"; ?> />
                            <label for="sizexxl">XXL
                            </label>
                        </div>
                        <div class="shoes">
                            <?php

                            for ($i = 32; $i < 49; $i++) {
                            ?>
                                <input type="checkbox" value="<?= $i . "," . $_GET["query"] ?>" id="<?= "size" . $i ?>" <?php if (isset($_GET["size"]) && in_array($i, explode("y", $_GET["size"]))) echo "checked"; ?> />
                                <label for="<?= "size" . $i ?>">
                                    <?= $i ?>
                                </label>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </li> -->
                <li>
                    <button type="button" id="collapse-prices-button" onclick="collapse_prices()">
                        <h5>Prix</h5>
                        <span class="arrow prices-arrow"></span>
                    </button>
                    <div id="collapse-prices">
                        <?php
                        for ($i = 50; $i <= 300; $i += 50) {
                        ?>
                            <input value="<?= $i . "," . $_GET["query"] ?>" type="radio" name="price-limit" id="<?= "price" . $i ?>" <?php if (isset($_GET["prc"]) && $i == $_GET["prc"]) echo "checked"; ?> />
                            <label for="price300">
                                <?= ($i - 50) . "€ - " . $i . "€" ?>
                            </label>
                        <?php
                        }
                        ?>
                        <input value="<?= "null" . "," . $_GET["query"] ?>" type="radio" name="price-limit" id="pricenull" <?php if (isset($_GET["prc"]) && $_GET["prc"] == "null") echo "checked"; ?> />
                        <label for="price300">
                            NO LIMIT
                        </label>
                    </div>
                </li>
            </ul>
        </div>

        <div class="main-section">
            <div class="sort-menu">
                <div class="src-result">
                    <?php
                    if ($this->input->get("query") != "") {
                    ?>

                        <p>Résultat de recherche pour</p>
                        <div>
                            <p><?= $this->input->get("query") ?></p>
                            <p>(<?= sizeof($request) ?> résultat)</p>
                        </div>

                    <?php } ?>
                </div>
                <div style="display:flex;flex-direction: row;gap:15px;max-width:650px;flex-wrap:wrap; ">

                    <?php
                    for ($i = 50; $i <= 300; $i += 50) {
                    ?>
                        <?php if (isset($_GET["prc"]) && $i == $_GET["prc"]) { ?>
                            <a for="price300">
                                <?= ($i - 50) . "€ - " . $i . "€" ?>
                            </a>
                        <?php
                        }
                    }
                    if (isset($_GET["prc"]) && $_GET["prc"] == "null") { ?>
                        <a for="price300">
                            NO LIMIT
                        </a>
                        <?php
                    }
                    foreach ($categories as $category) :
                        if (isset($_GET["cat"]) && in_array(str_replace("#", "", $category->getId()), explode("x", $_GET["cat"]))) {
                        ?>
                            <a class="" <?php if (isset($_GET["cat"]) && in_array(str_replace("#", "", $category->getId()), explode("x", $_GET["cat"]))) echo "style='background-color: rgb(70, 142, 235); '" ?>>
                                <?= $category->getName() ?>
                            </a>
                            <script>
                                collapse_category()
                            </script>
                    <?php
                        }
                    endforeach
                    ?>
                    <?php
                    foreach ($brands as $brand) :
                        if (isset($_GET["brd"]) && in_array($brand->getId(), explode("x", $_GET["brd"]))) {
                    ?>
                            <a <?php if (isset($_GET["brd"]) && in_array($brand->getId(), explode("x", $_GET["brd"]))) echo "style='background-color:rgb(70, 142, 235);'" ?>><?= $brand->getName() ?>
                            </a>
                    <?php
                        }
                    endforeach
                    ?>
                    <?php
                    foreach ($colors as $color) :
                        if (isset($_GET["col"]) && in_array(str_replace("#", "", $color->getCode()), explode("x", $_GET["col"]))) {
                    ?>
                            <a class="red" <?php if (isset($_GET["col"]) && in_array(str_replace("#", "", $color->getCode()), explode("x", $_GET["col"]))) echo "style='background-color: rgb(70, 142, 235); '" ?>>
                                <span class="circle-color" style="background-color: <?= $color->getCode(); ?>"></span>
                                <?= $color->getName() ?>
                            </a>
                    <?php
                        }
                    endforeach
                    ?>


                </div>
                <select class="sort-by" onchange="checkFilter(this.value,'<?= $_GET['query'] ?>')" onload="checkFilter(this.value,'<?= $_GET['query'] ?>')">
                    <option value="" disabled>SELECT A FILTER</option>
                    <option value="1">Prix: par ordre croissant</option>
                    <option value="2">Prix: par ordre decroissant</option>
                    <option value="3">Nom: A -> Z</option>
                    <option value="4">Nom: Z -> A</option>
                    <option value="5">Promotions</option>
                </select>
            </div>
            <div class="products-grid-container">
                <ul class="products-grid">
                    <?php
                    foreach ($request as $result) :
                    ?>

                        <li class="prod hiddenprod"> <a href="<?= base_url() . "index.php/Product/display/" . $result->getId() ?>">
                                <div class="img-product" style="background-image: url('<?= base_url() . IMGPROD . $result->getPicture(0) ?>') ">
                                    <div class="icon-container">

                                        <?php
                                        if (in_array($result, $allnewproducts)) {
                                        ?>
                                            <div class="new-icon">Nouveau</div>
                                        <?php }
                                        if (get_class($result) == "PromotionProductEntity") {
                                        ?>
                                            <div class="promo-icon">PROMO</div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="description">
                                    <h6><?= $this->ProductModel->findBrandbyId($result->getBrand()) . ' - ' . $result->getName() ?></h6>
                                    <div class="price-container">
                                        <?php
                                        if (get_class($result) == "PromotionProductEntity") {
                                        ?>
                                            <div>
                                                <p class="price promo"><?= $result->getPrice() . "€" ?></p>
                                                <p class="promo">-<?= $result->promotion() ?>%</p>
                                                <p class="price promo"><?= $result->getNewPrice() . "€" ?></p>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <p class="price"><?= $result->getPrice() . "€" ?></p>
                                        <?php
                                        }
                                        ?>
                                        <button>Voir le produit</button>
                                    </div>
                                </div>
                            </a></li>

                    <?php
                    endforeach
                    ?>
                </ul>
            </div>
            <div class="change-page" onclick="moreProduct()">
                Afficher +
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

<?php include 'header.php'; ?>
<?php $_SESSION["redirect"] = uri_string(); ?>
<?php include 'cartSide.php'; ?>
<?php include 'footer.php'; ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src=<?= base_url() . JS . "catalog.js" ?>></script>
<script>
    var productnumber = 0;
    moreProduct();
</script>
<?php
foreach ($categories as $category) :
    if (isset($_GET["cat"]) && in_array(str_replace("#", "", $category->getId()), explode("x", $_GET["cat"]))) {
?>
        <script>
            collapse_category()
        </script>
<?php
        break;
    }
endforeach
?>
<?php
foreach ($brands as $brand) :
    if (isset($_GET["brd"]) && in_array($brand->getId(), explode("x", $_GET["brd"]))) {
?>
        <script>
            collapse_brands()
        </script>
<?php
        break;
    }
endforeach
?>
<?php
foreach ($colors as $color) :
    if (isset($_GET["col"]) && in_array(str_replace("#", "", $color->getCode()), explode("x", $_GET["col"]))) {
?>
        <script>
            collapse_colors()
        </script>
<?php
        break;
    }
endforeach
?>
<?php
for ($i = 50; $i <= 300; $i += 50) {
?>
    <?php if (isset($_GET["prc"]) && $i == $_GET["prc"]) { ?>
        <script>
            collapse_prices()
        </script>
    <?php
        break;
    }
}
if (isset($_GET["prc"]) && $_GET["prc"] == "null") { ?>
    <script>
        collapse_prices()
    </script>
<?php
} ?>

</html>