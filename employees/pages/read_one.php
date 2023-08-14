<?php
// get ID of the employee to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/employee.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$employee = new Employee($db);
  
// set ID property of employee to be read
$employee->id = $id;
  
// read the details of employee to be read
$employee->readOne();

// set page headers
$page_title = "Read One Employee";
include_once "../../layout_header.php";
  
// read employees button
echo "<div class='right-button-margin'>";
    echo "<a href='employee_details.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span>Back To Employees";
    echo "</a>";
echo "</div>";

// HTML table for displaying a employee details
echo "<table class='table table-hover table-responsive table-bordered  table-sm thead-dark table-striped table-dark'>";
  
    echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>{$employee->name}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>MobileNo</td>";
        echo "<td>{$employee->mobile_no}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>IDNO</td>";
        echo "<td>{$employee->idno}</td>";
    echo "</tr>";
  
echo "</table>";
  
// set footer
include_once "../../layout_footer.php";
?>