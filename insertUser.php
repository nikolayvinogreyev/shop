<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');

insertUserCredentials($dbh, 'Администратор', 'admin@diploma.ru', '1111', [1]);
insertUserCredentials($dbh, 'Оператор', 'operator@diploma.ru', '1111', [1]);