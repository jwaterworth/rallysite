<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of NewsPostVO
 *
 * @author James
 */
class NewsPostVO implements IValueObject{
    
    private $id;
    
    private $newsTitle;
    
    private $newsBody;
    
    private $newsTimeStamp;
    
    private $userID;
    
    private $eventID;
    
    /*
     * Database column names
     */
    public static $dbId = "id";
    
    public static $dbNewsTitle = "newsTitle";
    
    public static $dbNewsBody = "newsBody";
    
    public static $dbNewsTimeStamp = "newsTimeStamp";
    
    public static $dbUserID = "userID";
    
    public static $dbEventID = "eventID";
        
    public function setId($id) {
        $this->id = (int)$id;
    }

    public function setNewsTitle($newsTitle) {
        $this->newsTitle = $newsTitle;
    }

    public function setNewsBody($newsBody) {
        $this->newsBody = $newsBody;
    }

    public function setNewsTimeStamp($newsTimeStamp) {
        $this->newsTimeStamp = $newsTimeStamp;
    }

    public function setUserID($userID) {
        $this->userID = $userID;
    }
    
    public function setEventID($eventID) {
        $this->eventID = $eventID;
    }
       
    public function getId() {
        return $this->id;
    }

    public function getNewsTitle() {
        return $this->newsTitle;
    }

    public function getNewsBody() {
        return $this->newsBody;
    }

    public function getNewsTimeStamp() {
        $dateArray =  date_parse_from_format('Y-m-d', $this->newsTimeStamp);
        $date =  $dateArray['day'] . '/' . $dateArray['month'] . '/' . $dateArray['year'];
        return $date;
    }

    public function getUserID() {
        return $this->userID;
    }
    
    public function getEventID() {
        return $this->eventID;
    }


}

?>
