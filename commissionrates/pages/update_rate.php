<?php
// get ID of the rate to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// include database and object files
include_once '../../config/database.php';
include_once '../objects/rates.php';
include_once '../../products/objects/product.php';
include_once '../../employees/objects/employee.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$rate = new Rate($db);
$employee = new Employee($db);
$product = new Product($db);

// set ID property of rate to be edited
$rate->id = $id;

// read the details of rate to be edited
$rate->readOne();

$page_title = "Update Commission Rate";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
        <a href='rate_details.php' class='btn btn-default pull-right'>Back To Rates</a>
    </div>";
  
?>

<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
  
    // set rate property values
    $rate->employee_id = $_POST['employee_id'];
    $rate->product_id = $_POST['product_id'];
    $rate->rate= $_POST['rate'];
  
    // create the rate
    if($rate->update()){
        echo "<div class='alert alert-success'>Commission rate was created.</div>";
    }
  
    // if unable to create the rate, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create commission rate.</div>";
    }
}
?>
  
<!-- HTML form for creating a rates -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
  
    <table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped'>
  
        <tr>            
            <td>Employee</td>
            <td>
                <?php
                // read the employee from the database
                $stmt = $employee->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='employee_id' required>";
                    echo "<option></option>";
                
                    while ($row_employee = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $employee_id=$row_employee['id'];
                        $employee_name = $row_employee['name'];
                
                        // current employee must be selected
                        if($rate->employee_id==$employee_id){
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
            <td>Product</td>
            <td>
                <?php
                // read the product categories from the database
                $stmt = $product->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='product_id' required>";
                    echo "<option></option>";
                                    
                    while ($row_product = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $product_id=$row_product['id'];
                        $product_name = $row_product['name'];
                
                        // current employee must be selected
                        if($rate->product_id==$product_id){
                            echo "<option value='$product_id' selected>";
                        }else{
                            echo "<option value='$product_id'>";
                        }
                
                        echo "$product_name</option>";
                    }
                
                echo "</select>";
                ?>
            </td>
        </tr>
  
        <tr>
            <td>Rate</td>
            <td><input type='number' min='0' max='100' name='rate' value='<?php echo $rate->rate; ?>' class='form-control' required/></td>
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
  
// footer
include_once "../../layout_footer.php";
?>