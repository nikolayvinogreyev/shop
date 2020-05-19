<?php

require($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');

if (!isset($_SESSION['isAuthorized'])) {
    header('Location: /route/admin/');
} else {
    if (!empty($_POST)) {
        if (isset($_POST['id'])) {
            removeProduct($dbh, $_POST['id']);
        }
    }
}
