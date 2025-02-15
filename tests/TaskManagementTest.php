<?php
require_once __DIR__ . '/../Models/Task.php';
require_once __DIR__ . '/../SingletonDB.php';
require_once __DIR__ . '/../Models/Commands/TaskDetailsCommand.php';
require_once __DIR__ . '/../Models/Commands/TaskCommand.php';

class TaskManagementTest
{
    private $db;
    private $testTaskId;

    public function __construct()
    {
        $this->db = DbConnection::getInstance();
        echo "\nStarting Task Management Tests\n";
        echo "============================\n";
    }

    public function runAllTests()
    {
        $this->testTaskCreation();
        $this->testTaskRetrieval();
        $this->testTaskUpdate();
        $this->testSkillsManagement();
        $this->testTaskStateManagement();
        $this->testTaskDeletion();
        $this->testTaskDetailsCommand();

        echo "\nAll tests completed!\n";
    }

    private function testTaskCreation()
    {
        echo "\nTesting Task Creation...\n";

        // Create a new task
        $task = new Task(
            "Test Task",
            "This is a test task description",
            4.5,
            "pending",
            null,
            null
        );

        $result = $task->save();
        $this->testTaskId = $task->getId();

        assert($result !== false, "Task creation failed");
        assert($task->getId() > 0, "Task ID should be greater than 0");
        assert($task->getName() === "Test Task", "Task name mismatch");
        assert($task->getStatus() === "pending", "Initial status should be pending");

        echo "✓ Task creation test passed\n";
    }

    private function testTaskRetrieval()
    {
        echo "\nTesting Task Retrieval...\n";

        $task = Task::findById($this->testTaskId);

        assert($task !== null, "Task retrieval failed");
        assert($task->getName() === "Test Task", "Retrieved task name mismatch");
        assert($task->getDescription() === "This is a test task description", "Retrieved task description mismatch");
        assert($task->getHoursOfWork() === 4.5, "Retrieved task hours mismatch");

        echo "✓ Task retrieval test passed\n";
    }

    private function testTaskUpdate()
    {
        echo "\nTesting Task Update...\n";

        $task = Task::findById($this->testTaskId);
        $task->setName("Updated Test Task");
        $task->setDescription("Updated description");
        $task->setHoursOfWork(5.5);

        $result = $task->save();

        assert($result !== false, "Task update failed");

        // Verify changes persisted
        $updatedTask = Task::findById($this->testTaskId);
        assert($updatedTask->getName() === "Updated Test Task", "Updated task name mismatch");
        assert($updatedTask->getDescription() === "Updated description", "Updated task description mismatch");
        assert($updatedTask->getHoursOfWork() === 5.5, "Updated task hours mismatch");

        echo "✓ Task update test passed\n";
    }

    private function testSkillsManagement()
    {
        echo "\nTesting Skills Management...\n";

        $task = Task::findById($this->testTaskId);

        // Add test skills with proper category reference
        $this->db->query("INSERT IGNORE INTO SkillCategories (name) VALUES ('Other')");
        $categoryId = $this->db->fetchAll("SELECT id FROM SkillCategories WHERE name = 'Other'")[0]['id'];

        // Add skills with proper category_id
        $this->db->query(
            "INSERT IGNORE INTO Skills (name, category_id, description) VALUES (?, ?, ?)",
            ["PHP", $categoryId, "PHP Programming"]
        );
        $this->db->query(
            "INSERT IGNORE INTO Skills (name, category_id, description) VALUES (?, ?, ?)",
            ["MySQL", $categoryId, "Database Management"]
        );

        $phpSkillId = $this->db->fetchAll("SELECT id FROM Skills WHERE name = ?", ["PHP"])[0]['id'];
        $mysqlSkillId = $this->db->fetchAll("SELECT id FROM Skills WHERE name = ?", ["MySQL"])[0]['id'];

        $task->addSkill($phpSkillId);
        $task->addSkill($mysqlSkillId);

        // Verify skills were added
        $skills = $task->getSkills();
        assert(count($skills) === 2, "Should have 2 skills assigned");
        assert(in_array("PHP", array_column($skills, 'name')), "PHP skill should be assigned");
        assert(in_array("MySQL", array_column($skills, 'name')), "MySQL skill should be assigned");

        echo "✓ Skills management test passed\n";
    }

