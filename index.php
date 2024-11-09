<?php
require_once 'Controllers/RefugeeController.php';

$controller = new RefugeeController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'save') {
        $controller->saveRefugee($_POST);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'find') {
    $refugee = $controller->findRefugeeById($_GET['id']);
    include 'Views/RefugeeView.php';
} else {
    include 'Views/RefugeeView.php';
}
