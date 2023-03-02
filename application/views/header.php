<header>
  <nav class="nav">
    <div class="over-container">
      <ul>
        <li class="logo-nav">
          <a href="<?= base_url() ?>">
            <h1 class="header-title" style="font-style: italic;">S<span>K</span>ATE</h1>
          </a>
        </li>
        <li class="search-nav">
          <div id="cover">
            <form method ="GET" action="<?= base_url()."index.php/Search" ?>">
              <div class="tb">
                <div class="td">
                  <input type="text" name="query" autocomplete="off" placeholder="Rechercher..." id="srcbar" class="srcbar"  />
                  <input type="hidden" name="cat" value="null"/>
                  <input type="hidden" name="col" value="null"/>
                  <input type="hidden" name="brd" value="null"/>
                  <input type="hidden" name="size" value="null"/>
                  <input type="hidden" name="prc" value="null"/>
                  <input type="hidden" name="filter" value="3"/>
                </div>
                <div class="td" id="s-cover">
                  <button type="submit" title="search">
                    <div id="s-circle"></div>
                    <span></span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>
        <ul class="nav-links">
          <li class="location-nav">
            <a href="<?= base_url() . 'index.php/Home/locinfo/'?>">
              <img src=<?= base_url() . IMG . "logo_loc.svg" ?> alt="logo location" />
              <p>Location</p>
            </a>
          </li>
          <li class="connexion-nav">
            <a href="<?= base_url() . 'index.php/User/display/' . $username ?>">
              <img src=<?= base_url() . IMG . "logo_co.svg" ?> alt="logo connexion" />
              <p>
                <?php 
                if (isset($pseudo))
                  echo $pseudo;
                else
                  echo "Connexion";
                ?></p>
            </a>
          </li>
          <li class="cart-nav">
            <a onClick="openNav()" data-toggle="modal" data-target="#sidenavcart">
              <img src=<?= base_url() . IMG . "logo_cart.svg" ?> alt="logo cart">
              <?php if (!empty($allcartproducts)){ ?>
                <span class="point"></span>
              <?php } ?>
              </image>
              <p>Panier</p>
            </a>
          </li>

          <?php
          if (isset($_SESSION["login"]) && $_SESSION["login"]["status"] == "Administrator") {
          ?>
            <li class="admin-nav">
              <a href="<?= base_url() . 'index.php/Home/admin' ?>">
                <img src=<?= base_url() . IMG . "logo_admin.png" ?> alt="menu bouton">
                <p>Admin</p>
              </a>
            </li>
          <?php } ?>
        </ul>
        <li>
          <img src=<?= base_url() . IMG . "menu-btn.png" ?> alt="menu bouton" class="menu-btn">
        </li>
      </ul>

    </div>
    <div class="under-container" id="undercontainer">
      <ul class="nav-bar">
        <li class="nav-item">
          <a href="<?= base_url() . "index.php/Search?query=&cat=nullx19&col=null&brd=null&size=null&prc=null&filter=3"?>" class="nav-link skateboard" id="skateboard">SKATEBOARD</a>
          <span class="menu-nav"></span>
        </li>
        <li class="nav-item">
          <a href="<?= base_url() . "index.php/Search?query=&cat=nullx3&col=null&brd=null&size=null&prc=null&filter=3"?>" class="nav-link shoes" id="shoes">CHAUSSURES</a>
          <span class="menu-nav"></span>
        </li>
        <li class="nav-item">
          <a href="<?= base_url() . "index.php/Search?query=&cat=nullx16x7x10x17x18x1&col=null&brd=null&size=null&prc=null&filter=3"?>" class="nav-link clothing" id="clothing">VETEMENTS</a>
          <span class="menu-nav"></span>
        </li>
        <li class="nav-item">
          <a href="<?= base_url() . "index.php/Search?query=&cat=nullx26x28&col=null&brd=null&size=null&prc=null&filter=3"?>" class="nav-link accesories" id="accesories">ACCESSOIRES</a>
          <span class="menu-nav"></span>
        </li>
        <li class="nav-item">
          <a href="<?= base_url() . "index.php/Search?query=&cat=x21x22x23x24x25&col=null&brd=null&size=null&prc=null&filter=3"?>" class="nav-link pieces" id="pieces">PIECES</a>
          <span class="menu-nav"></span>
        </li>
        <li class="nav-item">
          <a href="<?= base_url() . "index.php/Search?query=&cat=null&col=null&brd=null&size=null&prc=null&filter=5"?>" class="nav-link brand" id="brand">PROMOTIONS</a>
          <span class="menu-nav"></span>
        </li>
      </ul>
    </div>
  </nav>
  
  <div id="preloader">
        <img src="<?= base_url() . IMG ."skatewheel.png" ?>" alt="skatewheel" />
  </div>
  <script>
    var baseUrl = "<?=base_url() ?>" 
  </script>
  <script src=<?=base_url().JS."cart.js" ?>></script>
  <script src=<?=base_url().JS."home.js" ?>></script>
</header>