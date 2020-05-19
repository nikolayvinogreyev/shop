<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');

parse_str($_POST['formData'], $data);

// Проверка полей формы
$productName = clean($data['product-name']);
$productPrice = clean($data['product-price']);

// Результат работы условия передается в ajax для дальнейшей обработки в javascript
if (!empty($productName) && !empty($productPrice) && count($data['category']) > 0) {
    if (checkLength($productName, 2, 255) && is_numeric($productPrice)) {

        updateProduct($dbh,
            $_SESSION['productId'],
            $productName,
            $productPrice,
            $_FILES,
            $data['category'],
            isset($data['new']) ? 1 : 0,
            isset($data['sale']) ? 1 : 0);
        // Передаем 1 в ajax для обработ
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
