<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('url');
$username = 'null';
if (isset($_SESSION['login']))
  $username = $_SESSION['login']["email"];
if (isset($_SESSION['login']))
  $status = $_SESSION['login']["status"];
if (isset($_SESSION['login']))
  $pseudo = $_SESSION['login']["pseudo"];
?>




<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
  <title>SKATE</title>
  <link rel="stylesheet" href=<?= base_url() . CSS . "style.css" ?>>
  <link rel="stylesheet" href=<?= base_url() . CSS . "script.css" ?>>
  <link rel="stylesheet" href=<?= base_url() . CSS . "home.css" ?>>
  <link rel="stylesheet" href=<?= base_url() . CSS . "headerstyle.css" ?>>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>
  <?php include 'header.php'; ?>


  <article id="home">
    <div class="clip">
    </div>
    <section>
      <div class="container">
        <div class="section-container">
          <h1 class="logoskate">S<span style="color: var(--classic-blue-color);">K</span>ATE</h1>
          <div class="button-nav">
            <a href="#showcase">explore</a>
            <a href="#showcase" class="arrow"></a>
          </div>
        </div>
      </div>
    </section>



    <section id="showcase">
      <div class="container">
        <div class="product-container" id="productdisplay1">
          <div class="background-effect"></div>
          <div class="product">
            <img src="<?= base_url() . CSS . "skategrind.jpg" ?>" alt="">
            <div class="description">
              <div>
                <h4>A PROPOS DE NOUS</h4>
                <p>Lorem, ipsum dolor sit amet <span>consectetur</span> adipisicing elit. Perferendis vitae magni sed exercitationem corrupti ab <span>consequatur</span> eos quis modi commodi? Consequuntur, dolores aut!</p>
              </div>
            </div>
          </div>
        </div>
        <a href="#grid-section" class="arrow-container">
          <div class="arrow"></div>
        </a>
      </div>
      <div class="main-container" id="grid-section">
        <ul class="grid-container">
          <li>
            <div id="cover">
              <h4>CATALOGUE</h4>
              <p></p>
              <a href="<?= base_url() . "index.php/Search?query=&cat=null&col=null&brd=null&size=null&prc=null&filter=3" ?>">
                <button>Découvrez notre catalogue</button>
              </a>
            </div>
          </li>
          <li>
            <div id="cover">
              <h4>SKATE</h4>
            </div>
          </li>
          <li>
            <div id="cover">
              <h4>REJOINS NOUS</h4>
              <p>Connecte toi!
                Tu n’as pas de compte?
                Inscrit toi au plus vite!</p>
              <a href="<?= base_url() . 'index.php/User/display/' . $username ?>">
                <button>Connexion</button>
              </a>
            </div>
          </li>
          <li>
            <div id="cover">
              <h4>LOCALISATION</h4>
              <p></p>
              <a href="<?= base_url() . 'index.php/Home/locinfo/' ?>">
                <button>Retrouvez notre magasin</button>
              </a>
            </div>
          </li>
        </ul>
        <div class="button-nav">
          <a href="#carousel">Nos produits</a>
          <a href="#carousel" class="arrow"></a>
        </div>
      </div>
      <div class="carousel-container" id="carousel">
        <h4>Découvrez nos produit</h4>
        <span class="line"></span>
        <ul class="carousel">
          <?php foreach ($allproducts as $result) : ?>
            <li class="carousel-product">
              <a href="<?= base_url() . "index.php/Product/display/" . $result->getId() ?>">
                <div class="img-product" style="background-image: url('<?= base_url() . IMGPROD . $result->getPicture(0) ?>') "></div>
                <div class="description">
                  <h6><?= $this->ProductModel->findBrandbyId($result->getBrand()) . ' - ' . $result->getName() ?></h6>
                  <div>
                    <?php
                    if (get_class($result) == "PromotionProductEntity") {
                    ?>
                      <p class="price promo"><?= $result->getPrice() . "€" ?></p>
                      <p class="price promo"><?= $result->getNewPrice() . "€" ?></p>
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
              </a>
            </li>
          <?php
          endforeach
          ?>
        </ul>
        <div class="button-nav">
          <a href="#category">Nos Catégories</a>
          <a href="#category" class="arrow"></a>
        </div>
      </div>
      <div class="category-slider-container" id="category">
        <h4>Nos Catégories</h4>
        <div class="slider">
          <div class="slide first">
            <div id="cover">
              <div class="left-arrow" onclick="plusDivs(-1)"></div>
              <div class="right-arrow" onclick="plusDivs(1)"></div>
              <div class="description">
                <a href="<?= base_url() . "index.php/Search?query=&cat=nullx19&col=null&brd=null&size=null&prc=null&filter=3" ?>">
                  <h6>Skateboard</h6>
                </a>
                <p>Retrouvez toute notre collection de skateboard créée pour vous</p>
              </div>
            </div>
          </div>
          <div class="slide second">
            <div id="cover">
              <div class="left-arrow" onclick="plusDivs(-1)"></div>
              <div class="right-arrow" onclick="plusDivs(1)"></div>
              <div class="description">
                <a href="<?= base_url() . "index.php/Search?query=&cat=nullx3&col=null&brd=null&size=null&prc=null&filter=3" ?>">
                  <h6>Sneakers</h6>
                </a>
                <p>Retrouvez toute notre collection de sneakers adaptée au skate</p>
              </div>
            </div>
          </div>
          <div class="slide third">
            <div id="cover">
              <div class="left-arrow" onclick="plusDivs(-1)"></div>
              <div class="right-arrow" onclick="plusDivs(1)"></div>
              <div class="description">
                <a href="<?= base_url() . "index.php/Search?query=&cat=nullx3&col=null&brd=null&size=null&prc=null&filter=3" ?>">
                  <h6>Vetement</h6>
                </a>
                <p>Retrouvez toute notre collection de skateboard créée pour vous</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="brand-container">
        <h4>Nos Marques</h4>
        <ul>
          <li><a href="<?= base_url() . "index.php/Search?query=&cat=null&col=null&brd=4&size=null&prc=null&filter=3" ?>"></a></li>
          <li><a href="<?= base_url() . "index.php/Search?query=&cat=null&col=null&brd=24&size=null&prc=null&filter=3" ?>"></a></li>
          <li><a href="<?= base_url() . "index.php/Search?query=&cat=null&col=null&brd=28&size=null&prc=null&filter=3" ?>"></a></li>
          <li><a href="<?= base_url() . "index.php/Search?query=&cat=null&col=null&brd=12&size=null&prc=null&filter=3" ?>"></a></li>
          <li><a href="<?= base_url() . "index.php/Search?query=&cat=null&col=null&brd=46&size=null&prc=null&filter=3" ?>"></a></li>
          <li><a href="<?= base_url() . "index.php/Search?query=&cat=null&col=null&brd=47&size=null&prc=null&filter=3" ?>"></a></li>
          <li><a href="<?= base_url() . "index.php/Search?query=&cat=null&col=null&brd=5&size=null&prc=null&filter=3" ?>"></a></li>
          <li><a href="<?= base_url() . "index.php/Search?query=&cat=null&col=null&brd=13&size=null&prc=null&filter=3" ?>"></a></li>
        </ul>
      </div>
    </section>
  </article>



  <?php $_SESSION["redirect"] = uri_string(); ?>
  <?php include 'cartSide.php'; ?>
  <?php include 'footer.php'; ?>
  <script src=<?= base_url() . JS . "trueHome.js" ?>></script>
</body>

</html>