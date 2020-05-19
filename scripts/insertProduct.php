<?php 

require($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');

parse_str($_POST['formData'], $data);

// Проверка полей формы
$productName = clean($data['product-name']);
$productPrice = clean($data['product-price']);

// Результат работы условия передается в ajax для дальнейшей обработки в javascript
if (!empty($productName) && !empty($productPrice) && count($data['category']) > 0 && !empty($_FILES)) {
    if (checkLength($productName, 2, 255) && is_numeric($productPrice)) {
        insertProduct($dbh,
            $productName,
            $productPrice,
            $_FILES,
            $data['category'],
            isset($data['new']) ? 1 : 0,
            isset($data['sale']) ? 1 : 0);

        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
