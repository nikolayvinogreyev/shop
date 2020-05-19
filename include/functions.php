<?php

// Получение пользовательских данных
function getUserCredentials($dbh, $email)
{
    $sth = $dbh->prepare('select * from users where email = :email');
    $sth->execute([
        ':email' => $email,
    ]);
    $userCredentials = $sth->fetch();

    return $userCredentials;
}

// Получение последнего вставленного ID в БД
function getLastInsertId($dbh)
{
    $sth = $dbh->prepare('select last_insert_id() as lastInsertId');
    $sth->execute();

    return $sth->fetch()['lastInsertId'];
}

// Вспомогательная функция для вставки пользовательских данных
function insertUserCredentials($dbh, $name, $email, $password, $roles = [])
{
    if (!getUserCredentials($dbh, $email)) {
        $sth = $dbh->prepare('insert into users (name, email, password) values (:name, :email, :password)');
        $sth->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        if (count($roles) > 0) {
            $lastInsertId = getLastInsertId($dbh);

            $sth = $dbh->prepare('insert into user_role (user_id, role_id) values (:user_id, :role_id)');

            foreach ($roles as $role) {
                $sth->execute([
                    ':user_id' => $lastInsertId,
                    ':role_id' => $role,
                ]);
            }
        }
        return true;
    }
    return false;
}

// Проверка пользовательских данных
function checkUserCredentials($dbh, $email, $password)
{
    $userCredentials = getUserCredentials($dbh, $email);

    if ($userCredentials) {
        if (password_verify($password, $userCredentials['password'])) {
            return $userCredentials['id'];
        }
    }
}

// Функция для записи категория товара БД при создании нового товара
function insertCategories($dbh, $productId, $categoriesArr)
{
    $sth = $dbh->prepare('insert into product_category (product_id, category_id) values (:product_id, :category_id)'); // SQL запрос для вставки категорий товаров

    foreach ($categoriesArr as $categoryId) { // Раскодировка массива категорий из JSON, переданного скриптом /js/addProduct.js
        $sth->execute([
            ':product_id' => $productId,
            ':category_id' => $categoryId,
        ]);
    }
}

// Функция для создания нового товара
function insertProduct($dbh, $productName, $price, $file, $categories = [], $isNew = 0, $onSale = 0)
{
    $location = uploadImage($file);

    $sth = $dbh->prepare('insert into products (name, price, img_folder, is_new, on_sale) values (:name, :price, :img_folder, :is_new, :on_sale)'); // SQL запрос для записи данных в таблицу
    $sth->execute([
        ':name' => $productName,
        ':price' => $price,
        ':img_folder' => str_replace($_SERVER['DOCUMENT_ROOT'], '', $location),
        ':is_new' => $isNew,
        ':on_sale' => $onSale,
    ]);

    if (count($categories) > 0) {
        insertCategories($dbh, getLastInsertId($dbh), $categories);
    }
}

// Обновление товара
function updateProduct($dbh, $id, $productName, $price, $file, $categories = [], $isNew = 0, $onSale = 0)
{
    // Строка запроса для обновления товара
    $updateQuery = '
        update products
        set name = :name,
        price = :price,
        is_new = :is_new,
        on_sale = :on_sale
    ';
    // Массив передаваемых параметров для выполнения запроса
    $params = [
        ':name' => $productName,
        ':price' => $price,
        ':is_new' => $isNew,
        ':on_sale' => $onSale,
        ':id' => $id,
    ];
    // Если была обновлена картинка, то передаем новую
    if (!empty($file)) {
        $location = uploadImage($file);
        $updateQuery = $updateQuery . ',' . PHP_EOL . 'img_folder = :img_folder';
        $params['img_folder'] = str_replace($_SERVER['DOCUMENT_ROOT'], '', $location);
    }

    $updateQuery = $updateQuery . PHP_EOL . 'where id = :id';

    $sth = $dbh->prepare($updateQuery); // SQL запрос для записи данных в таблицу
    $sth->execute($params);

    $deleteQuery = '
        delete from product_category
        where product_id = :id
    ';

    $sth = $dbh->prepare($deleteQuery);
    $sth->execute([':id' => $id]);

    if (count($categories) > 0) {
        insertCategories($dbh, $id, $categories);
    }
}

