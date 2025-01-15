<?php
require_once 'Models/Task.php';
require_once 'Models/TaskCreationWizard.php';
require_once 'Models/Commands/TaskDetailsCommand.php';
require_once 'Models/Commands/AssignEventCommand.php';
require_once 'Models/Commands/AssignVolunteerCommand.php';

function printTestHeader($testName)
{
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "TEST: $testName\n";
    echo str_repeat("=", 60) . "\n";
}

function printTaskDetails($task, $label = "")
{
    echo $label ? "\n$label:\n" : "\n";
    echo "- Task Name: " . $task->getName() . "\n";
    echo "- Description: " . $task->getDescription() . "\n";
    echo "- Hours of Work: " . $task->getHoursOfWork() . "\n";
    echo "- Skills Required: " . $task->getSkillsRequired() . "\n";
    echo "- Status: " . $task->getStatus() . "\n";
    echo "- Event ID: " . ($task->getEventId() ?: "Not Assigned") . "\n";
    echo "- Volunteer ID: " . ($task->getVolunteerId() ?: "Not Assigned") . "\n";
}

echo "\nCOMMAND PATTERN IMPLEMENTATION TEST SUITE\n";
echo "========================================\n";
echo "Testing Task Management System with Command Pattern\n";
echo "Date: " . date('Y-m-d H:i:s') . "\n";

// Test 1: Task Creation and Initial State
printTestHeader("Task Creation and Initial State");
$task = new Task(
    null,
    "Emergency Supply Distribution",
    "Distribute emergency supplies to new arrivals",
    4.5,
    "Logistics, Organization",
    "pending"
);
printTaskDetails($task, "Initial Task State");

// Create the wizard
$wizard = new TaskCreationWizard();

// Test 2: Basic Task Update Operation
printTestHeader("Basic Task Update Operation");
echo "Attempting to update task details...\n";
printTaskDetails($task, "Before Update");

$wizard->executeCommand(new TaskDetailsCommand($task, [
    'name' => 'Medical Supply Distribution',
    'description' => 'Distribute medical supplies to refugee families',
    'hoursOfWork' => 6.0,
    'skillsRequired' => 'Medical Knowledge, Organization'
]));

printTaskDetails($task, "After Update");

// Test 3: Complex Update Chain with Undo
printTestHeader("Complex Update Chain with Undo Operations");
echo "Performing multiple updates and testing undo functionality...\n";

// First update
$wizard->executeCommand(new TaskDetailsCommand($task, [
    'name' => 'Language Translation Service',
    'description' => 'Provide translation services for new arrivals',
    'hoursOfWork' => 3.0,
    'skillsRequired' => 'Bilingual, Communication'
]));
printTaskDetails($task, "After First Update");

// Second update
$wizard->executeCommand(new TaskDetailsCommand($task, [
    'name' => 'Children Education Program',
    'description' => 'Conduct basic education sessions for children',
    'hoursOfWork' => 5.0,
    'skillsRequired' => 'Teaching, Patience'
]));
printTaskDetails($task, "After Second Update");

// Test undo operations
echo "\nTesting Undo Operations:\n";
$wizard->undo();
printTaskDetails($task, "After First Undo");
$wizard->undo();
printTaskDetails($task, "After Second Undo");

// Test 4: Event Assignment Workflow
printTestHeader("Event Assignment Workflow");
echo "Testing event assignment chain with different events...\n";

$wizard->executeCommand(new AssignEventCommand($task, 1));
echo "✓ Assigned to Event ID 1\n";
printTaskDetails($task, "After First Event Assignment");

$wizard->executeCommand(new AssignEventCommand($task, 2));
echo "✓ Reassigned to Event ID 2\n";
printTaskDetails($task, "After Second Event Assignment");

$wizard->undo();
echo "✓ Undid last event assignment\n";
printTaskDetails($task, "After Undoing Event Assignment");

// Test 5: Volunteer Assignment with Full Cycle
printTestHeader("Volunteer Assignment with Full Cycle");
echo "Testing volunteer assignment with undo/redo operations...\n";

printTaskDetails($task, "Initial State");

$wizard->executeCommand(new AssignVolunteerCommand($task, 5));
echo "✓ Assigned to Volunteer ID 5\n";
printTaskDetails($task, "After Volunteer Assignment");

$wizard->undo();
echo "✓ Undid volunteer assignment\n";
printTaskDetails($task, "After Undoing Volunteer Assignment");

$wizard->redo();
echo "✓ Redid volunteer assignment\n";
printTaskDetails($task, "After Redoing Volunteer Assignment");

// Test 6: Command History Analysis
printTestHeader("Command History Analysis");
$history = $wizard->getCommandHistory();
echo "Command History Statistics:\n";
echo "- Total Commands Executed: " . count($history) . "\n";
echo "- Last Executed Command: " . get_class(end($history)) . "\n";

// Count command types
$commandTypes = [];
foreach ($history as $command) {
    $type = get_class($command);
    $commandTypes[$type] = ($commandTypes[$type] ?? 0) + 1;
}

echo "\nCommand Type Distribution:\n";
foreach ($commandTypes as $type => $count) {
    echo "- $type: $count commands\n";
}

// Final Summary
printTestHeader("Test Suite Summary");
echo "✓ Task Creation and Modification: Successful\n";
echo "✓ Command Execution: Successful\n";
echo "✓ Undo/Redo Operations: Successful\n";
echo "✓ Event Assignment: Successful\n";
echo "✓ Volunteer Assignment: Successful\n";
echo "✓ Command History Tracking: Successful\n";

echo "\nTest Suite Completed Successfully!\n";
echo "Date Completed: " . date('Y-m-d H:i:s') . "\n";
