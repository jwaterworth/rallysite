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
					<iframe class="google_maps_iframe" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Melton+Mowbray&amp;aq=0&amp;oq=melt&amp;sll=52.768293,-0.886116&amp;sspn=0.088802,0.264187&amp;ie=UTF8&amp;hq=&amp;hnear=Melton+Mowbray,+Leicestershire,+United+Kingdom&amp;t=m&amp;z=14&amp;ll=52.766404,-0.887126&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.uk/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Melton+Mowbray&amp;aq=0&amp;oq=melt&amp;sll=52.768293,-0.886116&amp;sspn=0.088802,0.264187&amp;ie=UTF8&amp;hq=&amp;hnear=Melton+Mowbray,+Leicestershire,+United+Kingdom&amp;t=m&amp;z=14&amp;ll=52.766404,-0.887126" style="color:#0000FF;text-align:left">View Larger Map</a></small>
				</div>
            </div>
        </div>
    </div>
</div>
    
<?php
endif;
include (COMMON_TEMPLATES."/footer.php");
?>
