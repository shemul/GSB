<?php

global $hooks;
global $app;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Omnipay\Stripe;

$hooks->add_action('payment_gateway', 'register_stripe');

/* Register Paypal Payment Gateway */

function register_stripe() {
    global $payment_gateway;
    $payment_gateway[] = array(
        "id" => "StripeCC",
        "name" => "Stripe ( Credit Card )"
    );
}

include 'stripe-class.php';
$app->post('/stripe-validation', function (Request $request) use ($app) {
    $token = $request->get('stripetoken');
    $gateway = new StripeCC();
    $purchase = $gateway->final_purchase($token);
    print_r($purchase);
    if($purchase['status']=='0'){
        return new Response($purchase['message'], 401);
    }else{
        return new Response($purchase['message'], 200);
    }
});
