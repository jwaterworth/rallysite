<?php
    include (COMMON_TEMPLATES."/header.php");
    require_once(PAGE_CONTROLLERS."/ActivityPageController.inc.php");
    $eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
    $controller = new ActivityPageController($eventID);
?>
<h3 class="page_title"> Activities</h3>
<div class="activity_page">
<?php if($controller->errorMessage != null) : ?>
    <div class="error">
        <p><?php echo $controller->errorMessage ?></p>
    </div>
<?php else : ?>
	
    <div class="activity_brief">
        <p> <?php echo $controller->data['brief'] ?> </p>
    </div>	
    <?php
        foreach($controller->data['activities'] as $activity) : ?>
            <div class="activity">
                <a name="<?php echo $activity['id'] ?>"></a>
				<h2><?php echo $activity['name'] ?></h2>
                <div class="activity_left">					
                    <img class="activity_image" src="<?php echo $activity['imageLoc'] ?>" alt="Activity Image"></img>
                    <p class="activity_body">Cost: £<?php echo $activity['cost'] ?> </p>
                    <p class="activity_body">Capacity: <?php echo $activity['capacity'] ?></p>
                    <p class="activity_body">Current Number: <?php echo $activity['spacesTaken'] ?></p>
                </div>
                <div class="activity_right">
                    
                    <p class="activity_body"><?php echo $activity['description'] ?> </p>
                </div>
                <div class="activity_footer"></div>
            </div>
    <?php endforeach; endif; ?>
</div>
<?php
    include (COMMON_TEMPLATES."/footer.php");
?>
