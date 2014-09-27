<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");

/**
 * Description of BookingFoodChoiceFactory
 *
 * @author James
 */
class BookingFoodChoiceFactory implements IDatabaseFactory{
    
    
    public static function CreateValueObject() {
        require_once(VO_PATH."/BookingFoodChoiceVO.inc.php");
        return new BookingFoodChoiceVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            require_once(DBLAYER_PATH."/BookingFoodChoiceDAO.inc.php");
            $dao = new BookingFoodChoiceDAO();
        }
        return $dao;
    }
}

?>
