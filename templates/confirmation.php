<?php
include (COMMON_TEMPLATES."/header.php");
require_once(PAGE_CONTROLLERS."/ConfirmationPageController.inc.php");

$eventID = isset( $_GET['event'] ) ? $_GET['event'] : "1";
$type = isset( $_POST['confirmation_type'] ) ? $_POST['confirmation_type'] : ERROR;
$result = isset( $_POST['confirmation_result'] ) ? $_POST['confirmation_result'] : false;
$errorMessage = isset( $_POST['confirmation_error'] ) ? $_POST['confirmation_error'] : null;
$controller = new ConfirmationPageController($eventID, $type, $result, $errorMessage);
?>

<h3 class="page_title"><?php echo $controller->data['title'] ?></h3>

<div class="booking_page">
    <div class="confirmation" >
        <?php if($controller->confirmationType == REGISTRATION) : ?>
            <?php if($controller->errorMessage != null) : ?>
                <p>An error occurred creating your account: <?php echo $controller->errorMessage ?>. Please contact your club representative or try again.</p>
            <?php else : ?>
                <p>Congratulations, your account has been registered and is now awaiting approval. A confirmation email has been sent to your email address.</p>
            <?php endif; ?>
        <?php elseif($controller->confirmationType == BOOKING) : ?>
            <?php if($controller->errorMessage != null) : ?>
                <p>An error occurred creating booking: <?php echo $controller->errorMessage ?></p>
            <?php else: ?>
                <p>Congratulations, booking confirmed</p>
                <p>If you wish to pay for your booking now, please continue to site payment</p>
                <a href=".?event=<?php echo $controller->data['eventID'] ?>&action=payment">Continue to payment</a>
            <?php endif; ?>
		<?php elseif($controller->confirmationType == CLUB_BOOKING) : ?>
            <?php if($controller->errorMessage != null) : ?>
                <p>An error occurred creating club member booking: <?php echo $controller->errorMessage ?></p>
            <?php else: ?>
                <p>Club member booking created.</p>
                <p>If you wish to view payment details for this booking, please continue to payment view</p>
                <a href=".?event=<?php echo $controller->data['eventID'] ?>&action=payment">Continue to payment</a>
            <?php endif; ?>
		<?php elseif($controller->confirmationType == BOOKING) : ?>
            <?php if($controller->errorMessage != null) : ?>
                <p>An error occurred creating booking: <?php echo $controller->errorMessage ?></p>
            <?php else: ?>
                <p>Congratulations, booking confirmed</p>
                <p>If you wish to pay for your booking now, please continue to site payment</p>
                <a href=".?event=<?php echo $controller->data['eventID'] ?>&action=payment">Continue to payment</a>
            <?php endif; ?>
		<?php elseif($controller->confirmationType == UPDATE_DETAILS) : ?>
            <?php if($controller->errorMessage != null) : ?>
                <p>An error occurred updating account: <?php echo $controller->errorMessage ?></p>
            <?php else: ?>
                <p>Your details have been updated.</p>
            <?php endif; ?>
		<?php elseif($controller->confirmationType == CLUB_REGISTRATON) : ?>
            <?php if($controller->errorMessage != null) : ?>
                <p>An error occurred registering the club member account: <?php echo $controller->errorMessage ?></p>
            <?php else: ?>
                <p>Club member account created.</p>
				<a href=".?event=<?php echo $controller->data['eventID'] ?>&action=bookingInfo">Return to bookings page?</a>
            <?php endif; ?>
		<?php elseif($controller->confirmationType == CLUB_MEMBER_UPDATE) : ?>
            <?php if($controller->errorMessage != null) : ?>
                <p>An error occurred updating the club member account: <?php echo $controller->errorMessage ?></p>
            <?php else: ?>
                <p>Club member updated.</p>
				<a href=".?event=<?php echo $controller->data['eventID'] ?>&action=clubrepadmin">Return to club details page?</a>
            <?php endif; ?>				
        <?php else : ?>
            <?php if($controller->errorMessage != null) : ?>
                <p><?php echo $controller->errorMessage ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php
    include (COMMON_TEMPLATES."/footer.php");
?>
