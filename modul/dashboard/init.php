<?php
global $hooks;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


$hooks->add_action('silex_action','the_dashboard'); // Tancapkan fungsi dashboard ke Trigger Silex
$hooks->add_action('all_menu','menu_dashboard');
function dashboard_title(){
    echo "WELCOME TO GOLDEN START PVT LIMITED";
}
function menu_dashboard(){
    global $menu_array;
    $dashboardmenu = array(
        "label" => "Dashboard",
        "url" => "/dashboard",
        "icon" => "fa fa-home"
    );
    $menu_array[0]=$dashboardmenu;
}
function the_dashboard(){
    global $app;
    global $csrf;  

    function dashboard_js() {
        ?>
        <script type="text/javascript" src="/assets/modul-js/admin/dashboard.js"></script>
    <?php
    }

 
    $app->post('/dashboard/stat', function() { 
        global $db;
        $latestweek = getLatestWeek();

        $total_user = $db->query("SELECT * FROM user_id");
        $total_product = $db->query("SELECT * FROM product");
        $total_product = $db->query("SELECT * FROM product");
        $total_free_form = $db->query("SELECT * FROM user_id where product =49 ");         
        $total_form_this_week = $db->query("SELECT * FROM fund_transaction where week =''");
        $total_ban = $db->query("SELECT * FROM user_id where new_ban =1");

        // week free form
        $week_free_form = $db->query("SELECT * FROM fund_transaction WHERE date >'" . $latestweek . "' AND week=''");
        $total_free = 0 ; 
        foreach ($week_free_form as $key => $value) {
            $user = $value["to_id"];

            $temp = $db->query("SELECT * FROM user_id where product = 49 and uid ='" . $user."'");
            $total_free = $total_free + count($temp);
        }
        // 




        $arrayName = array('total_user' => count($total_user), 'total_product' => count($total_product) , 'week_form' => count($total_form_this_week) , 'week_free_form' => $total_free ,
            'total_free' =>count($total_free_form),
            'total_ban'  => count($total_ban)
            );

        $json = json_encode($arrayName);

        if ($total_user) {
            return $json ;
        } else {
            return new Response('FAIL', 201);
        }
    });




    $app->get('/dashboard', function() { 
        global $hooks;
        global $app;
        $hooks->add_action('global_js', "dashboard_js");
        $hooks->add_action('the_title',"dashboard_title");
        the_head();
        include 'dashboard.tpl.php';
        the_footer();
        // SEND EMAIL
        
        return "";
    }); 
}