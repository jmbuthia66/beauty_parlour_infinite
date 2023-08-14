<?php  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/commpay.php';
include_once '../../employees/objects/employee.php';
  
// instantiate database and objects
$database = new Database();
$db = $database->getConnection();
  
$commpay = new Commpay($db);
$employee = new Employee($db);
  
// query products
$stmt = $commpay->readAll();
$num = $stmt->rowCount();


// set page header
$page_title = "Read Commission Payments";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
    <a href='create_commpay.php' class='btn btn-default pull-right'>Capture Commission Payment</a>
</div>";

// display the products if there are any
if($num>0){
  
    echo "<table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>";
        echo "<tr>";
            echo "<th>Employee</th>";
            echo "<th>PaymentDate</th>";
            echo "<th>AmountPaid</th>";
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
                echo "<td>{$payment_date}</td>";
                echo "<td>{$amount_paid}</td>";
  
                echo "<td>";
                    // read, edit and delete buttons
                    echo "<a href='#read_one.php?id={$id}' class='btn btn-primary left-margin'>
                    <span class='glyphicon glyphicon-list'></span> Read
                    </a>

                    <a href='update_compay.php?id={$id}' class='btn btn-info left-margin'>
                    <span class='glyphicon glyphicon-edit'></span> Edit
                    </a>

                    <a delete-id='{$id}' class='btn btn-danger delete-object'>
                    <span class='glyphicon glyphicon-remove'></span> Delete
                    </a>";
                echo "</td>";
  
            echo "</tr>";
  
        }
  
    echo "</table>";
}
  
// tell the user there are no products
else{
    echo "<div class='alert alert-info'>No products found.</div>";
}

// set page footer
include_once "../../layout_footer.php";
?>