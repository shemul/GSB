var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 
           var bankname=$("#bank_name").val();
           var branchname=$("#branchname").val();
           var holder=$("#holder").val();
           var acnumber=$("#acnumber").val();
           var swift=$("#swiftcode").val();
           //var beneficiary=$("#beneficiary").val();
           var pin=$("#pin").val();
            var dataString = 'bankname='+bankname+'&branch='+branchname+'&holder='+holder+'&acnumber='+acnumber+'&swift='+swift+'&pin='+pin;
           
             $.ajax({
                type: "POST",
                url: "/account/bank/add/submit",
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
                            window.location.href="/account/bank";
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
        $("#addbank").validate({
            rules: {
               bank_name: {
                    minlength:3,
                    required: true
                },
                branchname: {
                    minlength:3,
                    required: true
                },
                holder: {
                    minlength:5,
                    required: true
                },
                acnumber: {
                    minlength:5,
                    required: true,
                    digits:true
                },
                swiftcode: {
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
                
                bank_name: {
                    minlength:"Your bank name must be at least 3 character",
                    required: "Please fill your bank name information"
                },
                branchname: {
                    minlength:"Your branch name must be at least 3 character",
                    required: "Please fill your branch name information"
                },
                holder: {
                    minlength:"Your bank holder name must be at least 5 character",
                    required: "Please fill your bank holder name"
                },
                acnumber: {
                    minlength:"Your bank account number must be at least 5 number",
                    required: "Please fill your account number information",
                    digits:"Account Number must be numerical only"
                },
                swiftcode: {
                    required: "Please fill your swiftcode information"
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