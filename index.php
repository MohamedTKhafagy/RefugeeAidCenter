

<?php

// require_once 'Controllers/RefugeeController.php';

// $controller = new RefugeeController();

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if ($_POST['action'] === 'save') {
//         $controller->saveRefugee($_POST);
//     }
// } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'find') {
//     $refugee = $controller->findRefugeeById($_GET['id']);
// } else {
//     include 'Views/RefugeeView.php';
// }

//-------------------------------******-----------------
// require_once 'Controllers/ShelterController.php';

// $controller = new ShelterController();

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
//     if ($_POST['action'] === 'updateCapacity' && isset($_POST['ShelterID'], $_POST['newCapacity'])) {
//         $controller->updateCapacity($_POST['ShelterID'], (int)$_POST['newCapacity']);
//     }
// } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
//     if ($_GET['action'] === 'showAll') {
//         $controller->showAllShelters();
//     } elseif ($_GET['action'] === 'show' && isset($_GET['ShelterID'])) {
//         $controller->showShelter((int)$_GET['ShelterID']);
//     }
// } else {
//     // Default action: show all shelters
//     $controller->showAllShelters();
// }

//-----------------------------------------


// require_once 'Controllers/InventoryController.php';

// $controller = new InventoryController();

// if (isset($_GET['action']) && $_GET['action'] === 'show' && isset($_GET['inventoryID'])) {
//     $controller->showInventory($_GET['inventoryID']);
// } else {
//     $controller->showAllInventory();
// }
// 

///----------------------------------


require_once 'Controllers/SchoolController.php';

$controller = new SchoolController();

if (isset($_GET['action']) && $_GET['action'] === 'show' && isset($_GET['SchoolID'])) {
    $controller->showSchool($_GET['SchoolID']);
} else {
    $controller->showAllSchools();
}


?>
