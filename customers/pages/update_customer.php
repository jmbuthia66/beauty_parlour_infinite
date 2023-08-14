<?php
// get ID of the customer to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/customer.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$customer = new Customer($db);
  
// set ID property of customer to be edited
$customer->id = $id;
  
// read the details of customer to be edited
$customer->readOne();
  
// set page header
$page_title = "Update Customer";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
          <a href='customer_details.php' class='btn btn-default pull-right'>Back To Customers</a>
     </div>";
  
?>

<?php 
// if the form was submitted
if($_POST){
  
    // set customer property values
    $customer->name = $_POST['name'];
    $customer->mobile_no = $_POST['mobile_no'];
  
    // update the customer
    if($customer->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Customer was updated.";
        echo "</div>";
    }
  
    // if unable to update the customer, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update customer.";
        echo "</div>";
    }
}
?>
  
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped'>
  
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value='<?php echo $customer->name; ?>' class='form-control' required/></td>
        </tr>
  
        <tr>
            <td>MobileNo</td>
            <td><input type='text' name='mobile_no' value='<?php echo $customer->mobile_no; ?>' class='form-control' required/></td>
        </tr>
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
  
    </table>
</form>
 
<?php
// set page footer
include_once "../../layout_footer.php";
?>