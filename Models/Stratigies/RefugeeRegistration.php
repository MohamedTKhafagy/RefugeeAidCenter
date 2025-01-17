<?php

require_once __DIR__ . '/../AdultModel.php';
require_once __DIR__ . '/../RefugeeModel.php';
require_once __DIR__ . '/RegistrationTemplate.php';

class RefugeeRegistration extends RegistrationTemplate
{

    protected function save()
    {
        $family = (isset($this->data["family"])) ? $this->data["family"] : [];
        $adultRefugee = new Adult(null, $this->data['name'], $this->data['age'], $this->data['gender'], $this->data['address'], $this->data['phone'], $this->data['nationality'], 0, $this->data['email'], $this->data['password'], $this->data["preference"], null, $this->data['passportNumber'], 1, 1, 1, 1, $this->data['profession'], $this->data['education'], $family);
        return $adultRefugee->save();
    }

    protected function validate()
    {
        $errors = [];

        if (!preg_match("/^[A-Za-z0-9]{5,10}$/", $this->data['passportNumber'])) {
            $errors['passportNumber'] = "Passport Number should be alphanumeric and between 5 to 10 characters.";
        }

        if (!preg_match("/^[a-zA-Z\s]+$/", $this->data['profession'])) {
            $errors['profession'] = "Profession should only contain letters and spaces.";
        }

        if (!preg_match("/^[a-zA-Z0-9\s]+$/", $this->data['education'])) {
            $errors['education'] = "Education should only contain letters, numbers, and spaces.";
        }

        if(isset($this->data["family"])) {
            $this->data["family"] = array_filter($this->data["family"], function($value) {
                return !empty($value);
            });

            if (!array_filter($this->data["family"], 'is_int')) {
                $errors['family'] = "Family members IDs should be valid integers.";
            }
            $errors['family'] = "";
            foreach ($this->data["family"] as $id) {
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
