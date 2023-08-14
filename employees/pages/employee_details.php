<?php
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
  
// set number of records per page
$records_per_page = 5;
  
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/employee.php';
  
// instantiate database and objects
$database = new Database();
$db = $database->getConnection();
  
$employee = new Employee($db);
  
// query employee
$stmt = $employee->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();


// set page header
$page_title = "Read Employees";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
    <a href='create_employee.php' class='btn btn-default pull-right'>Create Employee</a>
</div>";

// display the employee if there are any
if($num>0){
  
    echo "<table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>";
        echo "<tr>";
            echo "<th>Employee</th>";
            echo "<th>MobileNo</th>";
            echo "<th>IDNO</th>";
            echo "<th>ACTIVE</th>";
            echo "<th>Actions</th>";
        echo "</tr>";
  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
            extract($row);
  
            echo "<tr>";
                echo "<td>{$name}</td>";
                echo "<td>{$mobile_no}</td>";
                echo "<td>{$idno}</td>";
                echo "<td>{$active}</td>";
  
                echo "<td>";
                    // read, edit and delete buttons
                    echo "
                        <a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>
                        <span class='glyphicon glyphicon-list'></span> Read
                        </a>

                        <a href='update_employee.php?id={$id}' class='btn btn-info left-margin'>
                        <span class='glyphicon glyphicon-edit'></span> Edit
                        </a>

                        <a href='delete_employee.php?id={$id}' class='btn btn-danger left-margin'>
                        <span class='glyphicon glyphicon-edit'></span> Delete
                        </a>
                    ";
                echo "</td>";
  
            echo "</tr>";
  
        }
  
    echo "</table>";
  
    // the page where this paging is used
    $page_url = "employee_details.php?";
    
    // count all products in the database to calculate total pages
    $total_rows = $employee->countAll();
    
    // paging buttons here
    include_once '../../config/paging.php';
    }
  
// tell the user there are no employees
else{
    echo "<div class='alert alert-info'>No employees found.</div>";
}

// set page footer
include_once "../../layout_footer.php";
?>