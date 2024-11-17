<?php 

require_once __DIR__ . '/../DonatorModel.php';

class DonatorAuthentication implements iUserAuthentication
{
    //name age gender address phone nationality email
    //$Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $DonatorID
    public function register($data)
    {
        $donator = new Donator(123, $data['name'], $data['age'], $data['gender'], $data['address'], $data['phone'], $data['nationality'], 'donator', $data['email'], $data["preference"], 321);
        $donator->save();
    }

    public function validate($data)
    {
       return [];
    }

}

?>