<?php

interface iUserAuthentication
{
    public function register($data);
    public function validate($data);
}

?>