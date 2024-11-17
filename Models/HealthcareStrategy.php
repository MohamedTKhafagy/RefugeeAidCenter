<?php 
interface HealthcareStrategy {
    public function AssignHospital( Hospital $hospital);
}

class BasicInsurance implements HealthcareStrategy {
    public function AssignHospital(Hospital $hospital) {
        echo "Basic Insurance assigned to hospital: ". $hospital->getName(). "\n";
    }
}

class ComprehensiveInsurance implements HealthcareStrategy {
    public function AssignHospital(Hospital $hospital) {
        echo "Comprehensive Insurance assigned to hospital: ". $hospital->getName(). "\n";
    }
}
