<?php

// include database and object files
include_once '../../config/database.php';
include_once '../objects/service.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$service = new Service($db);

$page_title = "Create Service";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
        <a href='service_details.php' class='btn btn-default pull-right active bg-gradient-info'>Back To Services</a>
    </div>";
  
?>

<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
  
    // set service property values
    $service->name = $_POST['name'];
    $service->price = $_POST['price'];
  
    // create the service
    if($service->create()){
        echo "<div class='alert alert-success'>service was created.</div>";
    }
  
    // if unable to create the service, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create service.</div>";
    }
}
?>
  
<!-- HTML form for creating a service -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  
    <table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>
  
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' class='form-control' /></td>
        </tr>
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
  
    </table>
</form>

<?php
  
// footer
include_once "../../layout_footer.php";
?>