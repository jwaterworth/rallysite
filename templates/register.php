<?php
include (COMMON_TEMPLATES."/header.php");
require_once(PAGE_CONTROLLERS."/RegisterPageController.inc.php");
$eventId = isset( $_GET['event'] ) ? $_GET['event'] : "1";
$controller = new RegisterPageController($eventId);
$controller->GeneratePageData();
?>

<?php if($controller->data['edit']) : ?>
    <h3 class="page_title">Edit Account</h3>
<?php else : ?>
    <h3 class="page_title">Member Registration</h3>
<?php endif; ?>

<div class="booking_page">
    <?php $account = null; if($controller->data['edit']) : ?>
	<?php
		{
			$account = $controller->data['account'];
		}			
    ?>
    <div class="registration_info">
        <p>Update your account details here.</p>
    </div>
    <?php else : ?>
    <div class="registration_info" >
        <p>Once registered, your account must be approved by the club representative of the club you specify below</p>
    </div>
    <?php endif; ?>
    <div id="registration_form" class="registration_form">
        <form method="POST" action=".?event=<?php echo $controller->data['eventID']?>&action=entry&form=<?php echo $controller->data['edit'] ? "update_details" : "register"?>">
            <div class="form_details">
                <h3 class="form_details">Login Details</h3>
                <div>
                    <label for="email">Email</label>
                    <input type="text" id="email" name="userEmail" required value="<?php if($account) echo $account['email'] ?>"/>
                    <span id="emailInfo">Please enter a valid e-mail address, you will need it to log in!</span>
                </div>
				<div>
                    <label for="email">Confirm Email</label>
                    <input type="text" id="confirmEmail" required value="<?php if($account) echo $account['email'] ?>"/>
                    <span id="confirmEmailInfo">Please confirm your email address.</span>
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
					<!--
                    <label>Password: ******</label>
                    <a href="#">Change Password</a>
					-->
                </div>
                <?php endif; ?>
            </div>
            <div class="form_details">
                <h3 class="form_details">Personal Details</h3>
                <div>
                    <label>Name</label>
                    <input type="text" id="name" name="userName" required value="<?php echo $account['name'] ?>"/>
                    <span id="nameInfo"></span>
                </div>
                <div>
                    <label>Phone Number</label>
                    <input type="text" id="phone" name="userPhone" required maxlength="30" value="<?php echo $account['number'] ?>"/>
                    <span id="phoneInfo"></span>
                </div>
                <div>
                    <label>Address</label>
                    <textarea cols="20" rows="5" id="address" required name="userAddress"><?php echo $account['address'] ?></textarea>
                </div>
                <div>
                    <label>Date of birth</label>
                    <input type="text" id="datepicker" name="userDOB" required placeholder="dd/mm/yyyy" value="<?php echo $account['dob'] ?>"/>
					<span id="dobInfo"></span>
                </div>
                <div>
                    <label>Medical Conditions</label>
                    <textarea cols="20" rows="5" id="medicalCond" name="userMedicalCond"><?php echo $account['medicalCond'] ?></textarea>
                    <span id="medicalCondInfo"></span>
                </div>
                <div>
                    <label>Dietary Requirements</label>
                    <textarea cols="20" rows="5" id="dietaryReq" name="userDietaryReq"><?php echo $account['dietaryReq'] ?></textarea>
                </div>
            </div>
            <div class="form_details">
                <h3 class="form_details">Emergency Contact Details</h3>
                <div>
                    <label>Name</label>
                    <input type="text" id="emergName" name="emergName" required value="<?php echo $account['emergName'] ?>"/>
                    <span id="emergNameInfo"></span>
                </div>
                <div>
                    <label>Relationship</label>
                    <input type="text" id="emergRel" name="emergRel" required value="<?php echo $account['emergRelationship'] ?>"/>
                    <span id="emergRelInfo"></span>
                </div>
                <div>
                    <label>Phone Number</label>
                    <input type="text" id="emergPhone" name="emergPhone" required value="<?php echo $account['emergPhone'] ?>"/>
                    <span id="emergPhoneInfo"></span>
                </div>
                <div>
                    <label>Address</label>
                    <textarea cols="20" rows="5" id="emergAddress" required name="emergAddress"><?php echo $account['emergAddress'] ?></textarea>
                </div>
            </div>
            <?php if(!$controller->data['edit']) :?>
            <div class="form_details">
                <h3 class="form_details">Club</h3>
                <select name="clubID">
                    <?php foreach($controller->data['clubs'] as $club) : ?>
                    <option value="<?php echo $club['id']?>"><?php echo $club['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="submit" value="Register"/>
            <?php else : ?>
            <input type="submit" value="Update"/>        
            <?php endif; ?>
        </form>
        </div>
</div>


<?php
    include (COMMON_TEMPLATES."/footer.php");
?>