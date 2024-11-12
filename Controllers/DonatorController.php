<?php
require_once __DIR__ . '/../Models/DonatorModel.php';


class DonatorController
{

    public function index()
    {
        $donators = Donator::all();
        require 'Views/DonatorsView.php';
    }

    public function add($data = null)
    {
        
        if ($data) {
            //validation
            $this->saveDonator($data);
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/donators');
        } else {
            $id = Donator::getLatestId()+1;
            require 'Views/AddDonatorView.php';
        }
    }

    public function saveDonator($data)
    {
        $donator = new Donator(
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
        );
        $donator->save();
    }

    public function findDonatorById($id)
    {
        $donator = Donator::findById($id);
        require 'Views/DonatorView.php';
    }
}
