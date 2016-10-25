<?php
global $hooks;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$hooks->add_action('admin_action', 'the_products'); // Tancapkan fungsi dashboard ke Trigger Silex
// Define Heading & Title

function productInfo($id, $xo) {
    global $db;
    $db->bind("idprod", $id);
    $data = $db->query("SELECT * FROM product WHERE product_id = :idprod");
    return $data[0][$xo];
}

function product_title() {
    echo "Product Lists";
}

function addproduct_title() {
    echo "Add New Product";
}

function editproduct_title() {
    echo "Edit Product";
}

function addproduct_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/modul-js/admin/product-add.js"></script>
    <?php
}

function editproduct_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/modul-js/admin/product-edit.js"></script>
    <?php
}

// Define CSS
function product_css() {
    ?>
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-timepicker/css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
    <link href="/assets/css/footable/footable.core.css" rel="stylesheet">
    <?php
}

function product_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script src="/assets/js/footable/footable.js"></script>
    <script type="text/javascript" src="/assets/modul-js/admin/product-list.js"></script>
    <?php
}

function the_products() {
    global $app;
    $app->post('/products/add/submit', function(Request $request)  {
        global $db;
        // Catch the Request Data
        $pname = $request->get('product_name');
        $value = $request->get('value');
        $ref =   $request->get('ref');
        $drate = $request->get('devrate');
        $mpair = $request->get('max_pair');
        // PREPARE
        $db->bind("pname", $pname);
        $db->bind("value", $value);
        $db->bind("devrate", $drate);
        $db->bind("maxpair", $mpair);
        $db->bind("ref", $ref);
        // Execute
        $row = $db->query("INSERT INTO product(product_name,value,devident_rate,max_pairing,description) VALUES(:pname,:value,:devrate,:maxpair,:ref)");
        if ($row) {
            return new Response('SUCCESS', 200);
        } else {
            return new Response('Failed', 201);
        }
    });
    $app->post('/products/edit/submit', function(Request $request)  {
        global $db;
        // Catch The Request
        $pname = $request->get('product_name');
        $value = $request->get('value');
        $ref = $request->get('ref');
        $drate = $request->get('devrate');
        $mpair = $request->get('max_pair');
        $id = $request->get('id');
        // PREPARE DATA
        $db->bind("pname", $pname);
        $db->bind("value", $value);
        $db->bind("dev_rate", $drate);
        $db->bind("maxpair", $mpair);
        $db->bind("ref", $ref);
        $db->bind("prod_id", $id);
        // EXECUTE
        $row = $db->query("UPDATE product SET product_name = :pname,value = :value ,devident_rate = :dev_rate,max_pairing = :maxpair,description = :ref WHERE product_id = :prod_id");
        if ($row) {
            return new Response('SUCCESS', 200);
        } else {
            return new Response('Failed', 201);
        }
    });
    $app->post('/products/disable', function(Request $request)  {
        global $db;
        $prod = $request->get('idproduct');
        $db->bind("prod", $prod);
        $row = $db->query("UPDATE product SET disable = 1 WHERE product_id = :prod;");
        if ($row) {
            return new Response('SUCCESS', 200);
        } else {
            return new Response('FAILED', 201);
        }
    });
    $app->post('/products/enable', function(Request $request) {
        global $db;
        $prod = $request->get('idproduct');
        $db->bind("prod", $prod);
        $row = $db->query("UPDATE product SET disable = 0 WHERE product_id = :prod;");
        if ($row) {
            return new Response('SUCCESS', 200);
        } else {
            return new Response('FAILED', 201);
        }
    });
    $app->get('/products/edit/{id}', function ($id) use ($app) {
        global $db;
        global $hooks;
        global $prodid;
        $prodid = $app->escape($id);
        $hooks->add_action('global_js', "editproduct_js");
        $hooks->add_action('the_title', "editproduct_title");
        the_head();
        
        include 'product.edit.php';
        the_footer();
        return "";
    });
    $app->get('/products/add', function() {
        global $hooks;
        $hooks->add_action('global_js', "addproduct_js");
        $hooks->add_action('the_title', "addproduct_title");
        the_head();
        include 'product.add.php';
        the_footer();
        return "";
    });

    $app->post('/products/list', function(Request $request)  {
        $curpage = $request->get('page');
        include 'product.list.php';
        return '';
    });
    $app->get('/products', function()  {
        global $hooks;
        $hooks->add_action('global_css', 'product_css');
        $hooks->add_action('global_js', 'product_js');
        $hooks->add_action('the_title', "product_title");
        the_head();
        include 'product.tpl.php';
        the_footer();
        return "";
    });
}
