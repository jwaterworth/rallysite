<?php
    include (COMMON_TEMPLATES."/header.php");
    require_once(PAGE_CONTROLLERS."/EventPageController.inc.php");
    $eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
    $controller = new EventPageController($eventID);
?>
<h3 class="page_title"><?php echo $controller->data['name'] ?> - Event Information</h3>
<div class="event_information">
<?php if($controller->errorMessage != null) : ?>
    <div class="error">
        <p><?php echo $controller->errorMessage ?></p>
    </div>
<?php else : ?>
    <div class="normalise_tabs">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Information</a></li>
                <li><a href="#tabs-2">Directions</a></li>
            </ul>
            <div id="tabs-1">
                <div class="event_summary">
					<h2>Summary</h2>
                    <p> <?php echo $controller->data['summary'] ?> </p>
                </div>
                <div class="event_body">
					<h2>Important Information</h2>
                    <p> <?php echo $controller->data['info'] ?> </p>
                </div>
                <img src="<?php echo $controller->data['logoLoc']?>"/>
            </div>
            <div id="tabs-2">
				<div class="map_container">					
					<iframe class="google_maps_iframe" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2416.232379395157!2d-1.4970320000000028!3d52.7279989999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4879fe799fa413fb%3A0x27578e9a47e31ee3!2sWillesley+Scout+Campsite%2C+Willesley+Woodside%2C+Willesley%2C+Ashby-de-la-Zouch%2C+Leicestershire+LE65+2UP!5e0!3m2!1sen!2suk!4v1412714746674"></iframe>
				</div>
            </div>
        </div>
    </div>
</div>
    
<?php
endif;
include (COMMON_TEMPLATES."/footer.php");
?>
