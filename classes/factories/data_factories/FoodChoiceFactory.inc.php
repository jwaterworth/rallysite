<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");

/**
 * Description of FoodChoiceFactory
 *
 * @author James
 */
class FoodChoiceFactory implements IDatabaseFactory{
     
    public static function CreateValueObject() {
        require_once(VO_PATH."/FoodChoiceVO.inc.php");
        return new FoodChoiceVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            require_once(DBLAYER_PATH."/FoodChoiceDAO.inc.php");
            $dao = new FoodChoiceDAO();
        }
        return $dao;
    }
}

?>
