<?php 
interface HealthcareStrategy {
    public function AssignHospital(Hospital $hospital);
    public function calculateHealthcareCost(Hospital $hospital): float; // Estimate healthcare cost for treatment
    public function provideEmergencyService(Hospital $hospital);       // Handle emergency situations
}


class BasicInsurance implements HealthcareStrategy {
    public function AssignHospital(Hospital $hospital) {
        echo "Basic Insurance assigned to hospital: " . $hospital->getName() . "\n";
    }

    public function calculateHealthcareCost(Hospital $hospital): float {
        return 100.0; // Fixed cost for basic insurance
    }

    public function provideEmergencyService(Hospital $hospital) {
        echo "Emergency services available at hospital: " . $hospital->getName() . " under Basic Insurance\n";
    }
}

class ComprehensiveInsurance implements HealthcareStrategy {
    public function AssignHospital(Hospital $hospital) {
        echo "Comprehensive Insurance assigned to hospital: " . $hospital->getName() . "\n";
    }

    public function calculateHealthcareCost(Hospital $hospital): float {
        return 200.0; // Higher cost for comprehensive insurance
    }

    public function provideEmergencyService(Hospital $hospital) {
        echo "Premium emergency services available at hospital: " . $hospital->getName() . "\n";
    }
}
