$(document).ready(function() {
    $('#reset').click(function(){
        var username=$("#uname").val();
        var token=$("#token").val();
        var dataString = 'uname='+username+'&token='+token;
        if($.trim(username).length>0){
            $.ajax({
                type: "POST",
                url: "/forgot-password/reset",
                data: dataString,
                cache: false,
                beforeSend: function(){ $("#status").html('<p>Connecting to server....</p>');},
                complete: function(e, xhr, settings){
                    if(e.status === 200){
                       $("#status").html("<span style='color: #00CC96;'>Success:</span> Your new password has been sent to your email ");
                       // TRIGGER SETELAH SUKSES NANTI DISINI, BISA BERUPA DIRECT KE DASHBOARD
                    }else{
                        //Shake animation effect.
                    $('form').shake();
                    $("#status").html("<span style='color:#cc0000'>Error:</span> Invalid username");
                    }
                }
                
            });
        }
        return false;
    });

});