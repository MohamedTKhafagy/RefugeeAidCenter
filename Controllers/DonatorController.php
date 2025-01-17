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
            require 'Views/AddDonatorView.php';
        }
    }

    public function saveDonator($data)
    {
        $donator = new Donator(
            null,
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            1,
            $data['Email'],
            null,
            $data['Preference']
        );
        $donator->save();
    }

    public function editDonator($data){
        $donator = new Donator(
            $data['Id'],
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            1,
            $data['Email'],
            null,
            $data['Preference']
        );
        Donator::editById($data['Id'], $donator);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/donators');
    }

    public function edit($id){
            $donator = Donator::findById($id);
            require 'Views/EditDonatorView.php';
    }
    public function delete($id){
        Donator::deleteById($id);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/donators');
    }

    public function findDonatorById($id)
    {
        $donator = Donator::findById($id);
        require 'Views/DonatorView.php';
    }
}
