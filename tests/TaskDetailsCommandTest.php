<?php
require_once __DIR__ . '/../Models/Commands/TaskDetailsCommand.php';
require_once __DIR__ . '/../Models/Task.php';

class TaskDetailsCommandTest
{
    private $task;
    private $db;

    public function __construct()
    {
        $this->db = DbConnection::getInstance();
        echo "\nStarting TaskDetailsCommand Tests\n";
        echo "================================\n";
    }

    public function runAllTests()
    {
        $this->testTaskDetailsUpdate();
        $this->testUndoOperation();
        echo "\nAll TaskDetailsCommand tests completed!\n";
    }

    private function testTaskDetailsUpdate()
    {
        try {
            echo "\nTesting Task Details Update...\n";

            // Create a test task
            $this->task = new Task(
                "Test Task",
                "Original description",
                2.5,
                "pending"
            );

            if (!$this->task->save()) {
                throw new Exception("Failed to save test task");
            }
            echo "Created test task with ID: " . $this->task->getId() . "\n";

            // Prepare new details
            $newDetails = [
                'name' => 'Updated Task',
                'description' => 'Updated description',
                'hoursOfWork' => 3.5,
                'skillsRequired' => 'PHP,MySQL'
            ];
            echo "Prepared new details\n";

            // Execute command
            $command = new TaskDetailsCommand($this->task, $newDetails);
            $result = $command->execute();
            echo "Command execution result: " . ($result ? "success" : "failed") . "\n";

            // Verify changes
            assert($result === true, "Command execution failed");

            $updatedTask = Task::findById($this->task->getId());
            assert($updatedTask->getName() === 'Updated Task', "Name update failed");
            assert($updatedTask->getDescription() === 'Updated description', "Description update failed");
            assert($updatedTask->getHoursOfWork() === 3.5, "Hours update failed");

            echo "✓ Task details update test passed\n";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "\n";
            echo "File: " . $e->getFile() . "\n";
            echo "Line: " . $e->getLine() . "\n";
        }
    }

    private function testUndoOperation()
    {
        echo "\nTesting Undo Operation...\n";

        $newDetails = [
            'name' => 'Changed Task',
            'description' => 'Changed description',
            'hoursOfWork' => 4.0,
            'skillsRequired' => 'JavaScript'
        ];

        // Execute command
        $command = new TaskDetailsCommand($this->task, $newDetails);
        $command->execute();

        // Test undo
        $result = $command->undo();
        assert($result === true, "Undo operation failed");

        // Verify original values are restored
        $task = Task::findById($this->task->getId());
        assert($task->getName() === 'Updated Task', "Undo name failed");
        assert($task->getDescription() === 'Updated description', "Undo description failed");
        assert($task->getHoursOfWork() === 3.5, "Undo hours failed");

        echo "✓ Undo operation test passed\n";

        // Cleanup
        $this->cleanup();
    }

    private function cleanup()
    {
        echo "\nCleaning up test data...\n";
        if ($this->task && $this->task->getId()) {
            $this->db->query("DELETE FROM Task_Skills WHERE task_id = ?", [$this->task->getId()]);
            $this->db->query("DELETE FROM Tasks WHERE id = ?", [$this->task->getId()]);
        }
        echo "✓ Cleanup completed\n";
    }
}

// Run the tests
$test = new TaskDetailsCommandTest();
$test->runAllTests();
