<?php

session_start(); // Start The Session

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;

// ENABLE ERROR WARNING / DEBUG

error_reporting(E_ALL);
ini_set("display_errors", "1");
// Call the necessary files
include_once 'global.variable.php';
include_once 'func.class/SignatureGenerator.php'; // Main CSRF
// Configuring the CSRF
$secret = 'aUajhskjTAkjHjkhaskLjasjkh17912Hkas'; // well chosen secret
$csrf = new Kunststube\CSRFP\SignatureGenerator($secret);
// END
// Call Installer
include_once 'func.class/installer.class.php';
$install = new MLM_Installer();
if (!$install->configExists() && $_SERVER["REQUEST_URI"] != "/install/save" && $_SERVER["REQUEST_URI"] != "/install") {
    header('Location: /install');
}
// Call Hooks
include_once 'func.class/hook.class.php';
global $hooks;
// Call DB , but dont include if on install
if ($_SERVER["REQUEST_URI"] != "/update" && $_SERVER["REQUEST_URI"] != "/install/save" && $_SERVER["REQUEST_URI"] != "/install") {
    include_once 'func.class/db.class.php';
    $db = new DB();
}
if ($_SERVER["REQUEST_URI"] == "/update") {
    include_once 'func.class/db.class.update.only.php';
    $db = new DBUpdate();
}
// Call general function
include_once 'func.class/general.func.php';

// Redirect to Login if Match the rule
if ($_SERVER["REQUEST_URI"] != "/install/save" && $_SERVER["REQUEST_URI"] != "/install" && $_SERVER["REQUEST_URI"] != "/update" && $_SERVER["REQUEST_URI"] != "/forgot-password/reset" && $_SERVER["REQUEST_URI"] != "/forgot-password" && $_SERVER["REQUEST_URI"] != '/bonus/go' && $_SERVER["REQUEST_URI"] != '/login' && $_SERVER["REQUEST_URI"] != '/paypal-listen' && $_SERVER["REQUEST_URI"] != '/login/auth' && !is_login()) {
    header('Location: /login');
} else {
    // Call the Silex after logged in
    require_once 'vendor/autoload.php';
    $app = new Silex\Application(); // <-- Declare $app as Silex
    $app->register(new Silex\Provider\SwiftmailerServiceProvider()); // Register Swiftmailer
    $menu_array = array();
    // CSRF AND ESCAPE ANY POST REQUEST
    $protectPostsData = function (Request $request) use($app, $csrf) {
        switch ($request->getMethod()) {
            case 'POST':
                // Escape Any POST DATA
                foreach ($_POST as $key => $val) {
                    $_POST[$key] = (!is_array($_POST[$key]) ? $app->escape($_POST[$key]) : $_POST[$key]);
                }
                // CSRF IT
                $token = base64_decode($request->get('token'));
                // CSRF It !
                if (!$csrf->validateSignature($token)) {
                    return new Response("TOKEN WRONG!!", 403);
                    exit;
                }
        }
    };
    $protectPostsRender = function (Request $request) use($app, $csrf) {
        switch ($request->getMethod()) {
            case 'GET':
                /* Generate CSRF Token And Field */
                $token = base64_encode($csrf->getSignature());
                echo "<input type='hidden' id='token' name='token' value='" . $token . "'>";
            /* ENd */
        }
    };
    $app->before($protectPostsData);
    $app->after($protectPostsRender);
    if ($_SERVER["REQUEST_URI"] != "/install/save" && $_SERVER["REQUEST_URI"] != "/install") {
        include 'mailsetting.php';
        // Call the Login function , Mailer Function and make a conditional
        include_once 'func.class/mailer.func.php';
        include_once 'func.class/login.func.php';
        // UPDATER
        include_once 'updater.php';
        if (is_login()) {
            // Call necessary files;
            include_once 'func.class/newpin.func.php';
            include_once 'func.class/modular.func.php'; // <-- Controller Module
            include_once 'func.class/pagination.func.php'; // <-- Pagination Class
            
            $app->get('/', function() use($app) {
                return $app->redirect('/dashboard');
            });
            if ($_SESSION["role"] == "1") {
                $hooks->do_action('all_menu');
                $hooks->do_action('silex_action');
            } else {
                $hooks->do_action('admin_menu');
                $hooks->do_action('silex_action');
                $hooks->do_action('admin_action');
            }
        }
    } else {
        // Include the installation page
        include 'installer.php';
    }
    // Include the Mail Configurator
    $app->run();
}