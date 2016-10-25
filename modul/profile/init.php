<?php
global $hooks;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$hooks->add_action('silex_action', 'the_profile'); // Tancapkan fungsi dashboard ke Trigger Silex
$hooks->add_action('all_menu', 'menu_profile');

function myprofile_title() {
    echo "My Profile";
}

function editprofile_title() {
    echo "Edit Profile";
}

function chpwd_title() {
    echo "Change Password";
}

function chpin_title() {
    echo "Change PIN";
}

function chpin_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script src="/assets/modul-js/profile/chpin.js"></script>
<?php }

function chpwd_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script src="/assets/modul-js/profile/chpwd.js"></script>
<?php }

function editprofile_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script src="/assets/modul-js/profile/editprofile.js"></script>
<?php }

function myprofile_js() {
    ?>
    <script src="/assets/js/footable/footable.js"></script>
    <script src="/assets/modul-js/profile/myprofile.js"></script>
<?php }

function myprofile_css() {
    ?>
    <link href="/assets/css/footable/footable.core.css" rel="stylesheet">
<?php
}

function availPosition_only_for_edit_upline($din){

    global $db;
    $downlineIdArray = downlinex(0);
    
    foreach ($downlineIdArray as $key => $value) {
       
        if(slotAvail($value)){

            if($din==$value){
                $valid .= '<option selected value="'.$value.'">'.getUname($value)." ". $value."</option>";
            } else {
                $valid .= '<option value="'.$value.'">'.getUname($value)." ". $value."</option>";
            }

        }else{

            if($din==$value){
                $valid .= '<option selected disabled>'.getUname($value). " " .$value ." ( This user already have 2 LEG, please select user below of this user by viewing your network tree first )</option>";
            } else {
                $valid .= '<option disabled>'.getUname($value). " " .$value ." ( This user already have 2 LEG, please select user below of this user by viewing your network tree first )</option>";
            }

        }
    }
    return $valid;
}

function menu_profile() {
    global $menu_array;
    $profilemenu = array(
        "label" => "Profile",
        "url" => "#",
        "icon" => "fa fa-cogs",
        "sub" => array(
            array(
                "label" => "My Profile",
                "url" => "/profile",
                "icon" => "fa fa-glass",
            ),
            array(
                "label" => "Edit Profile",
                "url" => "/profile/edit",
                "icon" => "fa fa-edit",
            )
            // array(
            //     "label" => "Change Password",
            //     "url" => "/profile/chpwd",
            //     "icon" => "fa fa-lock",
            // ),
            // array(
            //     "label" => "Change PIN",
            //     "url" => "/profile/chpin",
            //     "icon" => "fa fa-puzzle-piece",
            // ),
            // array(
            //     "label" => "DOWNLOAD PLAN",
            //     "url" => "/download/PLAN.pptx",
            //     "icon" => "fa fa-download",
            // )
        )
    );
    $menu_array[1] = $profilemenu;
}

