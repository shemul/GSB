var Script = function () {
    // add the rule here
    $.validator.addMethod("valueNotEquals", function (value, element, arg) {
        return arg != value;
    }, "Value must not equal arg.");
    $.validator.setDefaults({
        submitHandler: function () {
            var amount = $("#amount").val();
            //var types=$("#type").val();
            var dataString = 'amount=' + amount;
            var gateway = $("#paymentgateway").val();
            $.ajax({
                type: "POST",
                url: "/buypoints/build",
                data: dataString,
                cache: false,
                beforeSend: function () {
                    $("#submitpayment").hide();
                    $("#waitingpayment").show();
                    $("#suksesupdate").hide();
                    $("#gagalupdate").hide();
                },
                complete: function (e, xhr, settings) {
                    if (e.status === 200) {
                        $("#waitingpayment").text("Redirecting to Payment Processor");
                        //$("#suksesupdate").show();
                        setTimeout(function () {
                            window.location.href = '/buypoints/pay/' + gateway;
                        }, 2000);
                    } else {
                        $("#submitpayment").show();
                        $("#waitingpayment").hide();
                        //$("#suksesupdate").show();
                        $("#gagalupdate").show();
                    }
                }
            });
        }
    });

    $().ready(function () {
        $("#buypoint").validate({
            rules: {
                amount: {
                    required: true,
                    min: $("#amount").data("minimum"),
                    digits: true
                },
                paymentgateway: {
                    valueNotEquals: "0",
                },
            },
            messages: {
                amount: {
                    required: "You must specified how much you want to buy",
                    min: "Minimum is $"+$("#amount").data("minimum")+"USD",
                    digits: "Amount must be numerical ONLY"
                },
                paymentgateway: {
                    valueNotEquals: "You must select payment gateway",
                }
            }
        });

        // propose username by combining first- and lastname

    });


}();