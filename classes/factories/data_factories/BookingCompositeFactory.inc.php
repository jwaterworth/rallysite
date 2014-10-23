<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");

/**
 * Description of BookingFactory
 *
 * @author James
 */
class BookingCompositeFactory implements IDatabaseFactory{
    
    public static function CreateValueObject() {
        require_once(VO_PATH."/BookingCompositeVO.inc.php");
        return new BookingCompositeVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            require_once(DBLAYER_PATH."/BookingCompositeDAO.inc.php");
            $dao = new BookingCompositeDAO();
        }
        return $dao;
    }
}

?>
