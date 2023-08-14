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
        if(reportType==1)//Employee
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
        else{
            $("#reportControl").html("<option value=''>Select report type</option>");
        }
   }else{
    alert("select report type"+reportType);
   }
   //reportControl fromDate toDate
}

</script>