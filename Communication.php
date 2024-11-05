<?php
class Communication{
    public $iCommunicationStrategy;
    public function __construct(ICommunicationStrategy $iCommunicationStrategy){
        $this->iCommunicationStrategy = $iCommunicationStrategy;
    }

}

?>