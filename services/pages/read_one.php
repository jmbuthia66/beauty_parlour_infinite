<?php
// get ID of the service to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/service.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$service = new Service($db);
  
// set ID property of service to be read
$service->id = $id;
  
// read the details of service to be read
$service->readOne();

// set page headers
$page_title = "Read One Service";
include_once "../../layout_header.php";
  
// read services button
echo "<div class='right-button-margin'>";
    echo "<a href='service_details.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Services";
    echo "</a>";
echo "</div>";

// HTML table for displaying a service details
echo "<table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>";
  
    echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>{$service->name}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Price</td>";
        echo "<td>{$service->price}</td>";
    echo "</tr>";
  
echo "</table>";
  
// set footer
include_once "../../layout_footer.php";
?>