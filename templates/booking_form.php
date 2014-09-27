<?php
include (COMMON_TEMPLATES."/header.php");
require_once(PAGE_CONTROLLERS."/BookingFormPageController.inc.php");
$eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
$bookingType = isset( $_GET['clubbooking'] ) ? $_GET['clubbooking'] : false;
$controller = new BookingFormPageController($eventID, !$bookingType);
$controller->GeneratePageData();
?>

<h3 class="page_title">Booking Form</h3>

<div class="booking_page">
    <?php if(!$controller->CheckAuth(ALLTYPES)) : ?>
        <p>You must be logged in to book on to an event</p>		
    <?php elseif($controller->errorMessage != null) : ?>
        <p><?php echo $controller->errorMessage ?></p>
    <?php else : ?>	
        <form name="bookingForm" class="booking_form" action=".?event=<?php echo $controller->data['eventID']?>&action=entry&form=booking" method="POST">
            <fieldset class="form_details">
                <?php if($controller->data['bookingType'] == 'ownBooking') : ?>
                    <legend>Membership details - <a href=".?action=myaccount">edit</a></legend>
                    <input type="hidden" name="userID" value="<?php echo $controller->data['userID'] ?>"/>
                    <p>Name: <?php echo $controller->data['userName'] ?></p>
                    <p>Club: <?php echo $controller->data['club'] ?></p>
                    <p>Email: <?php echo $controller->data['userEmail'] ?></p>
                    <p>Phone: <?php echo $controller->data['userPhone'] ?></p>
                    <p>Address: <?php echo $controller->data['userAddress'] ?></p>
                    <p>Emergency Contact: <?php echo $controller->data['emergName'] ?></p>
                    <p>Emergency Number: <?php echo $controller->data['emergPhone'] ?></p>
                    <p>Emergency Address: <?php echo $controller->data['emergAddress'] ?></p>
                <?php else : ?>
                    <legend>Club Member</legend>
                    <select id="accountID"  name="userID" onLoad="getAccountDetails()" onChange="getAccountDetails()">
                        <?php foreach($controller->data['clubMembers'] as $clubMember) : ?>
                            <option value="<?php echo $clubMember['id'] ?>"><?php echo $clubMember['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p>
                        <label>Member Name: <span id="memberName"></span></label>
                    </p>
                    <p>
                        <label>Member Email: <span id="memberEmail"></span></label>
                    </p>
                    <p>
                        <label>Member Phone: <span id="memberPhone"></span></label>
                    </p>
                <?php endif; ?>
            </fieldset>
            <fieldset class="form_details">
                <legend>Activity Choice</legend>
                <div class="normalise_grid">
                    <ol id="selectable">
                        <?php foreach($controller->data['activities'] as $activity) : ?>
                        <?php if($activity['enabled']) : ?>
                        <li class="ui-state-default" activityID="<?php echo $activity['id']?>"><p><?php echo $activity['name'] ?></p><img style="max-height: 50px; max-width: 50px;" src="<?php echo $activity['imageLoc'] ?>"/></li>
                        <?php endif; ?>
                        <?php endforeach ?>
                    </ol>
                </div>
                <div class="clear"></div>
                <input type="hidden" id="activityInput" name="activityID" value=""/>
                <p>
                    <label>Activity: <span id="activityName"></span></label>
                </p>
                <p>
                    <label>Activity Fee: <span id="activityCost"></span></label>
                </p>
                <p>
                    <label>Spaces: <span id="activitySpaces"></span></label>
                </p>
            </fieldset>
            <fieldset class="form_details">
                <legend>Food Choices</legend>
                <?php foreach($controller->data['foodTypes'] as $foodType) : ?>
                    <p>
                        <label><?php echo $foodType['name'] ?></label>
                        <?php if($foodType['errorMessage'] != null) : ?>
                            <p><?php echo $foodType['errorMessage'] ?></p>
                        <?php else : ?>
                            <select name="foodChoices[]">
                                <?php foreach($foodType['foodChoices'] as $foodChoice) : ?>
                                    <option value="<? echo $foodChoice['id'] ?>"><?php echo $foodChoice['name'] ?> | <?php echo $foodChoice['notes'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </p>
                <?php endforeach; ?>
            </fieldset>
            <input type="submit" value="Submit"/>
        </form>
    </div>

<?php endif; ?>

<?php      
    include (COMMON_TEMPLATES."/footer.php");
?>

<?php 
/*
<select id="activityID" name="activityID" onChange="getActivityDetails()">
                <?php foreach($controller->data['activities'] as $activity) : ?>
                    <?php if($activity['enabled']) : ?>
                        <option value="<? echo $activity['id'] ?>"><?php echo $activity['name'] ?> | £<?php echo $activity['cost'] ?></option>
                    <?php else : ?>
                        <option value="<? echo $activity['id'] ?>" disabled="true"><?php echo $activity['name'] ?> | £<?php echo $activity['cost'] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
                </select>
*/ ?>