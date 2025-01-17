<?php

class TestController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function mockLogin()
    {
        $type = isset($_GET['type']) ? $_GET['type'] : 'user';
        $_SESSION['user'] = [
            'id' => 1,
            'type' => $type
        ];
        $_SESSION['success'] = "Mock login successful as " . $type;
        header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events/registration');
        exit;
    }

    public function mockLogout()
    {
        session_destroy();
        $_SESSION = array();
        header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/login');
        exit;
    }
}
