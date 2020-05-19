<?php

require($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');

if (!empty($_POST)) {
    parse_str($_POST['formData'], $data);

    // Текст запроса на выборку цены товара
    $getPriceQuery = 'select price from products where id = :id';
    $insertOrderQuery = '';
    // Устанавливаем стоимость доставки в зависимости от выбранного типа доставки
    // 1 - самовывоз
    // 2 - курьерная доставка
    $deliveryPrice = $data['delivery_type'] == 1 ? 0 : DELIVERY_COST;
    // Получение цены товара из базы данных
    $sth = $dbh->prepare($getPriceQuery);
    $sth->execute([':id' => $_POST['productId']]);
    $productPrice = $sth->fetchAll()[0]['price'];
    // Окончательное определение стоимости доставки в зависимости от суммы покупки
    $deliveryPrice = $productPrice > PAID_DELIVERY_PRODUCT_SUM ? 0 : $deliveryPrice;
    // Если тип доставки 1 - Самовывоз
    $insertOrderQuery = 'insert into orders (
                        first_name,
                        second_name,
                        last_name,
                        phone,
                        email, 
                        delivery_type_id,
                        city,
                        street,
                        house,
                        flat,
                        payment_type_id,
                        comment_,
                        product_id,
                        product_price,
                        delivery_price
                    ) values (
                        :first_name,
                        :second_name,
                        :last_name,
                        :phone,
                        :email, 
                        :delivery_type_id,
                        :city,
                        :street,
                        :house,
                        :flat,
                        :payment_type_id,
                        :comment_,
                        :product_id,
                        :product_price,
                        :delivery_price
                    )';

    // Проверка полей формы, которые заполняются пользователем
    $firstName = clean($data['first_name']);
    $secondName = clean($data['second_name']);
    $lastName = clean($data['last_name']);
    $phone = clean($data['phone']);
    $email = clean($data['email']);
    $city = clean($data['city']);
    $street = clean($data['street']);
    $house = clean($data['home']);
    $flat = clean($data['aprt']);
    $comment = clean($data['comment']);

    // Проверка длины полей
    if (checkLength($firstName, 1, 100) &&
        checkLength($secondName, 0, 100) &&
        checkLength($lastName, 1, 100) &&
        checkLength($phone, 10, 15) &&
        checkLength($email, 5, 100) &&
        checkLength($comment, 0, 1000)) {
        // Если тип доставки - курьерная доставка и хотя бы одно из полей адреса имеет неправильную длину,
        // то отправляем в ajax - 0 - ошибка заполнения
        if ($data['delivery_type'] == 2 && (
            !checkLength($city, 1, 100) ||
            !checkLength($street, 1, 100) ||
            !checkLength($house, 1, 50) ||
            !checkLength($flat, 1, 50))) {
            // Отправляем отрицательный результат в ajax
            echo 0;
        } else {
            // Вставка запись данных в БД
            $sth = $dbh->prepare($insertOrderQuery);
            if ($sth->execute([
                ':first_name' => $data['first_name'],
                ':second_name' => !empty($data['second_name']) ? $data['second_name'] : null,
                ':last_name' => $data['last_name'],
                ':phone' => $data['phone'],
                ':email' => $data['email'],
                ':delivery_type_id' => $data['delivery_type'],
                ':city' => !empty($data['city']) ? $data['city'] : null,
                ':street' => !empty($data['street']) ? $data['street'] : null,
                ':house' => !empty($data['home']) ? $data['home'] : null,
                ':flat' => !empty($data['aprt']) ? $data['aprt'] : null,
                ':payment_type_id' => $data['payment_type'],
                ':comment_' => !empty($data['comment']) ? $data['comment'] : null,
                ':product_id' => $_POST['productId'],
                ':product_price' => $productPrice,
                ':delivery_price' => $deliveryPrice,
            ]));

            echo 1;
        }
    } else {
        echo 0;
    }
}
