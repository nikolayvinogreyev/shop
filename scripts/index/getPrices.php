<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/index/whereConditions.php');

$pricesQuery = '
    select
        min(pr.price) as min_price
    ,   max(pr.price) as max_price
    ,   concat(replace(format(min(pr.price), 0), ",", " "), " руб.") as formatted_min_price
    ,   concat(replace(format(max(pr.price), 0), ",", " "), " руб.") as formatted_max_price
    from products as pr
' . PHP_EOL;

$pricesQuery = $pricesQuery . $joins;
$pricesQuery = $pricesQuery . $where;

$sth = $dbh->prepare($pricesQuery);
$sth->execute($params);
$prices = $sth->fetchAll()[0];