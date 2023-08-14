<?php
// get ID of the service to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../../config/database.php';
include_once '../objects/service.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$service = new Service($db);
  
// set ID property of service to be edited
$service->id = $id;
  
// read the details of service to be edited
$service->readOne();
  
// set page header
$page_title = "Update Service";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
          <a href='service_details.php' class='btn btn-default pull-right active bg-gradient-info'>Back To Services</a>
     </div>";
  
?>

<?php 
// if the form was submitted
if($_POST){
  
    // set service property values
    $service->name = $_POST['name'];
    $service->price = $_POST['price'];
  
    // update the service
    if($service->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Service was updated.";
        echo "</div>";
    }
  
    // if unable to update the service, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update service.";
        echo "</div>";
    }
}
?>
  
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark'>
  
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value='<?php echo $service->name; ?>' class='form-control' /></td>
        </tr>
  
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' value='<?php echo $service->price; ?>' class='form-control' /></td>
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