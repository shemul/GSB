$(document).ready(function () {
    $('#activatePayment').live('click', function () {
        $(this).prop('disabled',true);
        $(this).text('Please Wait');
        if ($('#gateways').val() == "0") {
            alert("PLEASE SELECT THE PAYMENT GATEWAY");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "/activateGateway",
                data: "gateway=" + $("#gateways").val(),
                cache: false,
                success: function (msxg)
                {
                    location.reload();
                }

            });
        }
    });
    $('.deactivate').live('click', function () {
        $(this).prop('disabled',true);
        $(this).text('Please Wait');
        var x = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "/deactivateGateway",
            data: "gateway=" + x,
            cache: false,
            success: function (msxg)
            {
                location.reload();
            }

        });
    });
});