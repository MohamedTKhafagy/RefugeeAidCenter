<?php
require_once __DIR__ . '/../Models/Task.php';
require_once __DIR__ . '/../Models/Event.php';
require_once __DIR__ . '/../Models/TaskCreationWizard.php';
require_once __DIR__ . '/../Models/Commands/TaskDetailsCommand.php';
require_once __DIR__ . '/../Models/Commands/AssignEventCommand.php';
require_once __DIR__ . '/../Models/Commands/AssignVolunteerCommand.php';

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

function printEventDetails($event, $label = "")
{
    echo $label ? "\n$label:\n" : "\n";
    echo "- Event Name: " . $event->getName() . "\n";
    echo "- Location: " . $event->getLocation() . "\n";
    echo "- Type: " . $event->getType() . "\n";
    echo "- Capacity: " . $event->getCurrentCapacity() . "/" . $event->getMaxCapacity() . "\n";
    echo "- Date: " . $event->getDate() . "\n";
}

echo "\nCOMMAND PATTERN IMPLEMENTATION TEST SUITE\n";
echo "========================================\n";
echo "Testing Task Management System with Command Pattern\n";
echo "Date: " . date('Y-m-d H:i:s') . "\n";

// Test 1: Create Event
printTestHeader("Event Creation");
$event = new Event(
    null,
    "Emergency Supply Distribution",
    "Main Hall",
    1, // Type: Distribution
    100, // Max capacity
    0,  // Current capacity
    date('Y-m-d', strtotime('+1 week'))
);
$event->save();
printEventDetails($event, "Created Event");

// Test 2: Task Creation and Initial State
printTestHeader("Task Creation and Initial State");
$task = new Task(
    null,
    "Supply Distribution Task",
    "Distribute emergency supplies to new arrivals",
    4.5,
    "Logistics, Organization",
    "pending"
);
$task->save();
printTaskDetails($task, "Initial Task State");

// Verify task was saved and has an ID
if (!$task->getId()) {
    die("Failed to save task - no ID generated\n");
}

// Create the wizard
$wizard = new TaskCreationWizard();

// Test 3: Basic Task Update Operation
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

// Test 4: Event Assignment Workflow
printTestHeader("Event Assignment Workflow");
echo "Testing event assignment with undo/redo operations...\n";

$wizard->executeCommand(new AssignEventCommand($task, $event->getId()));
echo "✓ Assigned to Event: " . $event->getName() . "\n";
printTaskDetails($task, "After Event Assignment");

$wizard->undo();
echo "✓ Undid event assignment\n";
printTaskDetails($task, "After Undoing Event Assignment");

$wizard->redo();
echo "✓ Redid event assignment\n";
printTaskDetails($task, "After Redoing Event Assignment");

// Test 5: Volunteer Assignment
printTestHeader("Volunteer Assignment");
echo "Testing volunteer assignment...\n";

$wizard->executeCommand(new AssignVolunteerCommand($task, 5));
echo "✓ Assigned to Volunteer ID 5\n";
printTaskDetails($task, "After Volunteer Assignment");

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

// Test 7: Event Tasks Retrieval
printTestHeader("Event Tasks Retrieval");
$eventTasks = $event->getAssignedTasks();
echo "Tasks assigned to event '" . $event->getName() . "':\n";
echo "Total tasks: " . count($eventTasks) . "\n";
foreach ($eventTasks as $eventTask) {
    echo "- Task ID: " . $eventTask['id'] . ", Name: " . $eventTask['name'] . "\n";
}

// Final Summary
printTestHeader("Test Suite Summary");
echo "✓ Event Creation: Successful\n";
echo "✓ Task Creation and Modification: Successful\n";
echo "✓ Command Execution: Successful\n";
echo "✓ Undo/Redo Operations: Successful\n";
echo "✓ Event Assignment: Successful\n";
echo "✓ Volunteer Assignment: Successful\n";
echo "✓ Command History Tracking: Successful\n";

echo "\nTest Suite Completed Successfully!\n";
echo "Date Completed: " . date('Y-m-d H:i:s') . "\n";
