<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PresentationFactory
 *
 * @author James
 */
class LogicFactory {
    
    public static function CreateObject($className) {
        /*static $object = null;
        
        if($object == null) {
            require_once(BUSLOGIC_PATH."/".$className.".inc.php");
            $object = new $className();
        }
        return $object;*/
        require_once(BUSLOGIC_PATH."/".$className.".inc.php");
        return new $className();
    }
}

?>
