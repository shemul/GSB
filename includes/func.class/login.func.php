<?php

/*
 *  The SQL Injection Prevention are handled by BINDING
 *  $db->bind(something)
 * 
 */
global $app;
global $csrf;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function loginLog($uname, $status) {
    global $db;
    $ip = get_client_ip();
    // Prevent SQL Injection
    $db->bind("uname", $uname);
    $db->bind("ip", $ip);
    $db->bind("status", $status);
    // Execute
    $db->query("INSERT INTO login_log(uname,date,ip_address,status) VALUES(:uname,CURRENT_TIMESTAMP,:ip,:status)");
}

$app->post('/login/auth', function (Request $request)  {
    global $db;
    $uname = $request->get('uname');
    $pass = md5($request->get('pwd'));
    // Prevent SQL Injection
    $db->bind("uname", $uname);
    $db->bind("pass", $pass);
    // Execute
    $users = $db->query("SELECT * FROM user_id WHERE uname= :uname && password= :pass && banned = 0");
    if (count($users) > 0) {
        // TRIGGER SETELAH USRNAME DAN PASSWORD BENAR NANTI DITARUH DI SINI
        // JANGAN LUPA UTK CREATE $_SESSION untuk uname
        $_SESSION["uname"] = $uname;
        $_SESSION["uid"] = $users[0]["uid"];
        $_SESSION["role"] = $users[0]["role"];
        loginLog($uname, "SUCCESS");
        // SETELAH SET SESSION BERIKAN RESPONSE SUKSES
        return new Response('Success', 200);
    } else {
        loginLog($uname, "FAILED");
        return new Response('Failed', 201);
    }
});
$app->post('/forgot-password/reset', function (Request $request)  {
    global $db;
    $uname = $request->get('uname');
    $db->bind("uname", $uname);
   $users = $db->query("SELECT * FROM user_id WHERE uname= :uname  && banned = 0");
    if (count($users) > 0) {
        $newPwd = xToken(6);
        $encrypt = md5($newPwd);
        // SETELAH DAPAT PASSWORD UPDATE DULU
        $db->bind('pwd', $encrypt);
        $db->bind('unamex', $uname);
        $update = $db->query("UPDATE user_id SET password = :pwd WHERE uname = :unamex");
        if ($update) {
            $uid = getUID($uname);
            $email = getProfileData($uid, 'email');
            // Konfigurasi Pesan Email
            $pesan .= "Hello There. </br></br>";
            $pesan .= "We've just noticed that you've just request to reset your password because you forgot it, <br>We already reset your password, please login using password below and please dont forget to change it again to something you can remember.";
            $pesan .= "<br><br>NEW PASSWORD : <strong>" . $newPwd . "</strong></br>";
            // Kirim Email
            sendMail($email, $pesan, "FORGOT PASSWORD - RESET PASSWORD");
            return new Response('Success', 200);
        } else {
            return new Response('Failed', 201);
        }
    } else {

        return new Response('Failed', 201);
    }
});
$app->get('/login', function() {
    global $app;
    $title = "GOLDENSTAR PVT LTD";
    if (is_login()) {
        return $app->redirect('/dashboard');
    } else {
        require_once __DIR__ . '/../tpl/login.php';
        return "";
    }
});
$app->get('/forgot-password', function()  {
    global $app;
    $title = "Reset Password - BINARY MLM";
    if (is_login()) {
        return $app->redirect('/dashboard');
    } else {
        require_once __DIR__ . '/../tpl/resetpwd.php';
        return "";
    }
});
$app->get('/logout', function() {
    global $app;
    echo "Successfully logged out. </br>";
    session_destroy();
    return $app->redirect('/login');
});

