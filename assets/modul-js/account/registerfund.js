var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 
           var nominal=$("#nominal").val();
           var pin=$("#pin").val();
            var dataString = 'nominal='+nominal+'&pin='+pin;
           
             $.ajax({
                type: "POST",
                url: "/account/register-balance/convert",
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
                            window.location.href=window.location.href + "?success=1";
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
        $("#registerfund").validate({
            rules: {
               nominal: {
                    digits: true,
                    required: true
                },
                pin: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                    digits: true
                },
            },
            messages: {
                
                nominal: {
                    required: "Please enter the ammount you want to transfer",
                    digits: "Number only allowed"
                },
                pin: {
                    required: "Please provide current PIN",
                    minlength: "Your PIN must be at least 6 DIGITS",
                    maxlength: "Your PIN must be 6 DIGITS",
                    digits: "Your PIN must be numerical ONLY"
                },
                
                
            }
        });

        // propose username by combining first- and lastname
       
    });


}();