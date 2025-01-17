<?php

require_once __DIR__ . '/../RefugeeModel.php';
require_once __DIR__ . '/RegistrationTemplate.php';

class RefugeeRegistration extends RegistrationTemplate
{

    protected function save()
    {
        $Refugee = new Refugee(null, $this->data['name'], $this->data['age'], $this->data['gender'], $this->data['address'], $this->data['phone'], $this->data['nationality'], 0, $this->data['email'], $this->data['password'], $this->data["preference"], $this->data['passportNumber'], $this->data['profession'], $this->data['education']);
        return $Refugee->save();
    }

    public function validate()
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

        return $errors;
    }

}
