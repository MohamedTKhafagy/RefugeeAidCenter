

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
require_once 'Controllers/DoctorController.php';
require_once 'Controllers/NurseController.php';
require_once 'Controllers/TeacherController.php';
require_once 'Controllers/SocialWorkerController.php';

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
} else if ($segments[0] == 'hospitals') {
    $controller = new HospitalController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else $controller->index();
} elseif ($segments[0] == 'shelters') {

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
        $controller->showInventory();
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
if ($segments[0] == 'doctors') {
    $controller = new DoctorController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='view' && isset($segments[2])) $controller->findDoctorById($segments[2]);
    else if(isset($segments[1])&&$segments[1]=='edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editDoctor') $controller->editDoctor((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
if ($segments[0] == 'nurses') {
    $controller = new NurseController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='view' && isset($segments[2])) $controller->findNurseById($segments[2]);
    else if(isset($segments[1])&&$segments[1]=='edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editNurse') $controller->editNurse((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}

if ($segments[0] == 'teachers') {
    $controller = new TeacherController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='view' && isset($segments[2])) $controller->findTeacherById($segments[2]);
    else if(isset($segments[1])&&$segments[1]=='edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editTeacher') $controller->editTeacher((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
/*
if ($segments[0] == 'socialWorkers') {
    $controller = new SocialWorkerController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='view' && isset($segments[2])) $controller->findSocialWorkerById($segments[2]);
    else if(isset($segments[1])&&$segments[1]=='edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editSocialWorker') $controller->editSocialWorker((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
    */
else {
    
}
?>