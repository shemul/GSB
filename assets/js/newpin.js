var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 
           var pin=$("#pin").val();
            var dataString = 'pin='+pin;
           
             $.ajax({
                type: "POST",
                url: "/newpin/update",
                data: dataString,
                cache: false,
                beforeSend: function(){ 
                    $("#submitpin").hide();
                    $("#waitingpin").show();
                    $("#suksesupdate").hide();
                    $("#gagalupdate").hide();
                },
                complete: function(e, xhr, settings){
                    if(e.status === 200){
                        $("#submitpin").show();
                        $("#waitingpin").hide();
                        $("#suksesupdate").show();
                        setTimeout(function() {
                            window.location.href = "/dashboard";
                        }, 2000);
                    }else{
                        $("#submitpin").show();
                        $("#waitingpin").hide();
                        //$("#suksesupdate").show();
                        $("#gagalupdate").show();
                    }
                }
                
            }); 
        }
    });

    $().ready(function() {
        $("#newpin").validate({
            rules: {
                pin: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                    digits: true
                },
                confirm_pin: {
                    equalTo: "#pin",
                    
                    
                }
            },
            messages: {
                
                pin: {
                    required: "Please provide a pin",
                    minlength: "Your pin must be 6 digits long",
                    maxlength: "Your pin must be 6 digits long",
                    digits: "Your pin must be numerical only"
                },
                confirm_pin: {
                    equalTo: "Please enter the same pin as above"
                }
                
            }
        });

        // propose username by combining first- and lastname
       
    });


}();