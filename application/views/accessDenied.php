<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('url');

$username = 'null';
if (!isset($_SESSION['login'])) redirect('Home/sessionOver', 'refresh');
else {
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/png" href=<?= base_url() . IMG . "favicon.png" ?> />
    <title>Access Denied</title>
</head>
<body>
    <h1> Access Denied</h1>
<p> <a href="<?= base_url()?>"> Home </a></p>
</body>
</html>
<?php } ?>