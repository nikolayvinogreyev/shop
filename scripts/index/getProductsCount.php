<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/index/whereConditions.php');

$productsCountQuery = '
    select
        count(*) as products_cnt 
    from products as pr
' . PHP_EOL;

$productsCountQuery = $productsCountQuery . $joins;
$productsCountQuery = $productsCountQuery . $where;

$sth = $dbh->prepare($productsCountQuery);
$sth->execute($params);
$productsCount = intval($sth->fetchAll()[0]['products_cnt']);