<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of AccountTypeVO
 *
 * @author James
 */
class AccountTypeVO implements IValueObject{
    
    private $id;
    
    private $accountTypeName;
    
    public static $dbId = 'id';
    
    public static $dbAccountTypeName = 'accountTypeName';
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setAccountTypeName($accountTypeName) {
        $this->accountTypeName = $accountTypeName;
    }

    public function getId() {
        return $this->id;
    }

    public function getAccountTypeName() {
        return $this->accountTypeName;
    }

}

?>
