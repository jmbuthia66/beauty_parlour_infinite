<?php
$cat=trim($_REQUEST['reportControl']);
$from=trim($_REQUEST['fromDate']);
$todate=trim($_REQUEST['toDate']);
if($cat=="All"){
    $stmt = $commission->readSaleAll($from,$todate);
}else{
    $stmt = $commission->readSaleOne($cat,$from,$todate);
}
$num = $stmt->rowCount();
if($num>0){
    //define total paramers
    $priceTotal=0;
    $discountTotal=0;
    $totalPriceTotal=0;
?>

<table class="table table-hover table-responsive table-bordered table-sm thead-dark table-striped table-dark">
    <thead>
        <tr>
            <th>TranDate</th> 
            <th>Category</th> 
            <th>Item</th> 
            <th>Price</th> 
            <th>Qty</th>
            <th>Discount</th> 
            <th>TotalPrice</th>
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
                echo "<tr>";
                    echo "<td>{$tran_date}</td>";
                    echo "<td>{$category}</td>";
                    echo "<td>{$item}</td>";
                    echo "<td>{$price}</td>";
                    echo "<td>{$qty}</td>";
                    echo "<td>{$discount}</td>";
                    echo "<td>{$total_price}</td>";
                echo "</tr>";  
            }            
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='3' class="compute">Totals</td>
            <td><?php echo number_format($priceTotal,2);?></td>
            <td></td>
            <td><?php echo number_format($discountTotal,2);?></td>
            <td><?php echo number_format($totalPriceTotal,2);?></td>
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