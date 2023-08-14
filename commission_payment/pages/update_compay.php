<?php
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/commpay.php';
include_once '../../employees/objects/employee.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$commpay = new Commpay($db);
$employee = new Employee($db);
  
// set ID property of product to be edited
$commpay->id = $id;
  
// read the details of product to be edited
$commpay->readOne();
  
// set page header
$page_title = "Update Amount paid";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
          <a href='commpay_details.php' class='btn btn-default pull-right'>Back Commission Payment Details</a>
     </div>";
  
?>

<?php 
// if the form was submitted
if($_POST){
  
    // set product property values
    $commpay->employee_id = $_POST['employee_id'];
    $commpay->payment_date = $_POST['payment_date'];
    $commpay->amount_paid = $_POST['amount_paid'];
  
    // update the product
    if($commpay->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "updated successfully";
        echo "</div>";
    }
  
    // if unable to update the product, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update";
        echo "</div>";
    }
}
?>
  
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped'>
      
        <tr>
            <td>Employee</td>
            <td>
                <?php
                $stmt = $employee->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='employee_id' required>";
                
                    echo "<option></option>";
                    while ($row_employee = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $employee_id=$row_employee['id'];
                        $employee_name = $row_employee['name'];
                
                        // current employee  must be selected
                        if($commpay->employee_id==$employee_id){
                            echo "<option value='$employee_id' selected>";
                        }else{
                            echo "<option value='$employee_id'>";
                        }
                
                        echo "$employee_name</option>";
                    }
                echo "</select>";
                ?>
            </td>
        </tr>
  
        <tr>
            <td>PaymentDate</td>
            <td><input type='text' name='payment_date' value='<?php echo $commpay->payment_date; ?>' class='form-control' required/></td>
        </tr>
  
        <tr>
            <td>AmountPaid</td>
            <td><textarea name='amount_paid' class='form-control' required><?php echo $commpay->amount_paid; ?></textarea></td>
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