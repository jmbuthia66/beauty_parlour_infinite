<script type="">


function loadReportData()
{
   let reportType= parseInt($("#reportType").val()); 
   let reportControl= $("#reportControl").val();
   let fromDate= $("#fromDate").val(); 
   let toDate= $("#toDate").val();
   if(reportType>0)
   {
        //load ajax data here
        if(reportType==1)//commissions
        {
            //load employees
            $.ajax({
                url: '../objects/item.php?reportType='+reportType,
                type: 'post',
                data: {request: 1},
                dataType: 'json',
                success: function(response){
                    var len = response.length;
                    $("#reportControl").html("<option value='All'>All employees</option>");
                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#reportControl").append("<option value='"+id+"'>"+name+"</option>");

                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    let errorMsg = "Status: " + textStatus + " Error: " + errorThrown;
                    alert(errorMsg)
                }
            })
        }
        else if(reportType==2) //payments
        {
            $("#reportControl").html("<option value='All'>All Payments</option>");
        }
        else if(reportType==3) //product sales
        {
            //load products
            $.ajax({
                url: '../objects/item.php?reportType='+reportType,
                type: 'post',
                data: {request: 3},
                dataType: 'json',
                success: function(response){
                    var len = response.length;
                    $("#reportControl").html("<option value='All'>All Products</option>");
                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#reportControl").append("<option value='"+id+"'>"+name+"</option>");

                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    let errorMsg = "Status: " + textStatus + " Error: " + errorThrown;
                    alert(errorMsg)
                }
            })
        }
        else if(reportType==4) //income
        {
            //load categories
            $.ajax({
                url: '../objects/item.php?reportType='+reportType,
                type: 'post',
                data: {request: 4},
                dataType: 'json',
                success: function(response){
                    var len = response.length;
                    $("#reportControl").html("<option value='All'>All Income</option>");
                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#reportControl").append("<option value='"+name+"'>"+name+"</option>");

                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    let errorMsg = "Status: " + textStatus + " Error: " + errorThrown;
                    alert(errorMsg)
                }
            })
        }
        else if(reportType==5)//commissions
        {
            //load employees
            $.ajax({
                url: '../objects/item.php?reportType='+reportType,
                type: 'post',
                data: {request: 5},
                dataType: 'json',
                success: function(response){
                    var len = response.length;
                    $("#reportControl").html("<option value='All'>All employees</option>");
                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#reportControl").append("<option value='"+id+"'>"+name+"</option>");

                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    let errorMsg = "Status: " + textStatus + " Error: " + errorThrown;
                    alert(errorMsg)
                }
            })
        }
        else if(reportType==6) //payments
        {
            $("#reportControl").html("<option value='All'>All Commission Summary</option>");
        }
        else if(reportType==7) //sales
        {
            //load categories
            $.ajax({
                url: '../objects/item.php?reportType='+reportType,
                type: 'post',
                data: {request: 7},
                dataType: 'json',
                success: function(response){
                    var len = response.length;
                    $("#reportControl").html("<option value='All'>All Sales</option>");
                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#reportControl").append("<option value='"+id+"'>"+name+"</option>");

                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    let errorMsg = "Status: " + textStatus + " Error: " + errorThrown;
                    alert(errorMsg)
                }
            })
        }
        else{
            $("#reportControl").html("<option value=''>Select report type</option>");
        }
   }else{
    alert("select report type"+reportType);
   }
   //reportControl fromDate toDate
}

</script>