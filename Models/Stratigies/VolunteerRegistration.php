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
        return 0;
    }

    public function validate()
    {
        $errors = [];

        $validDays = ["Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

        if (!isset($this->data['Availability']) || !is_array($this->data['Availability']) || empty($this->data['Availability'])) {
            $errors['availability'] = "Please select at least one day of availability.";
        } else {
            foreach ($this->data['Availability'] as $day) {
                if (!in_array($day, $validDays)) {
                    $errors['Availability'] = "Invalid day selected in availability.";
                    break;
                }
            }
        }

        return $errors;
    }

    public function convertAvailability($availability)
    {
        $availabilityBits = 0;
        $dayMap = [
            'Sunday' => 0,
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6
        ];
        foreach ($availability as $day) {
            if (isset($dayMap[$day])) {
                $availabilityBits |= (1 << $dayMap[$day]);
            }
        }
        return $availabilityBits;
    }
}


?>