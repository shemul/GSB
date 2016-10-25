$(document).ready(function() {
   //$('#treeview-pan').panner({control: $('#pan-5-control')});
    var $section = $('.pan-container').first();
    $section.find('#treeview-pan').panzoom();
    $('li.subx').live('click',function(){
                    var id = $(this).attr('data-id');
                    $(this).removeClass('subx');
                    $("<p class='loadingtext'>Loading Data.. Please wait...</p>").insertAfter("[data-id="+id+"] a");
                    var msg = "";
                     $.ajax({
                     type: "POST",
                     url: "/genealogy/tree/sub",
                     data: "id="+id,
                     cache: false,
                     //beforeSend: function(){ $("#loading").show();},
                     success: function(msg)
                        {
                            $('p.loadingtext').remove();
                            $(msg).insertAfter("[data-id="+id+"] a");
                        }
                
                    });
                    
                });  
    $("#tree-loading").hide();
    $(".pan-container").show();
});