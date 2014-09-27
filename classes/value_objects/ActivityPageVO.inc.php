<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of ActivityPageVO
 *
 * @author James
 */
class ActivityPageVO implements IValueObject{
    
    private $id;
            
    private $activitiesBrief;
    
    public static $dbId = "id";
    
    public static $dbActivitiesBrief = "activitiesBrief";
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setActivitiesBrief($activitiesBrief) {
        $this->activitiesBrief = $activitiesBrief;
    }

    public function getId() {
        return $this->id;
    }

    public function getActivitiesBrief() {
        return $this->activitiesBrief;
    }
}

?>
