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
					<div>
						<p>Willesley Campsite, Willesley Woodside, Willesley,Ashby De La Zouch,Leicestershire, LE65 2UP</p>
					</div>
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2416.2307723951876!2d-1.497059!3d52.72802799999999!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4879fe799fb08dad%3A0x17148348abb3382d!2sWillesley+Scout+Campsite!5e0!3m2!1sen!2suk!4v1413844796359" class="google_maps_iframe" frameborder="0" style="border:0"></iframe>
				</div>
            </div>
        </div>
    </div>
</div>
    
<?php
endif;
include (COMMON_TEMPLATES."/footer.php");
?>
