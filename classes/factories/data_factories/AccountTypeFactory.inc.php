<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");

/**
 * Description of AccountTypeFactory
 *
 * @author James
 */
class AccountTypeFactory implements IDatabaseFactory{
    
    public static function CreateValueObject() {
        require_once(VO_PATH."/AccountTypeVO.inc.php");
        return new AccountTypeVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            require_once(DBLAYER_PATH."/AccountTypeDAO.inc.php");
            $dao = new AccountTypeDAO();
        }
        return $dao;        
    }
}

?>
