<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");

/**
 * Description of FoodTypeFactory
 *
 * @author Bernard
 */
class FoodTypeFactory implements IDatabaseFactory{
    
    public static function CreateValueObject() {
        require_once(VO_PATH."/FoodTypeVO.inc.php");
        return new FoodTypeVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            require_once(DBLAYER_PATH."/FoodTypeDAO.inc.php");
            $dao = new FoodTypeDAO();
        }
        return $dao;
    }
}

?>
