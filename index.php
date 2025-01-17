<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'Controllers/RefugeeController.php';
require_once 'Controllers/HospitalController.php';
require_once 'Controllers/RegisterController.php';
require_once 'Controllers/LoginController.php';
require_once 'Controllers/ShelterController.php';
require_once 'Controllers/SchoolController.php';
require_once 'Controllers/VolunteerController.php';
require_once 'Controllers/TaskController.php';
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



if ($segments[0] == 'hospitals') {
    $controller = new HospitalController();
    if (isset($segments[1])) {
        switch ($segments[1]) {
            case 'add':
                $controller->add($_POST ?: null);
                break;
            case 'edit':
                /*if (isset($segments[2])) {
                    $controller->edit($segments[2]);
                }*/
                if (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
                break;
            case 'update':


                $controller->editHospital((isset($_POST) && !empty($_POST)) ? $_POST : null);

                break;
            case 'delete':
                if (isset($segments[2])) {
                    $controller->delete($segments[2]);
                }
                break;
            default:
                $controller->index();
        }
    } else {
        $controller->index();
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
    else if (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findDonatorById($segments[2]);
    else if (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editDonator') $controller->editDonator((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
if ($segments[0] == 'donations') {
    $controller = new DonationController();
    if (isset($segments[1]) && $segments[1] === 'makeDonation') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findDonationById($segments[2]);
    else $controller->index();
}
if ($segments[0] == 'doctors') {
    $controller = new DoctorController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findDoctorById($segments[2]);
    else if (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editDoctor') $controller->editDoctor((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
if ($segments[0] == 'nurses') {
    $controller = new NurseController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findNurseById($segments[2]);
    else if (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editNurse') $controller->editNurse((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}

if ($segments[0] == 'teachers') {
    $controller = new TeacherController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findTeacherById($segments[2]);
    else if (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editTeacher') $controller->editTeacher((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
if ($segments[0] == 'socialWorkers') {
    $controller = new SocialWorkerController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findSocialWorkerById($segments[2]);
    else if (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editSocialWorker') $controller->editSocialWorker((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
if ($segments[0] == 'communication') {
    if (isset($segments[1]) && $segments[1] === 'send') {
        include_once "Controllers/CommunicationController.php";
        $controller = new CommunicationController();
        $controller->handleFormSubmit((isset($_POST) && !empty($_POST)) ? $_POST : null);
    } else {
        include __DIR__ . '../Views/SendMessage.php';
    }
}
if ($segments[0] == 'refugees') {
    $controller = new RefugeeController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add();
    else if (isset($segments[1]) && $segments[1] === 'editRefugee') {
        parse_str($queryString, $queryArray);
        $controller->edit((!empty($queryArray)) ? $queryArray : null);
    } else $controller->index();
} elseif ($segments[0] == 'volunteers') {
    $controller = new VolunteerController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findVolunteerById($segments[2]);
    else if (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editVolunteer') $controller->editVolunteer((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
} else if ($segments[0] == 'register') {
    $controller = new RegisterController();
    if (isset($segments[1]) && $segments[1] === 'new' && isset($_POST) && !empty($_POST)) $controller->register($_POST);
    else if (isset($segments[1]) && $segments[1] === 'newAdmin' && isset($_POST) && !empty($_POST)) $controller->register($_POST, true);
    else $controller->index();
} else if ($segments[0] == 'login') {
    $controller = new LoginController();
    if (isset($segments[1]) && $segments[1] === 'new' && isset($_POST) && !empty($_POST)) $controller->login($_POST);
    else $controller->index();
} elseif ($segments[0] == 'shelters') {
    $controller = new ShelterController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findShelterById($segments[2]);
    else if (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editShelter') $controller->editShelter((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
if ($segments[0] == 'tasks') {
    $controller = new TaskController();
    if (isset($segments[1])) {
        switch ($segments[1]) {
            case 'wizard':
                if (!isset($segments[2])) {
                    $controller->startWizard();
                } else {
                    switch ($segments[2]) {
                        case 'details':
                            $controller->wizardDetails();
                            break;
                        case 'event':
                            $controller->wizardEvent();
                            break;
                        case 'review':
                            $controller->wizardReview();
                            break;
                        case 'complete':
                            $controller->wizardComplete();
                            break;
                        case 'cancel':
                            $controller->cancelWizard();
                            break;
                        default:
                            header('Location: ' . $baseUrl . '/tasks');
                            exit;
                    }
                }
                break;
            case 'edit':
                if (isset($segments[2])) $controller->edit($segments[2]);
                break;
            case 'update':
                $controller->update((isset($_POST) && !empty($_POST)) ? $_POST : null);
                break;
            case 'delete':
                if (isset($segments[2])) $controller->delete($segments[2]);
                break;
            case 'assign':
                if (isset($segments[2])) $controller->assign($segments[2]);
                break;
            case 'unassign':
                if (isset($segments[2])) $controller->unassign($segments[2]);
                break;
            case 'complete':
                if (isset($segments[2])) $controller->complete($segments[2]);
                break;
            default:
                $controller->index();
        }
    } else {
        $controller->index();
    }
} elseif ($segments[0] == 'events') {
    require_once 'Controllers/EventController.php';
    require_once 'Views/Event/EventListView.php';
    require_once 'Views/Event/EventFormView.php';
    require_once 'Views/Event/EventDetailsView.php';
    require_once 'Views/Event/EventRegistrationView.php';

    $controller = new EventController();

    if (count($segments) == 1) {
        $controller->index();
    } else {
        switch ($segments[1]) {
            case 'add':
                $controller->add();
                break;
            case 'edit':
                if (isset($segments[2])) {
                    $controller->edit($segments[2]);
                } else {
                    header('Location: ' . $baseUrl . '/events');
                }
                break;
            case 'delete':
                if (isset($segments[2])) {
                    $controller->delete($segments[2]);
                } else {
                    header('Location: ' . $baseUrl . '/events');
                }
                break;
            case 'details':
                if (isset($segments[2])) {
                    $controller->details($segments[2]);
                } else {
                    header('Location: ' . $baseUrl . '/events');
                }
                break;
            case 'registration':
                $controller->registration();
                break;
            case 'register':
                $controller->register();
                break;
            case 'unregister':
                $controller->unregister();
                break;
            default:
                header('Location: ' . $baseUrl . '/events');
        }
    }
    exit;
} else if ($segments[0] == 'test') {
    require_once 'tests/TestController.php';
    $controller = new TestController();

    if (count($segments) > 1) {
        switch ($segments[1]) {
            case 'mock-login':
                $controller->mockLogin();
                break;
            case 'mock-logout':
                $controller->mockLogout();
                break;
            default:
                header('Location: ' . $baseUrl . '/login');
                exit;
        }
    } else {
        header('Location: ' . $baseUrl . '/login');
        exit;
    }
} else {
}
