<?php

require_once __DIR__ . '/../ChildModel.php';

class ChildAuthentication implements iUserAuthentication
{

    public function register($data)
    {
        //$Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $RefugeeID, $PassportNumber, $Advisor, $Shelter, $HealthCare, $ChildID, $School, $Level, $Guardian
        $childRefugee = new Child(null, $data['name'], $data['age'], $data['gender'], $data['address'], $data['phone'], $data['nationality'], 0, $data['email'], $data["preference"], null, $data['passportNumber'], 99, 99, 99, 99, 99, 99, 99);
        $childRefugee->save();
    }

    public function validate($data)
    {
        $errors = [];

        if (!preg_match("/^[A-Za-z0-9]{5,10}$/", $data['passportNumber'])) {
            $errors['passportNumber'] = "Passport Number should be alphanumeric and between 5 to 10 characters.";
        }

        return $errors;
    }

    public function update($user, $data) {
        $user->update($data);
    }

}
