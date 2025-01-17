<?php

// to be implemented by UserModel and Proxy
interface UserData {
    public function displayUserDetails($userId): string;
}
