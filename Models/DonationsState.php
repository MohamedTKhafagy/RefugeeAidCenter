<?php
include_once "DonationModel.php";
interface DonationStates
{
    public function nextState(Donation $donation,$failed);
    public function previousState(Donation $donation,$failed);
    public function getCurrentState();
}


Class DonationPendingState implements DonationStates{
    public function nextState(Donation $donation,$failed){
        if($failed){
            $donation->setState("Failed");
        }
        else{
            $donation->setState("Completed");
        }
    }
    public function previousState(Donation $donation,$failed){
        return;
    }
    public function getCurrentState(){
        return "Pending";
    }
}

Class DonationCompletedState implements DonationStates{
    public function nextState(Donation $donation,$failed){
        return;
    }
    public function previousState(Donation $donation,$failed){
        return;
    }
    public function getCurrentState(){
        return "Completed";
    }
}

Class FailedState implements DonationStates{
    public function nextState(Donation $donation,$failed){
        return;
    }
    public function previousState(Donation $donation,$failed){
        $donation->setState("Pending");
    }
    public function getCurrentState(){
        return "Failed";
    }
}