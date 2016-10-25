<?php
global $hooks;
$hooks->add_action('payment_gateway','register_paypal');

/* Register Paypal Payment Gateway */
function register_paypal(){
    global $payment_gateway;
    $payment_gateway[]=array(
        "id"    => "PaypalExpress",
        "name" => "Paypal Express Checkout"
    );
}

include 'paypal-class.php';