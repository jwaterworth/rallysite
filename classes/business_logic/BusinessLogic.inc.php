<?php

/**
 * Description of BusinessLogic
 *
 * @author James
 */
abstract class BusinessLogic {
    
    protected function CheckParam($param, $functionName){
        if($param == null) {
            throw new Exception("No paramater passed to " . $functionName);
        }
    }
    
}

?>
