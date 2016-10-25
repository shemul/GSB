<?php

global $hooks;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$ppdata = getSetting('active_gateway');
if ($ppdata != "") {
    $hooks->add_action('silex_action', 'the_point'); // Tancapkan fungsi dashboard ke Trigger Silex
    $hooks->add_action('all_menu', 'menu_point');
}

// Define Heading masing2 page
function buypoint_title() {
    echo "Buy Point";
}

function buypoint_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/modul-js/buypoint/buy.js"></script>
    <?php

}

function menu_point() {
    global $menu_array;
    $pointmenu = array(
        "label" => "Buy Point",
        "url" => "/buypoints",
        "icon" => "fa fa-money"
    );
    $menu_array[6] = $pointmenu;
}

function the_point() {
    global $app;
// Smarty untuk menu register balance
    $app->get('/buypoints', function() {
        global $hooks;
        global $global_min_bpoint;
        global $payment_gateway;
        unset($_SESSION['temp_purchase']);
        unset($_SESSION["purchase"]);
        $active_gateway = unserialize(getSetting('active_gateway'));
        $hooks->do_action('payment_gateway');
        $hooks->add_action('global_js', "buypoint_js");
        $hooks->add_action('the_title', "buypoint_title");
        the_head();
        include 'buypoint.tpl.php';
        //echo "WORKING ON SOME UPDATES";
        the_footer();
        return "";
    });
    $app->post('/buypoints/build', function(Request $request) {
        global $db;
        global $global_min_bpoint;
        if ($request->get('amount') >= $global_min_bpoint) {
            if (isset($_SERVER['HTTPS'])) {
                $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
            } else {
                $protocol = 'http';
            }
            $curdom = $protocol . "://" . $_SERVER['SERVER_NAME'];
            $_SESSION["temp_purchase"] = array(
                'amount' => $request->get('amount'),
                'description' => 'POINT PURCHASE',
                'curdom' => $curdom
            );
            return new Response('SUCCESS', 200);
        } else {
            $file = strtotime("now") . ".txt";
            $handle = fopen("logsz/" . $file, 'w') or die('Cannot open file:  ' . $file);
            $data = 'IS PIN RIGHT ? = ' . (pinCorrect($pin) ? "YA" : "SALAH TERDETEKSI PIN = [" . $pin . "]") . " \n USERNAME PENERIMA BENAR ? = " . (userExist($uname) ? "YA" : "SALAH TERDETEKSI USERNAME = [" . $uname . "]");
            fwrite($handle, $data);
            return new Response('Failed', 201);
        }
    });
    $app->get('/buypoints/pay/{id}', function (Request $request, $id) use ($app) {
        $builddata = $_SESSION["temp_purchase"];
        $param = array(
            'amount' => floatval($builddata['amount']),
            'returnUrl' => $builddata['curdom'] . '/buypoints/success/' . $id,
            'cancelUrl' => $builddata['curdom'] . '/buypoints/cancel/' . $id,
            'description' => $builddata['description'],
        );
        $gateway = new $id();
        $gateway->buildPayment($param);
        $gateway->purchase();
        return "";
    });
    $app->get('/buypoints/success/{id}', function (Request $request, $id) use ($app) {
        $gateway = new $id();
        $gateway->setUp();
        $gateway->complete();
        unset($_SESSION['purchase']);
        unset($_SESSION['temp_purchase']);
        return $app->redirect('/buypoints');
    });
    $app->get('/buypoints/cancel/{id}', function (Request $request, $id) use ($app) {
        unset($_SESSION['temp_purchase']);
        unset($_SESSION["purchase"]);
        return $app->redirect('/buypoints');
        
    });
}
