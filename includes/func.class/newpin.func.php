<?php
global $app;
global $hooks;
global $checkLicense;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
function newpin_title(){
    echo "Please set your pin";
}
function newpin_js(){?>
<script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
<script src="/assets/js/newpin.js"></script>
<?php }
function has_pin(){
    global $db;
    $db->bind("uname",$_SESSION["uname"]);
    $users = $db->query("SELECT * FROM user_id WHERE uname= :uname");
    if($users[0]["pin"]!="" || isset($_SESSION["godmode"]["status"])){
        return true;
    }else{
        return false;
    }
}
if(is_login() &&!has_pin() && $_SERVER["REQUEST_URI"]!='/newpin' && $_SERVER["REQUEST_URI"]!='/newpin/update'){
 header('Location: /newpin');
}
$app->post('/newpin/update', function (Request $request) {
    global $db;
    $pin = $request->get('pin');
    // Bind the data
    $db->bind("pin",md5($pin));
    $db->bind("uid",$_SESSION["uid"]);
    $pinupdate = $db->query("UPDATE user_id SET pin = :pin WHERE uid = :uid");
    if($pinupdate){
        return new Response('Success', 200);
    }else{
         return new Response('Failed', 201);
    }
});
$app->get('/newpin', function() { 
    global $app;
    global $hooks;
    if(has_pin()){
        return $app->redirect('/dashboard');
    }else{
        $hooks->add_action('global_js','newpin_js');
        $hooks->add_action('the_title',"newpin_title");   
        the_head();
        require_once __DIR__.'/../tpl/newpin.php';
        the_footer();
    return "";
    }
    
});