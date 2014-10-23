<?php
include("config.php");
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
switch($action) {
    case 'ajax':
        ajax();
        break;
    case 'login':
        login();
        break;
    case 'logout':
        logout();
        break;
    case 'myaccount':
        myaccount();
        break;
    case 'newspost':
        newspost();
        break;
    case 'eventinfo':
        eventInfo();
        break;
    case 'bookinginfo':
        bookings();
        break;
    case 'directions':
        directions();
        break;
    case 'bookingform':
        bookingForm();
        break;
    case 'payment':
        payment();
        break;
    case 'activities':
        activities();
        break;
    case 'participants':
        participants();
        break;
	case 'whosgoing':
		whosgoing();
		break;
    case 'clubrepadmin':
        clubrepadmin();
        break;
    case 'bookingsummary':
        bookingsummary();
        break;
    case 'admin':
        admin();
        break;
    case 'download':
        downloads();
        break;
    case 'editaccount':
        register();
        break;
    case 'register':
        register();
        break;
	case 'newclubmember':
		newclubmember();
		break;
    case 'entry':
        entry();
        break;
    case 'adminentry':
        adminentry();
        break;
    default:
        homepage();
 }
 
 
function adminentry() {
    require_once(PAGE_CONTROLLERS."/AdminPageController.inc.php");
    $imagePath = null;
    $eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
    $controller = new AdminPageController($eventID);

    $form = isset( $_GET['form'] ) ? $_GET['form'] : "";
    
    switch($form) {
        case 'news':
            $controller->SaveNewsPost($_POST['newsTitle'], $_POST['newsBody']);
            homepage();
            break;
        case 'eventinfo':
            if(isset($_FILES['upload'])) {
                $uploader = new Uploads();
                $imagePath = $uploader->UploadFile($_FILES['upload'], $_POST['name'], $_POST['replace'], $_POST['check']);
                
                if($imagePath == null) {
                    echo $uploader->error_message;
                    $imagePath = $_POST['currLogo'];
                }
            }       
            
            $controller->SaveEventInfo($_POST['eventID'], $_POST['eventName'], $_POST['eventSummary'],
                    $_POST['eventInfo'], $imagePath, $_POST['bookingInfoID'], $_POST['activityPageID']);
            admin();
            break;
        case 'bookinginfo' :
            $controller->SaveBookingInfo($_POST['bookingInfoID'], $_POST['bookingSummary'], $_POST['bookingInformation']);
            admin();
            break;
        case 'activitypage' :
            $controller->SaveActivityPage($_POST['activityPageID'], $_POST['activityPageBrief']);
            admin();
            break;
        case 'activity' :
            $imagePath = null;
            if(isset($_FILES['activity_upload'])) {
                $uploader = new Uploads();
                $imagePath = $uploader->UploadActivityImage($_FILES['activity_upload'], $_POST['name']);
                
                if($imagePath == null) {
                    echo $uploader->error_message;
                    $imagePath = isset($_POST['currLogo']) ? $_POST['currLogo'] : null;
                }
            }
            
            $controller->SaveActivity($_POST['activityPageID'], $_POST['activityName'], $_POST['activityDescription'], $_POST['activityCapacity'], $_POST['activityCost'], $imagePath);
            activities();
            break;
        case 'uploadtest' :
            $uploader = new Uploads();
            echo $uploader->UploadFile($_FILES['upload'], $_POST['name'], $_POST['replace'], $_POST['check']);
            admin();
            break;
        case 'deletenews':
            $newsPostID = $_GET['newsid'];
            $news = LogicFactory::CreateObject("News");
            try {
                $news->RemoveNewsPost($newsPostID);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            homepage();
            break;
        default:
            return;
    }
}

function entry() {
    
    $form = isset( $_GET['form'] ) ? $_GET['form'] : "";
    $eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
    
    switch($form) {
        case 'booking':
            require_once(PAGE_CONTROLLERS."/BookingFormPageController.inc.php");
            $controller = new BookingFormPageController($eventID);
		
			$result = $controller->SaveBooking($_POST['userID'], $_POST['activityID'], $_POST['foodChoices']);

			$_POST['confirmation_type'] =  Authentication::GetLoggedInId() == $_POST['userID'] ? BOOKING : CLUB_BOOKING;
			$_POST['confirmation_result'] = $result;
			$_POST['confirmation_error'] = $controller->errorMessage;

			confirmation();
            break;
        case 'removebooking' :
            require_once(PAGE_CONTROLLERS."/BookingFormPageController.inc.php");
            $controller = new BookingFormPageController($eventID);
            
            echo $controller->RemoveBooking($_GET['id']);
            bookings();
            break;
        case 'register':
            require_once(PAGE_CONTROLLERS."/RegisterPageController.inc.php");
            
            $controller = new RegisterPageController($eventID);
			
            $result = $controller->SaveAccount($_POST['userName'], $_POST['userEmail'], $_POST['userPassword'], $_POST['userPhone'], $_POST['userAddress'], 
                    $_POST['userDOB'], $_POST['userMedicalCond'], $_POST['userDietaryReq'],
                    $_POST['emergName'], $_POST['emergRel'], $_POST['emergPhone'], $_POST['emergAddress'], $_POST['clubID']);

            $_POST['confirmation_type'] = REGISTRATION;
            $_POST['confirmation_result'] = $result;
            $_POST['confirmation_error'] = $controller->errorMessage;
            confirmation();
            break;
		case 'update_details':
			require_once(PAGE_CONTROLLERS."/RegisterPageController.inc.php");
			
			$controller = new RegisterPageController($eventID);
			
			$result = $controller->SaveAccount(isset($_POST['userName']) ? $_POST['userName'] : null,
											isset($_POST['userEmail']) ? $_POST['userEmail'] : null, 
											isset($_POST['userPassword']) ? $_POST['userPassword'] : null, 
											isset($_POST['userPhone']) ? $_POST['userPhone'] : null, 
											isset($_POST['userAddress']) ? $_POST['userAddress'] : null, 
											isset($_POST['userDOB']) ? $_POST['userDOB'] : null, 
											isset($_POST['userMedicalCond']) ? $_POST['userMedicalCond'] : null, 
											isset($_POST['userDietaryReq']) ? $_POST['userDietaryReq'] : null, 
											isset($_POST['emergName']) ? $_POST['emergName'] : null, 
											isset($_POST['emergRel']) ? $_POST['emergRel'] : null, 
											isset($_POST['emergPhone']) ? $_POST['emergPhone'] : null, 
											isset($_POST['emergAddress']) ? $_POST['emergAddress'] : null, 
											isset($_POST['emergRel']) ? $_POST['emergRel'] : null, 
											isset($_POST['clubID']) ? $_POST['clubID'] : null);

			$_POST['confirmation_type'] = UPDATE_DETAILS;
			$_POST['confirmation_result'] = $result;
			$_POST['confirmation_error'] = $controller->errorMessage;
			confirmation();
			break;
		case'newclubmember':
			require_once(PAGE_CONTROLLERS."/NewClubMemberPageController.inc.php");
            
            $controller = new NewClubMemberPageController($eventID);
			
            $result = $controller->SaveNewAccount($_POST['userName'], $_POST['userEmail'], $_POST['userPassword'], $_POST['userPhone'], $_POST['userAddress'], 
                    $_POST['userDOB'], $_POST['userMedicalCond'], $_POST['userDietaryReq'],
                    $_POST['emergName'], $_POST['emergRel'], $_POST['emergPhone'], $_POST['emergAddress']);

            $_POST['confirmation_type'] = CLUB_REGISTRATON;
            $_POST['confirmation_result'] = $result;
            $_POST['confirmation_error'] = $controller->errorMessage;
            confirmation();
			break;
		case 'updateclubmember':
			require_once(PAGE_CONTROLLERS."/NewClubMemberPageController.inc.php");
			
			$controller = new NewClubMemberPageController($eventID, isset($_POST['userId']) ? $_POST['userId'] : null);
			
			$result = $controller->UpdateAccount(isset($_POST['userId']) ? $_POST['userId'] : null,
											isset($_POST['userName']) ? $_POST['userName'] : null,
											isset($_POST['userEmail']) ? $_POST['userEmail'] : null, 
											isset($_POST['userPhone']) ? $_POST['userPhone'] : null, 
											isset($_POST['userAddress']) ? $_POST['userAddress'] : null, 
											isset($_POST['userDOB']) ? $_POST['userDOB'] : null, 
											isset($_POST['userMedicalCond']) ? $_POST['userMedicalCond'] : null, 
											isset($_POST['userDietaryReq']) ? $_POST['userDietaryReq'] : null, 
											isset($_POST['emergName']) ? $_POST['emergName'] : null, 
											isset($_POST['emergRel']) ? $_POST['emergRel'] : null, 
											isset($_POST['emergPhone']) ? $_POST['emergPhone'] : null, 
											isset($_POST['emergAddress']) ? $_POST['emergAddress'] : null);

			$_POST['confirmation_type'] = CLUB_MEMBER_UPDATE;
			$_POST['confirmation_result'] = $result;
			$_POST['confirmation_error'] = $controller->errorMessage;
			confirmation();
			break;
		case 'login':
			$email = $_POST['username'];
			$password = $_POST['password'];
			
			if(Authentication::Login($email, $password)) {
				homepage();
			}
			else {
				$_POST['login_error'] = "Could not find an account for the details entered.";
				myaccount();
			}
			
			break;
        default;
            homepage();
    }
    
}

function downloads() {
    $eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
    $type = isset( $_GET['type'] ) ? $_GET['type'] : "";
    $id = isset( $_GET['id'] ) ? $_GET['id'] : "0";
    require_once(PAGE_CONTROLLERS."/AdminPageController.inc.php");
    $controller = new AdminPageController($eventID);
    
    $controller->PushFile($type, $id);
}

function ajax() {
	if(Authentication::CheckAuthenticationLevel(CLUBREP|EVENTEXEC|SSAGOEXEC)) {
		require_once('ajax/AJAXHandler.php');
		$ajaxHandler = new AJAXHandler();
		if($accountID = isset( $_GET['accountID'] ) ? $_GET['accountID'] : "") {
			$ajaxHandler->GetAccountDetails($accountID);
		} else if(isset($_GET['getClubs'])) {
			$ajaxHandler->GetClubs();
		} else if(isset($_GET['getClubBookings']) && isset($_GET['clubId'])) {
			$ajaxHandler->GetClubBookings($_GET['event'], $_GET['clubId']);
		} else if(isset($_GET['getActivities']) && isset($_GET['event'])) {
			$ajaxHandler->GetActivities($_GET['event']);
		} else if(isset($_GET['updateBooking'])) {
			$bookingId = isset($_POST['bookingId']) ? $_POST['bookingId'] : null;
			$activityId = isset($_POST['activityId']) ? $_POST['activityId'] : null;
			$fee = isset($_POST['fee']) ? $_POST['fee'] : null;
			$paid = isset($_POST['paid']) ? $_POST['paid'] : null;
			$ajaxHandler->UpdateBooking($bookingId, $activityId, $fee, $paid);
		}
	}
	
	if( $activityID = isset( $_GET['activityID'] ) ? $_GET['activityID'] : "") {
		require_once('ajax/AJAXHandler.php');
		$ajaxHandler = new AJAXHandler();
		$ajaxHandler->GetActivityDetails($activityID);	
	}
    
}

function confirmation() {
    require(TEMPLATE_PATH."/confirmation.php");
}

function register() {
    require(TEMPLATE_PATH."/register.php");
}

function newclubmember() {
	require(TEMPLATE_PATH."/new_club_member.php");
}

function login() {
    require(TEMPLATE_PATH."/login.php");
}

function logout() {
    require("logout.php");
}

function newspost() {
    require(TEMPLATE_PATH."/news_post.php");
}

function myaccount() {
    require(TEMPLATE_PATH."/myaccount.php");
}

function bookingsummary() {
    require(TEMPLATE_PATH."/standalone/booking_summary.php");
}

function homepage() {
    require(TEMPLATE_PATH."/homepage.php");
}

function clubrepadmin() {
    require(TEMPLATE_PATH."/clubrep_admin.php");
}

function admin() {
    require(TEMPLATE_PATH."/admin.php");
}

function eventInfo() {
    require(TEMPLATE_PATH."/event_info.php");
}

function bookings() {  
    require(TEMPLATE_PATH."/booking_info.php");
}

function participants() {
    require(TEMPLATE_PATH."/event_participants.php");
}

function whosgoing() {
	require(TEMPLATE_PATH."/club_event_participants.php");
}

function directions() {
    require(TEMPLATE_PATH."/directions.php");
}

function bookingForm() {
    require(TEMPLATE_PATH."/booking_form.php");
}

function payment() {
    $accountID = isset( $_GET['paymentid'] ) ? $_GET['paymentid'] : null;
    $eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
    if($accountID != null) {
        require_once(PAGE_CONTROLLERS."/PaymentPageController.inc.php");
        $controller = new PaymentPageController($eventID, null);
        $controller->SendPaymentDetailsEmail($accountID);
        
        return bookings();
    }
    
    require(TEMPLATE_PATH."/payment.php");
}
function activities() {
    require(TEMPLATE_PATH."/activities.php");
}

?>
