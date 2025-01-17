

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
require_once 'Controllers/TaskController.php';
require_once 'Controllers/InventoryController.php';
require_once 'Controllers/DonatorController.php';
require_once 'Controllers/DonationController.php';
require_once 'Controllers/DoctorController.php';
require_once 'Controllers/NurseController.php';
require_once 'Controllers/TeacherController.php';
require_once 'Controllers/SocialWorkerController.php';
require_once 'Controllers/RequestController.php';
require_once 'Controllers/AdminController.php';


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
        switch($segments[1]) {
            case 'add':
                $controller->add($_POST ?: null);
                break;
            case 'edit':
                /*if (isset($segments[2])) {
                    $controller->edit($segments[2]);
                }*/
                if(isset($segments[1])&&$segments[1]=='edit' && isset($segments[2])) $controller->edit($segments[2]);
                break;
            case 'update':

              
                    $controller->editHospital((isset($_POST) && !empty($_POST)) ? $_POST:null);

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
}
elseif ($segments[0] == 'schools') {
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
    else if(isset($segments[1])&&$segments[1]=='viewDonations') $controller->findDonationsById();
    else if(isset($segments[1])&&$segments[1]=='edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editDonator') $controller->editDonator((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
if ($segments[0] == 'donations') {
    $controller = new DonationController();
    if (isset($segments[1]) && $segments[1] === 'makeDonation') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='view' && isset($segments[2]))$controller->findDonationById($segments[2]);
    else if(isset($segments[1])&&$segments[1]=='complete' && isset($segments[2]))$controller->complete($segments[2]);
    else if(isset($segments[1])&&$segments[1]=='fail' && isset($segments[2]))$controller->fail($segments[2]);
    else if(isset($segments[1])&&$segments[1]=='undo' && isset($segments[2]))$controller->undo($segments[2]);
    else $controller->index();
}


if ($segments[0] == 'requests') {
    $controller = new RequestController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] === 'viewrefugee') $controller->findRequestByIdRefugee();
    else if (isset($segments[1]) && $segments[1] === 'view') $controller->findRequestByIdAdmin();
    else if (isset($segments[1]) && $segments[1] === 'submit' && isset($segments[2])) $controller->submitRequest($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'accept' && isset($segments[2])) $controller->acceptRequest($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'complete' && isset($segments[2])) $controller->completeRequest($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'decline' && isset($segments[2])) $controller->declineRequest($segments[2]);
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
if ($segments[0] == 'socialWorkers') {
    $controller = new SocialWorkerController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='view' && isset($segments[2])) $controller->findSocialWorkerById($segments[2]);
    else if(isset($segments[1])&&$segments[1]=='edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editSocialWorker') $controller->editSocialWorker((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if(isset($segments[1])&&$segments[1]=='delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
if ($segments[0] == 'communication') {
    include_once "Controllers/CommunicationController.php";
    $controller = new CommunicationController();

    if (isset($segments[1]) && $segments[1] === 'send') {
        // Pass form data to the controller's method
        $controller->handleFormSubmit($_POST);
    } elseif (isset($segments[1]) && $segments[1] === 'success') {
        echo "Message sent successfully!";
    } else {
        // Show the form for sending messages
        include __DIR__ . '/Views/SendMessage.php';
    }
}
// if ($segments[0] == 'refugees') {
//     $controller = new RefugeeController();
//     if (isset($segments[1]) && $segments[1] === 'add') $controller->add();
//     else if (isset($segments[1]) && $segments[1] === 'editRefugee') {
//         parse_str($queryString, $queryArray);
//         $controller->edit((!empty($queryArray)) ? $queryArray : null);
//     }
//     else $controller->index();
// } 

elseif ($segments[0] == 'refugees') {
    $controller = new RefugeeController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add();
    elseif (isset($segments[1]) && $segments[1] === 'editRefugee') {
        parse_str($queryString, $queryArray);
        $controller->edit((!empty($queryArray)) ? $queryArray : null);
    }
    elseif (isset($segments[1]) && $segments[1] === 'edit') $controller->update($_POST);
    elseif (isset($segments[1]) && $segments[1] === 'delete' && isset($segments[2])) $controller->delete($segments[2]);
    elseif (isset($segments[1]) && $segments[1] === 'view' && isset($segments[2])) $controller->view($segments[2]);
    else $controller->index();
} 

// elseif ($segments[0] == 'volunteers') {
//     $controller = new VolunteerController();
//     if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
//     else if (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findVolunteerById($segments[2]);
//     else if (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
//     else if (isset($segments[1]) && $segments[1] === 'editVolunteer') $controller->editVolunteer((isset($_POST) && !empty($_POST)) ? $_POST : null);
//     else if (isset($segments[1]) && $segments[1] == 'delete' && isset($segments[2])) $controller->delete($segments[2]);
//     else $controller->index();
// }

elseif ($segments[0] == 'volunteers') {
    $controller = new VolunteerController();
    // if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    if (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findVolunteerById($segments[2]);
    elseif (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
    elseif (isset($segments[1]) && $segments[1] === 'editVolunteer') $controller->update((isset($_POST) && !empty($_POST)) ? $_POST : null);
    elseif (isset($segments[1]) && $segments[1] == 'delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
} elseif ($segments[0] == 'register') {
    $controller = new RegisterController();
    if (isset($segments[1]) && $segments[1] === 'new' && isset($_POST) && !empty($_POST)) $controller->register($_POST);
    elseif (isset($segments[1]) && $segments[1] === 'newAdmin' && isset($_POST) && !empty($_POST)) $controller->register($_POST, true);
    else $controller->index();
} elseif ($segments[0] == 'login') {
    $controller = new LoginController();
    if (isset($segments[1]) && $segments[1] === 'new' && isset($_POST) && !empty($_POST)) $controller->login($_POST);
    else $controller->index();
} elseif ($segments[0] == 'shelters') {
    $controller = new ShelterController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    elseif (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findShelterById($segments[2]);
    elseif (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
    elseif (isset($segments[1]) && $segments[1] === 'editShelter') $controller->editShelter((isset($_POST) && !empty($_POST)) ? $_POST : null);
    elseif (isset($segments[1]) && $segments[1] == 'delete' && isset($segments[2])) $controller->delete($segments[2]);
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
elseif ($segments[0] == 'shelters') {
    $controller = new ShelterController();
    if (isset($segments[1]) && $segments[1] === 'add') $controller->add((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'view' && isset($segments[2])) $controller->findShelterById($segments[2]);
    else if (isset($segments[1]) && $segments[1] == 'edit' && isset($segments[2])) $controller->edit($segments[2]);
    else if (isset($segments[1]) && $segments[1] === 'editShelter') $controller->editShelter((isset($_POST) && !empty($_POST)) ? $_POST : null);
    else if (isset($segments[1]) && $segments[1] == 'delete' && isset($segments[2])) $controller->delete($segments[2]);
    else $controller->index();
}
elseif ($segments[0] == 'admin') {

    $controller = new AdminController();
    $taskcontroller = new TaskController();


    
    // Basic routing for admin actions
    if (!isset($segments[1])) {
        $controller->index();
    } else {
        switch ($segments[1]) {
            case 'editUser':
                if (isset($segments[2])) $controller->editUser($segments[2]);
                break;
            case 'editEvent':
                if (isset($segments[2])) $controller->editEvent($segments[2]);
                break;
            case 'editTask':
                if (isset($segments[2])) $taskcontroller->edit($segments[2]);
                break;
            case 'editDonation':
                if (isset($segments[2])) $controller->editDonation($segments[2]);
                break;
            default:
                // Handle 404 or redirect to dashboard
                $controller->index();
        }
    }
} 
// if ($segments[0] == 'tasks') {
//     $controller = new TaskController();

//     if (isset($segments[1]) && $segments[1] === 'edit' && isset($segments[2])) {
//         $controller->edit($segments[2]);
//     }
//     elseif (isset($segments[1]) && $segments[1] === 'update' && isset($_POST)) {
//         $controller->update($_POST);
//     }
//     else {
//         $controller->index();
//     }
// }

// if ($segments[0] == 'tasks') {
//     $controller = new TaskController();

//     if (isset($segments[1]) && $segments[1] === 'edit' && isset($segments[2])) {
//         $controller->edit($segments[2]);
//     }
//     elseif (isset($segments[1]) && $segments[1] === 'update' && isset($_POST)) {
//         $controller->update($_POST);
//     }
//     else {
//         $controller->index();
//     }
// }

elseif ($segments[0] == 'volunteertasks') {
    $controller = new TaskController();
    $controller->volunteerindex();
}

elseif ($segments[0] == 'tasks') {
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
                }
                break;
            case 'delete':
                if (isset($segments[2])) {
                    $controller->delete($segments[2]);
                }
                break;
            case 'details':
                if (isset($segments[2])) {
                    $controller->details($segments[2]);
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
        }
    }
} elseif ($segments[0] == 'test') {
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
} 
elseif ($segments[0] == 'dashboard') {
    if (isset($segments[1]) && $segments[1] === 'donator') {
        include_once 'Views/DonatorDashboard.php';
    }
    elseif (isset($segments[1]) && $segments[1] === 'refugee') {
        include_once 'Views/RefugeeDashboard.php';
    }
    elseif (isset($segments[1]) && $segments[1] === 'volunteer') {
        include_once 'Views/VolunteerDashboard.php';
    }
    elseif (isset($segments[1]) && $segments[1] === 'admin') {
        include_once 'Views/AdminDashboard.php';
    }
}

else {
    
}


?>
