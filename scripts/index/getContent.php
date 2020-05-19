<?php

$content = [];

ob_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/index/indexProductsTemplate.php');

$content['products'] = ob_get_contents();

ob_clean();

require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/index/indexPaginationTemplate.php');

$content['pagination'] = ob_get_contents();

ob_clean();

echo $productsCount . ' ' . wordDeclension($productsCount, "модель", "модели", "моделей");

$content['productsCount'] = ob_get_contents();

ob_clean();

require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/index/getPrices.php');

echo $prices['formatted_max_price'];

$content['formattedMaxPrice'] = ob_get_contents();

ob_clean();

echo $prices['formatted_min_price'];

$content['formattedMinPrice'] = ob_get_contents();

ob_clean();

echo $prices['max_price'];

$content['maxPrice'] = ob_get_contents();

ob_clean();

echo $prices['min_price'];

$content['minPrice'] = ob_get_contents();

ob_end_clean();



