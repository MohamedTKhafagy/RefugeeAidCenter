<?php

interface Subject{
    public function RegisterObserver(Observer $observer);
    public function RemoveObserver(Observer $observer);
    public function NotifyObservers($eventData);
}