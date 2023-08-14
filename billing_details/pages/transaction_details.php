<?php  
    // get ID of the product to be edited
    $tran_no = isset($_GET['tran_no']) ? $_GET['tran_no'] : die('ERROR: missing tran_no.');

    // include database and object files
    include_once '../../config/database.php';
    include_once '../objects/bill_detail.php';
    include_once '../../employees/objects/employee.php';
    include_once '../../products/objects/category.php';
    include_once '../../products/objects/product.php';
    
    // instantiate database and objects
    $database = new Database();
    $db = $database->getConnection();
    
    $billdetail = new BillDetail($db);
    $employee = new Employee($db);
    $category = new Category($db);
    $product = new Product($db);

    // set ID property of product to be edited
    $billdetail->tran_no = $tran_no;
    
    // query billing details
    $stmt = $billdetail->readTranDetails();
    $num= $stmt->rowCount();

    // query payment details
    $stmtp = $billdetail->readPaymentDetails();
    $nump= $stmtp->rowCount();

    // set page header
    $page_title = "Billing Details";

    include_once "../../layout_header.php";

    echo "<div class='right-button-margin'>
            <a href='billing_details.php' class='btn btn-default pull-right'>Back Billing Details</a>
        </div>";
        
    if($num>0){
        //Show billing details
?>

<?php
    // if the form was submitted
    if($_POST){        
           
        // delete data (billing and payment)
        if($billdetail->delete()){
            echo "<div class='alert alert-success alert-dismissable'>";
                echo "deleted successfully";
            echo "</div>";
        }
    
        // if unable to update the product, tell the user
        else{
            echo "<div class='alert alert-danger alert-dismissable'>";
                echo "Unable to delete";
            echo "</div>";
        }
    }
?>

    <form action="<?php echo "?tran_no={$tran_no}";?>" method="post">
        <?php        
            echo "<table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>";
                echo "<tr>";
                    echo "<th>Employee</th>";
                    echo "<th>Category</th>";
                    echo "<th>Item</th>";
                    echo "<th>Price</th>";
                    echo "<th>Qty</th>";
                    echo "<th>Discount</th>";
                    echo "<th>TotalPrice</th>";
                    echo "<th>TranNo</th>";
                    echo "<th>Date</th>";
                echo "</tr>";
        
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
                    extract($row);
        
                    echo "<tr>";
                        echo "<td>";
                            $employee->id = $employee_id;
                            $employee->readName();
                            echo $employee->name;
                        echo "</td>";
                        echo "<td>";
                            $category->id = $category_id;
                            $category->readName();
                            echo $category->name;
                        echo "</td>";
                        echo "<td>";
                            $product->id = $item_id;
                            $product->readName();
                            echo $product->name;
                        echo "</td>";
                        echo "<td>{$price}</td>";
                        echo "<td>{$qty}</td>";
                        echo "<td>{$discount}</td>";
                        echo "<td>{$total_price}</td>";
                        echo "<td>{$tran_no}</td>";
                        echo "<td>{$created}</td>";
                    echo "</tr>";  
                }  
            echo "</table>";     

            //show payment details
            if($nump>0){    
                echo "<table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>";  
                    while ($row = $stmtp->fetch(PDO::FETCH_ASSOC)){
            
                        extract($row);
            
                        echo "<tr>";
                            echo "<td>Mpesa:{$mpesa}</td>";
                            echo "<td>Cash:{$cash}</td>";
                            echo "<td>Total:{$total}</td>";
                        echo "</tr>";  
                    }  
                echo "</table>";
            }  
            // tell the user there is no data
            else{
                echo "<div class='alert alert-info'>No data found.</div>";
            }      

            //Action
            echo "<table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>";
                echo "<tr>";
                    echo "<td>";
                        //delete buttons
        ?>        
        <input type="hidden" name="trans_no" value="<?php echo $tran_no;?>"/>
        <button type="submit" class="btn btn-primary">Delete</button>

        <?php
                    echo "</td>";
                echo "</tr>";  
            echo "</table>";
        ?>
    </form>
<?php
    }  
    // tell the user there is no data
    else{
        echo "<div class='alert alert-info'>No data found.</div>";
    }

    // set page footer
    include_once "../../layout_footer.php";
?>