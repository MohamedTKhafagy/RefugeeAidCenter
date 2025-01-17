<?php

require_once __DIR__ . '/RegistrationTemplate.php';


class VolunteerRegistration extends RegistrationTemplate
{
    protected function save()
    {
        $availability = $this->convertAvailability($this->data['availability']);
        $volunteer = new Volunteer(
            null,
            $this->data['name'],
            $this->data['age'],
            $this->data['gender'],
            $this->data['address'],
            $this->data['phone'],
            $this->data['nationality'],
            2,
            $this->data['email'],
            $this->data['password'],
            $this->data['preference'],
            $this->data['skills'],
            $availability
        );

        return $volunteer->save();
    }

    protected function validate()
    {
        $errors = [];

        $validDays = ["Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

        if (!isset($this->data['availability']) || !is_array($this->data['availability']) || empty($this->data['availability'])) {
            $errors['availability'] = "Please select at least one day of availability.";
        } else {
            foreach ($this->data['availability'] as $day) {
                if (!in_array($day, $validDays)) {
                    $errors['availability'] = "Invalid day selected in availability.";
                    break;
                }
            }
        }

        return $errors;
    }

    function convertAvailability($availability)
    {
        // Define the days of the week in order, starting from Saturday (leftmost bit)
        $daysOfWeek = ['Friday', 'Thursday', 'Wednesday', 'Tuesday', 'Monday', 'Sunday', 'Saturday'];
        $daysOfWeek = array_reverse($daysOfWeek);

        $bits = 0;

        foreach ($availability as $day) {
            if (in_array($day, $daysOfWeek)) {
                $bits |= (1 << array_search($day, $daysOfWeek));
            }
        }

        return $bits;
    }
}
