<?php  
    // include database and object files
    include_once '../../config/database.php';
    include_once '../objects/bill_detail.php';
    
    // instantiate database and objects
    $database = new Database();
    $db = $database->getConnection();
    
    $billdetail = new BillDetail($db);

    // set page header
    $page_title = "Billing Details";
    include_once "../../layout_header.php";
?>

<div class="">
    <form class="form-control col-sm-12 border" method="get" >
        <select class="input-sm input-sel" id="reportType" name="reportType" onchange="loadReportData()" required>
            <option value="">Select Filter</option>
            <option value="1">Employee</option>
            <!-- <option value="2">Item</option> -->
            <!-- <option value="3">Product Sales</option>
            <option value="4">Income</option>
            <option value="5">Commission Payment</option>
            <option value="6">Commission Summary</option>
            <option value="7">Sales</option> -->
        </select>
        <select class="input-sm  input-sel" id="reportControl" name="reportControl" onchange="" required>
            <option value="">Select Filter First</option>
        </select> 
        <input type="date" name="fromDate" class="input-sm inpu-dt" style="padding:8px;" id="fromDate" required/>
        <input type="date" name="toDate" class="input-sm  inpu-dt"  style="padding:8px;"  id="toDate" required/>
        <button type="submit" name="btnReport" id="btnReport" style="margin-top:12px;" class="btn btn-secondary">Request</button>
    </form>
    <style type="text/css">
        .input-sel
        {
            padding:10px 10px;
        },
        .inpu-sm
            {
            padding:5px 10px;
        }
    </style>
</div>

<?php
    if(isset($_REQUEST['reportType']))
    {
        //customised reports loaded here

        $reportType=(int)$_REQUEST['reportType'];
        if($reportType==1)// Employee
        {
            include "filter_employee.php";
        }
        else if($reportType==2)//Item
        {
            include "filter_item.php";
        }
    }
    else
    {
    // tell the user there are no data
    echo "<div class='alert alert-info'>No Data found.</div>";
    }  


    include "filtersJs.php";
    // set page footer
    include_once "../../layout_footer.php";
?>