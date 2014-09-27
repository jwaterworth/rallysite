<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");


/**
 * Description of BookingActivityFactory
 *
 * @author James
 */
class BookingActivityFactory implements IDatabaseFactory{
    
    public static function CreateValueObject() {
        require_once(VO_PATH."/BookingActivityVO.inc.php");
        return new BookingActivityVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            require_once(DBLAYER_PATH."/BookingActivityDAO.inc.php");
            $dao = new BookingActivityDAO();
        }
        return $dao;
    }
}

?>
