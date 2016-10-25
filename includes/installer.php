<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->post('/install/save', function(Request $request) use($install) {
    global $app;
    $usr = $request->get('user');
    $pass = $request->get('pass');
    $host = $request->get('hostname');
    $dbname = $request->get('dbname');
    // ADMIN DATA
    $uname = $request->get('adminuname');
    $adminpass = md5($request->get('adminpass'));
    $adminmail = $request->get('adminmail');
    $try = @mysql_connect($host, $usr, $pass);
    if (!$try) {
        return new Response("FAILED", 403);
    } else {
        $db_selected = mysql_select_db($dbname, $try);
        if (!$db_selected) {
            return new Response("FAILED", 403);
        } else {
            // IMPORT THE DB
            $templine = '';
            // Read in entire file
            $lines = file('includes/mlm.sql');
            // Loop through each line
            foreach ($lines as $line) {
                // Skip it if it's a comment
                if (substr($line, 0, 2) == '--' || $line == '')
                    continue;
                // Add this line to the current segment
                $templine .= $line;
                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';') {
                    // Perform the query
                    mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                    // Reset temp variable to empty
                    $templine = '';
                }
            }
            mysql_query("INSERT INTO user_id VALUES ('$uname','$adminpass','',NOW(),'0',0,'0','0','1');") or print( mysql_error());
            mysql_query("UPDATE user_id SET uid = 0 WHERE uid = 1;");
            mysql_query("INSERT INTO user_detail VALUES ('0','Administrator','System','MALE','$adminmail','123456','123456','DKI JAKARTA','JAKARTA UTARA','10120','NONE','NONE','INDONESIA','NONE');") or print(mysql_error());
            // MAKE THE FILE
            $content = ";<?php return; ?>\r\n" .
                    "[SQL]\r\n" .
                    "host = " . $host . "\r\n" .
                    "user = " . $usr . "\r\n" .
                    "password = " . $pass . "\r\n" .
                    "dbname = " . $dbname;
            $fp = fopen("includes/dbconfig.php", "wb");
            fwrite($fp, $content);
            fclose($fp);
            // RETURN RESPONSE
            return new Response("SUCCESS", 200);
        }
    }
});

$app->get('/install', function() use($install) {
    global $app;
    global $db;
    global $app_ver;
    $title = "BINARY MLM INSTALLATION";
    if ($install->configExists()) {
        return $app->redirect('/');
    } else {
        require_once __DIR__ . '/tpl/installer.php';
        return "";
    }
});


