<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/index/getContent.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/headerNavigation.php');

$categories = getCategories($dbh);

require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/index/index.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
