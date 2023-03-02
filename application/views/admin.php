<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."UserMemento.php";
$this->load->helper('url');
$username = 'null';
if (isset($_SESSION['login'])) $username = $_SESSION['login']["email"];
if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect('Home/accessDenied', 'refresh');
else {
?>
    <!doctype html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href=<?= base_url() . CSS . "style.css" ?>>
        <link rel="stylesheet" href=<?= base_url() . CSS . "script.css" ?>>
        <link rel="stylesheet" href=<?= base_url() . CSS . "admin.css" ?>>
        <link rel="stylesheet" href=<?= base_url() . CSS . "headerstyle.css" ?>>
        <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
        <title>Admin</title>
    </head>

    <body>
        <!----------------------------------------------------    NAV    --------------------------------------------------------------------->
        <div id="filter"></div>
        <div class="nav-admin">
            
            <a href="<?= base_url() . "index.php/Home/admin" ?> " > <h1>Admin</h1> </a>
            
            <ul>
                <li>
                    <div class="selected" id='display1' style="display:none;"></div><a href="#nav1">Résumé</a>
                </li>
                <li>
                    <div class="selected" id='display2' style="display:none;"></div><a href="#nav2">Comptes</a>
                </li>
                <li>
                    <div class="selected" id='display3' style="display:none;"></div><a href="#nav3">Produits</a>
                </li>
                <li>
                    <div class="selected" id='display4' style="display:none;"></div><a href="#nav4">Marques</a>
                </li>
                <li>
                    <div class="selected" id='display5' style="display:none;"></div><a href="#nav5">Catégories</a>
                </li>
                <li>
                    <div class="selected" id='display6' style="display:none;"></div><a href="#nav6">Commandes</a>
                </li>

            </ul>
            <a href="<?= base_url() ?>" class="home">Home</a>
        </div>
        <article>
            <!----------------------------------------------------    RESUME    --------------------------------------------------------------------->
            <section class="info-tab">
                <div class="container" id="nav1" style="scroll-margin-top: 120px;">
                    <ul>
                        <li>
                            <div class="icon nb-comptes">
                                <img src=<?= base_url() . IMG . "logo_co.svg" ?> alt="">
                            </div>
                            <div class="info">
                                <p><?= $countuser ?></p>
                                <p>Nombre de comptes</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon nb-produits">
                                <img src=<?= base_url() . IMG . "logo_cart.svg" ?> alt="">
                            </div>
                            <div class="info">
                                <p><?= $countProd ?></p>
                                <p>Nombre de produits</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon nb-marques">
                                <img src=<?= base_url() . IMG . "brand1.png" ?> alt="">
                            </div>
                            <div class="info">
                                <p><?= $countbrand ?></p>
                                <p>Nombre de marques</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon nb-ventes">
                                <img src=<?= base_url() . IMG . "Vente1.png" ?> alt="">
                            </div>
                            <div class="info">
                                <p><?= $countorder ?></p>
                                <p>Nombre de ventes</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon recettes">
                                <img src=<?= base_url() . IMG . "euro.png" ?> alt="">
                            </div>
                            <div class="info">
                                <p><?= round($recipe, 2) ?> €</p>
                                <p>Recettes</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon nb-promo">
                                <img src=<?= base_url() . IMG . "pourcentage.png" ?> alt="">
                            </div>
                            <div class="info">
                                <p><?= $countpromo ?></p>
                                <p>Nombre de promotions</p>
                            </div>
                        </li>
                        <li>
                            <div class="progress"></div>
                            <div class="info">
                                <p><?= round(memory_get_usage()/1000000,1).'MB'?>/<?= ini_get('memory_limit').'B'?> </p>
                                <p>Mémoire utilisée</p>
                            </div>
                        </li>
                        <li>
                            <div class="progress"></div>
                            <div class="info">
                                <p><?= round(disk_total_space("/")/1000000000,1)-round(disk_free_space("/")/1000000000,1).''.'GB'?>/<?= round(disk_total_space("/")/1000000000,1).''.'GB'?> </p>
                                <p>Stockage utilisé</p>
                            </div>
                        </li>
                        <li>
                            <div class="progress"></div>
                            <div class="info">
                                <p><?=sys_getloadavg()[0]*100?>% </p>
                                <p>CPU utilisé</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>

            

            <!----------------------------------------------------    USER    --------------------------------------------------------------------->
            <section id="users">
                <div class="container" id="nav2" style="scroll-margin-top: 120px;">
                    <div class="table">
                        <ul>
                            <li class="info email">Email</li>
                            <li class="info">Nom d'utilisateur</li>
                            <li class="info">Mot de passe</li>
                            <li class="info">Statut</li>
                            <li class="add-user info">
                                <a onClick="openAdminoverlays('adminoverlaysuser')">
                                    <p>Ajouter</p>
                                    <span></span>
                                </a>
                                <!--------------------------    ADD USER POP UP    ------------------------------>
                                <div class="adminoverlays" id="adminoverlaysuser">
                                    <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex; color: rgb(70, 142, 235); border-color: rgb(70, 142, 235);">
                                        <div class="swal2-icon-content">!</div>
                                    </div>
                                    <form class="Add" action="<?= base_url() . 'index.php/User/addUser' ?>" method="post">
                                        <input type="text" name="email" placeholder="Email adress" required>
                                        <input type="text" name="pseudo" placeholder="Pseudo" required>
                                        <input type="password" name="password" placeholder="Password" required>
                                        <div>
                                            <input type="radio" id="visitor" name="status" value="Visitor"=REQUIRED>
                                            <label for="visitor">Visitor</label>
                                            <input type="radio" id="administrator" name="status" value="Administrator" required>
                                            <label for="administrator">Admin</label>
                                        </div>
                                        <input type="submit">
                                    </form>
                                </div>
                            </li>
                            <?php foreach ($allusers as $user) : ?>
                                <li class="items email">
                                    <a href="<?= base_url() . 'index.php/User/display/' . $user->getEmail() ?>"><?= $user->getEmail() ?> </a>
                                </li>
                                <li class="items">
                                    <div><?= $user->getPseudo() ?></div>
                                </li>
                                <li class="items">
                                    <p>Hidden</p>
                                </li>
                                <?php if ($user->getStatus() == "Administrator") { ?>
                                    <li class="items status-administrator">
                                        <div>
                                            <p><?= $user->getStatus() ?></p>
                                        </div>
                                    </li>
                                <?php } else { ?>
                                    <li class="items status-visitor">
                                        <div>
                                            <p><?= $user->getStatus() ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                                <li class="items command">
                                    <a onClick=<?= "openAdminoverlays('adminoverlaysUpuser" . $user->getEmail() . "')" ?> class="update">Update</a>
                                    <!--------------------------    UPADTE USER POP UP    ------------------------------>
                                    <div class="adminoverlays" id="<?= "adminoverlaysUpuser" . $user->getEmail() ?>">
                                        <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex;">
                                            <div class="swal2-icon-content">!</div>
                                        </div>
                                        <form class="Add" action="<?= base_url() . "index.php/User/updateUser" ?>" method="post">
                                            <input type="text" name="email" value="<?= $user->getEmail() ?>" readonly>
                                            <input type="text" name="pseudo" value="<?= $user->getPseudo() ?>" required>
                                            <input type="text" name="password" value="" placeholder="password" required>
                                            <div>
                                                <?php if ($user->getStatus() == "Administrator") { ?>
                                                    <input type="radio" id="visitor" name="status" value="Visitor" required>
                                                    <label for="visitor">Visitor</label>
                                                    <input type="radio" id="administrator" name="status" value="Administrator" required checked>
                                                    <label for="administrator">Admin</label>
                                                <?php } else { ?>
                                                    <input type="radio" id="visitor" name="status" value="Visitor" required checked>
                                                    <label for="visitor">Visitor</label>
                                                    <input type="radio" id="administrator" name="status" value="Administrator" required>
                                                    <label for="administrator">Admin</label>
                                                <?php } ?>
                                            </div>
                                            <input type="submit">
                                        </form>
                                    </div>
                                    <a class="remove-btn" href="<?= base_url() . 'index.php/User/delete/' . $user->getEmail() ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" height="30" width="30">
                                            <path fill="#b34b4b" d="M8.78842 5.03866C8.86656 4.96052 8.97254 4.91663 9.08305 4.91663H11.4164C11.5269 4.91663 11.6329 4.96052 11.711 5.03866C11.7892 5.11681 11.833 5.22279 11.833 5.33329V5.74939H8.66638V5.33329C8.66638 5.22279 8.71028 5.11681 8.78842 5.03866ZM7.16638 5.74939V5.33329C7.16638 4.82496 7.36832 4.33745 7.72776 3.978C8.08721 3.61856 8.57472 3.41663 9.08305 3.41663H11.4164C11.9247 3.41663 12.4122 3.61856 12.7717 3.978C13.1311 4.33745 13.333 4.82496 13.333 5.33329V5.74939H15.5C15.9142 5.74939 16.25 6.08518 16.25 6.49939C16.25 6.9136 15.9142 7.24939 15.5 7.24939H15.0105L14.2492 14.7095C14.2382 15.2023 14.0377 15.6726 13.6883 16.0219C13.3289 16.3814 12.8414 16.5833 12.333 16.5833H8.16638C7.65805 16.5833 7.17054 16.3814 6.81109 16.0219C6.46176 15.6726 6.2612 15.2023 6.25019 14.7095L5.48896 7.24939H5C4.58579 7.24939 4.25 6.9136 4.25 6.49939C4.25 6.08518 4.58579 5.74939 5 5.74939H6.16667H7.16638ZM7.91638 7.24996H12.583H13.5026L12.7536 14.5905C12.751 14.6158 12.7497 14.6412 12.7497 14.6666C12.7497 14.7771 12.7058 14.8831 12.6277 14.9613C12.5495 15.0394 12.4436 15.0833 12.333 15.0833H8.16638C8.05588 15.0833 7.94989 15.0394 7.87175 14.9613C7.79361 14.8831 7.74972 14.7771 7.74972 14.6666C7.74972 14.6412 7.74842 14.6158 7.74584 14.5905L6.99681 7.24996H7.91638Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>

            <!-------Si le memento est défini, on affiche un bouton pour remettre l'user--------->
            <?php 
            if($this->session->flashdata('UserMemento')!=""){
                $mem=$this->session->UserMemento;
                $mem=unserialize(serialize($mem))->getPrevious();
            ?>
                <form action="<?= base_url()."index.php/User/addUserModel"?>" method="POST">
                    <input type="hidden" name="email" value="<?= $mem->getEmail()?>">
                    <input type="hidden" name="pseudo" value="<?= $mem->getPseudo()?>">
                    <input type="hidden" name="password" value="<?= $mem->getPassword()?>">
                    <input type="hidden" name="status" value="<?= $mem->getStatus()?>">
                    <div class="undo-container">
                        <input type="submit" value="Undo" class="undo" name="undo" id="undo">
                        <label for="undo" class="undo-label"></label>
                    </div>
                </form>
            <?php
            }
            ?>
            
            <!----------------------------------------------------    PRODUCT    --------------------------------------------------------------------->

            <section id="users">
                <div class="container" id="nav3" style="scroll-margin-top: 120px;">
                    <div class="table">
                        <ul style="grid-template-columns: auto auto auto auto auto 25%;">
                            <li class="info email">ID</li>
                            <li class="info">Nom</li>
                            <li class="info">Marque</li>
                            <li class="info">Catégorie</li>
                            <li class="info">Prix</li>
                            <li class="add-user info">
                                <a onClick="openAdminoverlays('adminoverlaysprod')">
                                    <p>Ajouter</p>
                                    <span></span>
                                </a>
                                <div class="adminoverlays" id="adminoverlaysprod">
                                <!--------------------------    ADD PROD POP UP    ------------------------------>
                                    <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex; color: rgb(70, 142, 235); border-color: rgb(70, 142, 235);">
                                        <div class="swal2-icon-content">!</div>
                                    </div>
                                    <?php
                                    $this->load->model('ProductModel');
                                    $this->load->helper('form');
                                    $categories = $this->ProductModel->getAllCategories();
                                    $brands = $this->ProductModel->getAllBrands(); 
                                    echo form_open_multipart('Product/addProduct','class="Add"');?>
                                        <input type="text" name="name" placeholder="name" required>
                                        <select name="brand" required>
                                            <?php foreach ($brands as $brand) { ?>
                                                <option value="<?= $brand->getId() ?>"><?= $brand->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                        <select name="category">
                                            <?php foreach ($categories as $category) { ?>
                                                <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="text" name="price" placeholder="price" required>
                                        <input type="textarea" name="description" placeholder="Description">
                                        <input type="submit">
                                    </form>
                                </div>
                            </li>
                            <?php foreach ($allproducts as $product) : ?>
                                <li class="items email">
                                    <a href="<?= base_url() . 'index.php/Product/display/' . $product->getId() ?>"><?= $product->getId() ?></a>
                                </li>
                                <li class="items">
                                    <a href="<?= base_url() . 'index.php/Product/display/' . $product->getId() ?>"><?= $product->getName() ?></a>
                                </li>
                                <li class="items">
                                    <div><?= $this->ProductModel->findBrandbyId($product->getBrand()) ?></div>
                                </li>
                                <li class="items">
                                    <div><?= $this->ProductModel->findCategorybyId($product->getCategory()) ?></div>
                                </li>
                                <li class="items">
                                    <div><?= $product->getPrice() ?></div>
                                </li>
                                <li class="items command" style="gap: 5%;">
                                    <a href="<?= base_url() . 'index.php/Product/update/' . $product->getId() ?>" class="update">Update</a>
                                    <a class="remove-btn" href="<?= base_url() . 'index.php/Product/delete/' . $product->getId() ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" height="30" width="30">
                                            <path fill="#b34b4b" d="M8.78842 5.03866C8.86656 4.96052 8.97254 4.91663 9.08305 4.91663H11.4164C11.5269 4.91663 11.6329 4.96052 11.711 5.03866C11.7892 5.11681 11.833 5.22279 11.833 5.33329V5.74939H8.66638V5.33329C8.66638 5.22279 8.71028 5.11681 8.78842 5.03866ZM7.16638 5.74939V5.33329C7.16638 4.82496 7.36832 4.33745 7.72776 3.978C8.08721 3.61856 8.57472 3.41663 9.08305 3.41663H11.4164C11.9247 3.41663 12.4122 3.61856 12.7717 3.978C13.1311 4.33745 13.333 4.82496 13.333 5.33329V5.74939H15.5C15.9142 5.74939 16.25 6.08518 16.25 6.49939C16.25 6.9136 15.9142 7.24939 15.5 7.24939H15.0105L14.2492 14.7095C14.2382 15.2023 14.0377 15.6726 13.6883 16.0219C13.3289 16.3814 12.8414 16.5833 12.333 16.5833H8.16638C7.65805 16.5833 7.17054 16.3814 6.81109 16.0219C6.46176 15.6726 6.2612 15.2023 6.25019 14.7095L5.48896 7.24939H5C4.58579 7.24939 4.25 6.9136 4.25 6.49939C4.25 6.08518 4.58579 5.74939 5 5.74939H6.16667H7.16638ZM7.91638 7.24996H12.583H13.5026L12.7536 14.5905C12.751 14.6158 12.7497 14.6412 12.7497 14.6666C12.7497 14.7771 12.7058 14.8831 12.6277 14.9613C12.5495 15.0394 12.4436 15.0833 12.333 15.0833H8.16638C8.05588 15.0833 7.94989 15.0394 7.87175 14.9613C7.79361 14.8831 7.74972 14.7771 7.74972 14.6666C7.74972 14.6412 7.74842 14.6158 7.74584 14.5905L6.99681 7.24996H7.91638Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <a class="update sizes" onClick="<?= "openAdminoverlays('adminoverlaysSize" . $product->getId() . "')" ?>">Sizes</a>
                                    <table class="adminoverlays" id="<?= "adminoverlaysSize" . $product->getId() ?>">

                                        <!--------------------------    SIZE POP UP    ------------------------------>
                                        <?php
                                        $this->load->model('ProductModel');
                                        $this->load->model('Factories/ProductInfosFactory');
                                        $allInformations = $this->ProductModel->getAllProductInformations();
                                        $info = $allInformations[0];
                                        $infoArray = array();
                                        foreach ($allInformations as $info) {
                                            if ($product->getId() == $info->getProduct()) {
                                                array_push($infoArray, $info);
                                            }
                                        } ?>
                                        <tbody>
                                            <tr>
                                                <th> Id </th>
                                                <th> Product Id </th>
                                                <th> Size </th>
                                                <th> Quantity </th>
                                                <th> Color </th>
                                                <th> Color Code </th>
                                            </tr>
                                            <?php
                                            foreach ($infoArray as $info) : ?>
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
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>

            <!----------------------------------------------------    MARQUE    --------------------------------------------------------------------->

            <section id="users">
                <div class="container" id="nav4" style="scroll-margin-top: 120px;">
                    <div class="table">
                        <ul style="grid-template-columns: auto auto 25%;">
                            <li class="info">ID</li>
                            <li class="info">Marque</li>
                            <li class="add-user info">
                                <a onClick="openAdminoverlays('adminoverlaysbrand')">
                                    <p>Ajouter</p>
                                    <span></span>
                                </a>
                                <!--------------------------    ADD BRAND POP UP    ------------------------------>
                                <div class="adminoverlays" id="adminoverlaysbrand">
                                    <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex; color: rgb(70, 142, 235); border-color: rgb(70, 142, 235);">
                                        <div class="swal2-icon-content">!</div>
                                    </div>
                                    <form class="Add" action="<?= base_url() . "index.php/Product/addBrand" ?>" method="post">
                                        <input type="text" name="brand" placeholder="Brand Name" required>
                                        <input type="submit">
                                    </form>
                                </div>
                            </li>
                            <?php foreach ($brands as $brand) : ?>
                                <li class="items">
                                    <div><?= $brand->getId() ?></div>
                                </li>
                                <li class="items">
                                    <div><?= $brand->getName() ?></div>
                                </li>
                                <li class="items command">
                                    <a class="remove-btn" href="<?= base_url() . 'index.php/Product/deleteBrand/' . $brand->getId() ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" height="30" width="30">
                                            <path fill="#b34b4b" d="M8.78842 5.03866C8.86656 4.96052 8.97254 4.91663 9.08305 4.91663H11.4164C11.5269 4.91663 11.6329 4.96052 11.711 5.03866C11.7892 5.11681 11.833 5.22279 11.833 5.33329V5.74939H8.66638V5.33329C8.66638 5.22279 8.71028 5.11681 8.78842 5.03866ZM7.16638 5.74939V5.33329C7.16638 4.82496 7.36832 4.33745 7.72776 3.978C8.08721 3.61856 8.57472 3.41663 9.08305 3.41663H11.4164C11.9247 3.41663 12.4122 3.61856 12.7717 3.978C13.1311 4.33745 13.333 4.82496 13.333 5.33329V5.74939H15.5C15.9142 5.74939 16.25 6.08518 16.25 6.49939C16.25 6.9136 15.9142 7.24939 15.5 7.24939H15.0105L14.2492 14.7095C14.2382 15.2023 14.0377 15.6726 13.6883 16.0219C13.3289 16.3814 12.8414 16.5833 12.333 16.5833H8.16638C7.65805 16.5833 7.17054 16.3814 6.81109 16.0219C6.46176 15.6726 6.2612 15.2023 6.25019 14.7095L5.48896 7.24939H5C4.58579 7.24939 4.25 6.9136 4.25 6.49939C4.25 6.08518 4.58579 5.74939 5 5.74939H6.16667H7.16638ZM7.91638 7.24996H12.583H13.5026L12.7536 14.5905C12.751 14.6158 12.7497 14.6412 12.7497 14.6666C12.7497 14.7771 12.7058 14.8831 12.6277 14.9613C12.5495 15.0394 12.4436 15.0833 12.333 15.0833H8.16638C8.05588 15.0833 7.94989 15.0394 7.87175 14.9613C7.79361 14.8831 7.74972 14.7771 7.74972 14.6666C7.74972 14.6412 7.74842 14.6158 7.74584 14.5905L6.99681 7.24996H7.91638Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>

            <!----------------------------------------------------    CATEGORY    --------------------------------------------------------------------->

            <section id="users">
                <div class="container" id="nav5" style="scroll-margin-top: 120px;">
                    <div class="table">
                        <ul style="grid-template-columns: auto auto 25%;">
                            <li class="info">ID</li>
                            <li class="info">Catégorie</li>
                            <li class="add-user info">
                                <a onClick="openAdminoverlays('adminoverlaysCat')">
                                    <p>Ajouter</p>
                                    <span></span>
                                </a>
                                <!--------------------------    ADD CAT POP UP    ------------------------------>
                                <div class="adminoverlays" id="adminoverlaysCat">
                                    <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex; color: rgb(70, 142, 235); border-color: rgb(70, 142, 235);">
                                        <div class="swal2-icon-content">!</div>
                                    </div>
                                    <form class="Add" action="<?= base_url() . "index.php/Product/addCategory" ?>" method="get">
                                        <input type="text" name="category" placeholder="Category Name" required>
                                        <input type="submit">
                                    </form>
                                </div>
                            </li>
                            <?php foreach ($categories as $category) : ?>
                                <li class="items">
                                    <div><?= $category->getId() ?></div>
                                </li>
                                <li class="items">
                                    <div><?= $category->getName() ?></div>
                                </li>
                                <li class="items command">
                                    <a class="remove-btn" href="<?= base_url() . 'index.php/Product/deleteCategory/' . $category->getId() ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" height="30" width="30">
                                            <path fill="#b34b4b" d="M8.78842 5.03866C8.86656 4.96052 8.97254 4.91663 9.08305 4.91663H11.4164C11.5269 4.91663 11.6329 4.96052 11.711 5.03866C11.7892 5.11681 11.833 5.22279 11.833 5.33329V5.74939H8.66638V5.33329C8.66638 5.22279 8.71028 5.11681 8.78842 5.03866ZM7.16638 5.74939V5.33329C7.16638 4.82496 7.36832 4.33745 7.72776 3.978C8.08721 3.61856 8.57472 3.41663 9.08305 3.41663H11.4164C11.9247 3.41663 12.4122 3.61856 12.7717 3.978C13.1311 4.33745 13.333 4.82496 13.333 5.33329V5.74939H15.5C15.9142 5.74939 16.25 6.08518 16.25 6.49939C16.25 6.9136 15.9142 7.24939 15.5 7.24939H15.0105L14.2492 14.7095C14.2382 15.2023 14.0377 15.6726 13.6883 16.0219C13.3289 16.3814 12.8414 16.5833 12.333 16.5833H8.16638C7.65805 16.5833 7.17054 16.3814 6.81109 16.0219C6.46176 15.6726 6.2612 15.2023 6.25019 14.7095L5.48896 7.24939H5C4.58579 7.24939 4.25 6.9136 4.25 6.49939C4.25 6.08518 4.58579 5.74939 5 5.74939H6.16667H7.16638ZM7.91638 7.24996H12.583H13.5026L12.7536 14.5905C12.751 14.6158 12.7497 14.6412 12.7497 14.6666C12.7497 14.7771 12.7058 14.8831 12.6277 14.9613C12.5495 15.0394 12.4436 15.0833 12.333 15.0833H8.16638C8.05588 15.0833 7.94989 15.0394 7.87175 14.9613C7.79361 14.8831 7.74972 14.7771 7.74972 14.6666C7.74972 14.6412 7.74842 14.6158 7.74584 14.5905L6.99681 7.24996H7.91638Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>

            <!----------------------------------------------------    ORDER    --------------------------------------------------------------------->
            <section id="users">
                <div class="container" id="nav6" style="scroll-margin-top: 120px; margin-bottom:40px;">
                    <div class="table">
                        <ul style="grid-template-columns: auto auto auto auto auto auto;">
                            <li class="info">ID Commande</li>
                            <li class="info">ID Utilisateur</li>
                            <li class="info">ID Produit</li>
                            <li class="info">Quantité</li>
                            <li class="info">Prix</li>
                            <li class="info">Time</li>
                            <?php foreach ($allcommands as $command) : ?>
                                <li class="items">
                                    <div><?= $command->getId() ?></div>
                                </li>
                                <li class="items">
                                    <a href="<?= base_url() . 'index.php/User/display/' . $command->getLogin()  ?>"><?= $command->getLogin() ?></a>
                                </li>
                                <li class="items">
                                    <a href="<?= base_url() . 'index.php/Product/display/' . $this->ProductModel->getProductInformationsById($command->getRefprod())->getProduct()?>"><?= $command->getRefprod() ?></a>
                                </li>
                                <li class="items">
                                    <div><?= $command->getQuantity() ?></div>
                                </li>
                                <li class="items">
                                    <div><?= $command->getPrice() ?></div>
                                </li>
                                <li class="items">
                                    <div><?= $command->getTime() ?></div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>
        </article>




    </body>
    <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------->

    <?php include 'header.php'; ?>
    <?php $_SESSION["redirect"] = uri_string(); ?>
    <?php include 'cartSide.php'; ?>
    <?php include 'footer.php'; ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const wrapper = document.querySelectorAll('.progress');

        const barCount = 50;
        const percent1 = 50 * <?=round(round(memory_get_usage()/1000000,2)/intval(ini_get('memory_limit'))*100,1)?>/100;
        const percent2 = 50 * <?=100-round(disk_free_space("/")/disk_total_space("/")*100,2)?>/100;
        const percent3 = 50 * <?=sys_getloadavg()[0]*100?>/100;

        for (let index = 0; index < barCount; index++) {
            const className = index < percent1 ? 'selected1' : '';
            wrapper[0].innerHTML += `<i style="--i: ${index};" class="${className}"></i>`;
        }

        wrapper[0].innerHTML += `<p class="selected percent-text text1"> <?=round(round(memory_get_usage()/1000000,2)/intval(ini_get('memory_limit'))*100,1)?>%</p>`

        for (let index = 0; index < barCount; index++) {
            const className = index < percent2 ? 'selected2' : '';
            wrapper[1].innerHTML += `<i style="--i: ${index};" class="${className}"></i>`;
        }

        wrapper[1].innerHTML += `<p class="selected percent-text text2"> <?=100-round(disk_free_space("/")/disk_total_space("/")*100,1)?>%</p>`

        for (let index = 0; index < barCount; index++) {
            const className = index < percent3 ? 'selected3' : '';
            wrapper[2].innerHTML += `<i style="--i: ${index};" class="${className}"></i>`;
        }

        wrapper[2].innerHTML += `<p class="selected percent-text text3"><?=sys_getloadavg()[0]*100?>%</p>`
    </script>
    <script src=<?= base_url() . JS . "admin.js" ?>></script>

    </html>
<?php } ?>