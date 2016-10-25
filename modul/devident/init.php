<?php
global $hooks;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
$hooks->add_action('silex_action','the_devident'); // Tancapkan fungsi dashboard ke Trigger Silex
$hooks->add_action('all_menu','menu_devident');
// Define Heading masing2 page
function devid_title(){
    echo "Devident Viewer";
}
function dev_css(){?>
    <link href="/assets/css/footable/footable.core.css" rel="stylesheet">
<?php }
function devid_register(){
    echo "Devident Registration";
}
function regdevident_js(){ ?>
<script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/modul-js/devident/dev.reg.js"></script>
<?php }
function devident_js(){ ?>
<script type="text/javascript" src="/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
 <script src="/assets/js/footable/footable.js"></script>
<script type="text/javascript" src="/assets/modul-js/devident/devident.js"></script>
<?php }
/*function registerfund_title(){
    echo "Register Fund Overview";
}
function withdraw_title(){
    echo "Withdraw your balance";
}*/
function menu_devident(){
   global $menu_array;
    $devidentmenu = array(
        "label" => "Devident",
        "url" => "/devident",
        "icon" => "fa fa-book"
    );
    //$menu_array[4]=$devidentmenu;
}
function the_devident(){
global $app;    

$app->post('/devident/regnew', function(Request $request) { 
    global $db;
    $pin = $request->get('pin');
    $nominal = $request->get('nominal');
    /*
    /* Check if the submitted data is correct type
     * The $nominal must be numeric, the pin must be correct
     * and must have sufficient funds
     */
    if(is_numeric($nominal)&&  pinCorrect($pin) && current_fund()>=$nominal){
        $regDev = $db->query("INSERT INTO devident_log(nominal,`uid`,opendate,status) VALUES (:nominal,:userid,NOW(),'OPEN')",array(
            "nominal"=>$nominal,
            "userid"=>$_SESSION["uid"],
        ));
        $devId = $db->lastInsertId();
        if($regDev){
            $deduct = $db->query("INSERT INTO fund_transaction(type,nominal,details,from_id,to_id,date) VALUES('3',:nominalx,:notes,:fromx,:tox,NOW())", array(
                "nominalx"=>$nominal,"notes"=>"DEVIDENT REGISTRATION, ID #".$devId,"fromx"=>$_SESSION["uid"],"tox"=>"0"
            ));
            if($deduct){
                return new Response('Success', 200);
            }else{
             return new Response('Failed', 201);   
            }
        }else{
          return new Response('Failed', 201);  
        }
    }else{
         return new Response('Failed', 201);
    }
    
});
$app->post('/devident/close', function(Request $request) { 
    global $db;
    $nominalx = InvestNominal();
    $idDev = getActiveDevID();
    /*
     * Its Close the devident state before the day 270
     * Give Penalty to user
     * the penalty is 80% , so user will get only 20% of their money back
     */
    $nominal = (20/100)*$nominalx;
    $nominal = number_format($nominal, 3);
    $db->bind('idDev',$idDev);
    $close = $db->query("UPDATE devident_log SET status = 'CLOSED' WHERE id = :idDev");
    $cashback = $db->query("INSERT INTO fund_transaction(type,nominal,details,from_id,to_id,date) VALUES('7',:nominalx,:notes,:fromx,:tox,NOW())", array(
                "nominalx"=>$nominal,"notes"=>"20% OF $".$nominalx." (PENALTY 80%),DEVIDENT ID #".$idDev,"fromx"=>"0","tox"=>$_SESSION["uid"]
            ));
    if($close&&$cashback){
          return new Response('Success', 200);   
    }else{
         return new Response('Failed', 201);
    }
    
});
$app->post('/devident', function(Request $request) { 
    $curpage = $request->get('page');
    include 'devident.list.php';
    return '';
    
});

$app->get('/devident', function() {  
    global $hooks;
    if(hasDevident()>0) {
        $hooks->add_action('global_css',"dev_css");
        $hooks->add_action('global_js',"devident_js");
        $hooks->add_action('the_title',"devid_title");
        the_head();
        include 'devident.tpl.php';
        the_footer();
        return '';
    }
    else {
        $hooks->add_action('global_js',"regdevident_js"); // Tambahan JS untuk registrasi
        $hooks->add_action('the_title',"devid_register");
        the_head();
        include 'devident.reg.php';
        the_footer();
        return '';
    }   
});

}
include 'devident.func.php';