var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 
           var newpin=$("#newpin").val();
           var oldpin=$("#oldpin").val();
           var token=$("#token").val();
            var dataString = 'newpin='+newpin+'&oldpin='+oldpin+'&token='+token;
           
             $.ajax({
                type: "POST",
                url: "/profile/chpin/update",
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
        $("#chpin").validate({
            rules: {
                newpin: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                    digits: true
                },
                confirm_newpin: {
                    equalTo: "#newpin",
                },
                oldpin: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                    digits: true
                },
                token: {
                    required: true,
                    
                },
            },
            messages: {
                
                newpin: {
                    required: "Please provide a new PIN",
                    minlength: "Your PIN must be at least 6 DIGITS",
                    maxlength: "Your PIN must be 6 DIGITS",
                    digits: "Your PIN must be numerical ONLY"
                    
                },
                confirm_newpin: {
                    equalTo: "Please enter the same PIN as above"
                },
                oldpin: {
                    required: "Please provide current PIN",
                    minlength: "Your PIN must be at least 6 DIGITS",
                    maxlength: "Your PIN must be 6 DIGITS",
                    digits: "Your PIN must be numerical ONLY"
                },
                token: {
                    required: "Please provide your secret token",
                    
                },
                
            }
        });

        // propose username by combining first- and lastname
       
    });


}();