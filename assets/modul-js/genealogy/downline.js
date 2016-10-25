function loadData(page){
         $.ajax({
                type: "POST",
                url: "/genealogy/downline/list",
                data: "page="+page,
                cache: false,
                beforeSend: function(){ $("#loading").show();},
                success: function(msg)
                        {
                            $(".downline-tbl-wrap").ajaxComplete(function(event, request, settings)
                            {
                                //loading_hide();
                                $(".downline-tbl-wrap").html(msg);
                                $('#downline-tbl').footable();
                            });
                        }
                
            });
        
}
    
$(document).ready(function() {
    loadData(1);
    $('.downline-tbl-wrap .pagination li').live('click',function(){
                    var page = $(this).attr('p');
                    loadData(page);
                    
                });  
   

});
