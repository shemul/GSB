$(document).ready(function () {
    $('#login').click(function () {
        var username = $("#uname").val();
        var password = $("#pass").val();
        var token = $("#token").val();
        var dataString = 'uname=' + username + '&pwd=' + password + '&token=' +token;
        if ($.trim(username).length > 0 && $.trim(password).length > 0) {
            $.ajax({
                type: "POST",
                url: "/login/auth",
                data: dataString,
                cache: false,
                beforeSend: function () {
                    $("#status").html('<p>Connecting to server....</p>');
                },
                complete: function (e, xhr, settings) {
                    if (e.status === 200) {
                        $("#status").html("<span style='color: #00CC96;'>Success:</span> Redirecting to dashboard ");
                        // TRIGGER SETELAH SUKSES NANTI DISINI, BISA BERUPA DIRECT KE DASHBOARD
                        setTimeout(function () {
                            window.location.href = "/dashboard"; // The URL that will be redirected too.
                        }, 3000);

                    } else {
                        //Shake animation effect.
                        $('form').shake();
                        $("#status").html("<span style='color:#cc0000'>Error:</span> Invalid username and password. ");
                    }
                }

            });
        }
        return false;
    });
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

});