<?php

require_once __DIR__ . '/../AdultModel.php';

class RefugeeAuthentication implements iUserAuthentication
{

    public function register($data)
    {
        $adultRefugee = new Adult(123, $data['name'], $data['age'], $data['gender'], $data['address'], $data['phone'], $data['nationality'], 'refugee', $data['email'], 'preference', 321, $data['passportNumber'], null, null, null, 876, $data['profession'], $data['education'], null);
        $adultRefugee->save();
    }

    public function validate($data)
    {
        $errors = [];

        if (!preg_match("/^[A-Za-z0-9]{5,10}$/", $data['passportNumber'])) {
            $errors['passportNumber'] = "Passport Number should be alphanumeric and between 5 to 10 characters.";
        }

        if (!preg_match("/^[a-zA-Z\s]+$/", $data['profession'])) {
            $errors['profession'] = "Profession should only contain letters and spaces.";
        }

        if (!preg_match("/^[a-zA-Z0-9\s]+$/", $data['education'])) {
            $errors['education'] = "Education should only contain letters, numbers, and spaces.";
        }

        return $errors;
    }

}
