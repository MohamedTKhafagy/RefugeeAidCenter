<?php
class TaskWizardDetailsView
{
    private $wizard;
    private $baseUrl;

    public function __construct($wizard)
    {
        $this->wizard = $wizard;
        $this->baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    }

    public function render()
    {
        $task = $this->wizard->getTask();
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Create Task - Step 1: Details</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
            <style>
                .wizard-progress {
                    margin: 20px 0 40px 0;
                    display: flex;
                    justify-content: space-between;
                    position: relative;
                    max-width: 800px;
                    margin-left: auto;
                    margin-right: auto;
                }

                .wizard-step {
                    position: relative;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    flex: 1;
                    text-align: center;
                }

                .wizard-step::after {
                    content: '';
                    position: absolute;
                    top: 20px;
                    left: 50%;
                    width: 100%;
                    height: 3px;
                    background-color: #e9ecef;
                    z-index: 1;
                }

                .wizard-step:last-child::after {
                    display: none;
                }

                .step-number {
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    background-color: #e9ecef;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    margin-bottom: 10px;
                    position: relative;
                    z-index: 2;
                    font-weight: bold;
                    transition: all 0.3s ease;
                    border: 2px solid #dee2e6;
                }

                .step-active .step-number {
                    background-color: #fff;
                    border-color: #007bff;
                    color: #007bff;
                    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
                }

                .step-completed .step-number {
                    background-color: #007bff;
                    border-color: #007bff;
                    color: white;
                }

                .step-completed::after {
                    background-color: #007bff;
                }

                .wizard-step div:last-child {
                    color: #6c757d;
                    font-weight: 500;
                    margin-top: 4px;
                }

                .step-active div:last-child {
                    color: #007bff;
                    font-weight: bold;
                }

                .step-completed div:last-child {
                    color: #28a745;
                }

                .skill-entry {
                    background-color: #f8f9fa;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 15px;
                    border: 1px solid #e9ecef;
                    transition: all 0.3s ease;
                    position: relative;
                }

                .skill-entry:hover {
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    border-color: #ced4da;
                }

                .skill-entry .form-row {
                    align-items: center;
                }

                .skill-entry select {
                    background-color: white;
                    border: 1px solid #ced4da;
                    height: calc(1.5em + 1rem + 2px);
                    padding: .5rem 1rem;
                    font-size: 1rem;
                    border-radius: 6px;
                    transition: all 0.2s ease;
                }

                .skill-entry select:focus {
                    border-color: #80bdff;
                    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
                }

                .remove-skill {
                    width: 38px;
                    height: 38px;
                    padding: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 50%;
                    transition: all 0.2s ease;
                    background-color: #dc3545;
                    border-color: #dc3545;
                    position: absolute;
                    right: -10px;
                    top: -10px;
                }

                .remove-skill:hover {
                    background-color: #c82333;
                    border-color: #bd2130;
                    transform: scale(1.1);
                }

                .remove-skill i {
                    font-size: 0.9rem;
                }

                #addSkill {
                    padding: 0.7rem 1.2rem;
                    font-size: 0.95rem;
                    background-color: #28a745;
                    border-color: #28a745;
                    margin-top: 1rem;
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                }

