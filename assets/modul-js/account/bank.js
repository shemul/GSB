function loadData(page){
         $.ajax({
                type: "POST",
                url: "/account/bank/list",
                data: "page="+page,
                cache: false,
                beforeSend: function(){ $("#loading").show();},
                success: function(msg)
                        {
                            $(".bank-tbl-wrap").ajaxComplete(function(event, request, settings)
                            {
                                //loading_hide();
                                $(".bank-tbl-wrap").html(msg);
                                $('#bank-tbl').footable();
                            });
                        }
                
            });
        
}
function removeBank(id){
         $.ajax({
                type: "POST",
                url: "/account/bank/deletebank",
                data: "idbank="+id,
                cache: false,
                success: function(msxg)
                        {
                            
                           //     location.reload();
                                
                            
                        }
                
            });
        
}
$(document).ready(function() {
    loadData(1);
    $('.bank-tbl-wrap .pagination li').live('click',function(){
                    var page = $(this).attr('p');
                    loadData(page);
    });  
    $('.deletebank').live('click',function(){
                    var id = $(this).attr('data-id');
                    removeBank(id);
    });  

});