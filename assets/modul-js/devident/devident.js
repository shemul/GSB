function closeDev(){
    var dataString = 'close=1';
    $.ajax({
                type: "POST",
                url: "/devident/close",
                data: dataString,
                cache: false,
                beforeSend: function(){ 
                    $("#closeDev").hide();
                    $("#waitya").show();
                },
                complete: function(e, xhr, settings){
                    if(e.status === 200){
                        setTimeout(function() {
                            window.location.href=window.location.href;
                        }, 2000);
                    }else{
                        setTimeout(function() {
                            window.location.href=window.location.href;
                        }, 2000);
                    }
                }
                
            }); 
}
function loadData(page){
         $.ajax({
                type: "POST",
                url: "/devident",
                data: "page="+page,
                cache: false,
                beforeSend: function(){ $("#loading").show();},
                success: function(msg)
                        {
                            $(".devident-tbl-wrap").ajaxComplete(function(event, request, settings)
                            {
                                //loading_hide();
                                $(".devident-tbl-wrap").html(msg);
                                $('#devident-tbl').footable();
                            });
                        }
                
            });
        
}
$(document).ready(function() {
    loadData(1);
    
    $('.devident-tbl-wrap .pagination li').live('click',function(){
                    var page = $(this).attr('p');
                    loadData(page);
                    
                }); 
    $('#closeDev').live('click',function(){
                    closeDev();
                });              

});