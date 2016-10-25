var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 
           var uname=$("#uname").val();
           var pass=$("#pass").val();
           var host=$("#host").val();
           var port=$("#port").val();
           var sender=$("#sender").val();
            var dataString = 'uname='+uname+'&pass='+pass+'&host='+host+'&port='+port+'&sender='+sender;
           
             $.ajax({
                type: "POST",
                url: "/mail-setting/save",
                data: dataString,
                cache: false,
                beforeSend: function(){ 
                    $("#submit").hide();
                    $("#waiting").show();
                    $("#suksesupdate").hide();
                    $("#gagalupdate").hide();
                },
                complete: function(e, xhr, settings){
                    if(e.status === 200){
                        $("#submit").show();
                        $("#waiting").hide();
                        $("#suksesupdate").show();
                    }else{
                        $("#submit").show();
                        $("#waiting").hide();
                        //$("#suksesupdate").show();
                        $("#gagalupdate").show();
                    }
                }
                
            }); 
        }
    });

    $().ready(function() {
        $("#mailsave").validate({
            rules: {
                uname: {
                    required: true
                },
                sender: {
                    required: true
                },
                host: {
                    required: true
                },
                port: {
                    required: true
                },
            }
        });

        // propose username by combining first- and lastname
       
    });


}();