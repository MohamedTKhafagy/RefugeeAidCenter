<?php
require_once __DIR__ . '/../Models/DonationModel.php';
require_once __DIR__ . '/../Models/DonatorModel.php';


class DonationController
{

    public function index()
    {
        $donations = Donation::all();
        require 'Views/DonationsView.php';
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
        if ($data) {
            //validation
            $donation = $this->saveDonation($data);
            $donation->Donate();
            // Get the current URL
            $donation->recordTransaction($data['DonatorId']);
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
            $data['currency'] ?? null
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
        require 'Views/DonationView.php';
    }
}
