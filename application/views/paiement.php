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
        <title>Paiement</title>
    </head>

    <body>
        <div class="contentCheckout">
            <div class="info-livraison">
                <div class="content-livraison">
                    <div class="title-livraison">
                        Paiement
                        <div class="split-bar"></div>
                    </div>
                    <form class="form-livraison" action="<?= base_url()."index.php/Commande/save/".$pays."/".$livraison->getAdresse() ?>" methode="post" >
                        <label for="address">Numéro de carte bancaire</label>
                        <input class="regular-input" type="text" name="address" placeholder="CB" pattern="[0-9]{16}">
                        <div class="subdiv-form">
                            <div class="label-gauche">
                                <label for="firstname">Date d'expiration</label>
                                <input class="prenom" type="text" name="firstname" placeholder="Date exemple: 10/23" pattern="[0-9]{2}+\/[0-9]{2}">
                            </div>
                            <div class="label-droit">
                                <label for="lastname">CVC</label>
                                <input class="nom" type="text" name="lastname" placeholder="CVC" pattern="[0-9]{3}">
                            </div>
                        </div>
                        <div class="subdiv-form">
                            <div class="label-gauche">
                                <label for="firstname">Prénom</label>
                                <input class="prenom" type="text" name="firstname" placeholder="prénom">
                            </div>
                            <div class="label-droit">
                                <label for="lastname">Nom</label>
                                <input class="nom" type="text" name="lastname" placeholder="nom">
                            </div>
                        </div>

                        <button type="submit" class="pay-button">Payer</button>
                    </form>
                </div>
            </div>

            <div class="info-livraison" style="background-color: var(--shiping-summary)">
                <div class="content-summary" >
                
                    <div class="title-livraison">Résumé de la commande <div class="split-bar"></div></div>
                    
                    <?php 
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

                        <div class="split-bar"></div>
                        <div class="produits">
                            <div class="nom-prod">Frais de livraison</div>
                            <div class="prix"><?=$livraison->calculLivraison($cartPrice)?>€</div>
                        </div>
                        <div class="split-bar"></div>
                        
                        <div class="content-prix">
                            <div class="label-prix-total">Prix total</div>
                            <div class="prix-total"><?=$cartPrice+$livraison->calculLivraison($cartPrice)?>€</div>
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