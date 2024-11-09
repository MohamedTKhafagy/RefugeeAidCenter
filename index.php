<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'Controllers/RefugeeController.php';
require_once 'Controllers/HospitalController.php';

$basePath = dirname($_SERVER['SCRIPT_NAME']);
$requestUri = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
$requestUri = trim($requestUri, '/');

$segments = explode('/', $requestUri);

if ($segments[0] == 'refugees') {
    $controller = new RefugeeController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else $controller->index();
}
else if($segments[0] == 'hospitals') {
    $controller = new HospitalController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else $controller->index();
}
else {
    echo '404 Not Found';
}
?>
