<?php
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$controller = isset($uri[0]) && $uri[0] ? ucfirst($uri[0]) . 'Controller' : 'AuthController';
$method = $uri[1] ?? 'login';
$id = $uri[2] ?? null;

require_once "controllers/$controller.php";
$obj = new $controller();
if ($id !== null) {
    $obj->$method($id);
} else {
    $obj->$method();
}
