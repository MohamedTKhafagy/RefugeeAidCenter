<?php

require_once __DIR__ . '/../../Controllers/RegisterService.php';

abstract class RegistrationTemplate {

    protected $data;
    protected $errors = [];

    public function __construct($data) {
        $this->data = $data;
    }


    public function registerUser() {
        $registerService = new RegisterService();
        $this->errors = $registerService->validateUserData($this->data);
        $this->hashPassword();
        $specificErrors = $this->validate();
        
        $this->errors = array_merge($this->errors, $specificErrors);

        if (!empty($this->errors)) {
            return ["id" => -1, "errors" => $this->errors];
        }

        $newUser = $this->save();
        return ["id" => $newUser, "errors" => []];
    }

    protected function hashPassword() {
        $this->data['password'] = password_hash($this->data['password'], PASSWORD_BCRYPT);
    }

    abstract protected function validate();
    abstract protected function save();
}


?>