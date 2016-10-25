var Script = function () {

    $.validator.setDefaults({
        submitHandler: function () {
            var dataString = $('.payment-gateway-form').serialize();
            $.ajax({
                type: "POST",
                url: "/save-payment-gateway",
                data: dataString,
                cache: false,
                beforeSend: function () {
                    $('.save-all').prop('disabled',true);
                    $('.save-all').text('Please Wait..');
                },
                complete: function (e, xhr, settings) {
                    if (e.status === 200) {
                        location.reload();
                    } 
                }

            });
        }
    });

    $().ready(function () {
        $(".payment-gateway-form").validate();
        $('.save-all').live('click', function () {
            $('.payment-gateway-form').submit();
        });
    });


}();