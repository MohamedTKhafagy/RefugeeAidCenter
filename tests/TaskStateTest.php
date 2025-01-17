<?php
require_once __DIR__ . '/../Models/Task.php';
require_once __DIR__ . '/../Models/TaskCreationWizard.php';
require_once __DIR__ . '/../Models/States/TaskStates.php';
require_once __DIR__ . '/../Models/States/PendingState.php';
require_once __DIR__ . '/../Models/States/InProgressState.php';
require_once __DIR__ . '/../Models/States/CompletedState.php';
require_once __DIR__ . '/../Models/States/TaskWizardStates.php';
require_once __DIR__ . '/../Models/States/TaskDetailsState.php';
require_once __DIR__ . '/../Models/States/AssignEventState.php';
require_once __DIR__ . '/../Models/States/AssignVolunteerState.php';

// Mock Task class to avoid database operations
class MockTask extends Task
{
    public function save()
    {
        // Mock implementation that always returns true
        return true;
    }
}

class TaskStateTest
{
    private $task;
    private $wizard;

    public function __construct()
    {
        $this->task = new MockTask(null, "Test Task", "Test Description", 2, "PHP Skills");
        $this->wizard = new TaskCreationWizard();
        // Replace the wizard's task with our mock task
        $this->wizard->setTask(new MockTask(null, '', '', 0, ''));
    }

    public function testTaskStateTransitions()
    {
        echo "\nTesting Task State Transitions:\n";
        echo "--------------------------------\n";

        // Test initial state
        echo "Initial state: " . $this->task->getCurrentState() . "\n";
        assert($this->task->getCurrentState() === 'pending', "Initial state should be 'pending'");

        // Test transition to in_progress
        $this->task->nextState();
        echo "After first transition: " . $this->task->getCurrentState() . "\n";
        assert($this->task->getCurrentState() === 'in_progress', "State should be 'in_progress'");

        // Test transition to completed
        $this->task->nextState();
        echo "After second transition: " . $this->task->getCurrentState() . "\n";
        assert($this->task->getCurrentState() === 'completed', "State should be 'completed'");

        // Test backward transition
        $this->task->previousState();
        echo "After going back: " . $this->task->getCurrentState() . "\n";
        assert($this->task->getCurrentState() === 'in_progress', "State should be back to 'in_progress'");

        echo "Task state transitions test passed!\n";
    }

    public function testWizardStateTransitions()
    {
        echo "\nTesting Wizard State Transitions:\n";
        echo "--------------------------------\n";

        $task = $this->wizard->getTask();

        // Test initial state (TaskDetailsState)
        echo "Initial wizard state...\n";
        assert($task->getName() === '', "Task should start with empty name");

        // Test task details state
        $task->setName("New Task");
        $task->setDescription("Task Description");
        $this->wizard->executeState();
        echo "After setting task details...\n";

        // Verify transition to AssignEventState
        assert($task->getName() === "New Task", "Task name should be set");
        assert($task->getDescription() === "Task Description", "Task description should be set");

        // Test event assignment state
        $task->setEventId(1);
        $this->wizard->executeState();
        echo "After setting event...\n";

        // Verify event assignment
        assert($task->getEventId() === 1, "Event ID should be set");

        // Test volunteer assignment state
        $task->setVolunteerId(1);
        $this->wizard->executeState();
        echo "After setting volunteer...\n";

        // Verify volunteer assignment and final state
        assert($task->getVolunteerId() === 1, "Volunteer ID should be set");
        assert($task->getStatus() === 'pending', "Final task status should be 'pending'");

        echo "Wizard state transitions test passed!\n";
    }

    public function testInvalidTransitions()
    {
        echo "\nTesting Invalid State Transitions:\n";
        echo "--------------------------------\n";

        // Test trying to go back from initial state
        $task = new MockTask(null, "Test Task", "Test Description", 2, "PHP Skills");
        $initialState = $task->getCurrentState();
        $task->previousState();
        assert($task->getCurrentState() === $initialState, "Should not be able to go back from initial state");

        // Test trying to go forward from final state
        $task->nextState(); // to in_progress
        $task->nextState(); // to completed
        $finalState = $task->getCurrentState();
        $task->nextState();
        assert($task->getCurrentState() === $finalState, "Should not be able to go forward from final state");

        echo "Invalid transitions test passed!\n";
    }

    public function runAllTests()
    {
        echo "\nRunning all state pattern tests...\n";
        echo "==================================\n";

        $this->testTaskStateTransitions();
        $this->testWizardStateTransitions();
        $this->testInvalidTransitions();

        echo "\nAll tests completed successfully!\n";
    }
}

// Run the tests
$test = new TaskStateTest();
$test->runAllTests();
