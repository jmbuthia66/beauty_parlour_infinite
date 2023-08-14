<?php
// check if value was posted
if($_POST){
  
    // include database and object file
    include_once '../../config/database.php';
    include_once '../objects/service.php';
  
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
  
    // prepare service object
    $service = new Service($db);
      
    // set service id to be deleted
    $service->id = $_POST['object_id'];
      
    // delete the service
    if($service->delete()){
        echo "Object was deleted.";
    }
      
    // if unable to delete the service
    else{
        echo "Unable to delete object.";
    }
}
?>