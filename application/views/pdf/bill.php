<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="background-command">
        <div class="command-number">Commande n°<?= $command->getId() ?></div>
        <div class="date-command" style="font-size:12px;">Date : <?= $command->getTime()?></div>
        
        <div class="product-of-command">
            <div class="product-title-historic">Produits :</div>
            <div class="product-price">
                <?php
                foreach (array_slice($command,1,sizeof($command))  as $product):?>
                <div class="box-product">
                    <div class="img-of-product" style="background-image: url('<?=  base_url() . IMGPROD . $product[0]->getPicture(0) ?>') "></div>
                    <div class="product-details">

                        <div class="left-side-command">
                            <a href="<?=base_url().'index.php/Product/display/'.$product[0]->getId() ?>" style="font-size:13px;">N° produit : <?= $product[0]->getId() ?></a>
                            <a style="font-weight:bold;"><?= $product[0]->getName() ?> </a>
                            <a style="font-size:13px;">Couleur : <?= $product[1]["color"] ?></a>
                            <a style="font-size:13px;">Taille : <?= $product[1]["size"] ?></a>
                        </div>
                        <div class="right-side-command">
                            <a style="font-weight:bold;">x<?= $product[1]["quantity"] ?></a>
                            <a><?= $product[0]->getPrice() ?>€</a>

                        </div>
                        <?php $prix =$prix + $product[0]->getPrice() ;?>
                    </div>
                </div>
                
                <?php endforeach;
                ?>
                <div class="price-command">
                    <a>Prix total : <?= $prix?>€</a>
                    <?php $prix=0?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>