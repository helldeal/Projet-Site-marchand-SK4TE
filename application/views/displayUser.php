<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
if(isset($_SESSION['login'])) $username = $_SESSION['login']["pseudo"];
else {
    //S'OCCUPER DU CAS OU L4URL EST ENTREE MANUELLEMENT, SANS PRECISER DE PARAMETRE
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Sheeeesh2</title>
</head>
<body>
<p> <a href="<?=base_url()."index.php/Home/admin"?> "> Admin</a></p>
<table>
    <thead>
    <tr>
        <th> Pseudo </th>
        <th> Status </th>
        <?php
            if(isset($_SESSION['login'])&&$_SESSION["login"]["status"]=="Administrator"){
            ?>
                <th> update </th>
                <th> delete </th>
            <?php } ?>
    </tr>
    </thead>
    <tbody>

    <tr>
        <td> <?= $pseudo?> </td>
        <td> <?= $password ?> </td>
        <td> <?= $status ?> </td>
        <?php
        if(isset($_SESSION['login'])&&$_SESSION["login"]["status"]=="Administrator"){
        ?>
            <td> <a href="<?=base_url().'index.php/User/update/'.$email ?>"> update</a></td>
            
            <td> <a href="<?=base_url().'index.php/User/delete/'.$email ?>"> delete </a></td>
        <?php } ?>
    </tr>
    </tbody>
</table>
<!--UPDATE == SELECTION POUR ADMIN-->
   <style>
        table,
        td {
            background-color: #fff;
            text-align:center;
        }

        thead,
        tfoot {
            background-color: #fff;
        }
        table {
            background-color: #333;
        }
    </style>

</body>
</html>
<?php } ?>