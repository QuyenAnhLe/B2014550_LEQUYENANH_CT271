<?php
require_once __DIR__ .  '/../bootstrap.php';

use CT271\Labs\product;

$product = new product($PDO);
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['id'])
    && ($product->find($_POST['id'])) !== null
) {
    $product->delete();
}
redirect('quantri.php');