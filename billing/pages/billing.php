<?php
    // include database and object files
    include_once '../../config/database.php';
    include_once '../objects/bill.php';
    include_once '../../employees/objects/employee.php';
    include_once '../objects/item.php';
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // pass connection to objects
    $bill = new Bill($db);
    $employee = new Employee($db);
    // $product = new Product($db);
    // $service = new Service($db);

    $page_title = "Billing";
    include_once "../../layout_header.php";
   

    if($_POST)
    {	
        //get max tran_no
        $stmt = $db->prepare("select ifnull(max(tran_no),0)+1 as tran_no from payment_details");
        $stmt->execute();
        $tranno = $stmt->fetchColumn();
        //echo "{$tranno}";

        //Getting post values
        $employee_idArr=$_POST["employee_id"];	
        $sel_categoryArr=$_POST["sel_category"];	
        $sel_itemArr=$_POST["sel_item"];	
        $sel_priceArr=$_POST["sel_price"];	
        $qtyArr=$_POST["qty"];	
        $discArr=$_POST["disc"];	
        $total_priceArr=$_POST["total_price"];

        $tran_dateArr=$_POST["tran_date"];	
        $mpesaArr=$_POST["mpesa"];	
        $cashArr=$_POST["cash"];	
        $totalArr=$_POST["total"];

        if(!empty($employee_idArr) || !empty($totalArr)){  
            $errors=0;
            for($i=0; $i<count($employee_idArr); $i++){
                if(!empty($employee_idArr[$i])){
                    $employee_id=$employee_idArr[$i];
                    $sel_category=$sel_categoryArr[$i];	
                    $sel_item=$sel_itemArr[$i];	
                    $sel_price=$sel_priceArr[$i];	
                    $qty=$qtyArr[$i];	
                    $disc=$discArr[$i];	
                    $total_price=$total_priceArr[$i];
                    
                    $sql ="INSERT INTO billing (employee_id, category_id, item_id, qty, price, discount, total_price,tran_no) VALUES('".$employee_id."','".$sel_category."','".$sel_item."','".$qty."','".$sel_price."','".$disc."','".$total_price."','".$tranno."')";
                    if ($db->query($sql) == TRUE) 
                    { 
                        
                    }
                    else
                    {
                        $errors++;
                    }
                }   
            }              
            
            $tran_date=$tran_dateArr;
            $mpesa=$mpesaArr;	
            $cash=$cashArr;	
            $total=$totalArr;

            $sql2 ="INSERT INTO payment_details (tran_no,mpesa, cash, total, tran_date) VALUES('".$tranno."','".$mpesa."','".$cash."','".$total."','".$tran_date."')";
            if ($db->query($sql2) == TRUE) 
            { 
            }
            else
            {
                $errors++;
            }  
           if($errors==0) { 
                echo "New record created successfully";
            }
            else
            {
                //roll back
                echo 'Record not successfully';
            } 
        } else{            
            echo "The record was not saved, Please check all fields are filled";
        }                          
    }
?>
  
