function loadData(page){
         $.ajax({
                type: "POST",
                url: "/account/withdraw/list",
                data: "page="+page,
                cache: false,
                beforeSend: function(){ $("#loading").show();},
                success: function(msg)
                        {
                            $(".withdraw-tbl-wrap").ajaxComplete(function(event, request, settings)
                            {
                                //loading_hide();
                                $(".withdraw-tbl-wrap").html(msg);
                                $('#withdraw-tbl').footable();
                            });
                        }
                
            });
        
}
function filter(){
    var status = $("#status").val();
    $.ajax({
                type: "POST",
                url: "/account/withdraw/filter",
                data: "status="+status,
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
                url: "/account/withdraw/clearfilter",
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
    $('#clearfilter').live('click',function(){
        clearfilter();
    }); 
    $('.withdraw-tbl-wrap .pagination li').live('click',function(){
                    var page = $(this).attr('p');
                    loadData(page);
    });  

});