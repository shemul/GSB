$("#date").datepicker({format: 'yyyy-mm-dd'});
function clearDate(){
    $("#date").val("");
}
function loadData(page){
         $.ajax({
                type: "POST",
                url: "/history/list",
                data: "page="+page,
                cache: false,
                beforeSend: function(){ $("#loading").show();},
                success: function(msg)
                        {
                            $(".usr-tbl-wrap").ajaxComplete(function(event, request, settings)
                            {
                                //loading_hide();
                                $(".usr-tbl-wrap").html(msg);
                                $('#usr-tbl').footable();
                            });
                        }
                
            });
        
}
function filter(){
   var date = $("#date").val();
   var user = $("#user").val();
       $.ajax({
                type: "POST",
                url: "/user-management/filter",
                data: "&date="+date+"&uname="+user,
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
                url: "/user-management/clearfilter",
                data: "clear=1",
                cache: false,
                success: function(msg)
                        {
                           loadData(1);
                        }
                
            });
}
function block(id){
   $.ajax({
                type: "POST",
                url: "/user-management/block",
                data: "id="+id,
                cache: false,
                success: function(msg)
                        {
                           loadData(1);
                        }
                
            });
}
function unblock(id){

    $.ajax({
                type: "POST",
                url: "/user-management/unblock",
                data: "id="+id,
                cache: false,
                success: function(msg)
                        {
                           loadData(1);
                        }
                
            });
}
function godMode(id){
   $.ajax({
                type: "POST",
                url: "/user-management/godmode",
                data: "id="+id,
                cache: false,
                success: function(msg)
                        {
                           window.location.href = "/dashboard";
                        }
                
            });
}

function deletemode(id){
    console.log(id);
    $.ajax({
                type: "POST",
                url: "/user-management/deletemode",
                data: "id="+id,
                cache: false,
                success: function(msg)
                        {
                           //console.log("success");
                           window.location.href = "/user-management";
                        }
                
            });
}

function banmode(id){
    
    $.ajax({
            type: "POST",
            url: "/user-management/banmode",
            data: "id="+id,
            cache: false,
            success: function(msg)
            {
               //console.log("success");
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
    $('.usr-tbl-wrap .pagination li').live('click',function(){
                    var page = $(this).attr('p');
                    loadData(page);
    });  
    $('.ban').live('click',function(){
                     $(this).html("PLEASE WAIT..")
                    $(this).attr("disabled", true);
                    var id = $(this).attr('data-id');
                    banmode(id);
    });  
    $('.unban').live('click',function(){
                    $(this).html("PLEASE WAIT..")
                    $(this).attr("disabled", true);
                    var id = $(this).attr('data-id');
                    unblock(id);
    }); 
    $('.godmode').live('click',function(){
                    $(this).html("PLEASE WAIT..")
                    $(this).attr("disabled", true);
                    var id = $(this).attr('data-id');
                    godMode(id);
    }); 
    $('.deletemode').live('click',function(){
                    $(this).html("PLEASE WAIT..")
                    $(this).attr("disabled", true);
                    var id = $(this).attr('data-id');
                    deletemode(id);
    });


});