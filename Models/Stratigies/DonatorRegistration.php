<?php

require_once __DIR__ . '/../DonatorModel.php';
require_once __DIR__ . '/RegistrationTemplate.php';

class DonatorRegistration extends RegistrationTemplate
{
    protected function save()
    {
        $donator = new Donator(null, $this->data['name'], $this->data['age'], $this->data['gender'], $this->data['address'], $this->data['phone'], $this->data['nationality'], 'donator', $this->data['email'], $this->data['password'], $this->data["preference"], 321);
        return $donator->save();
    }

    public function validate()
    {
        return [];
    }
}
