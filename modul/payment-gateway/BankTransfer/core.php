<?php
global $hooks;
$hooks->add_action('payment_gateway','register_bank');

/* Register Paypal Payment Gateway */
function register_bank(){
    global $payment_gateway;
    $payment_gateway[]=array(
        "id"    => "BankTransfer",
        "name" => "Bank Transfer"
    );
}

include 'bank-class.php';