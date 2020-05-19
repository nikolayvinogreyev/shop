<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');

$categories = [];

foreach (getCategories($dbh) as $category) {
    $categories['/' . $category['eng_name']] = $_SERVER['DOCUMENT_ROOT'] . '/routes/index.php';
}

$routes = [
    '/' => $_SERVER['DOCUMENT_ROOT'] . '/routes/index.php',
    '/admin' => $_SERVER['DOCUMENT_ROOT'] . '/routes/admin.php',
    '/orders' => $_SERVER['DOCUMENT_ROOT'] . '/routes/orders.php',
    '/products' => $_SERVER['DOCUMENT_ROOT'] . '/routes/products.php',
    '/add' => $_SERVER['DOCUMENT_ROOT'] . '/routes/add.php',
    '/authorization' => $_SERVER['DOCUMENT_ROOT'] . '/scripts/authorization.php',
    '/exit' => $_SERVER['DOCUMENT_ROOT'] . '/scripts/exit.php',
    '/delivery' => $_SERVER['DOCUMENT_ROOT'] . '/routes/delivery.php',
    '/edit' => $_SERVER['DOCUMENT_ROOT'] . '/routes/add.php',
    '/new' => $_SERVER['DOCUMENT_ROOT'] . '/routes/index.php',
    '/sale' => $_SERVER['DOCUMENT_ROOT'] . '/routes/index.php',
];

$routes = array_merge($routes, $categories);

$page = $_SERVER['REQUEST_URI'];
// Проверяем содержит ли переданный url рездалитель ? для get параметров
$page = strpos($page, '?') ? explode('?', $page)[0] : $page;

if (isset($routes[$page]) && file_exists($routes[$page])) {
    require_once($routes[$page]);
} else {
    header("HTTP/1.0 404 Not Found");
}
