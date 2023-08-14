<?php
// page given in URL parameter, default page is one
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/rates.php';
include_once '../../products/objects/product.php';
include_once '../../employees/objects/employee.php';
  
// instantiate database and objects
$database = new Database();
$db = $database->getConnection();
  
$rate = new Rate($db);
$employee = new Employee($db);
$product = new Product($db);

// set ID property of customer to be read
$rate->id = $id;

// query products
$stmt = $rate->empRate();
$num = $stmt->rowCount();


// set page header
$page_title = "Employee Rates";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
    <a href='rate_details.php' class='btn btn-default pull-right'>Back To Rates</a>
</div>";

// display the products if there are any
if($num>0){
  
    echo "<table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>";
        echo "<tr>";
            echo "<th>Employee</th>";
            echo "<th>Product</th>";
            echo "<th>Rates</th>";
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
                    $product->id = $product_id;
                    $product->readName();
                    echo $product->name;
                echo "</td>";
                echo "<td>{$rate}</td>";
  
                echo "<td>";
                    // read, edit and delete buttons
                    echo "
                        <a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>
                        <span class='glyphicon glyphicon-list'></span> Read
                        </a>

                        <a href='update_rate.php?id={$id}' class='btn btn-info left-margin'>
                        <span class='glyphicon glyphicon-edit'></span> Edit
                        </a>

                        <a delete-id='{$id}' class='btn btn-danger delete-object'>
                        <span class='glyphicon glyphicon-remove'></span> Delete
                        </a>
                    ";
                echo "</td>";
  
            echo "</tr>";
  
        }
  
    echo "</table>";
    }
  
// tell the user there are no products
else{
    echo "<div class='alert alert-info'>No rates found.</div>";
}

// set page footer
include_once "../../layout_footer.php";
?>