function the_profile() {
    global $app;
    $app->post('/profile/edit/update', function (Request $request) {


        global $db;
       $uid = $_SESSION["uid"];

        $uname = $request->get('uname');
        $upline = $request->get('upline');
        $fname = $request->get('fname');
        $lname = $request->get('lname');
        $gender = $request->get('gender');
       
        $fat_name = $request->get('fat_name');
        $mobile = $request->get('mobile');
        $beneficiary = $request->get('beneficiary');
        $address = $request->get('address');
        $city = $request->get('city');
        $state = $request->get('state');
        $zip = $request->get('zip');
        $country = $request->get('country');
        // Bind the data
        //$db->bind("uname", $uname);
        $db->bind("fname", $fname);
        $db->bind("lname", $lname);
        $db->bind("gender", $gender);
        $db->bind("fat_name", $fat_name);
        $db->bind("mobile", $mobile);
        $db->bind("beneficiary", $beneficiary);
        $db->bind("address", $address);
        $db->bind("city", $city);
        $db->bind("state", $state);
        $db->bind("zip", $zip);
        $db->bind("country", $country);
        $db->bind("uid", $_SESSION["uid"]);


        $profileupdate = $db->query("UPDATE user_detail SET first_name = '$fname' , last_name = '$lname' , gender ='$gender' , mobile = '$mobile' ,beneficiary ='$beneficiary' , fatname = '$fat_name' , address = '$address'    WHERE uid ='$uid' ");

        $updateDin = $db->query("UPDATE user_id SET uname = '$uname' WHERE uid ='$uid'");

        $updateUpline ;
        if($upline != "null"){
            $updateUpline = $db->query("UPDATE genealogy SET parentid = '$upline' WHERE uid ='$uid'");
        }

        if ($profileupdate || $updateDin || $updateUpline) {
            
            return new Response('Success', 200);
        } else {
            return new Response('Failed', 201);
        }
    });
    $app->get('/profile/edit', function() {
        global $hooks;
        //$hooks->add_action('global_css','myprofile_css');
        $hooks->add_action('global_js', 'editprofile_js');
        $hooks->add_action('the_title', "editprofile_title");
        the_head();
        include 'editprofile.tpl.php';
        the_footer();
        return "";
    });
    $app->post('/profile/chpwd/update', function (Request $request) {
        global $db;
        $newpass = md5($request->get('newpass'));
        $oldpass = $request->get('oldpass');
        $token = $request->get('token');
        if (pwdCorrect($oldpass) && $token == $_SESSION["tokenpwd"]) {
            $db->bind("uid", $_SESSION["uid"]);
            $db->bind("newpass", $newpass);
            $passupdate = $db->query("UPDATE user_id SET password = :newpass WHERE uid = :uid");
            if ($passupdate) {
                $_SESSION["tokenpwd"] = "";
                return new Response('Success', 200);
            } else {
                return new Response('Failed', 201);
            }
        } else {
            return new Response('Failed', 201);
        }
    });
    $app->get('/profile/chpwd', function() {
        global $hooks;
        if (!isset($_SESSION["tokenpwd"]) || $_SESSION["tokenpwd"] == "" || $_GET["resend"] == "1") {
            if ($_GET["success"] != "1" && $_GET["resend"] != "1") {
                $_SESSION["tokenpwd"] = xToken();

                // Konfigurasi Pesan Email
                $pesan = "Hello there </br></br>";
                $pesan .= "We've just noticed that you want to change your account password, its okay, <br>but you need to insert this secret token code due to our security system.";
                $pesan .= "<br><br> YOUR ACCESS CODE TOKEN IS : <strong>" . $_SESSION["tokenpwd"] . "</strong>";
                // Kirim Email
                sendMail(getProfileData($_SESSION["uid"], "email"), $pesan, "PASSWORD CHANGE TOKEN");
            }
        }


        //$hooks->add_action('global_css','myprofile_css');
        $hooks->add_action('global_js', 'chpwd_js');
        $hooks->add_action('the_title', "chpwd_title");
        the_head();
        include 'chpwd.tpl.php';
        the_footer();
        return "";
    });
    $app->post('/profile/chpin/update', function (Request $request) {
        global $db;
        $newpin = md5($request->get('newpin'));
        $oldpin = $request->get('oldpin');
        $token = $request->get('token');
        if (pinCorrect($oldpin) && $token == $_SESSION["tokenpin"]) {
            $db->bind("uid", $_SESSION["uid"]);
            $db->bind("newpin", $newpin);
            $pinupdate = $db->query("UPDATE user_id SET pin = :newpin WHERE uid = :uid");
            if ($pinupdate) {
                $_SESSION["tokenpin"] = "";
                return new Response('Success', 200);
            } else {
                return new Response('Failed', 201);
            }
        } else {
            return new Response('Failed', 201);
        }
    });
    $app->get('/profile/chpin', function() {
        global $hooks;
        if (!isset($_SESSION["tokenpin"]) || $_SESSION["tokenpin"] == "" || $_GET["resend"] == "1") {
            if ($_GET["success"] != "1" && $_GET["resend"] != "1") {
                $_SESSION["tokenpin"] = xToken();

                // Konfigurasi Pesan Email
                $pesan = "Hello there </br></br>";
                $pesan .= "We've just noticed that you want to change your account PIN, its okay, <br>but you need to insert this secret token code due to our security system.";
                $pesan .= "<br><br> YOUR ACCESS CODE TOKEN IS : <strong>" . $_SESSION["tokenpin"] . "</strong>";
                // Kirim Email
                sendMail("no-reply@goldmontint.com", getProfileData($_SESSION["uid"], "email"), $pesan, "PIN CHANGE TOKEN", "GOLDMONTINT.COM");
            }
        }


        //$hooks->add_action('global_css','myprofile_css');
        $hooks->add_action('global_js', 'chpin_js');
        $hooks->add_action('the_title', "chpin_title");
        the_head();
        include 'chpin.tpl.php';
        the_footer();
        return "";
    });
    $app->get('/profile', function() {
        global $hooks;
        $hooks->add_action('global_css', 'myprofile_css');
        $hooks->add_action('global_js', 'myprofile_js');
        $hooks->add_action('the_title', "myprofile_title");
        the_head();
        include 'myprofile.tpl.php';
        the_footer();
        return "";
    });
}

include 'profile.func.php';
