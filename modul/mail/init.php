<?php

global $hooks;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

if ($_SESSION["role"] == 0) {
    $hooks->add_action('silex_action', 'the_mail'); // Tancapkan fungsi dashboard ke Trigger Silex
}

// Define Heading masing2 page
function mail_title() {
    echo "Mail Settings";
}

function mail_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/modul-js/mail/setting.js"></script>
    <?php

}

function the_mail() {
    global $app;global $csrf;
    $app->get('/mail-setting', function() use($csrf) {
        global $hooks;
        $hooks->add_action('global_js', "mail_js");
        $hooks->add_action('the_title', "mail_title");
        the_head();
        $setting = getSetting('mail');
        $setting = unserialize($setting);
        include 'mail.tpl.php';
        the_footer();
        return "";
    });
    $app->post('/mail-setting/save', function(Request $request) {
        global $db;
        $setting = getSetting('mail');
        $old = unserialize($setting);
        $maildata = array();
        $xPwd = $request->get('pass');
        $maildata['uname'] = $request->get('uname');
        $maildata['pass'] = (!empty($xPwd) ? $xPwd : $old["pass"]);
        $maildata['host'] = $request->get('host');
        $maildata['port'] = $request->get('port');
        $maildata['sender'] = $request->get('sender');
        // Validate if everything is not empty
        foreach ($maildata as $key => $value) {
            if (empty($value)) {
                $failed = "1";
            }
        }
        if ($failed != "1") {
            $maildata = serialize($maildata);
            if (!empty($setting)) {
                // UPDATE
                $db->bind("data", $maildata);
                $mailupdate = $db->query("UPDATE settings SET value = :data WHERE name = 'mail'");
                if ($mailupdate) {
                    return new Response('Success', 200);
                } else {
                    return new Response('Failed', 201);
                }
            } else {
                // INSERT
                $db->bind("data",$maildata);
                $insertpp = $db->query("INSERT INTO settings(name,value) VALUES('mail',:data)");
                if ($insertpp) {
                    return new Response('SUCCESS', 200);
                } else {
                    return new Response('Failed', 201);
                }
            }
        } else {
            return new Response('Failed', 201);
        }
    });
}
