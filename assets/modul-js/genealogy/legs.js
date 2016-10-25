function loadData(page){
         $.ajax({
                type: "POST",
                url: "/genealogy/legs/list",
                data: "page="+page,
                cache: false,
                beforeSend: function(){ $("#loading").show();},
                success: function(msg)
                        {
                            $(".legs-tbl-wrap").ajaxComplete(function(event, request, settings)
                            {
                                //loading_hide();
                                $(".legs-tbl-wrap").html(msg);
                                $('#legs-tbl').footable();
                            });
                        }
                
            });
        
}
    
$(document).ready(function() {
    loadData(1);
    $('.legs-tbl-wrap .pagination li').live('click',function(){
                    var page = $(this).attr('p');
                    loadData(page);
                    
                });  
   

});
