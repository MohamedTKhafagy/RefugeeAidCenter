<?php
require_once 'TaskDetailsCommandTest.php';
require_once 'TaskManagementTest.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting All Tests...\n";
echo "===================\n\n";

// Run TaskDetailsCommand tests
$detailsTest = new TaskDetailsCommandTest();
$detailsTest->runAllTests();

// Run TaskManagement tests
$managementTest = new TaskManagementTest();
$managementTest->runAllTests();
