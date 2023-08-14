<?php
// get ID of the employee to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/employee.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$employee = new Employee($db);
  
// set ID property of employee to be edited
$employee->id = $id;
  
// read the details of employee to be edited
$employee->readOne();
  
// set page header
$page_title = "Update Employee";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
          <a href='employee_details.php' class='btn btn-default pull-right'>Back To Employees</a>
     </div>";
  
?>

<?php 
// if the form was submitted
if($_POST){
  
    // set employee property values
    $employee->name = $_POST['name'];
    $employee->mobile_no = $_POST['mobile_no'];
    $employee->idno = $_POST['idno'];
  
    // update the employee
    if($employee->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Employee was updated.";
        echo "</div>";
    }
  
    // if unable to update the employee, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update employee.";
        echo "</div>";
    }
}
?>
  
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered  table-sm thead-dark table-striped'>
  
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value='<?php echo $employee->name; ?>' class='form-control' required/></td>
        </tr>
  
        <tr>
            <td>MobileNo</td>
            <td><input type='text' name='mobile_no' value='<?php echo $employee->mobile_no; ?>' class='form-control' required/></td>
        </tr>
  
        <tr>
            <td>IDNO</td>
            <td><input type='text' name='idno' value='<?php echo $employee->idno; ?>' class='form-control' required/></td>
        </tr>
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
  
    </table>
</form>
 
<?php
// set page footer
include_once "../../layout_footer.php";
?>