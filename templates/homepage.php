<?php
include (COMMON_TEMPLATES."/header.php");
require_once(PAGE_CONTROLLERS."/HomepageController.inc.php");
$eventID = isset( $_GET['event'] ) ? $_GET['event'] : "";
$eventID = isset( $_POST['event'] ) ? $_POST['event'] : $eventID;
$controller = new HomepageController(1);
?>

<h3 class="page_title">News and Updates</h3>
<div class="home_page">     
    <?php if($controller->errorMessage != null) : ?>
    <div class="error">
        <p><?php echo $controller->errorMessage ?></p>
    </div>
    <?php else : ?>
    <div class="news_posts">
        <?php foreach($controller->data['newsPosts'] as $newsPost) :?>
                <div class="news_post">
                    <a name="<?php echo $newsPost['newsId'] ?>"></a>
                    <a href=".?action=newspost&newsid=<?php echo $newsPost['newsId'] ?>"><p class="news_title"> <?php echo $newsPost['title'] ?> </p></a>
                    <p class="news_author"> <?php echo $newsPost['timestamp'] ?> | <?php echo $newsPost['author'] ?> </p>
                    <p> <?php echo $newsPost['body'] ?> </p>
                    <?php if($controller->CheckAuth(EVENTEXEC, false)) : ?>
                        <p><a href=".?event=<?php echo $controller->data['eventID'] ?>&action=adminentry&form=deletenews&newsid=<?php echo $newsPost['newsId']?>">Delete Post</a></p>
                    <?php endif; ?>
                </div>
        <?php endforeach;?>
                
    </div>
    <div class="side_bar">
        <?php if($controller->data['activityError'] != null) : ?>
            <p><?php echo $controller->data['activityError'] ?></p>
        <?php else :?>
            <?php foreach($controller->data['activities'] as $activity) : ?>
                <div class="side_bar_box side_bar_activity">
                    <p class="side_bar_header side_bar_external"><?php echo $activity['name'] ?></p>
                    <a href=".?event=<?php echo $controller->data['eventID']?>&action=activities#<?php echo $activity['id'] ?>">
                        <img src="<?php echo $activity['imgLoc'] ?>"/>
                        <p class="side_bar_text">Try <?php echo $activity['name'] ?>...Click here!</a></p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="side_bar_box side_bar_clear">
            <a href="http://www.facebook.com" target="_blank"><img class="side_bar_image" src="images/Find_us_on_Facebook.jpg"/></a>
        </div>
        <div class="side_bar_box side_bar_clear">
            <img src="http://co-project.lboro.ac.uk/users/cojw3/ssago/images/ssago_logo.jpg" />
            <!--<a href="http://www.beyond21.co.uk/ssago/"></a>-->
        </div>
    </div>
    <?php endif; ?>
    <div class="news_footer"></div>
</div>
<?php
include (COMMON_TEMPLATES."/footer.php");
?>
