var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 
            var dataString = $('#addproduct').serialize();
             $.ajax({
                type: "POST",
                url: "/products/edit/submit",
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
                            window.location.href="/products";
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
        $("#addproduct").validate({
            rules: {
               product_name: {
                    minlength:3,
                    required: true
                },
                value: {
                   
                    required: true
                },
                max_pair: {
                   
                    required: true
                },
                ref: {
                  
                    required: true
                },
                devrate: {
                    required: true
                },
               
            }
        });

        // propose username by combining first- and lastname
       
    });


}();