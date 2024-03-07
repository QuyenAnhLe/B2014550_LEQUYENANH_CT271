<?php

define('BASE_URL_PATH', '/');

require_once __DIR__ . '/src/helpers.php';
require_once __DIR__ . '/libraries/Psr4AutoloaderClass.php';

$loader = new Psr4AutoloaderClass;
$loader->register();
// Các lớp có không gian tên bắt đầu với CT271\Labs nằm ở src
$loader->addNamespace('CT271\Labs', __DIR__ .'/src');

try {
    $PDO = (new CT271\Labs\PDOFactory)->create([
    'dbhost' => 'localhost',
    'dbname' => 'CT271',
    'dbuser' => 'root',
    'dbpass' => ''
    ]);
    //echo("ket noi thanh cong");
    } catch (Exception $ex) {
    echo 'Không thể kết nối đến MySQL,
    kiểm tra lại username/password đến MySQL.<br>';
    exit("<pre>${ex}</pre>");
    }