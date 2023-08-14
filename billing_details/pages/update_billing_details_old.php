<?php
    // get ID of the product to be edited
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
    
    // include database and object files
    include_once '../../config/database.php';
    include_once '../objects/bill_detail.php';
    include_once '../../employees/objects/employee.php';
    include_once '../../products/objects/category.php';
    include_once '../../products/objects/product.php';
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // prepare objects
    $billdetail = new BillDetail($db);
    $employee = new Employee($db);
    $category = new Category($db);
    $product = new Product($db);
    
    // set ID property of product to be edited
    $billdetail->id = $id;
    
    // read the details of product to be edited
    $billdetail->readOne();
    
    // set page header
    $page_title = "Update Billing Details";
    include_once "../../layout_header.php";
    
    echo "<div class='right-button-margin'>
            <a href='billing_details.php' class='btn btn-default pull-right'>Back Billing Details</a>
        </div>";
  
?>

<?php 
// if the form was submitted
if($_POST){
  
    // set product property values
    $billdetail->employee_id = $_POST['employee_id'];
    $billdetail->category_id = $_POST['category_id'];
    $billdetail->item_id = $_POST['item_id'];
    $billdetail->price = $_POST['price'];
    $billdetail->qty = $_POST['qty'];
    $billdetail->discount = $_POST['discount'];
    $billdetail->total_price = $_POST['total_price'];
  
    // update the product
    if($billdetail->update()){
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
                            if($billdetail->employee_id==$employee_id){
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
            <td>Category</td>
            <td>
                <?php
                $stmt = $category->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='category_id' required>";
                
                    echo "<option></option>";
                    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $category_id=$row_category['id'];
                        $category_name = $row_category['name'];
                
                        // current category  must be selected
                        if($billdetail->category_id==$category_id){
                            echo "<option value='$category_id' selected>";
                        }else{
                            echo "<option value='$category_id'>";
                        }
                
                        echo "$category_name</option>";
                    }
                echo "</select>";
                ?>
            </td>
        </tr>

        <tr>
            <td>Item</td>
            <td>
                <?php
                $stmt = $product->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='item_id' required>";
                
                    echo "<option></option>";
                    while ($row_product = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $product_id=$row_product['id'];
                        $product_name = $row_product['name'];
                
                        // current product  must be selected
                        if($billdetail->item_id==$product_id){
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
            <td>Price</td>
            <td><input type='text' name='price' value='<?php echo $billdetail->price; ?>' class='form-control' required readonly /></td>
        </tr>
        
        <tr>
            <td>Qty</td>
            <td><input type='text' name='qty' value='<?php echo $billdetail->qty; ?>' class='form-control' required /></td>
        </tr>
        
        <tr>
            <td>Discount</td>
            <td><input type='text' name='discount' value='<?php echo $billdetail->discount; ?>' class='form-control' required  /></td>
        </tr>
        
        <tr>
            <td>TotalPrice</td>
            <td><input type='text' name='total_price' value='<?php echo $billdetail->total_price; ?>' class='form-control' required  readonly/></td>
        </tr>
  
        <tr>
            <td>Date</td>
            <td><input type='text' name='created' value='<?php echo $billdetail->created; ?>' class='form-control' required readonly /></td>
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