<!-- HTML form for creating a bill -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  
    <table class='table table-hover table-responsive table-bordered table-sm thead-dark table-striped ' id='billingtbl'>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Category</th>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Discount</th>
                <th>TotalPrice</th>
            </tr>
        </thead>
        <tbody>
            <tr>        
                <td>
                    <?php
                        // read the employee from the database
                        $stmt = $employee->readActive();
                        $employeesOptions="<option></option>";
                        // put them in a select drop-down
                        echo "<select class='form-control' name='employee_id[]' required>";
                            echo "<option></option>";
                        
                            while ($row_employee = $stmt->fetch(PDO::FETCH_ASSOC)){
                                extract($row_employee);
                                $employeesOptions.="<option value='{$id}'>{$name}</option>";
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        
                        echo "</select>";
                    ?>
                </td>
                <td>
                    <select class='form-control' id="sel_category" name="sel_category[]" onchange="getItemList('sel_category','sel_item')">
                        <option value="0" ></option>
                        <?php 
                            ## Fetch categories
                            $stmt = $db->prepare("SELECT * from categories order by name");
                            $stmt->execute();
                            $categoryList = $stmt->fetchAll();
                            
                            $categoryOptions="<option></option>";

                            foreach($categoryList as $category){
                                $categoryOptions.="<option value='".$category['id']."'>".$category['name']."</option>";
                                echo "<option value='".$category['id']."'>".$category['name']."</option>";
                            }
                        ?>
                    </select>
                </td>       
                <td>
                    <select class='form-control' id="sel_item" name="sel_item[]" onchange="getItemPrice('sel_item','sel_price0')">
                        <?php                    
                        $itemOptions="<option></option>";
                        ?>
                        <option value="0"></option>
                    </select>
                </td>
                <td>
                    <input class='form-control compute' type="text" id="sel_price0" onchange="getTotals()" readonly  name="sel_price[]"/>
                </td>
                <td><input type='text' id='qty0' name='qty[]'  onchange='getTotals()' class='form-control compute'/></td>
                <td><input type='text' id='disc0' name='disc[]'  onchange='getTotals()' class='form-control compute'/></td>
                <td><input type='text' id='total_price0' name='total_price[]' class='form-control compute' readonly/></td>
                <td><button type="button" name="add" id="add"  class="btn btn-success">+</button></td>
            </tr> 
        </tbody>
        <tfoot>
            <tr><td colspan='3' class="compute">Sub Totals</td>
                <td><input type="text" class="form-control compute" readonly id="totalPrice" name=""/></td>
                <td><input type="text" class="form-control compute" readonly id="totalQty" name=""/></td>
                <td><input type="text" class="form-control compute" readonly id="totalDisc" name=""/></td>
                <td><input type="text" class="form-control compute" readonly id="overalTotal" name=""/></td>
                <td></td>
            </tr>
            <tr>
                <td>Payment Modes</td>
            </tr>
            <tr>
                <td>TranDate</td>
                <td><input type="date" class="form-control compute" id="tran_date" name="tran_date" required/></td>
                <td></td>
            </tr>
            <tr>
                <td>Mpesa</td>
                <td><input type="text" class="form-control compute" id="mpesa" name="mpesa" required/></td>
                <td></td>
            </tr>
            <tr>
                <td>Cash</td>
                <td><input type="text" class="form-control compute" id="cash" name="cash" required/></td>
                <td></td>
            </tr>
            <tr>
                <td>Total</td>
                <td><input type="text" class="form-control compute" readonly id="total"  name="total"/></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <table>                   
        <tr>
            <td></td>
            <td>
                <td><button type="button" class="btn btn-primary" id="btnSaveBilling" onclick="compareTotals()">SAVE</button></td>
            </td>
        </tr>
  
    </table>    
</form>

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

<script type="text/javascript">     
        //get Item
        function getItemList(selectId,selectValId)
        {  
            var categoryid = $("#"+selectId).val();

            // AJAX request
            $.ajax({
                url: '../objects/item.php',
                type: 'post',
                data: {request: 1, categoryid: categoryid},
                dataType: 'json',
                
                success: function(response){
                    let selectOptions="<option value=''></option>";
                    var len = response.length;

                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        selectOptions+="<option value='"+id+"'>"+name+"</option>";
                    }

                    $("#"+selectValId).html(selectOptions);
                }
            });
        }

        //get  Price
        function getItemPrice(selectId,valueId)
        {
            var productid = $("#"+selectId).val();

            // AJAX request
            $.ajax({
                url: '../objects/item.php',
                type: 'post',
                data: {request: 2, productid: productid},
                dataType: 'json',
                success: function(response){

                var len = response.length;

                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var price = response[i]['price'];
                        $("#"+valueId).val(price); 
                        
                        // getTotals();
                        getTotals();
                    }
                }
            });
        }
        
        //calculate total price          
        function getTotals()
        {
            let overallTotal=0;
            let totalDisc=0;
            let totalQty=0;
            let totalPrice=0;
            let sel_prices=document.getElementsByName('sel_price[]');
            let qtys=document.getElementsByName('qty[]');
            let discs=document.getElementsByName('disc[]');
            let totaprices=document.getElementsByName('total_price[]');
            let num_of_rows=sel_prices.length;
            for(var j=0;j<num_of_rows;j++)
            {
                let price=parseFloat(sel_prices[j].value);
                let disc=parseFloat(discs[j].value);
                let qty=parseFloat(qtys[j].value);
                if(isNaN(qty))
                {
                    qtys[j].value=qty=1;
                }   
                if(isNaN(disc))
                {
                    discs[j].value=disc=0;
                }   
                if(isNaN(price))
                {
                    sel_prices[j].value=price=0;
                }
                // console.log(qty+" p"+price+" d"+disc);
                let total=(qty*price)-disc;
                totaprices[j].value=total;
                totalDisc+=disc;
                totalQty+=qty;
                totalPrice+=price;
                overallTotal+=total;
            }
            $("#totalPrice").val(totalPrice);
            $("#totalQty").val(totalQty);
            $("#totalDisc").val(totalDisc);
            $("#overalTotal").val(overallTotal);
        }

        //calculate total price          
        function compareTotals()
        {
            let overalTotal=0;
            let total=0;

            let overtot=document.getElementById('overalTotal');
            let tots=document.getElementById('total');
            
            let overalTot=parseFloat(overtot.value);
            let tot=parseFloat(tots.value);   

            if(isNaN(overalTot))
            {
                overtot.value=0;
            }   
            if(isNaN(tot))
            {
                tots.value=0;
            }
            if(overalTot!=tot || overalTot==0 || tot==0){
                alert("mismatch totals");
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
        
        $(document).ready(function(){
        
            //dynamic table
            var i=1;
            var empList="<?php  echo $employeesOptions;?>";
            var catList="<?php  echo $categoryOptions;?>";
            var itemList="<?php  echo $itemOptions;?>";
            $('#add').click(function(){
                i++;
                $('#billingtbl').append('<tr id="row'+i+'">'+
                '<td><select name="employee_id[]" id="employee_id'+i+'" class="form-control" required>'+empList+'</select></td>'+
                '<td><select name="sel_category[]" id="sel_category'+i+'" onchange="getItemList(\'sel_category'+i+'\',\'sel_item'+i+'\')" class="form-control" required>'+catList+'</select></td>'+
                '<td><select name="sel_item[]" id="sel_item'+i+'" onchange="getItemPrice(\'sel_item'+i+'\',\'sel_price'+i+'\')"  class="form-control" required>'+itemList+'</select></td>'+
                '<td><input type="text" name="sel_price[]" id="sel_price'+i+'" onchange="getTotals()" class="form-control compute" /></td>'+
                '<td><input type="text" name="qty[]" placeholder="qty" onkeyup="getTotals()" class="form-control compute" /></td>'+
                '<td><input type="text" name="disc[]"  onkeyup="getTotals()" placeholder="disc" class="form-control compute" /></td>'+
                '<td><input type="text" name="total_price[]" id="total_price'+i+'" class="form-control compute" /></td>'+
                '<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td>'+
                '</tr>');
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
                getTotals();
            });

            //calculata payment mode totals mpesa + cash
            function calculate(e)
            {
                $('#total').val(parseInt($('#mpesa').val()) + parseInt($('#cash').val()));
            } 
            //on mpesa or cash change call calculate  
            $('#mpesa').keyup(calculate);
            $('#cash').keyup(calculate);
            $('#qty0').keyup(getTotals);
            $('#disc0').keyup(getTotals);
        }); 
</script>

<?php
// footer
include_once "../../layout_footer.php";
?>