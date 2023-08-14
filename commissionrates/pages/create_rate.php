<?php

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

$page_title = "Create Commission Rate";
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
    if($rate->create()){
        echo "<div class='alert alert-success'>Commission rate was created.</div>";
    }
  
    // if unable to create the rate, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create commission rate.</div>";
    }
}
?>
  
<!-- HTML form for creating a rates -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  
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
                        extract($row_employee);
                        echo "<option value='{$id}'>{$name}</option>";
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
                        extract($row_product);
                        echo "<option value='{$id}'>{$name}</option>";
                    }
                
                echo "</select>";
                ?>
            </td>
        </tr>
  
        <tr>
            <td>Rate</td>
            <td><input type='number' name='rate'  min='0' max='100' class='form-control' required /></td>
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