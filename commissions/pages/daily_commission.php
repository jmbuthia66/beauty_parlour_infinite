<?php
$empid=trim($_REQUEST['reportControl']);
$from=trim($_REQUEST['fromDate']);
$todate=trim($_REQUEST['toDate']);
if($empid=="All"){
    $stmt = $commission->readAll($from,$todate);
}else{
    $stmt = $commission->readOne($empid,$from,$todate);
}
$num = $stmt->rowCount();
if($num>0){
    //define total paramers
    $priceTotal=0;
    $discountTotal=0;
    $totalPriceTotal=0;
    $commissionTotal=0;
?>

<table class="table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark">
    <thead>
        <tr>
            <th>TranDate</th> 
            <th>Employee</th> 
            <th>Category</th> 
            <th>Item</th> 
            <th>Price</th> 
            <th>Qty</th>
            <th>Discount</th> 
            <th>TotalPrice</th>
            <th>CommRate%</th>
            <th>Commission</th>
        </tr>
    </thead>
    <tbody>
        <?php  
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $priceTotal+=(float)$price;
                $discountTotal+=(float)$discount;
                $totalPriceTotal+=(float)$total_price;
                $commissionTotal+=(float)$commission;
                echo "<tr>";
                    echo "<td>{$tran_date}</td>";
                    echo "<td>{$employee_name}</td>";
                    echo "<td>{$category}</td>";
                    echo "<td>{$item}</td>";
                    echo "<td>{$price}</td>";
                    echo "<td>{$qty}</td>";
                    echo "<td>{$discount}</td>";
                    echo "<td>{$total_price}</td>";
                    echo "<td>{$commision_rate}</td>";
                    echo "<td>{$commission}</td>";  
                echo "</tr>";  
            }            
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='4' class="compute">Totals</td>
            <td><?php echo number_format($priceTotal,2);?></td>
            <td></td>
            <td><?php echo number_format($discountTotal,2);?></td>
            <td><?php echo number_format($totalPriceTotal,2);?></td>
            <td></td>
            <td><?php echo number_format($commissionTotal,2);?></td>
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