    private function testTaskStateManagement()
    {
        echo "\nTesting Task State Management...\n";

        $task = Task::findById($this->testTaskId);

        // Test state transitions
        assert($task->getStatus() === "pending", "Initial status should be pending");

        $task->setStatus("in_progress");
        $task->save();

        $updatedTask = Task::findById($this->testTaskId);
        assert($updatedTask->getStatus() === "in_progress", "Status should be in_progress");

        $task->setStatus("completed");
        $task->save();

        $updatedTask = Task::findById($this->testTaskId);
        assert($updatedTask->getStatus() === "completed", "Status should be completed");

        echo "✓ Task state management test passed\n";
    }

    private function testTaskDeletion()
    {
        echo "\nTesting Task Deletion...\n";

        // Soft delete the task
        $this->db->query("UPDATE Tasks SET is_deleted = 1 WHERE id = ?", [$this->testTaskId]);

        // Try to retrieve the deleted task
        $sql = "SELECT * FROM Tasks WHERE id = ? AND is_deleted = 0";
        $result = $this->db->fetchAll($sql, [$this->testTaskId]);

        assert(empty($result), "Deleted task should not be retrievable");

        echo "✓ Task deletion test passed\n";

        // Clean up test data
        $this->cleanup();
    }

    private function testTaskDetailsCommand()
    {
        echo "\nTesting TaskDetailsCommand...\n";

        // First create a task if it doesn't exist
        if (!isset($this->testTaskId) || !Task::findById($this->testTaskId)) {
            $this->testTaskCreation();
        }

        $task = Task::findById($this->testTaskId);
        if (!$task) {
            echo "❌ Task not found for testing TaskDetailsCommand\n";
            return;
        }

        $newDetails = [
            'name' => 'Updated via Command',
            'description' => 'Updated description via command',
            'hoursOfWork' => 6.5,
            'skills' => ['Medical', 'Teaching']
        ];

        try {
            $command = new TaskDetailsCommand($task, $newDetails);

            // Test execute
            $executeResult = $command->execute();
            assert($executeResult === true, "Command execution failed");
            echo "✓ Command execution passed\n";

            // Verify changes
            $updatedTask = Task::findById($this->testTaskId);
            assert($updatedTask->getName() === 'Updated via Command', "Name update failed");
            assert($updatedTask->getHoursOfWork() === 6.5, "Hours update failed");
            echo "✓ Task updates verified\n";

            // Check skills
            $skills = $updatedTask->getSkills();
            $skillNames = array_column($skills, 'name');
            assert(
                in_array('Medical', $skillNames) || in_array('Teaching', $skillNames),
                "Required skills not found"
            );
            echo "✓ Skills update verified\n";

            // Test undo
            $undoResult = $command->undo();
            assert($undoResult === true, "Command undo failed");

            $revertedTask = Task::findById($this->testTaskId);
            assert(
                $revertedTask->getName() === $task->getName(),
                "Undo failed - name not reverted"
            );
            echo "✓ Command undo passed\n";
        } catch (Exception $e) {
            echo "❌ Test failed: " . $e->getMessage() . "\n";
            return;
        }

        echo "✓ TaskDetailsCommand test passed\n";
    }

    private function cleanup()
    {
        echo "\nCleaning up test data...\n";

        // Actually delete the test task and its relationships
        $this->db->query("DELETE FROM Task_Skills WHERE task_id = ?", [$this->testTaskId]);
        $this->db->query("DELETE FROM Tasks WHERE id = ?", [$this->testTaskId]);

        echo "✓ Cleanup completed\n";
    }
}

// Run the tests
$test = new TaskManagementTest();
$test->runAllTests();
