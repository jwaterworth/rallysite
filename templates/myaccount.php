<?php
include (COMMON_TEMPLATES."/header.php");
require_once(PAGE_CONTROLLERS."/AccountPageController.inc.php");
$eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
$controller = new AccountPageController($eventID);

//Check for any posted errors
$error = isset($_POST['login_error']) ? $_POST['login_error'] : null;
?>

<h3 class="page_title">My Account</h3>


<div class="account_page">
<?php if(!$controller->GetAccountDetails()) : ?>
	<div class="logged_out_page">
		<div class="login_form">
			<form id="login_form" method="post" action=".?event=<?php echo $controller->data['eventID']?>&action=entry&form=login">
					<p class="login_header">Login</p>
						<p style="display: inline-block; width: 75px; margin-top: 5px;">Email:</p>
						<input type="email" name="username" required="required" />
						<div class="clear"></div>
						<p style="display: inline-block; width: 75px; margin-top: 5px;">Password:</p>
						<input type="password" name="password"  required="required"/>
						<div class="clear"></div>
					<input type="submit" value="Login" />
					<?php if ($error != null) :?>
						<p><?php echo $error ?></p>
					<?php endif; ?>	
			</form>
		</div>
		<div class="create_account">
				<p class="login_header">Create an Account</p>
				<p>Once you have created an account your may access restricted pages and create bookings.</p>
				<a class="booking_button" href=".?event=<?php echo $controller->data['eventID']?>&action=register"><span>Create</span></a>
		</div>
		<div class="clear"></div>
		<div class="error">
			<p><?php echo $controller->errorMessage ?></p>
		</div>
	</div>
<?php else : ?>
        <div class="form_details">
            <h3 class="form_details">Login Details <a class="details_header" href='.?action=editaccount'>edit</a></h3>
            <p class="account_detail">Email: <?php echo $controller->data['email'] ?></p>
            <p class="account_detail">Password: ****** <a href="#">Change Password</a></p>
        </div>
        <div class="form_details">
            <h3 class="form_details">Personal Details <a class="details_header" href='.?action=editaccount'>edit</a></h3>
            <p class="account_detail">Name: <?php echo $controller->data['name'] ?></p>
            <p class="account_detail">Phone: <?php echo $controller->data['phone'] ?></p>
            <p class="account_detail">Address: <?php echo $controller->data['address'] ?></p>
            <p class="account_detail">Dietary Requirements: <?php echo $controller->data['dietaryReq'] ?></p>
            <p class="account_detail">Medical Details: <?php echo $controller->data['medicalCond'] ?></p>
        </div>
        <div class="form_details">
            <h3 class="form_details">Account Information</h3>
            <p class="account_detail">Club: <?php echo $controller->data['clubName'] ?></p>
            <p class="account_detail">Account Type: <?php echo $controller->data['accountTypeName'] ?></p>
        </div>
    </div>
<?php endif; ?>

<?php
    include (COMMON_TEMPLATES."/footer.php");
?>
