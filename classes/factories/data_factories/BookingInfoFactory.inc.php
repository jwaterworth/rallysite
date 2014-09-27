<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");

/**
 * Description of BookingInfoFactory
 *
 * @author James
 */
class BookingInfoFactory implements IDatabaseFactory{

    public static function CreateValueObject() {
        require_once(VO_PATH."/BookingInfoVO.inc.php");
        return new BookingInfoVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            require_once(DBLAYER_PATH."/BookingInfoDAO.inc.php");
            $dao = new BookingInfoDAO();
        }
        return $dao;
    }
}

?>
