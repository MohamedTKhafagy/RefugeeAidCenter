<?php
require_once 'TaskDetailsCommandTest.php';
require_once 'TaskManagementTest.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting All Tests...\n";
echo "===================\n\n";


$detailsTest = new TaskDetailsCommandTest();
$detailsTest->runAllTests();

$managementTest = new TaskManagementTest();
$managementTest->runAllTests();
