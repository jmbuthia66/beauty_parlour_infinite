<?php

// include database and object files
include_once '../../config/database.php';
include_once '../objects/customer.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$customer = new Customer($db);

$page_title = "Create Customer";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
        <a href='customer_details.php' class='btn btn-default pull-right'>Back To Customers</a>
    </div>";
  
?>

<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
  
    // set customer property values
    $customer->name = $_POST['name'];
    $customer->mobile_no = $_POST['mobile_no'];
  
    // create the customer
    if($customer->create()){
        echo "<div class='alert alert-success'>Customer was created.</div>";
    }
  
    // if unable to create the customer, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create customer.</div>";
    }
}
?>
  
<!-- HTML form for creating a customer -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  
    <table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped'>
  
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' required/></td>
        </tr>
  
        <tr>
            <td>MobileNo</td>
            <td><input type='text' name='mobile_no' class='form-control' required/></td>
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