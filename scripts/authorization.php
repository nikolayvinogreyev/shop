<?php

session_start();

if (!isset($_SESSION['isAuthorized'])) {
    // Если была отправлена форма, то делаем проверку введенных данных
    if (!empty($_POST)) {
            $_SESSION['isAuthorized'] = checkUserCredentials($dbh, $_POST['email'], $_POST['password']);
        if (!empty($_SESSION['isAuthorized'])) {
            // Перенаправляем на страницу заказов
            header('Location: /orders');
        } else {
            header('Location: /admin');
        }
    }
}