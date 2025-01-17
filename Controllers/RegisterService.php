<?php

class RegisterService
{

    public function validateUserData($data, $update = false)
    {
        $errors = [];
        if (empty($data['name']) || !preg_match("/^[a-zA-Z\s]+$/", $data['name']) || strlen($data['name']) < 2) {
            $errors['name'] = "Name is required and should only contain letters and spaces (at least 2 characters).";
        }

        if (!isset($data['age']) || !filter_var($data['age'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 120]])) {
            $errors['age'] = "Age is required and must be a valid number between 1 and 120.";
        }

        if ($data['gender'] !== "0" && $data['gender'] !== "1") {
            $errors['gender'] = "Gender is required and must be 'Male' or 'Female'.";
        }

        if (empty($data['phone']) || !preg_match("/^\d{10}$/", $data['phone'])) {
            $errors['phone'] = "Phone is required and should be a valid 10-digit number.";
        }

        if (empty($data['nationality']) || !preg_match("/^[a-zA-Z\s]+$/", $data['nationality'])) {
            $errors['nationality'] = "Nationality is required and should only contain letters and spaces.";
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email is required and should be a valid email address.";
        }

        if (!$update && (empty($data['password']) || strlen($data['password']) < 8)) {
            $errors['password'] = "Password is required and should be at least 8 characters long.";
        }

        if(!$update && User::getBy('email', $data['email'])) {
            $errors['email'] = "Email is already taken.";
        }
        
        return $errors;
    }
}

?>