<?php

class AdminView {
    public function renderDashboard($users, $events, $tasks, $donations) {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Admin Dashboard</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                .dashboard-view {
                    display: none;
                }
                .dashboard-view.active {
                    display: block;
                }
            </style>
        </head>
        <body>
            <div class="container mt-4">
                <h2>Admin Dashboard</h2>
                
                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link active" onclick="showView('users')">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="showView('events')">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="showView('tasks')">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="showView('donations')">Donations</a>
                    </li>
                </ul>

                <!-- Views -->
                <?php 
                echo $this->renderUsersView($users);
                echo $this->renderEventsView($events);
                echo $this->renderTasksView($tasks);
                echo $this->renderDonationsView($donations);
                ?>
            </div>

            <script>
            function showView(viewName) {
                // Hide all views
                document.querySelectorAll('.dashboard-view').forEach(view => {
                    view.classList.remove('active');
                });
                // Show selected view
                document.getElementById(viewName + 'View').classList.add('active');
                // Update active tab
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });
                event.target.classList.add('active');
            }
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }

    private function renderUsersView($users) {
        ob_start();
        ?>
        <div id="usersView" class="dashboard-view active">
            <h3>User Management</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['Id']) ?></td>
                            <td><?= htmlspecialchars($user['Name']) ?></td>
                            <td><?= htmlspecialchars($user['Email']) ?></td>
                            <td><?= $this->getUserType($user['Type']) ?></td>
                            <td>
                                <a href="admin/editUser/<?= $user['Id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <button onclick="deleteUser(<?= $user['Id'] ?>)" class="btn btn-sm btn-danger">Delete</button>
                                <script>
                                function deleteUser(userId) {
                                    if (confirm('Are you sure you want to delete this user?')) {
                                        window.location.href = '/admin/deleteUser/' + userId;
                                    }
                                }
                                </script>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        return ob_get_clean();
    }

    private function renderEventsView($events) {
        ob_start();
        ?>
        <div id="eventsView" class="dashboard-view">
            <h3>Event Management</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Capacity</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($events as $event): ?>
                        <tr>
                            <td><?= htmlspecialchars($event['id']) ?></td>
                            <td><?= htmlspecialchars($event['name']) ?></td>
                            <td><?= htmlspecialchars($event['location']) ?></td>
                            <td><?= $this->getEventType($event['type']) ?></td>
                            <td><?= $event['current_capacity'] ?>/<?= $event['max_capacity'] ?></td>
                            <td><?= htmlspecialchars($event['date']) ?></td>
                            <td>
                                <a href="/admin/editEvent/<?= $event['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <button onclick="deleteEvent(<?= $event['id'] ?>)" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        return ob_get_clean();
    }

    private function renderTasksView($tasks) {
        ob_start();
        ?>
        <div id="tasksView" class="dashboard-view">
            <h3>Task Management</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Skills Required</th>
                        <th>Hours</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tasks as $task): ?>
                        <tr>
                            <td><?= htmlspecialchars($task['Id']) ?></td>
                            <td><?= htmlspecialchars($task['Name']) ?></td>
                            <td><?= htmlspecialchars($task['Description']) ?></td>
                            <td><?= htmlspecialchars($task['SkillRequired']) ?></td>
                            <td><?= htmlspecialchars($task['HoursOfWork']) ?></td>
                            <td><?= htmlspecialchars($task['VolunteerName'] ?? 'Unassigned') ?></td>
                            <td><?= $task['IsCompleted'] ? 'Completed' : 'In Progress' ?></td>
                            <td>
                                <a href="/admin/editTask/<?= $task['Id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <button onclick="deleteTask(<?= $task['Id'] ?>)" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        return ob_get_clean();
    }

    private function renderDonationsView($donations) {
        ob_start();
        ?>
        <div id="donationsView" class="dashboard-view">
            <h3>Donation Management</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Directed To</th>
                        <th>Collection Status</th>
                        <th>Currency</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($donations as $donation): ?>
                        <tr>
                            <td><?= htmlspecialchars($donation['Id']) ?></td>
                            <td><?= htmlspecialchars($donation['Amount']) ?></td>
                            <td><?= $this->getDonationType($donation['Type']) ?></td>
                            <td><?= htmlspecialchars($donation['DonorName'] ?? 'General') ?></td>
                            <td><?= $this->getCollectionStatus($donation['Collection']) ?></td>
                            <td><?= $this->getCurrencyType($donation['Currency']) ?></td>
                            <td>
                                <a href="/admin/editDonation/<?= $donation['Id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        return ob_get_clean();
    }

    // Edit Views
    public function renderEditUser($user) {
        ob_start();
        ?>
        <div class="container mt-4">
            <h2>Edit User</h2>
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="Name" 
                           value="<?= htmlspecialchars($user['Name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" name="Age" 
                           value="<?= htmlspecialchars($user['Age']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-control" id="gender" name="Gender">
                        <option value="0" <?= $user['Gender'] == 0 ? 'selected' : '' ?>>Male</option>
                        <option value="1" <?= $user['Gender'] == 1 ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="Email" 
                           value="<?= htmlspecialchars($user['Email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="Phone" 
                           value="<?= htmlspecialchars($user['Phone']) ?>">
                </div>
                <div class="mb-3">
                    <label for="nationality" class="form-label">Nationality</label>
                    <input type="text" class="form-control" id="nationality" name="Nationality" 
                           value="<?= htmlspecialchars($user['Nationality']) ?>">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">User Type</label>
                    <select class="form-control" id="type" name="Type">
                        <option value="0" <?= $user['Type'] == 0 ? 'selected' : '' ?>>Refugee</option>
                        <option value="1" <?= $user['Type'] == 1 ? 'selected' : '' ?>>Donator</option>
                        <option value="2" <?= $user['Type'] == 2 ? 'selected' : '' ?>>Volunteer</option>
                        <option value="3" <?= $user['Type'] == 3 ? 'selected' : '' ?>>Social Worker</option>
                        <option value="4" <?= $user['Type'] == 4 ? 'selected' : '' ?>>Doctor</option>
                        <option value="5" <?= $user['Type'] == 5 ? 'selected' : '' ?>>Nurse</option>
                        <option value="6" <?= $user['Type'] == 6 ? 'selected' : '' ?>>Teacher</option>
                        <option value="8" <?= $user['Type'] == 8 ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="preference" class="form-label">Communication Preference</label>
                    <select class="form-control" id="preference" name="Preference">
                        <option value="0" <?= $user['Preference'] == 0 ? 'selected' : '' ?>>Email</option>
                        <option value="1" <?= $user['Preference'] == 1 ? 'selected' : '' ?>>SMS</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="/admin" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    public function renderEditEvent($event) {
        ob_start();
        ?>
        <div class="container mt-4">
            <h2>Edit Event</h2>
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Event Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?= htmlspecialchars($event['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" 
                           value="<?= htmlspecialchars($event['location']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Event Type</label>
                    <select class="form-control" id="type" name="type">
                        <option value="1" <?= $event['type'] == 1 ? 'selected' : '' ?>>Workshop</option>
                        <option value="2" <?= $event['type'] == 2 ? 'selected' : '' ?>>Seminar</option>
                        <option value="3" <?= $event['type'] == 3 ? 'selected' : '' ?>>Training</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="max_capacity" class="form-label">Maximum Capacity</label>
                    <input type="number" class="form-control" id="max_capacity" name="max_capacity" 
                           value="<?= htmlspecialchars($event['max_capacity']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Event Date</label>
                    <input type="date" class="form-control" id="date" name="date" 
                           value="<?= htmlspecialchars($event['date']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Event</button>
                <a href="/admin" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    public function renderEditTask($task, $volunteers) {
        ob_start();
        ?>
        <div class="container mt-4">
            <h2>Edit Task</h2>
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Task Name</label>
                    <input type="text" class="form-control" id="name" name="Name" 
                           value="<?= htmlspecialchars($task['Name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="Description" required>
                        <?= htmlspecialchars($task['Description']) ?>
                    </textarea>
                </div>
                <div class="mb-3">
                    <label for="skillRequired" class="form-label">Required Skills</label>
                    <input type="text" class="form-control" id="skillRequired" name="SkillRequired" 
                           value="<?= htmlspecialchars($task['SkillRequired']) ?>">
                </div>
                <div class="mb-3">
                    <label for="hoursOfWork" class="form-label">Hours of Work</label>
                    <input type="number" class="form-control" id="hoursOfWork" name="HoursOfWork" 
                           value="<?= htmlspecialchars($task['HoursOfWork']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="assignedVolunteer" class="form-label">Assigned Volunteer</label>
                    <select class="form-control" id="assignedVolunteer" name="AssignedVolunteerId">
                        <option value="">Select Volunteer</option>
                        <?php foreach ($volunteers as $volunteer): ?>
                            <option value="<?= $volunteer['Id'] ?>" 
                                <?= $task['AssignedVolunteerId'] == $volunteer['Id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($volunteer['Name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="isCompleted" class="form-label">Status</label>
                    <select class="form-control" id="isCompleted" name="IsCompleted">
                        <option value="0" <?= $task['IsCompleted'] == 0 ? 'selected' : '' ?>>Pending</option>
                        <option value="1" <?= $task['IsCompleted'] == 1 ? 'selected' : '' ?>>Completed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Task</button>
                <a href="/admin" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }


    private function getUserType($type) {
        $types = [
            0 => 'Refugee',
            1 => 'Donator',
            2 => 'Volunteer',
            3 => 'Social Worker',
            4 => 'Doctor',
            5 => 'Nurse',
            6 => 'Teacher',
            8 => 'Admin'
        ];
        return $types[$type] ?? 'Unknown';
    }
     // Helper Methods for Type Conversions
     private function getEventType($type) {
        $types = [
            0 => 'Workshop',
            1 => 'Social Gathering',
            2 => 'Educational',
            3 => 'Health Campaign',
            4 => 'Other'
        ];
        return $types[$type] ?? 'Unknown';
    }

    private function getDonationType($type) {
        $types = [
            0 => 'Money',
            1 => 'Food',
            2 => 'Clothes',
            3 => 'Medicine',
            4 => 'Other'
        ];
        return $types[$type] ?? 'Unknown';
    }

    private function getCollectionStatus($status) {
        $statuses = [
            0 => 'Pending',
            1 => 'Collected',
            2 => 'Cancelled'
        ];
        return $statuses[$status] ?? 'Unknown';
    }

    private function getCurrencyType($type) {
        $types = [
            0 => 'USD',
            1 => 'EUR',
            2 => 'GBP'
        ];
        return $types[$type] ?? 'Unknown';
    }
}