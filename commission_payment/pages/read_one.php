<?php
// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/product.php';
include_once '../objects/category.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$commpay = new Commpay($db);
$category = new Category($db);
  
// set ID property of product to be read
$commpay->id = $id;
  
// read the details of product to be read
$commpay->readOne();

// set page headers
$page_title = "Read One Commission";
include_once "../../layout_header.php";
  
// read products button
echo "<div class='right-button-margin'>";
    echo "<a href='commpay_details.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span>Back Commission Payment Details";
    echo "</a>";
echo "</div>";

// HTML table for displaying a product details
echo "<table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>";
  
    echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>{$product->name}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Price</td>";
        echo "<td>{$product->price}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Description</td>";
        echo "<td>{$product->description}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Category</td>";
        echo "<td>";
            // display category name
            $category->id=$product->category_id;
            $category->readName();
            echo $category->name;
        echo "</td>";
    echo "</tr>";
  
echo "</table>";
  
// set footer
include_once "../../layout_footer.php";
?>