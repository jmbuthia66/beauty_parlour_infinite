<?php
$empid=trim($_REQUEST['reportControl']);
$from=trim($_REQUEST['fromDate']);
$todate=trim($_REQUEST['toDate']);
if($empid=="All"){
    $stmt = $commission->readCommPayAll($from,$todate);
}else{
    $stmt = $commission->readCommPayOne($empid,$from,$todate);
}
$num = $stmt->rowCount();
if($num>0){
    //define total paramers
    $amountPaid=0;
?>

<table class="table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark">
    <thead>
        <tr>
            <th>Employee</th> 
            <th>Payment Date</th> 
            <th>Amount Paid</th> 
            <th>Date Entered</th> 
        </tr>
    </thead>
    <tbody>
        <?php  
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $amountPaid+=(float)$amount_paid;
                echo "<tr>";
                    echo "<td>{$name}</td>";
                    echo "<td>{$payment_date}</td>";
                    echo "<td>{$amount_paid}</td>";
                    echo "<td>{$date_entered}</td>";
                echo "</tr>";  
            }            
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='2' class="compute">Totals</td>
            <td><?php echo number_format($amountPaid,2);?></td>
            <td></td>
        </tr>
    </tfoot>
</table>

<style>
    .form-control
    {
        border: 1px solid #cccccc;
    }
    .compute
    {
        text-align:right;
    }
</style>

<?php
}else{
    echo "<div class='alert alert-info'>No data found.</div>";
}
?>