<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'Controllers/RefugeeController.php';
require_once 'Controllers/HospitalController.php';
require_once 'Controllers/RegisterController.php';
require_once 'Controllers/LoginController.php';

$basePath = dirname($_SERVER['SCRIPT_NAME']);
$requestUri = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
$requestUri = trim($requestUri, '/');

$parsedUrl = parse_url($requestUri);
$path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
$queryString = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';

// Split the path into segments
$segments = explode('/', trim($path, '/'));

if ($segments[0] == 'refugees') {
    $controller = new RefugeeController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] === 'edit') {
        parse_str($queryString, $queryArray);
        $controller->edit((!empty($queryArray)) ? $queryArray : null);
    }
    else $controller->index();
}
else if($segments[0] == 'hospitals') {
    $controller = new HospitalController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else $controller->index();
}
else if ($segments[0] == 'register') {
    $controller = new RegisterController();
    if (isset($segments[1]) && $segments[1] === 'new' && isset($_POST) && !empty($_POST)) $controller->register($_POST);
    else if (isset($segments[1]) && $segments[1] === 'newAdmin' && isset($_POST) && !empty($_POST)) $controller->register($_POST, true);
    else $controller->index();
}
else if($segments[0] == 'login') {
    $controller = new LoginController();
    if (isset($segments[1]) && $segments[1] === 'new' && isset($_POST) && !empty($_POST)) $controller->login($_POST);
    else $controller->index();
}
else {
    echo '404 Not Found';
}
?>
