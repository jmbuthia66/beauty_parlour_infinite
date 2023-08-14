<?php  
$empid=trim($_REQUEST['reportControl']);
$from=trim($_REQUEST['fromDate']);
$todate=trim($_REQUEST['toDate']);
if($empid=="All"){
    $stmt = $billdetail->readAll($from,$todate);
}else{
    $stmt = $billdetail->readOne($empid,$from,$todate);
}
$num = $stmt->rowCount();

//object files
include_once '../../employees/objects/employee.php';
include_once '../../products/objects/category.php';
include_once '../../products/objects/product.php';
  
//instantiate objects
$employee = new Employee($db);
$category = new Category($db);
$product = new Product($db);
  
if($num>0){
  
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
            echo "<th>Actions</th>";
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
  
                echo "<td>";
                    // read, edit and delete buttons
                    echo "
                        <a href='transaction_details.php?tran_no={$tran_no}' class='btn btn-info left-margin'>
                        <span class='glyphicon glyphicon-edit'></span> View
                        </a>
                    ";
                echo "</td>";
  
            echo "</tr>";
  
        }
  
    echo "</table>";
}
  
// tell the user there is no data
else{
    echo "<div class='alert alert-info'>No data found.</div>";
}

// set page footer
include_once "../../layout_footer.php";
?>