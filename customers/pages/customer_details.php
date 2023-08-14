<?php
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
  
// set number of records per page
$records_per_page = 5;
  
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/customer.php';
  
// instantiate database and objects
$database = new Database();
$db = $database->getConnection();
  
$customer = new Customer($db);
  
// query customer
$stmt = $customer->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();


// set page header
$page_title = "Read Customers";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
    <a href='create_customer.php' class='btn btn-default pull-right'>Create Customer</a>
</div>";

// display the customer if there are any
if($num>0){
  
    echo "<table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>";
        echo "<tr>";
            echo "<th>Customer</th>";
            echo "<th>MobileNo</th>";
            echo "<th>Actions</th>";
        echo "</tr>";
  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
            extract($row);
  
            echo "<tr>";
                echo "<td>{$name}</td>";
                echo "<td>{$mobile_no}</td>";
  
                echo "<td>";
                    // read, edit and delete buttons
                    echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>
                    <span class='glyphicon glyphicon-list'></span> Read
                    </a>

                    <a href='update_customer.php?id={$id}' class='btn btn-info left-margin'>
                    <span class='glyphicon glyphicon-edit'></span> Edit
                    </a>

                    <a delete-id='{$id}' class='btn btn-danger delete-object'>
                    <span class='glyphicon glyphicon-remove'></span> Delete
                    </a>";
                echo "</td>";
  
            echo "</tr>";
  
        }
  
    echo "</table>";
  
    // the page where this paging is used
    $page_url = "customer_details.php?";
    
    // count all products in the database to calculate total pages
    $total_rows = $customer->countAll();
    
    // paging buttons here
    include_once '../../config/paging.php';
    }
  
// tell the user there are no customers
else{
    echo "<div class='alert alert-info'>No customers found.</div>";
}

// set page footer
include_once "../../layout_footer.php";
?>