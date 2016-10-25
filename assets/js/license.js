var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 
           var license=$("#license").val();
            var dataString = 'license='+license;
           
             $.ajax({
                type: "POST",
                url: "/setlicense",
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
        $("#licensing").validate({
            rules: {
                license: {
                    required: true,
                    minlength: 5,
                    
                }
            },
            messages: {
                
                license: {
                    required: "Please provide your license",
                    minlength: "Your license must be at least 5 character",
                }
                
            }
        });

        // propose username by combining first- and lastname
       
    });


}();