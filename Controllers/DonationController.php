<?php
require_once __DIR__ . '/../Models/DonationModel.php';
require_once __DIR__ . '/../Models/DonatorModel.php';
include __DIR__ . '/../Views/DonationsView.php';
include __DIR__ . '/../Views/DonationView.php';

class DonationController
{

    public function index()
    {
        $donations = Donation::all();
         // Initialize an array to store donators associated with donations
        $donatorsWithDonations = [];

        // Loop through each donation to find the associated donator
        foreach ($donations as $donation) {
            $donatorId = $donation->findDonatorId();
            $donator = Donator::findById($donatorId);
            // Add the donator and their donation to the array
            $donatorsWithDonations[] = [
                'donation' => $donation,
                'donator' => $donator,
            ];
        }
        echo renderDonationManagementView($donatorsWithDonations);
        //require 'Views/DonationsView.php';
    }
    private function extractLastNumber($url)
    {
        // Use a regular expression to match the last number
        if (preg_match('/\d+(?=[^\/]*$)/', $url, $matches)) {
            return (int)$matches[0]; // Convert the match to an integer
        }
        return null; // Return null if no number is found
    }
    public function add($data = null)
    {
        session_start();
        $userid = $_SESSION['user']['id'];
        if ($data) {
            //validation
            $donation = $this->saveDonation($data);
            //$donation->Donate();
            // Get the current URL
            $donation->recordTransaction($userid);
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/donations/view/' . $donation->getID());
        } else {
            require 'Views/MakeDonationView.php';
        }
    }

    public function saveDonation($data)
    {
        $donation = new Donation(
            null,
            $data['Type'] ?? null,
            $data['Amount'] ?? null,
            $data['DirectedTo'] ?? null,
            $data['CollectionFee'] ?? null,
            $data['currency'] ?? null,
            "Pending"
        );
        $donation=$donation->save();
        return $donation;
    }

    public function findDonationById($id)
    {
        $donation = Donation::findById($id);
        $donatorId = $donation->findDonatorId();
        $donator = Donator::findById($donatorId); 
        $Invoice = $donation->GenerateInvoice();
        echo renderDonationView($donation, $donator, $Invoice);
    }

    public function complete($id){
        $donation = Donation::findById($id);
        $donation->NextState();
        $this->index();
    }
    public function fail($id){
        $donation = Donation::findById($id);
        $donation->setFailed(true);
        $donation->NextState();
        $this->index();
    }
    public function undo($id){
        $donation = Donation::findById($id);
        $donation->PrevState();
        $this->index();
    }
}
