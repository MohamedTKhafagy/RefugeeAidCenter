<?php
require_once __DIR__ . '/../Models/RefugeeModel.php';


class RefugeeController
{
    public function saveRefugee($data)
    {
        $refugee = new Refugee(
            $data['Id'],
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            $data['Type'],
            $data['Email'],
            $data['Preference'],
            $data['RefugeeID'],
            $data['PassportNumber'],
            $data['Advisor'],
            $data['Shelter'],
            $data['HealthCare']
        );
        $refugee->save();
    }

    public function findRefugeeById($id)
    {
        return Refugee::findById($id);
    }
}

?>