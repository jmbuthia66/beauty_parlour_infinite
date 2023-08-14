<?php
$paymode=trim($_REQUEST['reportControl']);
$from=trim($_REQUEST['fromDate']);
$todate=trim($_REQUEST['toDate']);
if($paymode=="All"){
    $stmt = $commission->readAllPay($from,$todate);
}else{
    $stmt = $commission->readOnePay($paymode,$from,$todate);
}
$num = $stmt->rowCount();
if($num>0){
    $mpesaTotal=0;
    $cashTotal=0;
    $totTotal=0;
?>
<table class="table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark">
    <thead>
        <tr>
            <th>CreatedDate</th> 
            <th>TranDate</th> 
            <th>TranNo</th> 
            <th>Mpesa</th> 
            <th>Cash</th> 
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php  
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);                
                $mpesaTotal+=(float)$mpesa;                
                $cashTotal+=(float)$cash;
                $totTotal+=(float)$total;
                echo "<tr>";
                    echo "<td>{$created_date}</td>";
                    echo "<td>{$tran_date}</td>";
                    echo "<td>{$tran_no}</td>";
                    echo "<td>{$mpesa}</td>";
                    echo "<td>{$cash}</td>";
                    echo "<td>{$total}</td>";
                echo "</tr>";  
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='3' class="compute">Totals</td>
            <td><?php echo number_format($mpesaTotal,2);?></td>
            <td><?php echo number_format($cashTotal,2);?></td>
            <td><?php echo number_format($totTotal,2);?></td>
        </tr>
    </tfoot>
</table>
<?php
}else{
    echo "<div class='alert alert-info'>No data found.</div>";
}