<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of NewsPostPageController
 *
 * @author James
 */
class NewsPostPageController extends PageController {
    
    function __construct($newsPostID) {
        $this->data = array();
        
        $newsData = LogicFactory::CreateObject("News");
        $newsData = new News();
        
        try {
            $newsPost = $newsData->GetNewsPost($newsPostID);
            
            $this->data['id'] = $newsPost->getId();
            $this->data['title'] = $newsPost->getNewsTitle();
            $this->data['body'] = $newsPost->getNewsBody();
            $this->data['authorID'] = $newsPost->getUserID();
            $this->data['authorName'] = $newsData->GetNewsAuthor($newsPost);
            $this->data['timestamp'] = $newsPost->getNewsTimeStamp();
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

}

?>
