<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author James
 */
interface IDatabaseFactory {
    public static function CreateValueObject();
    
    public static function GetDataAccessObject();
}

?>
