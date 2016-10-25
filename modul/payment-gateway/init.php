<?php

global $hooks;
$payment_gateway = array();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/* Include All Payment Gateway */
foreach (glob("modul/payment-gateway/*/core.php") as $filename) {
    include $filename;
}


if ($_SESSION["role"] == 0) {
    $hooks->add_action('silex_action', 'payment_setting'); // Tancapkan fungsi dashboard ke Trigger Silex
}

function payment_setting_title() {
    echo "PAYMENT SETTINGS";
}

function payment_setting_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/modul-js/payment-gateway/activate.js"></script>
    <script type="text/javascript" src="/assets/modul-js/payment-gateway/save.js"></script>
    <?php

}

function payment_setting() {
    global $app;
    $app->get('/payment-setting', function() {
        global $hooks;
        global $payment_gateway;
        $active_gateway = unserialize(getSetting('active_gateway'));
        $hooks->do_action('payment_gateway');
        $hooks->add_action('global_js', "payment_setting_js");
        $hooks->add_action('the_title', "payment_setting_title");
        the_head();
        include 'setting.tpl.php';
        the_footer();
        return "";
    });
    $app->post('/activateGateway', function(Request $request) {
        global $db;
        $gt = $request->get('gateway');
        if($gt!="0"){
        $gateway = array();
        $active_gateway = getSetting('active_gateway');
        if ($active_gateway != "") {
            $db->query("DELETE FROM settings WHERE name = 'active_gateway'");
            $gateway = unserialize($active_gateway);
        }
        $gateway[] = $request->get('gateway');
        $gateway = serialize($gateway);
        $db->bind("data", $gateway);
        $row = $db->query("INSERT INTO settings(name,value) VALUES ('active_gateway',:data);");
        if ($row) {
            return new Response('SUCCESS', 200);
        }}else{
            return new Response('FAILED', 201);
        }
    });
    $app->post('/deactivateGateway', function(Request $request) {
        global $db;
        $active_gateway = unserialize(getSetting('active_gateway'));
        $gateway = $request->get('gateway');
        if (($key = array_search($gateway, $active_gateway)) !== false) {
            unset($active_gateway[$key]);
        }
        $gateway = serialize($active_gateway);
        $db->bind("data", $gateway);
        $row = $db->query("UPDATE settings SET value = :data WHERE name = 'active_gateway';");
        if ($row) {
            return new Response('SUCCESS', 200);
        }
    });
    $app->post('/save-payment-gateway', function(Request $request) {
        global $db;
        $setting = getSetting('payment_gateway');
        if ($setting != "") {
            $db->query("DELETE FROM settings WHERE name = 'payment_gateway'");
        }
        $gateway = serialize($request->get('gateway'));
        $db->bind("data", $gateway);
        $row = $db->query("INSERT INTO settings(name,value) VALUES ('payment_gateway',:data);");
        if ($row) {
            return new Response('SUCCESS', 200);
        }
    });
}

function createInvoice($data) {
    global $db;
    $db->query("INSERT INTO invoice(invoice_id,status,date,buyer,gateway,amount,notes) VALUES(:inv,:status,NOW(),:buyer,:gateway,:amount,:notes)", 
            array("inv" => $data['idinvoice'], "status" => $data['status'], "buyer" => $_SESSION['uid'], "gateway" => $data['gateway'], "amount" => $data['amount'],"notes" => $data['notes']));
    if ($data['status'] == "1") {
        // SEND MONEY
        $db->query("INSERT INTO fund_transaction(type,nominal,details,from_id,to_id,date) VALUES(:tipe,:nominal,:notes,:from,:to,NOW())", array("tipe" => "1", "nominal" => $data["amount"], "notes" => "PURCHASE POINT", "from" => "0", "to" => $_SESSION["uid"]));
    }
}
