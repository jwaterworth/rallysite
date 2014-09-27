<?php
require_once(INTERFACE_PATH."/IDatabaseFactory.interface.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FeesFactory
 *
 * @author James
 */
class FeesFactory implements IDatabaseFactory{
    
    public static function CreateValueObject() {
        require_once(VO_PATH."/FeesVO.inc.php");
        return new FeesVO();
    }
    
    public static function GetDataAccessObject() {
        static $dao = null;
        if($dao == null) {
            require_once(DBLAYER_PATH."/FeesDAO.inc.php");
            $dao = new FeesDAO();
        }
        return $dao;
    }
}

?>
