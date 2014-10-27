<?php
include (COMMON_TEMPLATES."/header.php");
require_once(PAGE_CONTROLLERS."/PaymentPageController.inc.php");
$eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
$bookingID = isset( $_GET['id'] ) ? $_GET['id'] : null;
$controller = new PaymentPageController($eventID, $bookingID);
$controller->GetPageData();
$booking = $controller->data['booking'];
?>

<h3 class="page_title">Payment Summary</h3>

<div class="booking_page payment_page">
    <?php if(!$controller->CheckAuth(ALLTYPES)) : ?>
        <p>Please log in to view payment summary</p>
    <?php elseif($controller->errorMessage != null) : ?>
        <p><?php echo $controller->errorMessage ?></p>
    <?php else : ?>
        <div class="payment_summary">
        <?php if($booking['paid']) : ?>
        <p>Congratulations, your booking has been paid for!</p>
        <?php endif; ?>
        <?php if($controller->data['clubBooking'] ) : ?>
            <p>Summary for club member booking on <?php echo $controller->data['eventName'] ?></p>
        <?php else : ?>
            <p>Thank you for booking on to <?php echo $controller->data['eventName'] ?>, here is your payment summary:</p>
        <?php endif; ?>
            <p>Name: <?php echo $booking['userName']?></p>
            <p>Activity: <?php echo $booking['activityName'] ?></p>
            <p>Price Breakdown: </p>
            <p>Total: <?php echo $booking['bookingFee'] ?></p>
            <p>Base fee (at time of booking): <?php echo $booking['baseFee']?></p>
            <p>Activity Cost: <?php echo $booking['activityCost'] ?></p>
        </div>
        <?php if(!$booking['paid']) : ?>
        <div class="payment_options">
                <p class="payment_header">Pay by cheque</p>
                <p>Payable to: <?php echo $controller->data['paymentName'] ?></p>
                <p>Address: <?php echo $controller->data['paymentAddress'] ?></p>
				<p>Notes: Write your name and club on the back of the cheque, so we know it's you! Include your initial, surname and club (or as much will fit) as the reference</p>
                <p class="payment_header">Bank Transfer</p>
				<!--
                <p>Transfer details available by email...</p>
                <p><a href=".?event=<?php echo $controller->data['eventID']?>&action=payment&paymentid=<?php echo $booking['userID']?>&id=<?php echo $booking['bookingID'] ?>">Request bank details</a></p>
				-->
				<p>Account Name: SSAGO Autumn Rally</p>
				<p>Account No: 72815753</p>
				<p>Sort Code: 40-16-15</p>
				<p>Please include your a name and club (or an abbreviated form thereof) in the description so that we know it's from you!</p>
            <div class="clear"></div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
	</div>
<?php       
    include (COMMON_TEMPLATES."/footer.php");
?>