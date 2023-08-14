<?php

// include database and object files
include_once '../../config/database.php';
include_once '../objects/commpay.php';
include_once '../../employees/objects/employee.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$commpay = new Commpay($db);
$employee = new Employee($db);

$page_title = "Commission Payment";
include_once "../../layout_header.php";
  
echo "<div class='right-button-margin'>
        <a href='commpay_details.php' class='btn btn-default pull-right'>Back Commission Payment Details</a>
    </div>";
  
?>

<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
  
    // set product property values
    $commpay->employee_id = $_POST['employee_id'];
    $commpay->payment_date = $_POST['payment_date'];
    $commpay->amount_paid = $_POST['amount_paid'];
  
    // create the product
    if($commpay->create()){
        echo "<div class='alert alert-success'>Payment has been capture successfully</div>";
    }
  
    // if unable to create the product, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to capture payment.</div>";
    }
}
?>
  
<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  
    <table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped'>
     
        <tr>
            <td>Employee</td>
            <td>
                <?php
                // read the product categories from the database
                $stmt = $employee->read();
                ?>
                
                <select class='form-control' id='employee_id' name='employee_id' onchange="getUnpaidComm('employee_id','unpaidcomm')" required>;
                <option></option>
                <?php
                    while ($row_employee = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row_employee);
                        echo "<option value='{$id}'>{$name}</option>";
                    }
                ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Unpaid Commission</td>
            <td><input type='text' id='unpaidcomm' class='form-control' readonly required/></td>
        </tr>
  
        <tr>
            <td>PaymentDate</td>
            <td><input type='date' name='payment_date' class='form-control' required/></td>
        </tr>
  
        <tr>
            <td>AmountPaid</td>
            <td><input type='text' id='amount_paid' name='amount_paid' class='form-control' required></td>
        </tr>
  
        <tr>
            <td></td>
            <td>
                <button type="button"  id="btnSaveBilling" onclick="comparePaidUnpaid()" class="btn btn-primary">Create</button>
            </td>
        </tr>
  
    </table>
</form>

<script type="text/javascript">  
        //get  unpaidcomm
        function getUnpaidComm(selectId,valueId)
        {
            var unpaidcomm = $("#"+selectId).val();

            // AJAX request
            $.ajax({
                url: '../objects/item.php',
                type: 'post',
                data: {request: 1, unpaidcomm: unpaidcomm},
                dataType: 'json',
                success: function(response){

                var len = response.length;

                    for( var i = 0; i<len; i++){
                        var emp_id = response[i]['emp_id'];
                        var unpaidcomm = response[i]['unpaidcomm'];
                        $("#"+valueId).val(unpaidcomm); 
                    }
                }
            });
        }

        function comparePaidUnpaid()
        {
            let unpaid=document.getElementById('unpaidcomm').value;
            let paid=document.getElementById('amount_paid').value;   
            if(parseFloat(paid)>parseFloat(unpaid)){
                alert("Amount Paid is more than unpaid commission");
                $("#btnSaveBilling").prop("type","button");
                $("#btnSaveBilling").removeClass("btn btn-success");
                $("#btnSaveBilling").addClass("btn btn-primary");
            }
            else{
                $("#btnSaveBilling").removeClass("btn btn-success");
                $("#btnSaveBilling").addClass("btn btn-primary");
                $("#btnSaveBilling").prop("type","submit");
            }
        }
</script>

<?php
  
// footer
include_once "../../layout_footer.php";
?>