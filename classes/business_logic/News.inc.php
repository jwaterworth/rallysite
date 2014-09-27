<?php
require_once(BUSLOGIC_PATH."/BusinessLogic.inc.php");

/**
 * Description of HomePage
 *
 * @author James
 */
class News extends BusinessLogic {
    
    public function GetAllNews(EventVO $event) {
        $this->CheckParam($event, "GetAllNews");
        
        $dbNewsPost = NewsPostFactory::GetDataAccessObject();
        
        $newsPosts = $dbNewsPost->GetByForeignKey($event->getId());
        
        if($newsPosts == null) {
            throw new Exception("No news posts found");    
        }
        
        return $newsPosts;
    }
    
    public function GetNewsPost($id) {
        $this->CheckParam($id, "GetNewsPost");
        
        $dbNewsPost = NewsPostFactory::GetDataAccessObject();
        
        $newsPost = NewsPostFactory::CreateValueObject();
        $newsPost = $dbNewsPost->GetById($id);
        
        if($newsPost == null) {
            throw new Exception("News post not found");
        }
        
        return $newsPost;
    }
    
    public function GetNewsAuthor(NewsPostVO $newsPost) {
        $this->CheckParam($newsPost, "GetNewsAuthor");
        
        $userID = $newsPost->getUserID();
        
        $dbAccount = AccountFactory::GetDataAccessObject();
        
        $account = AccountFactory::CreateValueObject();
        $account = $dbAccount->GetById($userID);
        
        $author = $account->getName();
        
        if($author == null){
            throw Exception("No author found");
        }
        return $author;
    }
    
    public function SaveNewsPost(NewsPostVO $newsPost) {
        $this->CheckParam($newsPost, "SaveNewsPost");

        $dbNewsPost = NewsPostFactory::GetDataAccessObject();
        
        if($dbNewsPost->Save($newsPost) < 1) {
            throw Exception("An error occured while saving " . $newsPost->getNewsTitle());
        }
        
        return true;
    }
    
    public function RemoveNewsPost($newsPostID) {
        $this->CheckParam($newsPostID, "RemoveNewsPost");
        
        $dbNewsPost = NewsPostFactory::GetDataAccessObject();
        
        $newsPost = NewsPostFactory::CreateValueObject();
        $newsPost = $dbNewsPost->GetById($newsPostID);
        
        if($newsPost == null || $dbNewsPost->Delete($newsPost) < 1){
            throw Exception("An error occured while removing " . $newsPost->getNewsTitle());
        }
        
        return false;
    }
}

?>
