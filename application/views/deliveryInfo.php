<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
$username = 'null';
if (isset($_SESSION['login']))
  $username = $_SESSION['login']["email"];
?>
<!doctype html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href=<?=base_url().CSS."style.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."script.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."deliveryInfo.css" ?>>
        <link rel="stylesheet" href=<?=base_url().CSS."headerstyle.css" ?>>
        <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
        <title>SKATE</title>
    </head>

    <body>
        <div class="delivery-info-container">
            <div class="titre">Détails de livraison</div>
            <table>
                <tr>
                    <td>
                        Destination
                    </td>
                    <td>
                        Taxe <br>(TVA incluse dans le prix du produit)
                    </td>
                    <td>
                        frais de port
                    </td>
                </tr>
                <tr>
                    <td>
                        France Métropolitaine
                    </td>
                    <td>
                        0%
                    </td>
                    <td>
                        0€
                    </td>
                </tr>
                <tr>
                    <td>
                        Union Européenne
                    </td>
                    <td>
                        0%
                    </td>
                    <td>
                        10€
                    </td>
                </tr>
                <tr>
                    <td>
                        Hors Union Européenne
                    </td>
                    <td>
                        5%
                    </td>
                    <td>
                        10€
                    </td>
                </tr>
            </table>
            <div class="details-retour">
                <a style="font-size: 18px;">Vous disposez d'un droit de rétractation sous 30 jours: </a>
                    <a>- Les frais de retours sont pris en charge par le client.</a>
                    <a>-Le(s) Produits(s) faisant l'objet du droit de rétractation doivent être retournés dans leur(s) carton(s) et/ou emballage(s) d'origine du fabricant en utilisant le formulaire « Bon de retour » accompagnant le Produit livré ou en joignant à un courrier indiquant par exemple comme raison du retour «Conformément à mon droit de rétractation, je ne souhaite plus acheter l(es) article(s) que j'avais commandé(s) ». </a>
                    <a>-Le remboursement du Client ne pourra intervenir que si l'ensemble des conditions qui précèdent sont remplies. Le remboursement interviendra dans un délai de 14 jours à compter de la date à laquelle le droit de rétractation aura valablement été notifié par le Client.</a>

            </div>
            <div class="pays">
                La livraison est assuré pour les pays spécifiés ci-dessous :
                <ul>
                    <li>France</li>
                    <li>Espagne</li>
                    <li>Royaume-Unis</li>
                    <li>Italie</li>
                    <li>Pays-Bas</li>
                    <li>Allemagne</li>
                </ul>
            </div>

        </div>
    
    <?php include 'header.php';?>
        <?php $_SESSION["redirect"] = uri_string(); ?>
        <?php include 'cartSide.php'; ?>
        <?php include 'footer.php';?>
    </body>
    
</html>