 jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z0-9\-]+$/i.test(value);
        }, "Letters only please"); 
var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 
            
            var dataString = $('#stepy_form').serialize();
           
             $.ajax({
                type: "POST",
                url: "/register-account/submit",
                data: dataString,
                cache: false,
                beforeSend: function(){ 
                    $("#finish").hide();
                    $("#wait").show();
                    $("#suksesupdate").hide();
                    $("#gagalupdate").hide();
                },
                complete: function(e, xhr, settings){
                    if(e.status === 200){
                        $("#finish").show();
                        $("#wait").hide();
                        $("#suksesupdate").show();
                        //$("#gagalupdate").hide();
                        location.reload();
                    }else{
                        $("#finish").show();
                        $("#wait").hide();
                        //$("#suksesupdate").show();
                        $("#gagalupdate").show();
                    }
                }
                
            });
        
        return false;
        }
    });

    $().ready(function() {
        $('#stepy_form').stepy({
            backLabel: 'Back',
            nextLabel: 'Next',
            errorImage: true,
            block: true,
            description: true,
            legend: false,
            titleClick: true,
            titleTarget: '#top_tabby',
            validate: true
        });
       
        $('#stepy_form').validate({
            errorPlacement: function(error, element) {
                $('#stepy_form div.stepy-error').append(error);
            },
            rules: {
                uname: {
                    lettersonly:false,
                    required: true,
                    minlength: 5,
                    remote: {
                        url: "/register-account/check",
                        type: "post",
                        data: {
                            uname: function() {
                                return $( "#uname" ).val();
                                }
                              }
                    }
                },
                product: {
                    required: true,
                    remote: {
                        url: "/register-account/valuecheck",
                        type: "post",
                        data: {
                            product: function() {
                                return $( "#product" ).val();
                                }
                              }
                    }
                },
                pass: {
                    required: true,
                    minlength: 8,
                },
                pass_conf: {
                    equalTo: "#pass"
                },
                beneficiary: {
                    required: true
                },
                sponsor: {
                  required: true  
                },
                relation: {
                    required: true
                },
                fname: {
                    required: true
                },
                lname : {
                    required: true
                },
                gender : {
                    required: true
                },
                
                address: {
                    required: true
                },
                city: {
                    required: true
                },
                zip: {
                    required: true
                },
                state: {
                    required: true
                },
                country: {
                    required: true
                },
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
                'email': 'required'
            },
            messages: {
                uname: {
                    required: 'Username field is required!',
                    minlength: 'Username must be at least 5 character',
                    remote: "This username is already taken! Try another."
                },
                pass: {
                    required: "Password must be set",
                    minlength: "Password must have at least 8 character",
                },
                pass_conf: {
                    equalTo: "Password didnt match!"
                },
                email: {
                    required: 'Email field is requerid!'
                },
                relation: {
                    required: 'Relation is required!'
                },
                fname: {
                    required: 'First name is required!'
                },
                lname : {
                    required: 'Last name is required'
                },
                gender : {
                    required: 'Gender is required'
                },
                
                address: {
                    required: 'Address is required'
                },
                city: {
                    required: 'City is required'
                },
                zip: {
                    required: 'Zip is required'
                },
                state: {
                    required: 'State is required'
                },
                country: {
                    required: 'Country is required'
                },
                sponsor: {
                    required: "SPONSOR USERNAME REQUIRED"
                },
                beneficiary: {
                    required: "BENEFICIARY REQUIRED"
                },
                product: {
                    required: "Please select join value",
                    remote: "You have insufficient register funds! Select other join value!"
                },
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
            }
        });
    });


}();