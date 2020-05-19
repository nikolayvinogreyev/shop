<?php

require($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');

if (!empty($_POST)) {
    $sth = $dbh->prepare('update orders set order_status_id = :order_status_id where id = :order_id ');
    $sth->execute([
            ':order_status_id' => $_POST['statusId'],
            ':order_id' => $_POST['orderId']]);
}
