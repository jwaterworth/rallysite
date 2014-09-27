<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");
require_once(VO_PATH."/ClubVO.inc.php");
require_once(DBLAYER_PATH."/ClubDAO.inc.php");

/**
 * Description of ClubFactory
 *
 * @author James
 */
class ClubFactory implements IDatabaseFactory{
    public static function CreateValueObject(){
        return new ClubVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            $dao = new ClubDAO();
        }
        return $dao;
    }
}

?>
