<?php

// include database and object files
include_once '../../config/database.php';
include_once '../objects/employee.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$employee = new Employee($db);

$page_title = "Create Employee";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
        <a href='employee_details.php' class='btn btn-default pull-right'>Back To Employees</a>
    </div>";
  
?>

<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
  
    // set employee property values
    $employee->name = $_POST['name'];
    $employee->mobile_no = $_POST['mobile_no'];
    $employee->idno = $_POST['idno'];
  
    // create the employee
    if($employee->create()){
        echo "<div class='alert alert-success'>Employee was created.</div>";
    }
  
    // if unable to create the employee, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create employee.</div>";
    }
}
?>
  
<!-- HTML form for creating a employee -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  
    <table class='table table-hover table-responsive table-bordered  table-sm thead-dark table-striped'>
  
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' required/></td>
        </tr>
  
        <tr>
            <td>MobileNo</td>
            <td><input type='text' name='mobile_no' class='form-control' required/></td>
        </tr>
  
        <tr>
            <td>IDNO</td>
            <td><input type='text' name='idno' class='form-control' required/></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
  
    </table>
</form>

<?php
  
// footer
include_once "../../layout_footer.php";
?>