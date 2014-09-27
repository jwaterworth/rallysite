<?php
require_once("classes/upload/class/upload_class.inc.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Uploads
 *
 * @author Bernard
 */
class Uploads {
    
    private $upload;
    
    private $max_size;
    
    public $error_message;
    
    function __construct() {
        $this->max_size = 1024*250; // the max. size for uploading
	
        $this->upload = new file_upload();

        $this->upload->upload_dir = IMAGE_PATH; // "files" is the folder for the uploaded files (you have to create this folder)
        $this->upload->extensions = array(".png", ".jpg", ".gif"); // specify the allowed extensions here
        // $my_upload->extensions = "de"; // use this to switch the messages into an other language (translate first!!!)
        $this->upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
        $this->upload->rename_file = true;
    }
    
    public function UploadFile($file, $name, $replace, $check) {
        $this->upload->the_temp_file = $file['tmp_name'];
	$this->upload->the_file = $file['name'];
	$this->upload->http_error = $file['error'];
	$this->upload->replace = (isset($replace)) ? $replace : "n"; // because only a checked checkboxes is true
	$this->upload->do_filename_check = (isset($check)) ? $check : "n"; // use this boolean to check for a valid filename
	$new_name = (isset($name)) ? $name : "";
	if ($this->upload->upload($new_name)) { // new name is an additional filename information, use this to rename the uploaded file
		$full_path = $this->upload->upload_dir.$my_upload->file_copy;
		$info = $this->upload->get_uploaded_file_info($full_path);
                return $full_path . $new_name;
	}
        
        $this->error_message = $this->upload->show_error_string();
        
        return null;
    }
    
    public function UploadActivityImage($file, $name) {
        $this->upload->upload_dir = INTERNAL_IMAGE_PATH . 'images/activities/';
        
        $this->upload->the_temp_file = $file['tmp_name'];
	$this->upload->the_file = $file['name'];
	$this->upload->http_error = $file['error'];
	$this->upload->replace = 'y';
	$this->upload->do_filename_check = 'y';
	$new_name = (isset($name)) ? $name : "";
	if ($this->upload->upload($new_name)) { // new name is an additional filename information, use this to rename the uploaded file
		$full_path = $this->upload->upload_dir.$my_upload->file_copy;
		$info = $this->upload->get_uploaded_file_info($full_path);
                return $new_name;
	}
        
        $this->error_message = $this->upload->show_error_string();
        
        return null;
    }

}

?>
