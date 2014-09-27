<?php
include (COMMON_TEMPLATES."/header.php");
require_once(PAGE_CONTROLLERS."/NewsPostPageController.inc.php");

$newsPostID = isset($_GET['newsid']) ? $_GET['newsid'] : "";

$controller = new NewsPostPageController($newsPostID);
?>
<div class="booking_page">     
    <?php if($controller->errorMessage != null) : ?>
        <div class="error">
            <p><?php echo $controller->errorMessage ?></p>
        </div>
    <?php else : ?>
    <div class="news_post">
        <p class="news_title"> <?php echo $controller->data['title'] ?> </p>
        <p class="news_author"> <?php echo $controller->data['authorName'] ?> | <?php echo $controller->data['timestamp'] ?> </p>
        <p> <?php echo $controller->data['body'] ?> </p>      
    </div>
    <div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
    <fb:comments href="http://co-project.lboro.ac.uk/users/cojw3/ssago/?action=newspost&newsid=<?php echo $controller->data['id'] ?>"></fb:comments>
    <?php endif; ?>
</div>
<?php
include(COMMON_TEMPLATES."/footer.php");
?>
