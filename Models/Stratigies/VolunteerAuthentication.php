<?php

require_once __DIR__ . '/iUserAuthentication.php';

class VolunteerAuthentication implements iUserAuthentication
{
    public function register($data)
    {
        // $volunteer = new Volunteer(123, $data['name'], $data['age'], $data
        $availability = $this->convertAvailability($data['availability']);
    }

    public function validate($data)
    {
        $errors = [];

        $validDays = ["Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

        if (!isset($data['availability']) || !is_array($data['availability']) || empty($data['availability'])) {
            $errors['availability'] = "Please select at least one day of availability.";
        } else {
            foreach ($data['availability'] as $day) {
                if (!in_array($day, $validDays)) {
                    $errors['availability'] = "Invalid day selected in availability.";
                    break;
                }
            }
        }

        return $errors;
    }

    function convertAvailability($availability) {
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
