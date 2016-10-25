<?php
global $hooks;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$hooks->add_action('silex_action', 'downline_registration');
$hooks->add_action('all_menu', 'menu_register');

// Set the Menu
function menu_register() {
    global $menu_array;
    $accountmenu = array(
        "label" => "Register Downline",
        "url" => "/register-account",
        "icon" => "fa fa-bullhorn"
    );
    //$menu_array[10] = $accountmenu;
}

// Define Page Title & Heading Text
function dreg_title() {
    echo "DOWNLINE REGISTRATION";
}

// Define the CSS 
function dreg_css() {
    ?>
    <link href="/assets/css/jquery.stepy.css" rel="stylesheet">
    <link href="/assets/js/bootstrap-datepicker/css/datepicker.css" rel="stylesheet">

    
    <?php
}

// Define The JS
function dreg_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script src="/assets/js/jquery.stepy.js"></script>
    <script type="text/javascript" src="/assets/modul-js/registration/dreg.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    


    <?php
}

function step_js() {
    ?>

    <?php
}

function upload_photo($check)
{
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
       
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}



// Declare & SET the URL handler
function downline_registration() {
    global $app;
    // Check Username Handler
    $app->post('/register-account/check', function(Request $request) {
        global $db;
        $uname = $request->get('uname');
        $db->bind('uname', $uname);
        $row = $db->query("SELECT uid FROM user_id WHERE uname = :uname");
        if (count($row) > 0) {
            $status = 'false';
        } else {
            $status = 'true';
        }
        echo $status;
        return '';
    });

    $app->post('/register-account/valuecheck', function(Request $request) {
        global $db;
        $pid = $request->get('product');
        echo (productExist($pid) && is_numeric($pid) && current_register_fund() >= packagePrice($pid) ? "true" : "false");
        return "";
    });

    


    // Handler New Registration 
    $app->post('/register-account/submit', function(Request $request) {
        global $db;
        // Catch the GET

        
        // Step 1

        $fno = $request->get('fno');
        $fname = $request->get('fname');
        $mname = $request->get('mname');
        $lname = $request->get('lname');
        $fatName = $request->get('fatName');
        $motName = $request->get('motName');
        $dob = $request->get('dob');
        $gender = $request->get('gender');
        $bene = $request->get('beneficiary');
        $relation = $request->get('relation');
        $mobile = $request->get('mobile');
        $address = $request->get('address');
       

        // Step 2 

        $uname = $request->get('uname');
        $email = "NULL";
        $pass = "1234";
        
        //Un-necessary
        $phone = "NULL";
        $city = "NULL";
        $zip = "NULL";
        $state = "NULL";
        $country = "NULL";
        $bankname = "NULL";
        $branch =   "NULL";
        $holder = "NULL";
        $acnumber = "NULL";
        $swiftcode = "NULL";
        $pid = $request->get('product');
        
        $position = (have2Leg($_SESSION["uid"]) ? $request->get('position') : $_SESSION["uid"]);
        $pin = $request->get('pin');
        // END
        // Check if the request match the conditional
        if (pinCorrect($pin) && !userExist($uname) && productExist($pid) && is_numeric($pid) && current_register_fund() >= packagePrice($pid) && !have2Leg($position) && userExist(getUname($position))) {
            // PREPARE
            $db->bind("uname", $uname);
            $db->bind("pass", md5($pass));
            $db->bind("product", $pid);
            // Record to user_id to get the user id
            $current_date_time = date("Y-m-d h:i:s");
            $userReg = $db->query("INSERT INTO user_id(uname,password,register_date,role,product) VALUES(:uname,:pass,NOW(),'1',:product)");
            $uid = $db->lastInsertId();
            if ($userReg && $uid) {
                // Record User Detail
                // PREPARE
                // Step 1 : Saving to database
                $db->bind("uid", $uid);
                $db->bind("fno", $fno);
                $db->bind("fname", $fname);
                $db->bind("mname", $mname);
                $db->bind("lname", $lname);
                $db->bind("fatName", $fatName);
                $db->bind("motName", $motName);
                $db->bind("dob", $dob);
                $db->bind("gender", $gender);
                $db->bind("bene", strtoupper($bene));
                $db->bind("rel", $relation);
                $db->bind("mobile", $mobile);
                $db->bind("address", $address);
                // TO-DO photo

                


                $db->bind("email", $email);
                $db->bind("phone", $phone);
                $db->bind("state", $state);
                $db->bind("city", $city);
                $db->bind("zip", $zip);
                
                
                $db->bind("country", $country);
                
                // EXECUTE
                $userDetRec = $db->query("INSERT INTO user_detail(uid,fno,first_name,mname,last_name,fatName,motName, dob,gender,email,mobile,phone,state,city,zip,address,relation,country,beneficiary) VALUES(:uid,:fno,:fname,:mname,:lname,:fatName ,:motName,:dob,:gender,:email,:mobile,:phone,:state,:city,:zip,:address,:rel,:country,:bene)");
                // Record User Bank Info
                // PREPARE
                $db->bind("bname", $bankname);
                $db->bind("brname", $branch);
                $db->bind("acnum", $acnumber);
                $db->bind("holder", $holder);
                $db->bind("swift", $swiftcode);
                $db->bind("uid", $uid);
                // EXECUTE
                $userBankRec = $db->query("INSERT INTO user_bank(bank_name,branch_name,acnumber,bankholder,swiftcode,uid) VALUES(:bname,:brname,:acnum,:holder,:swift,:uid)");
                // Record to genealogy
                $userGenRec = $db->query("INSERT INTO genealogy(uid,parentid,sponsorid) VALUES(:uid,:parent,:sponsor)", array("uid" => $uid, "parent" => $position, "sponsor" => $_SESSION["uid"]));
                // Record to transaction
                // Record member registration fee

                /*
                commented on 11-04-2016 because of we dont need additional trasections
                $userFeeRec = $db->query("INSERT INTO fund_transaction(date,type,nominal,from_id,details,to_id) VALUES(NOW(),'9',:nom,:from,:notes,:to)", array("nom" => packagePrice($pid), "from" => $_SESSION["uid"], "notes" => "REGISTRATION FOR USERNAME :" . strtoupper($uname), "to" => "0"));
                */
                // Initial Point to new member
                $userInitRec = $db->query("INSERT INTO fund_transaction(date,type,nominal,from_id,ban,to_id) VALUES(NOW(),'1',:val,:dari,:info,:ke)", array("val" => packagePrice($pid), "dari" => "0", "info" => 0, "ke" => $uid));
                // Bonus Sponsor
                $persen = ($_SESSION["role"]!="0"?getActiveProduct($_SESSION["uid"], "referral_rate"):"0");
                $harga = packagePrice($pid);
                $bonus = ($persen / 100) * $harga;
                // Record the bonus to db
                

                /*
                commented on 11-04-2016 because of we dont need additional trasections
                $tembakbonus = $db->query("INSERT INTO fund_transaction(date,type,nominal,from_id,details,to_id) VALUES(NOW(),'6',:bonus,:fromx,:infox,:tox)", array("bonus" => $bonus, "fromx" => "0", "infox" => "BONUS FOR USERNAME <b>" . strtoupper($uname) . "</b> REGISTRATION", "tox" => $_SESSION["uid"]));

                */
                if ($userDetRec && $userBankRec && $userGenRec && $userFeeRec && $userInitRec && $tembakbonus) {
                    // Email
                    // Konfigurasi Pesan Email
                    $pesan = "Thankyou for your registration to us. </br></br>";
                    $pesan .= "We've just noticed that you've just registered to our system, <br>Here is your user detail, please save this data to somewhere safe.";
                    $pesan .= "<br><br> USERNAME : <strong>" . $uname . "</strong></br>";
                    $pesan .= "<br>PASSWORD : <strong>" . $pass . "</strong></br>";
                    $pesan .= "<br>JOIN VALUE : <strong>" . packageName($pid) . " - $" . packagePrice($pid) . "</strong></br>";
                    $pesan .= "<br>SPONSORED BY : <strong>" . strtoupper(getUname($_SESSION["uid"])) . "</strong></br>";
                    $pesan .= "<br>UPLINE : <strong>" . strtoupper(getUname($position)) . "</strong></br>";
                    // Kirim Email
                    sendMail($email, $pesan, "WELCOME TO GOLDMONTINT");
                    return new Response("SUCCESS", 200);
                } else {
                    return new Response('FAILED', 200);
                }
            }
        }
    });
    // End Handler
    $app->get('/register-account', function() {
        global $hooks;
        $hooks->add_action('global_css', "dreg_css");
        $hooks->add_action('global_js', "dreg_js");
        $hooks->add_action('global_js', "step_js");
        $hooks->add_action('the_title', "dreg_title");
        the_head();
        include 'dreg.tpl.php';
        the_footer();
        return "";
    });
}

include 'dreg.func.php';
