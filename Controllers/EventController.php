<?php
require_once __DIR__ . '/../Event.php';
require_once __DIR__ . '/../Models/Task.php';
require_once __DIR__ . '/../Views/Event/EventListView.php';
require_once __DIR__ . '/../Views/Event/EventFormView.php';
require_once __DIR__ . '/../Views/Event/EventDetailsView.php';

class EventController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function checkAdminAccess()
    {
        if (
            !isset($_SESSION['user']) ||
            !isset($_SESSION['user']['type']) ||
            $_SESSION['user']['type'] !== 'admin'
        ) {
            $_SESSION['error'] = "Access denied. Admin privileges required.";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/login');
            exit;
        }
    }

    public function index()
    {
        $this->checkAdminAccess();

        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Events WHERE is_deleted = 0 ORDER BY date DESC";
        $results = $db->fetchAll($sql);

        $events = [];
        foreach ($results as $event) {
            $events[] = new Event(
                $event['id'],
                $event['name'],
                $event['location'],
                $event['type'],
                $event['max_capacity'],
                $event['current_capacity'],
                $event['date'],
                [], // volunteers array
                []  // attendees array
            );
        }

        require_once __DIR__ . '/../Views/Event/EventListView.php';
        echo renderEventListView($events);
    }

    public function add()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $event = new Event(
                null,
                $_POST['name'],
                $_POST['location'],
                $_POST['type'],
                $_POST['max_capacity'],
                0, // Initial current capacity is 0
                $_POST['date'],
                [], // Initial volunteers array
                []  // Initial attendees array
            );

            try {
                $db = DbConnection::getInstance();
                $sql = "INSERT INTO Events (name, location, type, max_capacity, current_capacity, date) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $db->query($sql, [
                    $event->getName(),
                    $event->getLocation(),
                    $event->getType(),
                    $event->getMaxCapacity(),
                    $event->getCurrentCapacity(),
                    $event->getDate()
                ]);

                $_SESSION['success'] = "Event created successfully";
                header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }

        require_once __DIR__ . '/../Views/Event/EventFormView.php';
        echo renderEventFormView();
    }

    public function edit($id)
    {
        $this->checkAdminAccess();

        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Events WHERE id = ? AND is_deleted = 0";
        $result = $db->fetchAll($sql, [$id]);

        if (empty($result)) {
            $_SESSION['error'] = "Event not found";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events');
            exit;
        }

        $event = new Event(
            $result[0]['id'],
            $result[0]['name'],
            $result[0]['location'],
            $result[0]['type'],
            $result[0]['max_capacity'],
            $result[0]['current_capacity'],
            $result[0]['date'],
            [], // volunteers array
            []  // attendees array
        );

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $sql = "UPDATE Events 
                        SET name = ?, location = ?, type = ?, max_capacity = ?, date = ? 
                        WHERE id = ? AND is_deleted = 0";
                $db->query($sql, [
                    $_POST['name'],
                    $_POST['location'],
                    $_POST['type'],
                    $_POST['max_capacity'],
                    $_POST['date'],
                    $id
                ]);

                $_SESSION['success'] = "Event updated successfully";
                header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }

        require_once __DIR__ . '/../Views/Event/EventFormView.php';
        echo renderEventFormView($event);
    }

    public function delete($id)
    {
        $this->checkAdminAccess();

        $db = DbConnection::getInstance();

        // First check if there are any tasks associated with this event
        $sql = "SELECT COUNT(*) as count FROM Tasks WHERE event_id = ? AND is_deleted = 0";
        $result = $db->fetchAll($sql, [$id]);

        if ($result[0]['count'] > 0) {
            $_SESSION['error'] = "Cannot delete event: There are tasks associated with it";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events');
            exit;
        }

        $sql = "UPDATE Events SET is_deleted = 1 WHERE id = ?";
        $result = $db->query($sql, [$id]);

        if ($result) {
            $_SESSION['success'] = "Event deleted successfully";
        } else {
            $_SESSION['error'] = "Failed to delete event";
        }

        header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events');
        exit;
    }

    public function details($id)
    {
        $this->checkAdminAccess();

        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Events WHERE id = ? AND is_deleted = 0";
        $result = $db->fetchAll($sql, [$id]);

        if (empty($result)) {
            $_SESSION['error'] = "Event not found";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events');
            exit;
        }

        $event = new Event(
            $result[0]['id'],
            $result[0]['name'],
            $result[0]['location'],
            $result[0]['type'],
            $result[0]['max_capacity'],
            $result[0]['current_capacity'],
            $result[0]['date'],
            [], // volunteers array
            []  // attendees array
        );

        // Get associated tasks
        $sql = "SELECT * FROM Tasks WHERE event_id = ? AND is_deleted = 0";
        $taskResults = $db->fetchAll($sql, [$id]);

        $tasks = [];
        foreach ($taskResults as $task) {
            $tasks[] = new Task(
                $task['name'],
                $task['description'],
                $task['hours_of_work'],
                $task['status'],
                $task['event_id'],
                $task['volunteer_id'],
                $task['id']
            );
        }

        require_once __DIR__ . '/../Views/Event/EventDetailsView.php';
        echo renderEventDetailsView($event, $tasks);
    }

    public function registration()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            $_SESSION['error'] = "Please log in to register for events";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/login');
            exit;
        }

        $db = DbConnection::getInstance();

        // Get all upcoming events
        $sql = "SELECT * FROM Events 
                WHERE date >= CURDATE() 
                AND is_deleted = 0 
                ORDER BY date ASC";
        $results = $db->fetchAll($sql);

        $events = [];
        foreach ($results as $event) {
            $events[] = new Event(
                $event['id'],
                $event['name'],
                $event['location'],
                $event['type'],
                $event['max_capacity'],
                $event['current_capacity'],
                $event['date'],
                [], // volunteers array
                []  // attendees array
            );
        }

        // Get user's registered events
        $sql = "SELECT event_id FROM Event_Registrations 
                WHERE user_id = ? AND is_deleted = 0";
        $registrations = $db->fetchAll($sql, [$_SESSION['user']['id']]);
        $registeredEvents = array_column($registrations, 'event_id');

        require_once __DIR__ . '/../Views/Event/EventRegistrationView.php';
        echo renderEventRegistrationView($events, $_SESSION['user']['id'], $registeredEvents);
    }

    public function register()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            $_SESSION['error'] = "Please log in to register for events";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['event_id'])) {
            $_SESSION['error'] = "Invalid request";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events/registration');
            exit;
        }

        $db = DbConnection::getInstance();

        // Check if event exists and has capacity
        $sql = "SELECT * FROM Events 
                WHERE id = ? 
                AND is_deleted = 0 
                AND current_capacity < max_capacity";
        $event = $db->fetchAll($sql, [$_POST['event_id']]);

        if (empty($event)) {
            $_SESSION['error'] = "Event is either full or not available";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events/registration');
            exit;
        }

        // Start transaction
        $db->query("START TRANSACTION");

        try {
            // Check for existing registration (including soft-deleted ones)
            $sql = "SELECT id, is_deleted FROM Event_Registrations 
                    WHERE event_id = ? AND user_id = ?";
            $existing = $db->fetchAll($sql, [$_POST['event_id'], $_SESSION['user']['id']]);

            if (!empty($existing)) {
                if ($existing[0]['is_deleted'] == 0) {
                    // Active registration exists
                    throw new Exception("You are already registered for this event");
                } else {
                    // Reactivate the soft-deleted registration
                    $sql = "UPDATE Event_Registrations 
                            SET is_deleted = 0 
                            WHERE id = ?";
                    $result1 = $db->query($sql, [$existing[0]['id']]);
                }
            } else {
                // Create new registration
                $sql = "INSERT INTO Event_Registrations (event_id, user_id) VALUES (?, ?)";
                $result1 = $db->query($sql, [$_POST['event_id'], $_SESSION['user']['id']]);
            }

            // Update event capacity
            $sql = "UPDATE Events 
                    SET current_capacity = current_capacity + 1 
                    WHERE id = ? 
                    AND current_capacity < max_capacity";
            $result2 = $db->query($sql, [$_POST['event_id']]);

            if ($result1 && $result2) {
                $db->query("COMMIT");
                $_SESSION['success'] = "Successfully registered for the event";
            } else {
                throw new Exception("Failed to register");
            }
        } catch (Exception $e) {
            $db->query("ROLLBACK");
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events/registration');
        exit;
    }

    public function unregister()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            $_SESSION['error'] = "Please log in to manage event registrations";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['event_id'])) {
            $_SESSION['error'] = "Invalid request";
            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events/registration');
            exit;
        }

        $db = DbConnection::getInstance();

        // Start transaction
        $db->query("START TRANSACTION");

        try {
            // Soft delete registration
            $sql = "UPDATE Event_Registrations 
                    SET is_deleted = 1 
                    WHERE event_id = ? AND user_id = ? AND is_deleted = 0";
            $result1 = $db->query($sql, [$_POST['event_id'], $_SESSION['user']['id']]);

            // Update event capacity
            $sql = "UPDATE Events 
                    SET current_capacity = current_capacity - 1 
                    WHERE id = ? AND current_capacity > 0";
            $result2 = $db->query($sql, [$_POST['event_id']]);

            if ($result1 && $result2) {
                $db->query("COMMIT");
                $_SESSION['success'] = "Successfully cancelled event registration";
            } else {
                throw new Exception("Failed to cancel registration");
            }
        } catch (Exception $e) {
            $db->query("ROLLBACK");
            $_SESSION['error'] = "Failed to cancel event registration";
        }

        header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/events/registration');
        exit;
    }
}
