var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 
           var uname=$("#uname").val();
           var pass=$("#pass").val();
           var signature=$("#signature").val();
           var mode=$("#paypalmode").val();
           var logo=$("#logouri").val();
            var dataString = 'uname='+uname+'&pass='+pass+'&signature='+signature+'&mode='+mode+'&logo='+logo;
           
             $.ajax({
                type: "POST",
                url: "/paypal-setting/save",
                data: dataString,
                cache: false,
                beforeSend: function(){ 
                    $("#submitpaypal").hide();
                    $("#waitingpaypal").show();
                    $("#suksesupdate").hide();
                    $("#gagalupdate").hide();
                },
                complete: function(e, xhr, settings){
                    if(e.status === 200){
                        $("#submitpaypal").show();
                        $("#waitingpaypal").hide();
                        $("#suksesupdate").show();
                    }else{
                        $("#submitpaypal").show();
                        $("#waitingpaypal").hide();
                        //$("#suksesupdate").show();
                        $("#gagalupdate").show();
                    }
                }
                
            }); 
        }
    });

    $().ready(function() {
        $("#paypalsave").validate({
            rules: {
                uname: {
                    required: true
                },
                pass: {
                    required: true
                },
                signature: {
                    required: true
                },
            },
            messages: {
                
                uname: {
                    required: "Please insert the Paypal API Username"
                },
                pass: {
                    required: "Please insert the Paypal API password"
                },
                signature: {
                    required: "Please insert the Paypal API Signature"
                },
                
                
                
            }
        });

        // propose username by combining first- and lastname
       
    });


}();