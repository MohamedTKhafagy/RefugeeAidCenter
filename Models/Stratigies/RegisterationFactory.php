<?php
class RegisterationFactory
{
    public static function createStrategy(string $type): iUserAuthentication
    {
        if ($type == 'volunteer') {
            return new VolunteerAuthentication();
        } else if ($type == 'donator') {
            return new DonatorAuthentication();
        } else if ($type == 'refugee') {
            return new RefugeeAuthentication();
        } else if ($type == 'child') {
            return new ChildAuthentication();
        } else {
            throw new Exception("Invalid user type.");
        }
    }
}
