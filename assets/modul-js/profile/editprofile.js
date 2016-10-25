var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { 

            var uname=$("#uname").val();
            var fname=$("#fname").val();
            var lname=$("#lname").val();
            var gender=$("#gender").val();
            var mobile=$("#mobile").val();
            var beneficiary=$("#beneficiary").val();
            var address=$("#address").val();
            var city=$("#city").val();
            var state=$("#state").val();
            var country=$("#country").val();
            var zip=$("#zip").val();
            var fat_name=$("#fat_name").val();

            var upline=$("#upline").val();
            console.log(upline)

            var dataString = 'fname='+fname+'&lname='+lname+'&gender='+gender+'&mobile='+mobile+'&beneficiary='+beneficiary+'&address='+address +'&uname='+uname +'&upline='+upline+'&fat_name='+fat_name;
           console.log(dataString);
             $.ajax({
                type: "POST",
                url: "/profile/edit/update",
                data: dataString,
                cache: false,
                beforeSend: function(){ 
                    $("#submitprofile").hide();
                    $("#waiting").show();
                    $("#suksesupdate").hide();
                    $("#gagalupdate").hide();
                },
                complete: function(e, xhr, settings){
                    if(e.status === 200){
                        $("#submitprofile").show();
                        $("#waiting").hide();
                        $("#suksesupdate").show();
                        //$("#gagalupdate").hide();
                        console.log(e);
                    }else{
                        $("#submitprofile").show();
                        $("#waiting").hide();
                        //$("#suksesupdate").show();
                        $("#gagalupdate").show();
                    }
                }
                
            });
        
        return false;
        }
    });

    $().ready(function() {
        // validate the comment form when it is submitted
        $("#editForm").validate();
    });


}();