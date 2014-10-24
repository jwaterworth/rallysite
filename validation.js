/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

$(document).ready(function() {
    
    //global vars  
    var form = $("#registration_form"); 
    var email = $("#email");  
    var emailInfo = $("#emailInfo");  
	var confirmEmail = $("#confirmEmail");
	var confirmEmailInfo = $("#confirmEmailInfo");
    var pass1 = $("#password1");  
    var pass1Info = $("#pass1Info");  
    var pass2 = $("#password2");  
    var pass2Info = $("#pass2Info");
    var name = $("#name");  
    var nameInfo = $("#nameInfo");  
    var phone = $("#phone");  
    var phoneInfo = $("#phoneInfo"); 
    var address = $("#address");  
    var addressInfo = $("#addressInfo");
    var date = $("#datepicker");  
    var dateInfo = $("#dobInfo");
    var emergName = $("#emergName");  
    var emergNameInfo = $("#emergNameInfo");
    var emergPhone = $("#emergPhone");  
    var emergPhoneInfo = $("#emergPhoneInfo");
    var emergAddress = $("#emergAddress");  
    var emergAddressInfo = $("#emergAddressInfo");

    //onBlur
    email.blur(validateEmail);
	confirmEmail.blur(checkConfirmEmail);
    pass1.blur(validatePass1);
    pass2.blur(validatePass2);  
    name.blur(validateName);
    phone.blur(validatePhone);
    address.blur(validateAddress);
    //date.blur(validateDate);
    emergName.blur(validateEmergName);
    emergPhone.blur(validateEmergPhone);
    emergAddress.blur(validateEmergAddress);
    /*
    //OnKeyPress
    //email.keyup(validateEmail);
    pass1.keyup(validatePass1);
    pass2.keyup(validatePass2);
    name.keyup(validateName);
    address.keyup(validateAddress);
    emergName.keyup(validateEmergName);
    emergPhone.keyup(validateEmergPhone);
    emergAddress.keyup(validateEmergAddress);
    */
    //On submitting
    //On Submitting
    form.submit(function(){
            if(validateName() & validateEmail() & checkConfirmEmail() & validatePass1() & validatePass2() & validatePhone() & validateAddress()
            & validateEmergName() & validateEmergPhone() & validateAddress())
                    return true
            else
                    return false;
    });
	
    
    function validateEmail(){
        //testing regular expression
        var a = $("#email").val();
        var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
        //if it's valid email
        if(filter.test(email.val())){
                email.removeClass("error");
                emailInfo.text("Valid Address");
                emailInfo.removeClass("error");
								
				if(confirmEmail.val()) {
					checkConfirmEmail();
				}
				
                return true;
        }
        //if it's NOT valid
        else { 
                email.addClass("error");
                emailInfo.text("Error - Please enter a valid email");
                emailInfo.addClass("error");
                return false;
        }		
    }
	
	function checkConfirmEmail() {
		if(email.val() == confirmEmail.val()) {
			confirmEmail.removeClass("error");
			confirmEmailInfo.text("Valid Address");
			confirmEmailInfo.removeClass("error");
			return true;
		} else {
			confirmEmail.addClass("error");
			confirmEmailInfo.text("Error - Please ensure both email addresses match");
			confirmEmailInfo.addClass("error");
			return false;
		}
	}
    
    function validatePass1(){
        //it's NOT valid
        if(pass1.val().length <5){
                pass1.addClass("error");
                pass1Info.text("Error - Invalid password. At least 5 characters");
                pass1Info.addClass("error");
                return false;
        }
        //it's valid
        else{			
                pass1.removeClass("error");
                pass1Info.text("Valid");
                pass1Info.removeClass("error");
                validatePass2();
                return true;
        }
    }
    
    function validatePass2(){
        //are NOT valid
        if( pass1.val() != pass2.val() || pass2.val().length < 5){
                pass2.addClass("error");
                pass2Info.text("Passwords don't match");
                pass2Info.addClass("error");
                return false;
        }
        //are valid
        else{
                pass2.removeClass("error");
                pass2Info.text("Valid - Match");
                pass2Info.removeClass("error");
                return true;
        }
    }
    
    function validateName() {
        //if it's NOT valid
        if(name.val().length < 4){
                name.addClass("error");
                nameInfo.text("Error - Name too short");
                nameInfo.addClass("error");
                return false;
        }
        //if it's valid
        else{
                name.removeClass("error");
                nameInfo.text("");
                nameInfo.removeClass("error");
                return true;
        }
    }
    
    function validatePhone() {
        //if it's NOT valid
        if(phone.val().length != 11 || phone.val().substr(0,1) != "0" || isNaN(phone.val())|| phone.val().indexOf(" ") != -1){
            phone.addClass("error");
            phoneInfo.text("Error - UK phone number required");
            phoneInfo.addClass("error");
            return false;
        }
        //if it's valid
        else {
            phone.removeClass("error");
            phoneInfo.text("");
            phoneInfo.removeClass("error");
            return true;
        }
    }
    
    function validateAddress() {
        //if it's NOT valid
        if(address.val().length < 10 || address.val().length > 255){
                address.addClass("error");
                addressInfo.text("Error - Name too short");
                addressInfo.addClass("error");
                return false;
        }
        //if it's valid
        else{
                address.removeClass("error");
                addressInfo.text("");
                addressInfo.removeClass("error");
                return true;
        }
    }
    
    function validateDate() {
        var validFormat = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
        alert(date.val());
        if(validFormat.test(date.val())) { //Invalid form
            date.addClass("error");
            dateInfo.text("Error - Invalid date format");
            dateInfo.addClass("error");
            return false;
        } else {
            var monthfield=date.val().split("/")[0];
            var dayfield=date.val().split("/")[1];
            var yearfield=date.val().split("/")[2];
            
            var dayObject = new Date(yearfield, monthfield, dayfield);
            if(dayObject.getMonth() != monthfield || dayObject.getDay()!= dayfield || dayObject.getYear()!= yearfield) { //Invalid values
                date.addClass("error");
                dateInfo.text("Error - Invalid day, month or year detected");
                dateInfo.addClass("error");
                return false;
            } else { //Valid
                address.removeClass("error");
                addressInfo.text("Valid");
                addressInfo.removeClass("error");
                return true;
            }
        }
    }
    
    function validateEmergName() {
        //if it's NOT valid
        if(emergName.val().length < 4){
                emergName.addClass("error");
                emergNameInfo.text("Error - Name too short");
                emergNameInfo.addClass("error");
                return false;
        }
        //if it's valid
        else{
                emergName.removeClass("error");
                emergNameInfo.text("");
                emergNameInfo.removeClass("error");
                return true;
        }
    }
    
    function validateEmergPhone() {
        //if it's NOT valid
        if(emergPhone.val().length != 11 || emergPhone.val().substr(0,1) != "0" || isNaN(emergPhone.val()) || emergPhone.val().indexOf(" ") != -1){
            emergPhone.addClass("error");
            emergPhoneInfo.text("Error - UK phone number required");
            emergPhoneInfo.addClass("error");
            return false;
        }
        //if it's valid
        else {
            emergPhone.removeClass("error");
            emergPhoneInfo.text("");
            emergPhoneInfo.removeClass("error");
            return true;
        }
    }
    
    function validateEmergAddress() {
        //if it's NOT valid
        if(emergAddress.val().length < 10 || emergAddress.val().length > 255){
                emergAddress.addClass("error");
                emergAddressInfo.text("Error - Address too short");
                emergAddressInfo.addClass("error");
                return false;
        }
        //if it's valid
        else{
                emergAddress.removeClass("error");
                emergAddressInfo.text("");
                emergAddressInfo.removeClass("error");
                return true;
        }
    }
});



