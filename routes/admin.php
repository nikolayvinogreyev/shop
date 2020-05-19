<?php

if (!isset($_SESSION['isAuthorized'])) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/headerNavigation.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/admin.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
} else {
    header('Location: /orders');
}
