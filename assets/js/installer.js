$(document).ready(function () {
    $('#install').click(function () {
       var usr = $("#user").val();
        var pass = $("#pass").val();
        var hostname = $("#hostname").val();
        var dbname = $("#dbname").val();
        var adminuname = $("#adminuname").val();
        var adminpass = $("#adminpass").val();
        var mail = $("#adminmail").val();
        
        var dataString = 'user=' + usr + '&pass=' + pass + '&hostname=' + hostname + '&dbname=' + dbname + '&adminuname=' + adminuname + '&adminpass=' + adminpass + '&mail=' + mail;
        
            $.ajax({
                type: "POST",
                url: "/install/save",
                data: dataString,
                cache: false,
                beforeSend: function () {
                    $("#status").html('<p>TRY YOUR CONNECTION..</p>');
                },
                complete: function (e, xhr, settings) {
                    if (e.status === 200) {
                        $("#status").html("<span style='color: #00CC96;'>Success:</span> Redirecting to Homepage ");
                        setTimeout(function () {
                           window.location.href = "/login"; // The URL that will be redirected too.
                        }, 3000);
                    } else {
                        //Shake animation effect.
                        $('form').shake();
                        $("#status").html("<span style='color:#cc0000'>Error:</span> Please make sure that your DB is exists and the credential are correct, then try again.");
                    }
                }

            });
        
        return false;
    });
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

});