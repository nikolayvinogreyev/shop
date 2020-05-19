<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/index/getContent.php');

echo json_encode($content);