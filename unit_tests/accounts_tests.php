<?php

include("C:/wamp/www/rallysite/unit_tests/test_config.php");
require_once(PAGE_CONTROLLERS."/RegisterPageController.inc.php");

class AccountsTest extends PHPUnit_Framework_TestCase
{	
    // ...

    public function testCanBeNegated()
    {
        // Arrange
		//uthentication::Login("j.waterworth1990@gmail.com", "password");
		
		$registrationController = new RegisterPageController(1);
		
        


        // Act
		// Assert
			$this->assertTrue($registrationController->SaveAccount("Unit Test 1", 
											"test@testing.com", 
											"password", 
											"07511914561",
											 "3 Orston Lane,Whatton,Nottinghamshire",
											 15-06-1990,
											 "Diabetic",
											 "Need to check labels",
											 "Mrs Test",
											 "Mother",
											 "07511914562",
											 "5 Orston Lane, Wahtton, Nottinghamshire",
											 "1"));       
    }

    // ...
}