<?php
require_once __DIR__ . '/TaskCommand.php';
require_once __DIR__ . '/../../Models/Task.php';

class TaskDetailsCommand implements TaskCommand
{
    private $task;
    private $oldDetails;
    private $newDetails;
    private $db;

    public function __construct(Task $task, array $newDetails)
    {
        $this->task = $task;
        $this->db = DbConnection::getInstance();
        $this->oldDetails = [
            'name' => $task->getName(),
            'description' => $task->getDescription(),
            'hoursOfWork' => $task->getHoursOfWork(),
            'skills' => $task->getSkills()
        ];
        $this->newDetails = $newDetails;
    }

    public function execute()
    {
        try {
            $this->task->setName($this->newDetails['name']);
            $this->task->setDescription($this->newDetails['description']);
            $this->task->setHoursOfWork($this->newDetails['hoursOfWork']);

            if ($this->task->save()) {
                return $this->updateSkills();
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    private function updateSkills()
    {
        try {
            // Remove existing skills
            $this->db->query("DELETE FROM Task_Skills WHERE task_id = ?", [$this->task->getId()]);

            // Add new skills
            if (!empty($this->newDetails['skills'])) {
                foreach ($this->newDetails['skills'] as $skillName) {
                    if (empty($skillName)) continue;

                    error_log("Processing skill: " . $skillName);

                    // Get or create skill
                    $sql = "SELECT id FROM Skills WHERE name = ?";
                    $existingSkill = $this->db->fetchAll($sql, [$skillName]);

                    if (empty($existingSkill)) {
                        error_log("Skill not found, attempting to create new skill");

                        // Get the category ID for this skill
                        $categoryCheck = $this->db->fetchAll("SELECT id FROM SkillCategories WHERE name = ?", [$skillName]);
                        error_log("Category check result: " . print_r($categoryCheck, true));

                        if (!empty($categoryCheck)) {
                            // Create new skill with the found category ID
                            $sql = "INSERT INTO Skills (name, category_id, description) VALUES (?, ?, ?)";
                            $result = $this->db->query($sql, [
                                $skillName,
                                $categoryCheck[0]['id'],
                                'Skill for ' . $skillName
                            ]);
                            error_log("Skill creation result: " . ($result ? "success" : "failed"));

                            if ($result) {
                                $newSkill = $this->db->fetchAll("SELECT id FROM Skills WHERE name = ?", [$skillName]);
                                if (!empty($newSkill)) {
                                    error_log("New skill created with ID: " . $newSkill[0]['id']);
                                    $this->task->addSkill($newSkill[0]['id']);
                                } else {
                                    error_log("Failed to retrieve new skill ID");
                                }
                            }
                        } else {
                            error_log("Category not found for skill: " . $skillName);
                        }
                    } else {
                        error_log("Using existing skill with ID: " . $existingSkill[0]['id']);
                        $this->task->addSkill($existingSkill[0]['id']);
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            error_log("Error in updateSkills: " . $e->getMessage());
            return false;
        }
    }

    public function undo()
    {
        try {
            $this->task->setName($this->oldDetails['name']);
            $this->task->setDescription($this->oldDetails['description']);
            $this->task->setHoursOfWork($this->oldDetails['hoursOfWork']);

            if ($this->task->save()) {
                // Restore old skills
                $this->db->query("DELETE FROM Task_Skills WHERE task_id = ?", [$this->task->getId()]);
                foreach ($this->oldDetails['skills'] as $skill) {
                    $this->task->addSkill($skill['id']);
                }
                return true;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
