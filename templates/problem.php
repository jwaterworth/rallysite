<?php
include (COMMON_TEMPLATES."/header.php");

$issueReceived = false;
$error = false;

if(isset($_POST['issueTitle']) && $_POST['issueTitle']) {
	
	$emailer = new Email();
	$title = isset($_POST['issueTitle']) ? htmlspecialchars($_POST['issueTitle']) : "Unknown";
	$details = isset($_POST['issueDetails']) ? htmlspecialchars($_POST['issueDetails']) : "Unknown";
	$name = isset($_POST['reporterName']) ? htmlspecialchars($_POST['reporterName']) : "Unknown";
	$club = isset($_POST['reporterClub']) ? htmlspecialchars($_POST['reporterClub']) : "Unknown";
	$email = isset($_POST['reporterEmail']) ? htmlspecialchars($_POST['reporterEmail']) : "Unknown";
	
	$result = $emailer->SendProblemEmail($title, $details, $name, $club, $email);
	echo $result;
	if($result) {
		$issueReceived = true;
		
	} else {
		$error = true;
	}	
}

?>

<h3 class="page_title">Report a problem</h3>

<div class="booking_page">
	<div class="issue">
	<?php if($error) : ?>
		<p>An error occurred submitting your booking, please contact the site team on <a href="mailto:rallysupport@ssago.org.uk">rallysupport@ssago.org.uk</a></p>
	<?php endif ?>
	<?php if(!$issueReceived) :?>
	<form name="bookingForm" action=".?&action=reportaproblem" method="POST">
		<div>
		<label>Nature of issue</label><input required type="text" name="issueTitle"/>
		</div>
		<div>
		<label>Details</label><textarea required cols="20" rows="10" name="issueDetails"></textarea>
		</div>
		<div>
		<label>Name<label><input type="text" required name="reporterName"/>
		</div>
		<div>
		<label>Club<label><input type="text" required name="reporterClub"/>
		</div>
		<div>
		<label>Email Address<label><input type="email" name="reporterEmail"/>
		</div>
		<div>
		<input type="submit" value="Report"/>
		</div>
	</form>
	<?php else: ?>
		<p>Thanks for getting in touch. The details of your problem have been sent to the site team who will be in touch shortly.</p>	
	<?php endif; ?>
	</div>
</div>

<?php
    include (COMMON_TEMPLATES."/footer.php");
?>
