<?php
require_once 'model/Base.php';
require_once 'model/User.php';

session_start();
$pageHeader = 'Добро пожаловать';

//var_dump(mb_strlen("Привет"));

$username = null;
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']->getUsername();
}

include "view/index.php";