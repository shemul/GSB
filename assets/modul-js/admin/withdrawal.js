var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 
           var nominal=$("#nominal").val();
           var bank=$("#bank").val();
           var pin=$("#pin").val();
            var dataString = 'nominal='+nominal+'&bank='+bank+'&pin='+pin;
           
             $.ajax({
                type: "POST",
                url: "/account/withdraw/exec",
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
                        $("#nominal").val('');
                        $("#pin").val('');
                        loadData(1);
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
        $("#wdfund").validate({
            rules: {
               nominal: {
                    digits:true,
                    minlength:3,
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
                    digits:"Numerical only",
                    minlength:"3 Digits minimum",
                    required: "Please fill your bank name information"
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