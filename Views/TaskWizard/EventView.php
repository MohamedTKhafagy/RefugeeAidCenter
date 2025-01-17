<?php
class TaskWizardEventView
{
    private $wizard;
    private $baseUrl;
    private $events;

    public function __construct($wizard, $events)
    {
        $this->wizard = $wizard;
        $this->events = $events;
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
            <title>Create Task - Step 2: Event Assignment</title>
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

                .event-card {
                    transition: all 0.3s ease;
                    cursor: pointer;
                    border: 2px solid transparent;
                }

                .event-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .event-card.selected {
                    border-color: #007bff;
                    background-color: #f8f9fa;
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

                .alert {
                    border-radius: 8px;
                    padding: 1.25rem;
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
                    <div class="wizard-step step-active">
                        <div class="step-number">2</div>
                        <div>Event Assignment</div>
                    </div>
                    <div class="wizard-step">
                        <div class="step-number">3</div>
                        <div>Review</div>
                    </div>
                </div>

                <form action="<?= $this->baseUrl ?>/tasks/wizard/event" method="post" class="mb-4">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-4">Select an Event</h4>

                            <?php if (empty($this->events)): ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-circle"></i> No events are currently available. Please create an event first before creating a task.
                                    <br>
                                    <a href="<?= $this->baseUrl ?>/events/add" class="btn btn-warning mt-2">
                                        <i class="fas fa-plus"></i> Create New Event
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <?php foreach ($this->events as $event): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card event-card <?= $task->getEventId() == $event->getId() ? 'selected' : '' ?>"
                                                onclick="selectEvent(this, <?= $event->getId() ?>)">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= htmlspecialchars($event->getName()) ?></h5>
                                                    <p class="card-text">
                                                        <small class="text-muted">
                                                            <i class="far fa-calendar-alt"></i>
                                                            <?= htmlspecialchars($event->getDate()) ?>
                                                        </small>
                                                    </p>
                                                    <p class="card-text">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <?= htmlspecialchars($event->getLocation()) ?>
                                                        <br>
                                                        <i class="fas fa-users"></i>
                                                        Capacity: <?= htmlspecialchars($event->getCurrentCapacity()) ?>/<?= htmlspecialchars($event->getMaxCapacity()) ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <input type="hidden" name="event_id" id="selectedEvent" value="<?= $task->getEventId() ?>" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= $this->baseUrl ?>/tasks/wizard/details" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Previous Step
                        </a>
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
                function selectEvent(element, eventId) {
                    
                    document.querySelectorAll('.event-card').forEach(card => {
                        card.classList.remove('selected');
                    });

                    
                    element.classList.add('selected');

                    
                    document.getElementById('selectedEvent').value = eventId;
                }
            </script>
        </body>

        </html>
<?php
        return ob_get_clean();
    }
}
?>