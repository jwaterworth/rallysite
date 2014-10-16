<?php
include (COMMON_TEMPLATES."/header.php");
require_once(PAGE_CONTROLLERS."/NewClubMemberPageController.inc.php");
$eventId = isset( $_GET['event'] ) ? $_GET['event'] : "1";
$userId = isset( $_GET['userId'] ) ? $_GET['userId'] : null;
$controller = new NewClubMemberPageController($eventId, $userId);
$controller->GeneratePageData();
?>

<?php if($controller->data['edit']) : ?>
    <h3 class="page_title">Edit Club Member</h3>
<?php else : ?>
    <h3 class="page_title">Club Member Registration</h3>
<?php endif; ?>

<div class="booking_page">
	<?php $account = null; if($controller->data['edit']) : ?>
	<?php
		{
			$account = $controller->data['account'];
		}			
    ?>
	<div class="registration_info">
        <p>Update member account details here.</p>
    </div>
	
	<?php endif;?>	
	<div id="registration_form" class="registration_form">
        <form method="POST" action=".?event=<?php echo $controller->data['eventID']?>&action=entry&form=<?php echo $controller->data['edit'] ? "update_details" : "newclubmember"?>">
			<div class="form_details">
                <h3 class="form_details">Login Details</h3>
                <div>
                    <label for="email">Email</label>
                    <input type="text" id="email" name="userEmail" required value="<?php if($account) echo $account['email'] ?>"/>
                    <span id="emailInfo">Please enter a valid e-mail address. This will be used by the member to log in.</span>
                </div>
                <?php if(!$controller->data['edit']) : ?>
                <div>
                    <label>Password</label>
                    <input type="password" id="password1" name="userPassword" required/>
                    <span id="pass1Info">At least 5 characters: letters, numbers and '_'</span>
                </div>
                <div>
                    <label>Confirm Password</label>
                    <input type="password" id="password2" name="userPassword2" required/>
                    <span id="pass2Info">Confirm password</span>
                </div>
                <?php else:  ?>
                <div>
                    <label>Password: ******</label>
                    <a href="#">Change Password</a>
                </div>
                <?php endif; ?>
			</div>
            <div class="form_details">
                <h3 class="form_details">Personal Details</h3>
				<div>
					<label>Name</label>
					<input type="text" id="name" name="userName" required value="<?php if($account) echo $account['name'] ?>"/>
					<span id="nameInfo"></span>
				</div>
				<div>
					<label>Phone Number</label>
					<input type="text" id="phone" name="userPhone" required maxlength="30" value="<?php if($account) echo $account['number'] ?>"/>
					<span id="phoneInfo"></span>
				</div>
				<div>
					<label>Address</label>
					<textarea cols="20" rows="5" id="address" required name="userAddress"><?php if($account) echo $account['address'] ?></textarea>
				</div>
				<div>
					<label>Date of birth</label>
					<input type="text" id="datepicker" name="userDOB" required placeholder="dd/mm/yyyy" value="<?php if($account) echo $account['dob'] ?>"/>
				</div>
				<div>
					<label>Medical Conditions</label>
					<textarea cols="20" rows="5" id="medicalCond" name="userMedicalCond"><?php if($account) echo $account['medicalCond'] ?></textarea>
					<span id="medicalCondInfo"></span>
				</div>
				<div>
					<label>Dietary Requirements</label>
					<textarea cols="20" rows="5" id="dietaryReq" name="userDietaryReq"><?php if($account) echo $account['dietaryReq'] ?></textarea>
				</div>
            </div>
            <div class="form_details">
                <h3 class="form_details">Emergency Contact Details</h3>
                <div>
                    <label>Name</label>
                    <input type="text" id="emergName" name="emergName" required value="<?php if($account) echo $account['emergName'] ?>"/>
                    <span id="emergNameInfo"></span>
                </div>
                <div>
                    <label>Relationship</label>
                    <input type="text" id="emergRel" name="emergRel" required value="<?php if($account) echo $account['emergRelationship'] ?>"/>
                    <span id="emergRelInfo"></span>
                </div>
                <div>
                    <label>Phone Number</label>
                    <input type="text" id="emergPhone" name="emergPhone" required value="<?php if($account) echo $account['emergPhone'] ?>"/>
                    <span id="emergPhoneInfo"></span>
                </div>
                <div>
                    <label>Address</label>
                    <textarea cols="20" rows="5" id="emergAddress" required name="emergAddress"><?php if($account) echo $account['emergAddress'] ?></textarea>
                </div>
            </div>
            <?php if(!$controller->data['edit']) :?>
            <input type="submit" value="Create"/>
            <?php else : ?>
            <input type="submit" value="Update"/>        
            <?php endif; ?>
        </form>
        </div>
	
</div>