// Функция для загрузки изображения
function uploadImage($file)
{
    $fileName = $file['file']['name'];
    // Формируем путь, по которому сохраним изображение
    // Имя картинки формируем с помощью uniqid(), чтобы оно было уникальным
    $location = $_SERVER['DOCUMENT_ROOT'] . '/img/products/' . uniqid() . '.' . explode('.', $fileName)[1];

    if (move_uploaded_file($file['file']['tmp_name'], $location)) {
        return $location;
    } else {
        return false;
    }
}

// ФУнкция для удаления товара
function removeProduct($dbh, $productId)
{
    $sth = $dbh->prepare('update products set is_active = 0 where id = :id');
    if ($sth->execute([':id' => $productId])) {
        return true;
    } else {
        return false;
    }
}

// Получение товара из БД по id
function getProduct($dbh, $productId)
{
    $sth = $dbh->prepare('select * from products where id = :id');
    if ($sth->execute([':id' => $productId])) {
        $product = $sth->fetchAll();

        if (!empty($product)) {
            $product = $product[0];

            return $product;
        }
    }

    return false;
}

// Получение категорий товара для редактирования товара
function getProductCategoriesForEdit($dbh, $productId)
{
    $sth = $dbh->prepare('
        select
            cat.id
        ,   cat.name
        ,	pr_cat.product_id
        
        from categories as cat
        
        left join product_category as pr_cat on
            cat.id = pr_cat.category_id
        and	pr_cat.product_id = :id
        
        where
            1 = 1
        and cat.id <> 1
        
        order by cat.id
    ');

    if ($sth->execute([':id' => $productId])) {

        $categories = $sth->fetchAll();

        if (!empty($categories)) {
            return $categories;
        }
    }

    return false;
}

// Получение товарных категорий
function getCategories($dbh)
{
    $sth = $dbh->prepare('select * from categories order by id');

    if ($sth->execute()) {

        $categories = $sth->fetchAll();

        if (!empty($categories)) {
            return $categories;
        }
    }

    return false;
}

// Функция для получения товаров в админку
function getProductsForAdmin($dbh)
{
    $sth = $dbh->prepare('
        select
        pr.name as name
    ,   pr.id as id
    ,   pr.price as price
    ,   pr.img_folder
    ,   group_concat(cat.name separator \'\n\') as category
    ,   if(pr.is_new = 1, \'Да\', \'Нет\') as is_new
    ,   concat(replace(format(price, 0), ",", " "), " руб.") as formatted_price
    
    from products as pr
    
    join product_category as pr_cat on
            pr.id = pr_cat.product_id
              
    join categories cat on
            pr_cat.category_id = cat.id
            
    where
        pr.is_active = 1
              
    group by
        pr.name
    ,   pr.id
    ,   pr.price
    ,   pr.img_folder
    ,   if(pr.is_new = 1, "Да", "Нет")
    ,   concat(replace(format(price, 0), ",", " "), " руб.")
    ');

    if ($sth->execute()) {

        $products = $sth->fetchAll();

        if (!empty($products)) {
            return $products;
        }
    }
    return false;
}

// Склонение слов для блока с количеством моделей на главное странице
function wordDeclension($n, $word1, $word2, $word3)
{
    if ((substr($n, strlen($n) - 2) >= 11 and substr($n, strlen($n) - 2) <= 19)) {
        return $word3;
    }

    $n = $n % 10;

    if ($n == 1) {
        return $word1;
    }

    if ($n >= 2 and $n <= 4) {
        return $word2;
    }

    return $word3;
}

// Проверка наличия доступа к странице для разраничения доступов по ролям
function checkPageAccess($dbh, $userId, $pageName)
{
    $access = false;

    $sth = $dbh->prepare('
        select count(1) as cnt from pages_access as pa
        join user_role as ur on pa.role_id = ur.role_id
        join users as u on ur.user_id = u.id and u.id = :userId
        where page_name = :pageName
    ');

    if ($sth->execute([':userId' => $userId, ':pageName' => $pageName])) {
        if ($sth->fetchAll()[0]['cnt'] > 0) {
            $access = true;
        }
    }

    return $access;
}

// Функция для очистки переданных значений из формы от HTML и PHP тегов
function clean($value = "")
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}

// Функция для проверки длины строки
function checkLength($value = "", $min, $max)
{
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return !$result;
}
