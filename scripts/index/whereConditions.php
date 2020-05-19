<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');

$params = [];

$where = '
    where
        pr.is_active = 1
' . PHP_EOL;

if(isset($_GET['category'])) {
    $category = $_GET['category'];
} else {
    $category = str_replace('/', '', explode('?', $_SERVER['REQUEST_URI'])[0]);
}

$joins = '';

if ($category == 'new') {
    $where = $where . 'and pr.is_new = 1' . PHP_EOL;
} else if ($category == 'sale') {
    $where = $where . 'and pr.on_sale = 1' . PHP_EOL;
}

if (!in_array($category, ['new', 'sale', ''])) {

    $joins = PHP_EOL.'
        join product_category as pr_cat on
                pr.id = pr_cat.product_id
    
        join categories as cat on
                pr_cat.category_id = cat.id
        ' . PHP_EOL;

    // Дополнение блока where категориями
    $where = $where . 'and cat.eng_name = :category' . PHP_EOL;
    $params[':category'] = $category;
}

if (isset($_GET['isNew']) && $_GET['isNew'] == 1) {
    $where = $where . 'and pr.is_new = 1' . PHP_EOL;
}

if (isset($_GET['onSale']) && $_GET['onSale'] == 1) {
    $where = $where . 'and pr.on_sale = 1' . PHP_EOL;
}

// Если переданы параметры цены
if (isset($_GET['minPrice']) && isset($_GET['maxPrice'])) {
    $where = $where . PHP_EOL . 'and pr.price between :min_price and :max_price' . PHP_EOL;
    $params[':min_price'] = $_GET['minPrice'];
    $params[':max_price'] = $_GET['maxPrice'];
}
