<?php
/**
 *
 * @author James
 */
interface IDatabaseAccessObject {
    
    public function __construct();
    
    public function GetById($id);
    
    public function GetAll();
    
    public function Save(IValueObject $valueObject);
    
    public function Delete(IValueObject $valueObject);
}

?>
