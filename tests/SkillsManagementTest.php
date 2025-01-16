<?php
require_once __DIR__ . '/../Models/Skill.php';
require_once __DIR__ . '/../Models/Task.php';
require_once __DIR__ . '/../Models/VolunteerModel.php';

class SkillsManagementTest
{
    private $db;
    private $testVolunteerEmail = 'test.volunteer@example.com';
    private $testTaskName = 'Test Task';

    public function __construct()
    {
        $this->db = DbConnection::getInstance();
    }

    private function cleanupTestData()
    {
        // Clean up any existing test data
        $this->db->query("DELETE FROM Volunteer_Skills WHERE volunteer_id IN (SELECT Id FROM User WHERE Email = '$this->testVolunteerEmail')");
        $this->db->query("DELETE FROM Task_Skills WHERE task_id IN (SELECT id FROM Tasks WHERE name = '$this->testTaskName')");
        $this->db->query("DELETE FROM Skills WHERE name LIKE 'Test Skill%'");
        $this->db->query("DELETE FROM Tasks WHERE name = '$this->testTaskName'");
        $this->db->query("DELETE FROM Volunteer WHERE VolunteerId IN (SELECT Id FROM User WHERE Email = '$this->testVolunteerEmail')");
        $this->db->query("DELETE FROM User WHERE Email = '$this->testVolunteerEmail'");
    }

    public function runTests()
    {
        try {
            $this->cleanupTestData();

            $this->testSkillCreation();
            $this->cleanupTestData();

            $this->testVolunteerSkills();
            $this->cleanupTestData();

            $this->testTaskSkills();
            $this->cleanupTestData();

            $this->testSkillQueries();
            $this->cleanupTestData();

            echo "All tests passed successfully!\n";
        } catch (Exception $e) {
            echo "Test failed: " . $e->getMessage() . "\n";
        }
    }

    private function testSkillCreation()
    {
        // Test creating a new skill
        $skill1 = new Skill('Test Skill Creation', 'Medical', 'A test medical skill');
        $skill1->save();
        assert($skill1->getId() !== null, "Skill should have an ID after saving");

        // Test finding skill by ID
        $foundSkill = Skill::findById($skill1->getId());
        assert($foundSkill !== null, "Should be able to find skill by ID");
        assert($foundSkill->getName() === 'Test Skill Creation', "Skill name should match");

        // Test finding skill by name
        $foundSkill = Skill::findByName('Test Skill Creation');
        assert($foundSkill !== null, "Should be able to find skill by name");
        assert($foundSkill->getCategory() === 'Medical', "Skill category should match");

        echo "Skill creation tests passed\n";
    }

    private function testVolunteerSkills()
    {
        // Create test volunteer
        $volunteer = new Volunteer(
            null,
            'Test Volunteer',
            25,
            'Male',
            1,
            '1234567890',
            'Test Nationality',
            2,
            $this->testVolunteerEmail,
            0,
            'Monday'
        );
        $volunteer->save();

        // Create test skills
        $skill1 = new Skill('Test Skill Volunteer 1', 'Medical', 'Test skill 1');
        $skill2 = new Skill('Test Skill Volunteer 2', 'Teaching', 'Test skill 2');
        $skill1->save();
        $skill2->save();

        // Test adding skills to volunteer
        $volunteer->addSkill($skill1->getId(), 'Advanced');
        $volunteer->addSkill($skill2->getId(), 'Beginner');

        // Verify skills were added
        $volunteerSkills = $volunteer->getSkills();
        assert(count($volunteerSkills) === 2, "Volunteer should have 2 skills");
        assert($volunteerSkills[0]['proficiency_level'] === 'Advanced', "Skill 1 should have Advanced proficiency");

        // Test removing a skill
        $volunteer->removeSkill($skill1->getId());
        $volunteerSkills = $volunteer->getSkills();
        assert(count($volunteerSkills) === 1, "Volunteer should have 1 skill after removal");

        echo "Volunteer skills tests passed\n";
    }

    private function testTaskSkills()
    {
        // Create test task
        $task = new Task($this->testTaskName, 'Test Description', 2.5);
        $task->save();

        // Create test skill
        $skill = new Skill('Test Skill Task', 'Medical', 'Test skill');
        $skill->save();

        // Test adding skill to task
        $task->addSkill($skill->getId());

        // Verify skill was added
        $taskSkills = $task->getSkills();
        assert(count($taskSkills) === 1, "Task should have 1 skill");
        assert($taskSkills[0]['name'] === 'Test Skill Task', "Task skill name should match");

        // Test removing skill
        $task->removeSkill($skill->getId());
        $taskSkills = $task->getSkills();
        assert(count($taskSkills) === 0, "Task should have no skills after removal");

        echo "Task skills tests passed\n";
    }

    private function testSkillQueries()
    {
        // Create test data
        $skill = new Skill('Test Skill Query', 'Medical', 'Test skill');
        $skill->save();

        $task = new Task($this->testTaskName, 'Test Description', 2.5);
        $task->save();
        $task->addSkill($skill->getId());

        $volunteer = new Volunteer(
            null,
            'Test Volunteer',
            25,
            'Male',
            1,
            '1234567890',
            'Test Nationality',
            2,
            $this->testVolunteerEmail,
            0,
            'Monday'
        );
        $volunteer->save();
        $volunteer->addSkill($skill->getId(), 'Expert');

        // Test finding tasks with skill
        $tasksWithSkill = $skill->getTasksWithSkill();
        assert(count($tasksWithSkill) === 1, "Should find 1 task with the skill");
        assert($tasksWithSkill[0]['name'] === $this->testTaskName, "Task name should match");

        // Test finding volunteers with skill
        $volunteersWithSkill = $skill->getVolunteersWithSkill();
        assert(count($volunteersWithSkill) === 1, "Should find 1 volunteer with the skill");
        assert($volunteersWithSkill[0]['proficiency_level'] === 'Expert', "Volunteer skill proficiency should match");

        echo "Skill queries tests passed\n";
    }
}

// Run the tests
$test = new SkillsManagementTest();
$test->runTests();
