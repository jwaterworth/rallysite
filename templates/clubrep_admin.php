<?php
include (COMMON_TEMPLATES."/header.php");
require_once(PAGE_CONTROLLERS."/ClubRepAdminPageController.inc.php");
$controller = new ClubRepAdminPageController();

$entry = isset( $_GET['entry'] ) ? $_GET['entry'] : "";
    
    switch($entry) {
        case 'approvemember':
            $controller->ApproveClubMember($_GET['id']);
            break;
    }

$controller->GetClubData();
?>

<h3 class="page_title"><?php echo $controller->data['club']?> Administration</h3>

<div class="booking_page">
        <?php if ($controller->errorMessage != null ) : ?>
            <p><?php echo $controller->errorMessage ?></p>
        <?php else : ?>         
            <?php if(!$controller->CheckAuth(CLUBREP)) : ?>
                <p>You must be a club representative to view this page.</p>
            <?php else : ?>
                <div class="normalise_tabs">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Club Accounts</a></li>
                        </ul>
                        <div id="tabs-1">
                            <p>Awaiting Approval</p>
							<?php if(count($controller->data['unapproved']) > 0) : ?>
                            <?php foreach($controller->data['unapproved'] as $account) : ?>
                                <ul class="member_list">
                                    <li><?php echo htmlspecialchars($account['name']) ?></li>
                                    <li class="member_email"><a href="mailto:<?php echo htmlspecialchars($account['email']) ?>"><?php echo htmlspecialchars($account['email']) ?></a></li>
                                    <li class="member_phone"><?php echo htmlspecialchars($account['phone']) ?></li>
                                    <li class="tick"><a href=".?action=clubrepadmin&entry=approvemember&id=<?php echo $account['id'] ?>"><img class="tick" src="images/tick.png"/></a></li>
                                    <li class="tick"><a href="#"><img class="tick" src="images/cross.png"/></a></li>
                                </ul>   
                            <?php endforeach; ?> 
							<?php endif; ?>
                            <p class="club_header">Club Members</p>
							<?php if(count($controller->data['approved']) > 0 ) : ?>
                            <?php foreach($controller->data['approved'] as $account) : ?>
                                <ul class="member_list">
                                    <li><?php echo htmlspecialchars($account['name']) ?></li>
                                    <li class="member_email"><a href="mailto:<?php echo htmlspecialchars($account['email']) ?>"><?php echo htmlspecialchars($account['email']) ?></a></li>
                                    <li><?php echo htmlspecialchars($account['phone']) ?></li>
									<li><a href=".?action=newclubmember&userid=<?php echo $account['id'] ?>">Update Details</a></li>
                                </ul>
                            <?php endforeach; ?>
							<?php endif; ?>
                            <p class="club_header"></p>
                        </div>
                    </div>
                </div>
        <?php endif; endif;?>
</div>
<?php       
    include (COMMON_TEMPLATES."/footer.php");
?>