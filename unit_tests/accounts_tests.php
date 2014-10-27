<?php

include("C:/wamp/www/rallysite/unit_tests/test_config.php");
require_once(PAGE_CONTROLLERS."/RegisterPageController.inc.php");
require_once(PAGE_CONTROLLERS."/BookingFormPageController.inc.php");

class AccountsTest extends PHPUnit_Framework_TestCase
{	
    // ...
	
	public function testFiftyCreates() {
		for($i=0; $i<50; $i++) {
			$this->Create($i);
		}
	}

    public function Create($index)
    {
        // Arrange
		//Authentication::Login("j.waterworth1990@gmail.com", "password");
		
		$registrationController = new RegisterPageController(1);
		     
        // Act
		// Assert
		//$this->assertTrue(
			$registrationController->SaveAccount("Unit Test Account " . $index, 
											$this->generateRandomString() . "@testing.com", 
											"password", 
											"07511914561",
											 "3 Orston Lane,Whatton,Nottinghamshire",
											 "15/06/1990",
											 "Diabetic",
											 "Need to check labels",
											 "Mrs Test",
											 "Mother",
											 "07511914562",
											 "5 Orston Lane, Wahtton, Nottinghamshire",
											 "1");       
		 echo $registrationController->errorMessage;
    }

	private function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}