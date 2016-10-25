$("#date").datepicker({format: 'yyyy-mm-dd'});
function clearDate(){
    $("#date").val("");
}
function loadData(page){
         $.ajax({
                type: "POST",
                url: "/dashboard/stat",
                data: "page="+page,
                cache: false,
                dataType:"json",
                beforeSend: function(){ $("#loading").show();},
                success: function(msg)
                        {
                            console.log(msg);
                            //console.log(msg.total_product);

                            

                                $(".total_form").html("TOTAL FORM " + msg.total_user);
                                $(".total_product").html("TOTAL PRODUCT " + msg.total_product);
                                $(".week_form").html("FORM : " + msg.week_form);
                                
                                $(".week_free_form").html("FREE FORM : " + msg.week_free_form);
                                $(".total_free").html("TOTAL FREE : " + msg.total_free);
                                $(".total_ban").html("TOTAL BAN : " + msg.total_ban);
                        }
                
            });
        
}

$(document).ready(function() {
    loadData(1);
});