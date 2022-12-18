<?php
//session_start();
//unset($_SESSION['username']);
try {
    $controller = $_GET['controller'] ?? 'index';

    $routes = require 'routes.php';

    if (!key_exists($controller, $routes)) {
        throw new Exception("404");
    }

    require_once $routes[$controller];
} catch (PDOException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo "404";
}