                #addSkill:hover {
                    background-color: #218838;
                    border-color: #1e7e34;
                    transform: translateY(-1px);
                }

                #addSkill i {
                    font-size: 0.9rem;
                }

                .skills-container {
                    position: relative;
                    padding: 1rem;
                    background-color: white;
                    border-radius: 10px;
                    border: 1px solid #e9ecef;
                }

                .form-group label {
                    font-weight: 500;
                    color: #495057;
                    margin-bottom: 0.5rem;
                }

                .form-control {
                    border: 1px solid #ced4da;
                    border-radius: 6px;
                    padding: 0.75rem 1rem;
                    transition: all 0.2s ease;
                }

                .form-control:focus {
                    border-color: #80bdff;
                    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
                }

                .btn {
                    padding: 0.5rem 1.5rem;
                    font-weight: 500;
                    border-radius: 6px;
                    transition: all 0.2s ease;
                }

                .btn-primary {
                    background-color: #007bff;
                    border-color: #007bff;
                }

                .btn-primary:hover {
                    background-color: #0069d9;
                    border-color: #0062cc;
                    transform: translateY(-1px);
                }

                .btn-secondary {
                    background-color: #6c757d;
                    border-color: #6c757d;
                }

                .btn-secondary:hover {
                    background-color: #5a6268;
                    border-color: #545b62;
                }

                .container {
                    max-width: 1000px;
                    padding: 2rem;
                    background-color: #fff;
                    border-radius: 10px;
                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
                }

                .remove-skill {
                    padding: 0.75rem;
                }

                #addSkill {
                    padding: 0.5rem 1rem;
                    font-size: 0.9rem;
                }

                .form-row {
                    margin-bottom: 1rem;
                }
            </style>
        </head>

        <body class="bg-light">
            <div class="container mt-5">
                <!-- Cancel form completely separate from task form -->
                <form action="<?= $this->baseUrl ?>/tasks/wizard/cancel" method="post" id="cancelForm">
                </form>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Create New Task</h2>
                    <button type="submit" form="cancelForm" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>

                <!-- Wizard Progress -->
                <div class="wizard-progress">
                    <div class="wizard-step step-active">
                        <div class="step-number">1</div>
                        <div>Task Details</div>
                    </div>
                    <div class="wizard-step">
                        <div class="step-number">2</div>
                        <div>Event Assignment</div>
                    </div>
                    <div class="wizard-step">
                        <div class="step-number">3</div>
                        <div>Review</div>
                    </div>
                </div>

                <form action="<?= $this->baseUrl ?>/tasks/wizard/details" method="post" class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Task Name:</label>
                                <input type="text" id="name" name="Name" class="form-control" required
                                    value="<?= htmlspecialchars($task->getName() ?? '') ?>"
                                    placeholder="Enter task name">
                            </div>

                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea id="description" name="Description" class="form-control" rows="4" required
                                    placeholder="Enter task description"><?= htmlspecialchars($task->getDescription() ?? '') ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="hours">Hours of Work:</label>
                                <input type="number" id="hours" name="HoursOfWork" class="form-control" min="0.5" step="0.5" required
                                    value="<?= htmlspecialchars($task->getHoursOfWork() ?? 0) ?>"
                                    placeholder="Enter estimated hours">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Required Skills:</label>
                                <div class="skills-container">
                                    <div id="skillsContainer">
                                        <?php
                                        $skills = $task->getSkills();
                                        if (empty($skills)) {
                                            // Add one empty skill entry by default
                                        ?>
                                            <div class="skill-entry">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <select name="skills[]" class="form-control" required>
                                                            <option value="">Select a skill...</option>
                                                            <option value="Medical">Medical</option>
                                                            <option value="Teaching">Teaching</option>
                                                            <option value="Counseling">Counseling</option>
                                                            <option value="Translation">Translation</option>
                                                            <option value="Logistics">Logistics</option>
                                                            <option value="Fundraising">Fundraising</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-danger remove-skill">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <?php
                                        } else {
                                            foreach ($skills as $skill) {
                                            ?>
                                                <div class="skill-entry">
                                                    <div class="form-row">
                                                        <div class="col">
                                                            <select name="skills[]" class="form-control" required>
                                                                <option value="">Select a skill...</option>
                                                                <option value="Medical" <?= $skill['name'] === 'Medical' ? 'selected' : '' ?>>Medical</option>
                                                                <option value="Teaching" <?= $skill['name'] === 'Teaching' ? 'selected' : '' ?>>Teaching</option>
                                                                <option value="Counseling" <?= $skill['name'] === 'Counseling' ? 'selected' : '' ?>>Counseling</option>
                                                                <option value="Translation" <?= $skill['name'] === 'Translation' ? 'selected' : '' ?>>Translation</option>
                                                                <option value="Logistics" <?= $skill['name'] === 'Logistics' ? 'selected' : '' ?>>Logistics</option>
                                                                <option value="Fundraising" <?= $skill['name'] === 'Fundraising' ? 'selected' : '' ?>>Fundraising</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-danger remove-skill">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <button type="button" class="btn btn-success" id="addSkill">
                                        <i class="fas fa-plus"></i>
                                        Add Another Skill
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            Next Step <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>
                document.getElementById('addSkill').addEventListener('click', function() {
                    const container = document.getElementById('skillsContainer');
                    const skillEntries = container.querySelectorAll('.skill-entry');
                    const newSkill = skillEntries[0].cloneNode(true);

                    // Clear selections in the new element
                    newSkill.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

                    // Add remove button functionality
                    newSkill.querySelector('.remove-skill').addEventListener('click', function() {
                        this.closest('.skill-entry').remove();
                    });

                    container.appendChild(newSkill);
                });

                // Add remove functionality to all existing skill entries
                document.querySelectorAll('.remove-skill').forEach(button => {
                    button.addEventListener('click', function() {
                        if (document.querySelectorAll('.skill-entry').length > 1) {
                            this.closest('.skill-entry').remove();
                        }
                    });
                });
            </script>
        </body>

        </html>
<?php
        return ob_get_clean();
    }
}
?>