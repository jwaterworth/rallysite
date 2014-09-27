<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");
require_once(VO_PATH."/AccountVO.inc.php");
require_once(DBLAYER_PATH."/AccountDAO.inc.php");
/**
 * Description of AccountFactory
 *
 * @author James
 */
class AccountFactory implements IDatabaseFactory{
    
    public static function CreateValueObject(){
        return new AccountVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            $dao = new AccountDAO();
        }
        return $dao;
    }
}

?>
