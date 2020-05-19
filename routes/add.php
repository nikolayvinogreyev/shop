<?php

if (isset($_SESSION['isAuthorized'])) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');

    if (checkPageAccess($dbh, $_SESSION['isAuthorized'], basename(__FILE__, '.php'))) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/adminNavigation.php');

        $categories = getCategories($dbh);

        if (isset($_GET['id'])) {
            $product = getProduct($dbh, $_GET['id']);
            $categories = getProductCategoriesForEdit($dbh, $_GET['id']);

            $_SESSION['productId'] = $_GET['id'];

            if (!$product) {
                die;
            }
        }
        require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/add.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/adminFooter.php');

    } else {
        header('Location: /orders');
    }
} else {
    header('Location: /admin');
}
