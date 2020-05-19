<?php

$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db = 'shop';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$dbh = new PDO($dsn, $user, $pass, $opt);

define('PRODUCTS_CNT_PER_PAGE', 6);
define('PAID_DELIVERY_PRODUCT_SUM', 2000);
define('DELIVERY_COST', 300);