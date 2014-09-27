<head>
    <link rel="stylesheet" type="text/css" href="http://co-project.lboro.ac.uk/users/cojw3/ssago/common_styles.css"/>
    <link rel="stylesheet" type="text/css" href="http://co-project.lboro.ac.uk/users/cojw3/ssago/information_styles.css"/>
    <link rel="stylesheet" type="text/css" href="http://co-project.lboro.ac.uk/users/cojw3/ssago/form_styles.css"/>
</head>
<body>
    <div class="container">
        <?php
        require_once(PAGE_CONTROLLERS."/BookingSummaryPageController.inc.php");
        $eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
        $bookingID = isset( $_GET['id'] ) ? $_GET['id'] : null;
        $controller = new BookingSummaryPageController($eventID, $bookingID);
        $controller->GeneratePageData();
        $booking = $controller->data['booking'];
        ?>

        <p class="page_title">Booking Summary</p>

        <div class="booking_page">
        <?php if($controller->errorMessage != null) : ?>
            <div class="error">
                <p><?php echo $controller->errorMessage ?></p>
            </div>
        <?php else : ?>
            <p>Name: <?php echo $booking['userName']?></p>
            <p>Activity: <?php echo $booking['activityName'] ?></p>
            <p>Price Breakdown: </p>
            <p>Total: <?php echo $booking['bookingFee'] ?></p>
            <p>Base fee (at time of booking): <?php echo $booking['baseFee']?></p>
            <p>Activity Cost: <?php echo $booking['activityCost'] ?></p>
        <?php endif; ?>
        </div>
    </div>
</body>