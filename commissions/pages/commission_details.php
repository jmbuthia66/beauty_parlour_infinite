<?php  
    // include database and object files
    include_once '../../config/database.php';
    include_once '../objects/commission.php';
    
    // instantiate database and objects
    $database = new Database();
    $db = $database->getConnection();
    
    $commission = new Commission($db);

    // set page header
    $page_title = "Reports";
    include_once "../../layout_header.php";
?>

<div class="">
    <form class="form-control col-sm-12 border" method="get" >
        <select class="input-sm input-sel" id="reportType" name="reportType" onchange="loadReportData()" required>
            <option value="">Select Report</option>
            <?php
            //if  user is any
            if($_SESSION['userRoleId']==2){
            ?>
                <option value="2">Payments</option>
            <?php
            }else{?>
            <!-- <option value="3">Product Sales</option> -->
                <option value="1">Commissions</option>
                <option value="2">Payments</option>
                <option value="4">Income</option>
                <option value="5">Commission Payment</option>
                <option value="6">Commission Summary</option>
                <option value="7">Sales</option>
            <?php
            }?>
        </select>
        <select class="input-sm  input-sel" id="reportControl" name="reportControl" onchange="" required>
            <option value="">Select Report First</option>
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
        if($reportType==1)// commissions
        {
            include "daily_commission.php";
        }
        else if($reportType==2)//payments
        {
            include "payment_transactions.php";
        }
        else if($reportType==3)//product sales
        {
            include "product_sales.php";
        }
        else if($reportType==4)//income
        {
            include "income.php";
        }
        else if($reportType==5)//income
        {
            include "commission_payment_rpt.php";
        }
        else if($reportType==6)//income
        {
            include "commission_summary.php";
        }
        else if($reportType==7)//sales
        {
            include "sales.php";
        }
    }
    else
    {
    // tell the user there are no data
    echo "<div class='alert alert-info'>No Data found.</div>";
    }  


    include "reportsJs.php";
    // set page footer
    include_once "../../layout_footer.php";
?>