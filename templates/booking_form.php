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
			<?php if($controller->data['bookingType'] == 'ownBooking') : ?>
				<div class="booking_form_section">
					<h3>Membership details - <a href=".?action=myaccount">edit</a></h3>				
					<input type="hidden" name="userID" value="<?php echo $controller->data['userID'] ?>"/>
					<div>
					<label>Name</label><span><?php echo $controller->data['userName'] ?></span>
					</div>
					<div>
					<label>Club</label><span><?php echo $controller->data['club'] ?></span>
					</div>
					<div>
					<label>Email</label><span><?php echo $controller->data['userEmail'] ?></span>
					</div>
					<div>
					<label>Phone</label><span><?php echo $controller->data['userPhone'] ?></span>
					</div>
					<div>
					<label>Address</label><span><?php echo $controller->data['userAddress'] ?></span>
					</div>
					<div>
					<label>Emergency Contact</label><span><?php echo $controller->data['emergName'] ?></span>
					</div>
					<div>
					<label>Emergency Number</label><span><?php echo $controller->data['emergPhone'] ?></span>
					</div>
					<div>
					<label>Emergency Address</label><span><?php echo $controller->data['emergAddress'] ?></span>
					</div>
				</div>				
			<?php else : ?>
				<div class="booking_form_section">
					<h3>Club Member</h3>
					<select id="accountID"  name="userID" onLoad="getAccountDetails()" onChange="getAccountDetails()">
						<?php foreach($controller->data['clubMembers'] as $clubMember) : ?>
							<option value="<?php echo $clubMember['id'] ?>"><?php echo $clubMember['name'] ?></option>
						<?php endforeach; ?>
					</select>
					<label>Member Name</label><span id="memberName"></span>
					<label>Member Email</label><span id="memberEmail"></span>
					<label>Member Phone</label><span id="memberPhone"></span>
				</div>
			<?php endif; ?>
            <div class="booking_form_section">
                <h3>Activity Choice</h3>
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
				<div>
				<label>Activity</label><span id="activityName"></span>
				</div>
				<div>
				<label>Activity Fee</label><span id="activityCost"></span>
				</div>
				<div>
				<label>Spaces</label><span id="activitySpaces"></span>
				</div>
            </div>
            <div class="booking_form_section">
                <h3>Food Choices</h3>
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
				<input type="submit" value="Create Booking"/>
			</div>
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