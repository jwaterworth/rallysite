<!DOCTYPE html>
<?php 
require_once(PAGE_CONTROLLERS."/HeaderController.inc.php");
$eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
$eventID = isset( $_POST['event'] ) ? $_POST['event'] : $eventID;
$controller = new HeaderController(1);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        
        <script src="jquery/jquery.js" type="text/javascript"></script>
        <script src="ajax_functions.js" type="text/javascript"></script>
        <script src="validation.js" type="text/javascript"></script>
        
        <!-- facebox -->
        <link href="jquery/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="jquery/facebox/facebox.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function($) {
				$('a[rel*=facebox]').facebox({
					loadingImage : 'jquery/facebox/loading.gif',
					closeImage   : 'jquery/facebox/closelabel.png'
				})           
            })
        </script>
        <!-- end of facebox -->
        
        <link rel="stylesheet" type="text/css" href="jquery/css/tabs.css"/>
        <link rel="stylesheet" type="text/css" href="jquery/css/scrollable-vertical.css"/>
        
        <!-- jQuery UI -->
        <link type="text/css" href="jquery/jqueryui/css/south-street/jquery-ui-1.8.20.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="jquery/jqueryui/js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="jquery/jqueryui/js/jquery-ui-1.8.20.custom.min.js"></script>
        
        
        <!-- end of jQuery UI -->
        
        <!-- jQuery Tools -->
        <script src="jquery/jquery.tools.min.js"></script>
        <!-- end of jQuery Tools-->

		<link rel="stylesheet" type="text/css" href="styles/common_styles.css"/>
        <link rel="stylesheet" type="text/css" href="styles/information_styles.css"/>
        <link rel="stylesheet" type="text/css" href="styles/form_styles.css"/>
        
        <script type="text/javascript">
        // perform JavaScript after the document is scriptable.
        $(function() {
            // setup ul.tabs to work as tabs for each div directly under div.panes
            //$("ul.tabs").tabs("div.panes > div.pane");
            $( "#selectable" ).selectable({
				stop: function() {
					$( ".ui-selected", this ).each(function() {
						var index = $(this).attr("activityID");
						//$( "#activityID" ).val(index);
						getActivityDetails(index);
						$('#activityInput').val(index);
					}); 
				}                        
			});
			
			// Tabs
			$( "#tabs" ).tabs({
			//cookie: {
				// store cookie for a day, without, it would be a session cookie
				//expires: 1
			//}
			});
                
			$( "#datepicker" ).datepicker({
				dateFormat: "dd/mm/yy",
				defaultDate: '-22y',
			});
        });
        </script>
        <title><?php echo $controller->data['eventName'] ?></title>
    </head>
    <body>
        <div class="container">
           <div class="header">
                <div class="account_signout">
                    <?php if($controller->data['loggedin'] != null) : ?>
                        <?php if(isset($controller->data['club']) && $controller->data['club'] != null) :?>
                            <p class="account_link"><a href=".?action=clubrepadmin"><?php echo $controller->data['club'] ?></a> | <a href=".?action=myaccount"><?php echo $controller->data['name'] ?></a> | <a href=".?event=<?php echo $controller->data['eventID']?>&action=logout">Logout</a></p>
                        <?php else : ?>
                            <p class="account_link"><a href=".?action=myaccount"><?php echo $controller->data['name'] ?></a> | <a href=".?event=<?php echo $controller->data['eventID']?>&action=logout">Logout</a></p>
                        <?php endif; ?>
                    <?php else : ?>
                    <p class="account_link"><a href=".?event=<?php echo $controller->data['eventID']?>&action=myaccount">Sign In</a></p>
                    <?php endif; ?>
                </div>
				<div class="title_container">
					<div class="left_logo">
						<a href="index.php?event=<?php echo $controller->data['eventID']?>"><img src="images/badge_purple.png" alt="SSAGO Logo"/></a>
					</div>
					<div class="event_title">
						<h1><?php echo $controller->data['eventName'] ?></h1>
						<h4><?php echo sprintf("%s - %s", $controller->data['eventStartDate'], $controller->data['eventEndDate']) ?></h4>
					</div>	
					<div class="event_date">
						
					</div>
					<div class="right_logo">
						<a href="index.php?event=<?php echo $controller->data['eventID']?>"><img src="images/badge_green.png" alt="SSAGO Logo"/></a>
					</div>
					<div class="clear"></div>
				</div>              
            
				<div class="clear"></div>
				<div class="menu">
					<ul>
						<li><a href="index.php?event=<?php echo $controller->data['eventID'] ?>">News</a></li>
						<li><a href=".?event=<?php echo $controller->data['eventID'] ?>&action=eventinfo">Event Information</a></li>
						<li><a href=".?event=<?php echo $controller->data['eventID'] ?>&action=bookinginfo">Bookings</a></li>
						<li><a href=".?event=<?php echo $controller->data['eventID'] ?>&action=activities">Activities</a></li>
						<li><a href=".?event=<?php echo $controller->data['eventID'] ?>&action=participants">Who's Going</a></li>
						<li><a href=".?event=<?php echo $controller->data['eventID'] ?>&action=admin">Admin</a></li>
					</ul>
				</div>
			</div>
            <div class="content">
