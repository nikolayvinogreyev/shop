<?php

if ($_SESSION['isAuthorized']) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/adminNavigation.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/getOrders.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/orders.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/adminFooter.php');
} else {
    header('Location: /admin');
}
