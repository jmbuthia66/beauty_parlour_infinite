<?php
// get ID of the employee to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/customer.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$customer = new Customer($db);
  
// set ID property of customer to be read
$customer->id = $id;
  
// read the details of customer to be read
$customer->readOne();

// set page headers
$page_title = "Read One Customer";
include_once "../../layout_header.php";
  
// read customer button
echo "<div class='right-button-margin'>";
    echo "<a href='customer_details.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span>Back To Customers";
    echo "</a>";
echo "</div>";

// HTML table for displaying a customer details
echo "<table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>";
  
    echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>{$customer->name}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>MobileNo</td>";
        echo "<td>{$customer->mobile_no}</td>";
    echo "</tr>";
  
echo "</table>";
  
// set footer
include_once "../../layout_footer.php";
?>