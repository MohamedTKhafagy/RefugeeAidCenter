

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'Controllers/RefugeeController.php';
require_once 'Controllers/HospitalController.php';
require_once 'Controllers/ShelterController.php';
require_once 'Controllers/SchoolController.php';
require_once 'Controllers/InventoryController.php';
require_once 'Controllers/DonatorController.php';
require_once 'Controllers/DonationController.php';

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
    else $controller->index();
} elseif ($segments[0] == 'hospitals') {
    $controller = new HospitalController();

    if (isset($segments[1])) {
        if ($segments[1] === 'add') {
            $controller->add((!empty($_POST)) ? $_POST : null);
        } elseif ($segments[1] === 'assignStrategy') {
            parse_str($queryString, $queryArray);
            $controller->assignStrategy($queryArray['hospitalId'], $queryArray['type']);
        } elseif ($segments[1] === 'update' && isset($_GET['id'])) {
            // Handle update functionality
            $controller->update($_GET['id'], (!empty($_POST)) ? $_POST : null);
        } elseif ($segments[1] === 'delete' && isset($_GET['id'])) {
            // Handle delete functionality
            $controller->delete($_GET['id']);
        } else {
            echo "Invalid action for hospitals.";
        }
    } else {
        $controller->index();
    }
}


 elseif ($segments[0] == 'shelters') {

    $controller = new ShelterController();
    if (isset($segments[1]) && $segments[1] === 'shelterDetails') {
        parse_str($queryString, $queryArray);
        $controller->showShelter((!empty($queryArray)) ? $queryArray : null);
    } else {
        $controller->showAllShelters();
    }
} elseif ($segments[0] == 'schools') {

    $controller = new SchoolController();
    if (isset($segments[1]) && $segments[1] === 'schoolDetails') {
        parse_str($queryString, $queryArray);
        $controller->showSchool((!empty($queryArray)) ? $queryArray : null);
    } else {
        $controller->showAllSchools();
    }
} elseif ($segments[0] == 'inventory') {

    $controller = new InventoryController();
    if (isset($segments[1]) && $segments[1] === 'inventorydetails') {
        parse_str($queryString, $queryArray);
        $controller->showInventory((!empty($queryArray)) ? $queryArray : null);
    } else {
        $controller->showAllInventory();
    }
}
if ($segments[0] == 'donators') {
    $controller = new DonatorController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='view' && isset($segments[2])) $controller->findDonatorById($segments[2]);
    else if(isset($segments[1])&&$segments[1]=='edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editDonator') $controller->editDonator((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
if ($segments[0] == 'donations') {
    $controller = new DonationController();
    if (isset($segments[1]) && $segments[1] === 'makeDonation') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='view' && isset($segments[2]))$controller->findDonationById($segments[2]);
    else $controller->index();
}
else {
    
}
?>