<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/index/whereConditions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/index/getProductsCount.php');

$pagesCount = ceil($productsCount / PRODUCTS_CNT_PER_PAGE);