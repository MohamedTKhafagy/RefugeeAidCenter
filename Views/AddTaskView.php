<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .skill-entry {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .form-group label {
            font-weight: 500;
        }

        .btn-toolbar {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Create New Task</h2>
            <a href="/RefugeeAidCenter/tasks" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Task List
            </a>
        </div>

        <form action="/RefugeeAidCenter/tasks/add" method="post" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Task Name:</label>
                        <input type="text" id="name" name="Name" class="form-control" required
                            placeholder="Enter task name">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="Description" class="form-control" rows="4" required
                            placeholder="Enter task description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="hours">Hours of Work:</label>
                        <input type="number" id="hours" name="HoursOfWork" class="form-control" min="0.5" step="0.5" required
                            placeholder="Enter estimated hours">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Required Skills:</label>
                        <div id="skillsContainer">
                            <div class="skill-entry">
                                <div class="row">
                                    <div class="col-md-10">
                                        <label class="small">Skill:</label>
                                        <select name="skills[]" class="form-control" required>
                                            <option value="">Select a skill</option>
                                            <option value="Medical">Medical</option>
                                            <option value="Teaching">Teaching</option>
                                            <option value="Counseling">Counseling</option>
                                            <option value="Translation">Translation</option>
                                            <option value="Logistics">Logistics</option>
                                            <option value="Fundraising">Fundraising</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small">&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-block remove-skill">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" id="addSkill">
                            <i class="fas fa-plus"></i> Add Another Skill
                        </button>
                    </div>
                </div>
            </div>

            <div class="btn-toolbar">
                <button type="submit" class="btn btn-primary mr-2">
                    <i class="fas fa-save"></i> Create Task
                </button>
                <a href="/RefugeeAidCenter/tasks" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
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