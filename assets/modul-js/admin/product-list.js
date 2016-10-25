$("#date").datepicker({format: 'yyyy-mm-dd'});
function clearDate(){
    $("#date").val("");
}
function loadData(page){
         $.ajax({
                type: "POST",
                url: "/products/list",
                data: "page="+page,
                cache: false,
                beforeSend: function(){ $("#loading").show();},
                success: function(msg)
                        {
                            $(".product-tbl-wrap").ajaxComplete(function(event, request, settings)
                            {
                                //loading_hide();
                                $(".product-tbl-wrap").html(msg);
                                $('#product-tbl').footable();
                            });
                        }
                
            });
        
}
function filter(){
    var productid = $("#productid").val();
    var date = $("#date").val();
    var type = $("#producttype").val();
    var flow = $("#productflow").val();
    var model = $("#model").val();
    var user = $("#user").val();
       $.ajax({
                type: "POST",
                url: "/productaction/filter",
                data: "productid="+productid+"&date="+date+"&type="+type+"&flow="+flow+"&model="+model+"&uname="+user,
                cache: false,
                success: function(msg)
                        {
                           loadData(1);
                           $("#filter").html("<i class='fa fa-search'></i> FILTER");
                           $("#filter").attr("disabled", false);
                        }
                
            });
}
function DisableProduct(id){
         $.ajax({
                type: "POST",
                url: "/products/disable",
                data: "idproduct="+id,
                cache: false,
               complete: function(e, xhr, settings){
                    if(e.status === 200){
                        loadData(1)
                    }else{
                        alert("DISABLE PRODUCT FAILED");
                    }
                }
                
            });
        
}
function EnableProduct(id){
         $.ajax({
                type: "POST",
                url: "/products/enable",
                data: "idproduct="+id,
                cache: false,
                complete: function(e, xhr, settings){
                    if(e.status === 200){
                        loadData(1)
                    }else{
                        alert("ENABLE PRODUCT FAILED");
                    }
                }
                
            });
        
}
function clearfilter(){
     $.ajax({
                type: "POST",
                url: "/productaction/clearfilter",
                data: "clear=1",
                cache: false,
                success: function(msg)
                        {
                           loadData(1);
                        }
                
            });
}
$(document).ready(function() {
    loadData(1);
    $('#filter').live('click',function(){
        $(this).html("<i class='fa fa-search'></i> PLEASE WAIT..")
        $(this).attr("disabled", true);
        filter();
    }); 
    $('.disableprod').live('click',function(){
                    $(this).text("PLEASE WAIT...");
                    var id = $(this).attr('data-id');
                    DisableProduct(id);
    });
    $('.enableprod').live('click',function(){
                    $(this).text("PLEASE WAIT...");
                    var id = $(this).attr('data-id');
                    EnableProduct(id);
    });
    $('.product-tbl-wrap .pagination li').live('click',function(){
                    var page = $(this).attr('p');
                    loadData(page);
    });  

});