<?php
    include (COMMON_TEMPLATES."/header.php");
    require_once(PAGE_CONTROLLERS."/ParticipantsPageController.inc.php");
    $eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
    $controller = new ParticipantsPageController($eventID);
    $controller->GetPageData(WHOSDOING);
?>

<h3 class="page_title">Who's Doing</h3>

<div class="booking_page">
<?php if($controller->errorMessage != null) : ?>
    <div class="error">
        <p><?php echo $controller->errorMessage ?></p>
    </div>
<?php else : ?>
    <div class="event_participants">
		<div class="activity_entry activity_header" >    
			<p><?php echo $controller->data['total']?> participants signed up so far!</p>
		</div>
        <div class="activity_list" >
        <?php foreach($controller->data['activities'] as $activity) : ?>
            <div class="activity_entry" >      
                <?php if($activity['error'] != null) : ?>
                     <p><?php echo $activity['error'] ?></p>
                <?php else : ?>
                     <div class="participant_list">
                        <p class="activity_title"><?php echo $activity['name'] ?></p>
                        <p>Spaces filled: <?php echo $activity['number'] ?> / <?php echo $activity['capacity'] ?></p>
                        <?php foreach($activity['participants'] as $participant) : ?>
                        <?php if($participant['error'] != null) : ?>
                            <p><?php echo $participant['error'] ?></p>
                        <?php else : ?>
                            <div class="activity_participant">
                                <p><?php echo $participant['accountName'] ?> - <?php echo $participant['clubName'] ?></p>
                            </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                     </div>
                     <div class="participants_image">
                         <img src="<?php echo $activity['imgLoc']?>" alt="Activity Image"/>
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
