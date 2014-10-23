<?php
    include (COMMON_TEMPLATES."/header.php");
    require_once(PAGE_CONTROLLERS."/ParticipantsPageController.inc.php");
    $eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
    $controller = new ParticipantsPageController($eventID);
    $controller->GetPageData(WHOSGOING);
?>

<h3 class="page_title">Who's Going</h3>

<div class="booking_page">
<?php if($controller->errorMessage != null) : ?>
    <div class="error">
        <p><?php echo $controller->errorMessage ?></p>
    </div>
<?php else : ?>
    <div class="event_participants">
		<div class="activity_entry  activity_header" >    
			<p><?php echo $controller->data['total']?> participants signed up so far!</p>
		</div>
		<div class="activity_list" >
        <?php foreach($controller->data['clubs'] as $club) : ?>
            <div class="activity_entry" >      
                <?php if($club['clubError'] != null) : ?>
                     <p><?php echo $club['clubError'] ?></p>
                <?php else : ?>
                     <div class="participant_list">
                        <p class="activity_title"><?php echo $club['clubName'] ?></p>
                        <p>(<?php echo $club['numBookings'] ?> bookings)</p>
                        <?php foreach($club['clubBookings'] as $booking) : ?>
                            <div class="activity_participant">
                                <p><?php echo $booking['accountName'] ?> - <?php echo $booking['activityName'] ?></p>
                            </div>
                        <?php endforeach; ?>
                     </div>
                     <div class="clear"></div>
                <?php endif; ?>
                </div>
        <?php endforeach; ?>
        </div>
        </div>
    </div>
    
<?php endif; //Error message ?>
    
	
<?php
    include (COMMON_TEMPLATES."/footer.php");
?>