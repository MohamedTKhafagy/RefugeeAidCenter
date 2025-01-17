<?php

// 1. Interface that both the RealSubject (UserModel) and Proxy must implement
interface UserData {
    public function displayUserDetails($userId): string;
}
