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
        <link rel="stylesheet" href=<?=base_url().CSS."user.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."script.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."headerstyle.css" ?>>
        <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
        <title>SKATE</title>
    </head>

    <body>
    <div class="content-user-profile">
        <div class="box-user">
            <div class="content-modif-user">
                <label class="title-update-user">Profil</label>
                <div>
                    <div id="content-form-pseudo">
                        <form action="<?= base_url()."index.php/User/updateUserPseudo/".$user->getEmail()?>" methode="post">
                            <div class="user-input">
                                <label class="label-user-input">Pseudo</label>
                                <input type="text" name="pseudo" placeholder="Modifier le pseudo" value="<?= $user->getPseudo()?>">
                            </div>
                            <input type="submit" hidden />
                        </form>
                    </div>
                    <?php
                    if($_SESSION["login"]["email"]==$user->getEmail()){
                    ?>
                    <div id="content-form-pseudo">
                        <div class="user-input">
                            <label class="label-user-input">Mot de passe</label>
                            <button onclick="display_modifpass()" id="modifpass">Modifier <span id="arrow_modifpass"></span></button>
                        </div>
                    </div>
                    <div id="content-form-pass">
                        <form action="<?= base_url()."index.php/User/updateUserMDP/".$user->getEmail()?>" methode="post">
                            <div class="user-input">
                                <label>Mot de passe actuel</label>
                                <input type="password" name="password" placeholder="Ancien mot de passe" required>
                            </div>
                            
                            <div class="user-input">
                                <label class="label-user-input">Nouveau mot de passe</label>
                                <input type="password" name="newpassword" placeholder="Mot de passe" required> 
                            </div>
                            <input type="submit" hidden />
                        </form>
                    </div>
                    <?php } ?>
                </div>
                <div class="user-input">
                    <?php
                    if($_SESSION["login"]["email"]==$user->getEmail()){
                    ?>
                    <a href="<?= base_url()."index.php/User/logout" ?>" >Deconnexion</a>
                    <?php } ?>
                    <div></div>
                </div>
            </div>
        </div>

        <div class="box-user" style="background-color: var(--shiping-summary)">


                <div class="command-user">
                    
                    <div class="title-historic">Historique des commandes</div>

                    <?php
                    if(!empty($allCommands)){

                    foreach ($allCommands as $command):
                        $prix=0;
                        ?>
                    <div class="background-command">
                        <div class="content-info-commande">
                            <div class="command-number">Commande n°<?= $command[0]->getId() ?></div>
                            <div class="date-command">Date : <?= explode(" ",$command[0]->getTime())[0]?></div>
                        </div>
                        <div class="product-of-command">
                            <?php
                            foreach (array_slice($command,1,sizeof($command))  as $product):?>
                            <a href="<?=base_url().'index.php/Product/display/'.$product[0]->getId() ?>" class="box-product">
                                <div class="preview">
                                    <div class="img-of-product" style="background-image: url('<?=  base_url() . IMGPROD . $product[0]->getPicture(0) ?>') "></div>
                                    <p class="product-info"><?= $product[0]->getName() ?> | <?= $product[1]->getColor() ?> | <?= $product[1]->getSize() ?></p>
                                </div>
                                
                                <p class="quantity">x<?= $product[1]->getQuantity() ?></p>

                                <p class="price"><?= $product[0]->getPrice() ?>€</p>
                                <?php $prix =$prix + $product[0]->getPrice() ;?>
                            </a>
                            
                            <?php endforeach;
                            $this->load->model('CommandeModel');
                            $livraison=$this->CommandeModel->LivraisonById($command[0]->getId());
                            $prix =$prix +($livraison->taxe/100)*$prix+$livraison->fdp;
                            $adresse=str_replace("%20", " ", $livraison->adresse)
                            ?>
                            <div class="command-summary">
                                <div class="frais-de-port"><div>Frais de port : </div> <div><?=($livraison->taxe/100)*$prix+$livraison->fdp ?>€</div></div>
                                <div class="livraison">Livraison : <?=str_replace("::", " ", $adresse) ?></div>
                                <div class="total"><div>TOTAL DE LA COMMANDE: </div><div class="montant-total"><?= $prix?>€</div></div>
                                <?php $prix=0?>
                            </div>
                        </div>
                    </div>
                    <?php
                    endforeach;
                    }else{
                        ?>
                    
                    <div class="empty-command">Votre Historique de commande est vide. </div>
                    <?php }?>
                </div>

            </div>

    </div>
        <?php include 'header.php';?>
        <?php $_SESSION["redirect"] = uri_string(); ?>
        <?php include 'cartSide.php'; ?>
        <?php include 'footer.php';?>
    </body>
    
</html>
