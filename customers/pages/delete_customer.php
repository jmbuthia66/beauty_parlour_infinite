<?php
// check if value was posted
if($_POST){
  
    // include database and object file
    include_once '../../config/database.php';
    include_once '../objects/customer.php';
  
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
  
    // prepare customer object
    $employee = new Customer($db);
      
    // set customer id to be deleted
    $customer->id = $_POST['object_id'];
      
    // delete the customer
    if($customer->delete()){
        echo "Object was deleted.";
    }      
    // if unable to delete the customer
    else{
        echo "Unable to delete object.";
    }
}
?>