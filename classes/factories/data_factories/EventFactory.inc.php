<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");
require_once(VO_PATH."/EventVO.inc.php");
require_once(DBLAYER_PATH."/EventDAO.inc.php");

/**
 * Description of EventFactory
 *
 * @author James
 */
class EventFactory implements IDatabaseFactory{
    
    public static function CreateValueObject() {
        return new EventVO();
    }
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            $dao = new EventDAO();
        }
        return $dao;
    }
}

?>
