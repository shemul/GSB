var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 
           var newpass=$("#newpass").val();
           var oldpass=$("#oldpass").val();
           var token=$("#token").val();
            var dataString = 'newpass='+newpass+'&oldpass='+oldpass+'&token='+token;
           
             $.ajax({
                type: "POST",
                url: "/profile/chpwd/update",
                data: dataString,
                cache: false,
                beforeSend: function(){ 
                    $("#submitpass").hide();
                    $("#waitingpass").show();
                    $("#suksesupdate").hide();
                    $("#gagalupdate").hide();
                },
                complete: function(e, xhr, settings){
                    if(e.status === 200){
                        $("#submitpass").show();
                        $("#waitingpass").hide();
                        $("#suksesupdate").show();
                        setTimeout(function() {
                            window.location.href=window.location.href + "?success=1";
                        }, 2000);
                    }else{
                        $("#submitpass").show();
                        $("#waitingpass").hide();
                        //$("#suksesupdate").show();
                        $("#gagalupdate").show();
                    }
                }
                
            }); 
        }
    });

    $().ready(function() {
        $("#chpwd").validate({
            rules: {
                newpass: {
                    required: true,
                    minlength: 5
                },
                confirm_newpass: {
                    equalTo: "#newpass",
                },
                oldpass: {
                    required: true,
                    minlength: 5
                },
                token: {
                    required: true,
                    
                },
            },
            messages: {
                
                newpass: {
                    required: "Please provide a new password",
                    minlength: "Your password must be at least 5 character",
                    
                },
                confirm_newpass: {
                    equalTo: "Please enter the same password as above"
                },
                oldpass: {
                    required: "Please provide your current password",
                    minlength: "Your password must be at least 5 character",
                },
                token: {
                    required: "Please provide your secret token",
                    
                },
                
            }
        });

        // propose username by combining first- and lastname
       
    });


}();