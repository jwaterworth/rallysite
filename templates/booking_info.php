<?php
    include (COMMON_TEMPLATES."/header.php");
    require_once(PAGE_CONTROLLERS."/BookingPageController.inc.php");
    $eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
    $controller = new BookingPageController($eventID);
?>

<h3 class="page_title">Bookings</h3>
<div class="booking_page">
<?php if($controller->errorMessage != null) : ?>
    <div class="error">
        <p><?php echo $controller->errorMessage ?></p>
    </div>
<?php else : ?>
    <div class="normalise_tabs">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Information</a></li>
                <li><a href="#tabs-2">Your Booking</a></li>
                <?php if($controller->CheckAuth(CLUBREP, false)) : ?>
                <li><a href="#tabs-3">Club Bookings</a></li>
                <?php endif;?>
            </ul>
            <div id="tabs-1">
                <div class="booking_info_summary">
					<h3>Booking Summary</h3>
                    <p> <?php echo $controller->data['infoSummary'] ?> </p>
                </div>
                <div class="booking_fees">
                    <h3>Fee Deadlines</h3>
                    <?php foreach($controller->data['fees'] as $fee) : ?>
                        <ul class="fee_list">
                            <li class="fee_list">Fee: <?php echo $fee['fee'] ?></li>
                            <li class="fee_list">Applies from: <?php echo $fee['deadline'] ?></li>
                        </ul>						
                    <?php endforeach; ?>
					<div class="clear"></div>
                </div>
                <div class="booking_info">
					<h3>Important Booking Information</h3>
                    <p><?php echo $controller->data['info'] ?></p>
                </div>
            </div>
            <div id="tabs-2">
                <?php if($controller->data['personalBooking'] == null) : ?>
                    <div class="no_bookings">
                        <p><?php echo $controller->data['reason'] ?></p>
						<?php if($controller->data['bookingAllowed']) :?>
                        <a class="booking_button" href=".?event=<?php echo $controller->data['eventID'] ?>&action=bookingform"><span id="buttonText">Create a booking</span></a> 
						<?php endif; ?>
                        <div style="clear: both;"></div>
                    </div>
                <?php else :?>
                    <div class="booking_summary">
                        <p class="booking_header">Your Booking</p>
                        <div class="booking">
							<div class="booking_actions">	
                            <p><?php echo $controller->data['personalBooking']['userName'] ?></p>
                            <p class="short_attribute"><?php echo $controller->data['personalBooking']['fee'] ?></p>
                            <p><?php echo $controller->data['personalBooking']['activityName'] ?></p>
							</div>
							<div class="booking_actions">					
                                <a class="booking_button" href=".?event=<?php echo $controller->data['eventID'] ?>&action=bookingsummary" rel="facebox"><span>view</span></a>
								<a class="booking_button" href=".?event=<?php echo $controller->data['eventID'] ?>&action=payment"><span>payment</span></a>
								<a class="booking_button remove_button" href=".?event=<?php echo $controller->data['eventID'] ?>&action=entry&form=removebooking&id=<?php echo $controller->data['personalBooking']['bookingID'] ?>"><span>remove</span></a>
							</div>
                        </div>
                        <p class="club_header"></p>
                    </div>
                <?php endif; //Check for personal booking?>
                <div class="booking_activities">
                    <p>Some activities on offer...</p>
                    <?php if($controller->data['activities'] == null ) : ?>
                        <p>Try some activities!</p>
                        <p><?php echo $controller->data['activity_error']?></p>
                    <?php else : ?>
                        <?php foreach($controller->data['activities'] as $activity) : ?>
                            <div class="booking_activity side_bar_box side_bar_activity">
                                <p class="side_bar_header side_bar_external"><?php echo $activity['activityName'] ?></p>
                                <a href=".?event=<?php echo $controller->data['eventID']?>&action=activities#<?php echo $activity['activityID'] ?>">
                                    <img src="<?php echo $activity['activityImgLoc'] ?>"/>
                                    <p class="side_bar_text">Try <?php echo $activity['activityName'] ?>...Click here!</a></p>
                                </a>
                            </div>
                        <?php endforeach; ?>
                        <div class="clear"></div>
                    <?php endif; ?>
                </div>
            </div>
			<?php if($controller->CheckAuth(CLUBREP, false)) : ?>
            <div id="tabs-3">
                <div class="club_bookings">
                <?php if(!$controller->CheckAuth(CLUBREP, false)) : ?>
                    <div class="no_bookings">
                        <p><?php echo $controller->data['club_reason'] ?> </p>
                    </div>
                <?php else : ?>
                    <p class="booking_header">Club Bookings </p>
                    <a class="booking_button" href=".?event=<?php echo $controller->data['eventID'] ?>&action=bookingform&clubbooking=true"><span id="buttonText">Create a club booking</span></a> 
					<a class="booking_button" href=".?event=<?php echo $controller->data['eventID'] ?>&action=newclubmember"><span id="buttonText">Add a new club member</span></a> 
                    <div class="clear"></div>
                    <?php foreach($controller->data['clubBookings'] as $booking) : ?>
                        <div class="booking">
							<div class="booking_actions">	
                            <p><?php echo $booking['userName'] ?></p>
                            <p class="short_attribute"><?php echo $booking['fee'] ?></p>
                            <p><?php echo $booking['activityName'] ?></p>
							</div>
							<div class="booking_actions">	
                                <a class="booking_button" href=".?event=<?php echo $controller->data['eventID'] ?>&action=bookingsummary&id=<?php echo $booking['bookingID'] ?>" rel="facebox"><span>view</span></a>
								<a class="booking_button" href=".?event=<?php echo $controller->data['eventID'] ?>&action=payment&id=<?php echo $booking['bookingID'] ?>"><span>payment</span></a>
								<a class="booking_button remove_button" href=".?event=<?php echo $controller->data['eventID'] ?>&action=entry&form=removebooking&id=<?php echo $booking['bookingID'] ?>"><span>remove</span></a>
							</div>
                        </div>
                    <?php endforeach; //Club bookings ?>
                <?php endif; //Club booking null check?>
                </div>
            </div>
			<?php endif; ?>
        </div>
    </div>
	 <script type="text/javascript" src="scripts/booking_info_script.js"></script>
<?php endif; //Error message ?>
</div>
<?php
    include (COMMON_TEMPLATES."/footer.php");
?>