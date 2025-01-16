<?php
require_once __DIR__ . '/../Models/SocialWorkerModel.php';


class SocialWorkerController
{

    public function index()
    {
        $socialWorkers = SocialWorker::all();
        require 'Views/SocialWorkersView.php';
    }

    public function add($data = null)
    {
        
        if ($data) {
            //validation
            $this->saveSocialWorker($data);
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/socialWorkers');
        } else {
            require 'Views/AddSocialWorkerView.php';
        }
    }

    public function saveSocialWorker($data)
    {
        $SocialWorker = new SocialWorker(
            null,
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            3,
            $data['Email'],
            $data['Preference'],
            $data["Availability"],
            $data["Shelter"]
        );
        $SocialWorker->save();
    }

    public function editSocialWorker($data){
        $SocialWorker = new SocialWorker(
            $data['Id'],
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            3,
            $data['Email'],
            $data['Preference'],
            $data["Availability"],
            $data["Shelter"]
        );
        SocialWorker::editById($data['Id'], $SocialWorker);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/socialWorkers');
    }

    public function edit($id){
            $socialWorker = SocialWorker::findById($id);
            require 'Views/EditSocialWorkerView.php';
    }
    public function delete($id){
        SocialWorker::deleteById($id);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/socialWorkers');
    }

    public function findSocialWorkerById($id)
    {
        $socialWorker = SocialWorker::findById($id);
        require 'Views/SocialWorkerView.php';
    }
}
