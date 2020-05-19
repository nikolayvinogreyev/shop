<?php

session_start();

if (isset($_SESSION['isAuthorized']) && $_SESSION['isAuthorized']) {

    unset($_SESSION);

    session_destroy();

    header('Location: /admin');

}