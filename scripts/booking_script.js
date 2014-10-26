BookingScript = {};

BookingScript.ClubBooking = false;

$(document).ready(function() { 
	if($('#clubBookingFlag').val())
		getAccountDetails();
	
	$("#bookingSubmit").click(function(e) {
		if(BookingScript.ClubBooking && !$('#accountID').val()) {
			e.preventDefault();
			alert("Please select a member.");
		}

		if(!$('#activityInput').val()) {
			e.preventDefault();
			alert("Please select an activity.");
		}		
	});
	
	$(".activityButton").click(function(e) {
		e.preventDefault();
		$(this).css('background-color', 'rgba(0, 177, 45, 1)');
		$(this).siblings().css('background-color', 'rgba(143, 34, 113, 1)');
		
		var index = $(this).data("activityid");
		getActivityDetails(index);
		$('#activityInput').val(index);
	});
	
	
});

function getAccountDetails(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	BookingScript.ClubBooking = true;
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
                    responseText = ajaxRequest.responseText.split("|");
                    document.getElementById('memberName').innerHTML = responseText[0]  ? responseText[0] : "";
                    document.getElementById('memberEmail').innerHTML = responseText[1] ? responseText[1] : "";
                    document.getElementById('memberPhone').innerHTML = responseText[2] ? responseText[2] : "";
		}
	}
	var accountID = document.getElementById('accountID').value;
	var queryString = "?action=ajax&accountID=" + accountID;
        
	ajaxRequest.open("GET", "index.php" + queryString, true);
	ajaxRequest.send(null); 
        
}

function getActivityDetails(activityID) {
    var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
                    var responseText = ajaxRequest.responseText.split("|");
                    
                    /*if(responseText[0].substring(0,1) == "0") {
                        return;
                    }*/
                    
                    document.getElementById('activityName').innerHTML = responseText[0];
                    document.getElementById('activityCost').innerHTML = responseText[1];
                    document.getElementById('activitySpaces').innerHTML = responseText[4] + ' remaining';
		}
	}
	//var accountID = document.getElementById('activityID').value;
	var queryString = "?action=ajax&activityID=" + activityID;
        
	ajaxRequest.open("GET", "index.php" + queryString, true);
	ajaxRequest.send(null); 
}



