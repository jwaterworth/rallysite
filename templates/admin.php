<?php
include (COMMON_TEMPLATES."/header.php");
require_once(PAGE_CONTROLLERS."/AdminPageController.inc.php");
$eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
$controller = new AdminPageController($eventID);
$controller->GetPageData();
?>

<h3 class="page_title">Event Administration</h3>

<div class="booking_page">
        <?php if ($controller->errorMessage != null ) : ?>
            <p>Error: '<?php echo $controller->errorMessage ?>' occurred, please contact the web master</p>
        <?php else : ?>         
            <?php if(!$controller->CheckAuth(EVENTEXEC)) : ?>
                <p>You must be an event executive member to view this page.</p>
            <?php else : ?>
                <div class="normalise_tabs">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">News and Updates</a></li>
                            <li><a href="#tabs-2">Event Information</a></li> 
                            <li><a href="#tabs-3">Booking Information</a></li>
                            <li><a href="#tabs-4">Activities</a></li>
							<li><a href="#tabs-5">Manage Bookings</a></li>
                            <li><a href="#tabs-6">Downloads</a></li>
                        </ul>
                        <div id="tabs-1">
                            <div class="admin_entry">
                                <form name="newsPost" action=".?event=<?php echo $controller->data['eventID'] ?>&action=adminentry&form=news" method="POST">
                                    <div>
                                        <label for="newsTitle">Title</label>
                                        <input type="text" name="newsTitle"/><br/>
                                    </div>
                                    <div>
                                        <label for="newsBody">Body</label>
                                        <textarea cols="80" rows="20" name="newsBody"></textarea>
                                    </div>
                                    
                                    <input type="hidden" name="timestamp" value="2012-05-13"/>
                                    <input type="hidden" name="userid" value="1"/>
                                    <input type="hidden" name="eventid" value="1"/>
                                    <input type="submit" value="Submit"/>
                                </form>

                            </div>
                        </div>
                        <div id="tabs-2">
                            <div class="admin_entry"> 
                                <form class="event_information_form" enctype="multipart/form-data" action=".?event=<?php echo $controller->data['eventID'] ?>&action=adminentry&form=eventinfo" method="POST">
                                    <input type="hidden" name="eventID" value="<?php echo $controller->data['eventID'] ?>"/>
                                    <input type="hidden" name="bookingInfoID" value="<?php echo $controller->data['bookingInfoID'] ?>"/>
                                    <input type="hidden" name="activityPageID" value="<?php echo $controller->data['activityPageID'] ?>"/>
                                    <div>
                                        <label for="eventName">Event Name</label>
                                        <input type="text" name="eventName" required="required" value="<?php echo $controller->data['eventName'] ?>"/>
                                    </div>
                                    <div>
                                        <label for="eventSummary">Event Summary</label>
                                        <textarea cols="100" rows="10" name="eventSummary"><?php echo $controller->data['eventSummary'] ?></textarea>
                                    </div>
                                    <div> 
                                        <label for="eventInfo">Event Information</label>
                                        <textarea cols="100" rows="20" name="eventInfo"><?php echo $controller->data['eventInfo'] ?></textarea>
                                    </div>
                                    <img src="<?php $controller->data['eventLogo'] ?>"/>
                                    <input type="hidden" name="currLogo" value="<?php $controller->data['eventLogo']?>"/> 
                                    <?php /*<div>
                                        <label for="upload">Select a file...</label>
                                        <input type="file" name="upload" size="30"><br clear="all"> 
                                        <label for="name">New name?</label>
                                        <input type="text" name="name" size="20"> 
                                        (without extension!) <br clear="all">
                                        <label for="replace">Replace ?</label>
                                        <input type="checkbox" name="replace" value="y"><br clear="all">
                                        <label for="check">Validate filename ?</label>
                                        <input name="check" type="checkbox" value="y" checked><br clear="all">
                                    </div>*/?>
                                    <input type="submit" value="Update"/>
                                </form>
                            </div>
                        </div>
                        <div id="tabs-3">
                            <div class="admin_entry">
                                <form class="booking_info_form" action=".?event=<?php echo $controller->data['eventID'] ?>&action=adminentry&form=bookinginfo" method="POST">
                                    <input type="hidden" name="bookingInfoID" value="<?php echo $controller->data['bookingInfoID'] ?>"/>
                                    <div>
                                        <label for="bookingSummary">Booking Summary</label>
                                        <textarea cols="80" rows="10" name="bookingSummary"><?php echo $controller->data['bookingSummary'] ?></textarea>
                                    </div>

                                    <div>
                                        <label for="bookingInformation">Booking Information</label>
                                        <textarea cols="80" rows="20" name="bookingInformation"><?php echo $controller->data['bookingInfo'] ?></textarea>
                                    </div>
                                    <input type="submit" value="Update"/>
                                </form>
                            </div>  
                        </div>
                        <div id="tabs-4">
                            <div class="admin_entry">
                                <form class="activitypage_info_form" action=".?event=<?php echo $controller->data['eventID'] ?>&action=adminentry&form=activitypage" method="POST">
                                    <input type="hidden" name="activityPageID" value="<?php echo $controller->data['activityPageID'] ?>"/>
                                    <div>
                                        <label>Activity Page Brief:</label>
                                        <textarea cols="80" rows="10" name="activityPageBrief"><?php echo $controller->data['activityPageBrief'] ?></textarea>
                                    </div>
                                    <input type="submit" value="Update" />
                                </form>
                                <form class="activity_form" action=".?event=<?php echo $controller->data['eventID'] ?>&action=adminentry&form=activity" enctype="multipart/form-data" method="POST">
                                    <fieldset>
                                        <legend>New Activity</legend>
                                        <input type="hidden" name="activityPageID" value="<?php echo $controller->data['activityPageID'] ?>"/>
                                        <div>
                                            <label>Name:</label>
                                            <input type="text" name="activityName" />
                                        </div>
                                        <div>
                                            <label>Description:</label>
                                            <textarea cols="80" rows="10" name="activityDescription"></textarea>
                                        </div>
                                        <div>
                                            <label>Capacity:</label>
                                            <input type="text" name="activityCapacity"/>
                                        </div>
                                        <div>
                                            <label>Cost:</label>
                                            <input type="text" name="activityCost" />
                                        </div>
                                        <div>
                                            <label for="activity_upload">Select a file...</label>
                                            <input type="file" name="activity_upload" size="30"><br clear="all"> 
                                            <label for="name">New image name?</label>
                                            <input type="text" name="name" size="20"> 
                                            (without extension!) <br clear="all">
                                        </div>
                                        <input type="submit" value="Create" />
                                    </fieldset>
                                </form>
                            </div>
                        </div>
						<div id="tabs-5">
                            <h3>Manage Bookings</h3>
							
							<h4>Update a booking</h4>
							<div>
								<label for="sltClubs">Club:</label><select id="sltClubs"></select>
							</div>
							<div>
								<label for="sltClubBookings">Club Bookings:</label><select id="sltClubBookings"></select>
							</div>							
                        </div>
                        <div id="tabs-6">
                            <p><?php echo $controller->data['eventName'] ?> Participants</p>
                            <ul>
                                <li><a href=".?event=<?php echo $controller->data['eventID']?>&action=download&type=<?php echo PARTICIPANT_LIST ?>">Download Participants</a></li>
                            </ul>
                            <p>Activity Lists</p>
                            <ul>
                                <?php foreach($controller->data['activity_downloads'] as $activity) : ?>
                                <li><a href=".?event=<?php echo $controller->data['eventID']?>&action=download&type=<?php echo ACTIVITY_LIST ?>&id=<?php echo $activity['id']?>"><?php echo $activity['name']?> (<?php echo $activity['number']?>)</a></li>
                                <?php endforeach ?>                                
                            </ul>
                        </div>
                    </div>    
                </div>
            <?php endif; endif;?>
        </div>
		<script type="text/javascript" src="scripts/event_admin.js"></script>
<?php       
    include (COMMON_TEMPLATES."/footer.php");
?>
