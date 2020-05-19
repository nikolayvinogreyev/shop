<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/index/whereConditions.php');

$limit = PHP_EOL . '    limit :positionFrom, :productsCnt';

$productParams = [];

if (isset($_GET['page'])) {
    $productParams[':positionFrom'] = ($_GET['page'] - 1) * PRODUCTS_CNT_PER_PAGE;
} else {
    $productParams[':positionFrom'] = 0;
}

$productParams[':productsCnt'] = PRODUCTS_CNT_PER_PAGE;

$productParams = array_merge($productParams, $params);

$productsQuery = '
    select
        pr.*
    ,   concat(replace(format(price, 0), ",", " "), " руб.") as formatted_price
    from products as pr
' . PHP_EOL;

$order = '';

if (isset($_GET['orderBy']) && isset($_GET['orderType'])) {
    if ($_GET['orderBy'] == 'price') {
        if ($_GET['orderType'] == 'asc') {
            $order = PHP_EOL . 'order by pr.price asc';
        } elseif ($_GET['orderType'] == 'desc') {
            $order = PHP_EOL . 'order by pr.price desc';
        }
    } elseif ($_GET['orderBy'] == 'name') {
        if ($_GET['orderType'] == 'asc') {
            $order = PHP_EOL . 'order by name asc';
        } elseif ($_GET['orderType'] == 'desc') {
            $order = PHP_EOL . 'order by name desc';
        }
    }
}

$productsQuery = $productsQuery . $joins;
$productsQuery = $productsQuery . $where;
$productsQuery = $productsQuery . $order;
$productsQuery = $productsQuery . $limit;

$sth = $dbh->prepare($productsQuery);
$sth->execute($productParams);
$products = $sth->fetchAll();