<?php
$empid=trim($_REQUEST['reportControl']);
if($empid=="All"){
    $stmt = $commission->readAllCommSumm();
}else{
    $stmt = $commission->readAllCommSumm();
}
$num = $stmt->rowCount();
if($num>0){
    //define total paramers
    $commTotal=0;
    $paidCommTotal=0;
    $unpaidCommTotal=0;
?>

<table class="table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark">
    <thead>
        <tr>
            <th>Employee</th> 
            <th>Commission</th> 
            <th>Paid Commission</th> 
            <th>Unpaid Commission</th> 
        </tr>
    </thead>
    <tbody>
        <?php  
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $commTotal+=(float)$commission;
                $paidCommTotal+=(float)$PaidCommission;
                $unpaidCommTotal+=(float)$UnpaidCommission;
                echo "<tr>";
                    echo "<td>{$Employee}</td>";
                    echo "<td>{$commission}</td>";
                    echo "<td>{$PaidCommission}</td>";
                    echo "<td>{$UnpaidCommission}</td>";
                echo "</tr>";  
            }            
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="compute">Totals</td>
            <td><?php echo number_format($commTotal,2);?></td>
            <td><?php echo number_format($paidCommTotal,2);?></td>
            <td><?php echo number_format($unpaidCommTotal,2);?></td>
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