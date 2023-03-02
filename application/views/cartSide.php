<div id="overlay"></div>
<div id="sidenavcart" class="classsidenavcart">
    <div class="cartHeader">
        <p>MON PANIER</p>
        <a class="closebtn" onclick="closeNav()">&times;</a>
    </div>
    <?php 
            if (!empty($allcartproducts)){
        ?>
    <div class="cartContent">
        <div class="cartBody" data-scrollable>
            <?php 
                $cartPrice=0;
                foreach ($allcartproducts as $cartproduct):
                    $cartPrice+=$cartproduct[0]->getNewPrice()* $cartproduct[1][0];
                ?>
                <div class="cartproduct">
                    <img class="img" src=<?= base_url() . 'public/img/products/' . $cartproduct[0]->getPicture(0); ?>>
                    <div class="productInformations">
                        <div class="priceandname">
                            <div class="name"> <a href="<?= base_url()."index.php/Product/display/".$cartproduct[0]->getId() ?>"><?= $cartproduct[0]->getName() ?></a>  </div>
                            <p class="price"> <?= $cartproduct[0]->getNewPrice()."€" ?> </p>
                            <p class="price"> <?= "Size :".$cartproduct[1][1] ?> </p>
                        </div>
                        <div class="deleteandqty">
                            <div class="QuantitySelector">
                                <button class="Quantity Sign" title="Increase Quantity to <?= $cartproduct[1][0]+1 ?>" onClick="increase('qtyVal<?= $cartproduct[1][3] ?>', <?= $cartproduct[1][4]?>, <?= $cartproduct[1][3]?>,<?= $cartproduct[0]->getPrice() ?>)">
                                    +
                                </button>
                                <input readonly type="text" class="Quantity Number" onChange="updateCookieValue(event, '<?=$cartproduct[0]->getId()?>', '<?=$cartproduct[1][4]?>')" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="<?="qtyVal".$cartproduct[1][3]?>" value="<?= $cartproduct[1][0] ?>" pattern="[0-9]+"> </input>

                                <button class="Quantity Sign" title="Decrease Quantity to <?= $cartproduct[1][0]-1 ?>" onClick="decrease('qtyVal<?= $cartproduct[1][3] ?>', <?= $cartproduct[1][3] ?>,<?= $cartproduct[0]->getPrice() ?>)">
                                    -
                                </button>
                            </div>
                            <a class="delete" href="<?=base_url().'index.php/Product/deleteToCart/'.$cartproduct[1][3].'/index' ?>"> delete </a>
                        </div>
                    </div>
                </div>
            <?php endforeach;
            
            ?>
        </div>
        
        <div class="cartBottom">
            <form action="<?=base_url().'index.php/Commande/displayCheckout'?>" method="POST">
                <button type="submit" class="pay">
                    <span>PAYER</span>
                    <span class="sep">|</span>
                    <span id="cartTotal"><?=number_format($cartPrice, 2, '.', "");?></span>
                    <span>€</span>
                </button>
            </form>
            <a class="delete" href="<?=base_url().'index.php/Product/dropCart' ?>"> VIDER LE PANIER</a>
        </div>
        <?php
            } else {
        ?>
        <div class="emptyCartContent" data-scrollable>
            <p class="cartHeader">VOTRE PANIER EST VIDE</p>
        </div>
        <?php
            }
        ?>
    </div>
</div>
<script

  src="https://code.jquery.com/jquery-3.6.1.min.js"
  integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
  crossorigin="anonymous">
  
</script> 


