<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");

/**
 * Description of BookingFactory
 *
 * @author James
 */
class BookingFactory implements IDatabaseFactory{
    
    public static function CreateValueObject() {
        require_once(VO_PATH."/BookingVO.inc.php");
        return new BookingVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            require_once(DBLAYER_PATH."/BookingDAO.inc.php");
            $dao = new BookingDAO();
        }
        return $dao;
    }
}

?>
