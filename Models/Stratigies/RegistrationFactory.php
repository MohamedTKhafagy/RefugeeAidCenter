<?php

require_once __DIR__ . '/../Stratigies/DonatorRegistration.php';
require_once __DIR__ . '/../Stratigies/VolunteerRegistration.php';
require_once __DIR__ . '/../Stratigies/RefugeeRegistration.php';

class RegistrationFactory
{
    public static function createStrategy(string $type, $data)
    {
        if ($type == 'volunteer') {
            return new VolunteerRegistration($data);
        } else if ($type == 'donator') {
            return new DonatorRegistration($data);
        } else if ($type == 'refugee') {
            return new RefugeeRegistration($data);
        } else {
            throw new Exception("Invalid user type.");
        }
    }
}
