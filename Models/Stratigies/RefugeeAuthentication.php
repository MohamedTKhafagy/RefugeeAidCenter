<?php

require_once __DIR__ . '/../AdultModel.php';
require_once __DIR__ . '/../RefugeeModel.php';

class RefugeeAuthentication implements iUserAuthentication
{

    public function register($data)
    {
        //$Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $RefugeeID, $PassportNumber, $Advisor, $Shelter, $HealthCare
        $family = (isset($data["family"])) ? $data["family"] : [];
        $adultRefugee = new Adult(null, $data['name'], $data['age'], $data['gender'], $data['address'], $data['phone'], $data['nationality'], 0, $data['email'], $data["preference"], null, $data['passportNumber'], 99, 99, 99, 99, $data['profession'], $data['education'], $family);
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

        if(isset($data["family"])) {
            $data["family"] = array_filter($data["family"], function($value) {
                return !empty($value);
            });

            if (!array_filter($data["family"], 'is_int')) {
                $errors['family'] = "Family members IDs should be valid integers.";
            }
            $errors['family'] = "";
            foreach ($data["family"] as $id) {
                $refugee = Refugee::findById($id);
                if (!$refugee) {
                    $errors['family'] .= "Family member " . $id . " not found.<br>";
                }
            }
            if(empty($errors['family'])) unset($errors['family']);
        }

        return $errors;
    }

}
