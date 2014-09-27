<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of clubVO
 *
 * @author James
 */
class ClubVO implements IValueObject{
    
    private $id;
    
    private $name;
    
    private $logoLoc;
    
    /*
     * Database column names
     */
    public static $dbId = "id";
    
    public static $dbName = "name";
                    
    public static $dbLogoLoc = "logoLoc";
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($clubName) {
        $this->name = $clubName;
    }

    public function setLogoLoc($logoLoc) {
        $this->logoLoc = $logoLoc;
    }
        
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getLogoLoc() {
        return $this->logoLoc;
    }


}

?>
