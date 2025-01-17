<?php
class TaskWizardReviewView
{
    private $wizard;
    private $baseUrl;
    private $event;

    public function __construct($wizard, $event = null)
    {
        $this->wizard = $wizard;
        $this->event = $event;
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
            <title>Create Task - Step 3: Review</title>
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

                .container {
                    max-width: 1000px;
                    padding: 2rem;
                    background-color: #fff;
                    border-radius: 10px;
                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
                }

                .review-section {
                    background-color: #f8f9fa;
                    padding: 1.5rem;
                    border-radius: 8px;
                    margin-bottom: 2rem;
                }

                .review-section h5 {
                    color: #007bff;
                    margin-bottom: 1.5rem;
                    font-weight: 600;
                }

                .review-section .row {
                    margin-bottom: 1rem;
                }

                .review-section strong {
                    color: #495057;
                }

                .skill-badge {
                    background-color: #e9ecef;
                    padding: 8px 15px;
                    border-radius: 20px;
                    margin: 3px;
                    display: inline-block;
                    font-size: 0.9em;
                    color: #495057;
                    border: 1px solid #ced4da;
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

                hr {
                    margin: 1.5rem 0;
                    border-color: #dee2e6;
                }
            </style>
        </head>

        <body class="bg-light">
            <div class="container mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Create New Task</h2>
                </div>

                <!-- Wizard Progress -->
                <div class="wizard-progress">
                    <div class="wizard-step step-completed">
                        <div class="step-number"><i class="fas fa-check"></i></div>
                        <div>Task Details</div>
                    </div>
                    <div class="wizard-step step-completed">
                        <div class="step-number"><i class="fas fa-check"></i></div>
                        <div>Event Assignment</div>
                    </div>
                    <div class="wizard-step step-active">
                        <div class="step-number">3</div>
                        <div>Review</div>
                    </div>
                </div>

                <form action="<?= $this->baseUrl ?>/tasks/wizard/complete" method="post" class="mb-4">
                    <div class="review-section">
                        <h5><i class="fas fa-tasks"></i> Task Details</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Name:</strong>
                            </div>
                            <div class="col-md-9">
                                <?= htmlspecialchars($task->getName()) ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Description:</strong>
                            </div>
                            <div class="col-md-9">
                                <?= nl2br(htmlspecialchars($task->getDescription())) ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Hours of Work:</strong>
                            </div>
                            <div class="col-md-9">
                                <?= htmlspecialchars($task->getHoursOfWork()) ?> hours
                            </div>
                        </div>
                    </div>

                    <div class="review-section">
                        <h5><i class="fas fa-tools"></i> Required Skills</h5>
                        <div class="row">
                            <div class="col-12">
                                <?php
                                $skills = $task->getSkills();
                                if (empty($skills)) {
                                    echo '<em>No specific skills required</em>';
                                } else {
                                    foreach ($skills as $skill) {
                                        echo '<span class="skill-badge">' . htmlspecialchars($skill['name']) . '</span>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php if ($this->event): ?>
                        <div class="review-section">
                            <h5><i class="far fa-calendar-alt"></i> Associated Event</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Event Name:</strong>
                                </div>
                                <div class="col-md-9">
                                    <?= htmlspecialchars($this->event->getName()) ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Date:</strong>
                                </div>
                                <div class="col-md-9">
                                    <?= htmlspecialchars($this->event->getDate()) ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Location:</strong>
                                </div>
                                <div class="col-md-9">
                                    <?= htmlspecialchars($this->event->getLocation()) ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Capacity:</strong>
                                </div>
                                <div class="col-md-9">
                                    <?= htmlspecialchars($this->event->getCurrentCapacity()) ?>/<?= htmlspecialchars($this->event->getMaxCapacity()) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= $this->baseUrl ?>/tasks/wizard/event" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Previous Step
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Create Task
                        </button>
                    </div>
                </form>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>

        </html>
<?php
        return ob_get_clean();
    }
}
?>