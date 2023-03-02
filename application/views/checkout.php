<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');

$username=null;
if(isset($_SESSION['login'])) $username = $_SESSION['login']["email"]; 
if(!isset($_SESSION['login'])) redirect('User/login', 'refresh');
?>
<!doctype html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href=<?=base_url().CSS."style.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."checkout.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."script.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."headerstyle.css" ?>>
        <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
        <title>Checkout</title>
    </head>

    <body>
        <div class="contentCheckout">
<!--Partie information de livraison client-->
            <div class="info-livraison">
                <div class="content-livraison">
                    <div class="title-livraison">
                        Livraison
                        <div class="split-bar"></div>
                    </div>
                    <form class="form-livraison" action="<?= base_url()."index.php/Commande/Paiement" ?>" methode="GET" >
                        <select class="regular-input" id="pays" name="pays" onchange="changePays()" required>
                            <option value="" disabled selected>Pays/région</option>
                            <option value="France">France</option>
                            <option value="Espagne">Espagne</option>
                            <option value="Allemagne">Allemagne</option>
                            <option value="Pays-Bas">Pays-Bas</option>
                            <option value="Royaume-Uni">Royaume-Uni</option>
                            <option value="Italie">Italie</option>
                        </select>
                        <div class="subdiv-form">
                            <div class="label-gauche">
                                <label for="firstname">Prénom</label>
                                <input class="prenom" type="text" name="firstname" placeholder="prénom" required>
                            </div>
                            <div class="label-droit">
                                <label for="lastname">Nom</label>
                                <input class="nom" type="text" name="lastname" placeholder="nom" required>
                            </div>
                        </div>
                        <label for="address">Adresse</label>
                        <input class="regular-input" type="text" name="address" placeholder="adresse" required>
                        <label for="appartement">Appartement</label>
                        <input class="regular-input" type="text" name="appartement" placeholder="appartement">
                        <div class="subdiv-form">
                            <div class="label-gauche">
                                <label for="codepostal">Code postal</label>
                                <input class="codepostal" type="text" pattern="[0-9]{5}" name="codepostal" placeholder="code postal" required>
                            </div>
                            <div class="label-droit">
                                <label for="city" >Ville</label>
                                <input class="ville" type="text" name="city" placeholder="ville" required>
                            </div>
                        </div>
                        <label for="phone">Téléphone</label>
                        <input class="regular-input" type="text" pattern="[0-9]{10}" name="phone" placeholder="téléphone">

                        <button type="submit" class="pay-button">Paiement</button>
                    </form>
                </div>
            </div>
<!--Partie résumé de la commande-->
            <div class="info-livraison" style="background-color: var(--shiping-summary)">
                <div class="content-summary" > 
                
                    <div class="title-livraison">Résumé de la commande <div class="split-bar"></div></div>
                    
                    <?php /* affichage de tous les produits de la commande d'un utilisateur*/
                    if(!empty($allcartproducts)){
                    $cartPrice=0;
                    foreach ($allcartproducts as $cartproduct):
                        $cartPrice+=$cartproduct[0]->getNewPrice()* $cartproduct[1][0]; 
                    ?>
                    <div class="produits">
                        <div class="nom-prod"><?=$cartproduct[0]->getName()?></div>
                        <div class="quantité">x<?=$cartproduct[1][0]?></div>
                        <div class="prix"><?=$cartproduct[0]->getNewPrice()?>€</div>
                        
                    </div>
                    <div class="split-bar"></div>

                    <?php endforeach;?>
                    <div class="content-prix">
                        <div class="label-prix-total">Prix produits</div>
                        <div class="prix-total"><?=$cartPrice?>€</div>
                    </div>
                    <?php }else{ ?>
                    <div class="emptycart">Votre panier est vide</div>
                    <?php } ?>
                </div>
            </div>
        </div>




                            


        <?php include 'header.php';?>
        <?php $_SESSION["redirect"] = uri_string(); ?>
        <?php include 'footer.php';?>
        <script src=<?= base_url() . JS . "checkout.js" ?>></script>
    </body>
    
</html>