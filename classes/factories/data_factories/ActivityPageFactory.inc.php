<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");
require_once(VO_PATH."/ActivityPageVO.inc.php");
require_once(DBLAYER_PATH."/ActivityPageDAO.inc.php");

/**
 * Description of ActivityFactory
 *
 * @author James
 */
class ActivityPageFactory implements IDatabaseFactory{
    
    public static function CreateValueObject() {
        return new ActivityPageVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            $dao = new ActivityPageDAO();
        }
        return $dao;
    }
}

?>
