<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");
require_once(VO_PATH."/OpenSessionVO.inc.php");
require_once(DBLAYER_PATH."/OpenSessionDAO.inc.php");
/**
 * Description of OpenSessionFactory
 *
 * @author James
 */
class OpenSessionFactory implements IDatabaseFactory{
    
    public static function CreateValueObject(){
        return new OpenSessionVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            $dao = new OpenSessionDAO();
        }
        return $dao;
    }
}

?>
