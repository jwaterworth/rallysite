<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");
require_once(VO_PATH."/ActivityVO.inc.php");
require_once(DBLAYER_PATH."/ActivityDAO.inc.php");

/**
 * Description of ActivityFactory
 *
 * @author Bernard
 */
class ActivityFactory implements IDatabaseFactory{
    
    public static function CreateValueObject() {
        return new ActivityVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            $dao = new ActivityDAO();
        }
        return $dao;
    }
}

?>
