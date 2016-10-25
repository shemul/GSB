$(".tgl").datepicker({format: 'yyyy-mm-dd'});

function clearDate(){
    $("#from").val("");
    $("#to").val("");
}
function loadData(page){
         $.ajax({
                type: "POST",
                url: "/invoice/list",
                data: "page="+page,
                cache: false,
                beforeSend: function(){ $("#loading").show();},
                success: function(msg)
                        {
                            $(".invoice-tbl-wrap").ajaxComplete(function(event, request, settings)
                            {
                                //loading_hide();
                                $(".invoice-tbl-wrap").html(msg);
                                $('#invoice-tbl').footable();
                            });
                        }
                
            });
        
}
function filter(){
    var status = $("#status").val();
    var wdid = $("#wdid").val();
    $.ajax({
                type: "POST",
                url: "/invoice/filter",
                data: "status="+status+'&wdid='+wdid,
                cache: false,
                success: function(msg)
                        {
                           loadData(1);
                           $("#filter").html("<i class='fa fa-search'></i> FILTER");
                           $("#filter").attr("disabled", false);
                        }
                
            });
}
function clearfilter(){
     $.ajax({
                type: "POST",
                url: "/invoice/clearfilter",
                data: "clear=1",
                cache: false,
                success: function(msg)
                        {
                           loadData(1);
                        }
                
            });
}
function payIt(id){
     $.ajax({
                type: "POST",
                url: "/invoice/pay",
                data: "id="+id,
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
    $('#clearfilter').live('click',function(){
        clearfilter();
    }); 
    $('.invoice-tbl-wrap .pagination li').live('click',function(){
                    var page = $(this).attr('p');
                    loadData(page);
    });  
     $('.pay').live('click',function(){
                    var id = $(this).attr('data-id');
                     $(this).html("PLEASE WAIT..")
                    $(this).attr("disabled", true);
                    payIt(id);
    });  

});