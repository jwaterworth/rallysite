<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");
require_once(VO_PATH."/NewsPostVO.inc.php");
require_once(DBLAYER_PATH."/NewsPostDAO.inc.php");

/**
 * Description of NewsPostFactory
 *
 * @author James
 */
class NewsPostFactory implements IDatabaseFactory{
    public static function CreateValueObject(){
        return new NewsPostVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            $dao = new NewsPostDAO();
        }
        return $dao;
    }
}

?>
