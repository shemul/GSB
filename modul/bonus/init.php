<?php
global $hooks;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
$hooks->add_action('silex_action','execute_bonus');
function execute_bonus(){
    global $app;
    $app->get('/bonus/go', function() { 
     global $hooks;
     $tgL = date('Y-m-d',strtotime('-1 day'));
    if(!isWeekend($tgL)&&!isHariLibur($tgL)&&!sudahEksekusi()){ 
    $hooks->do_action('hitung_bonus');
    recordEksekusi();
    echo "DONE!";
    }else{
    echo "SUDAH HITUNG BONUS HARI INI SEBELUMNYA!";  
    }
    return "";
    }); 
}
function sudahEksekusi(){
    global $db;
    $db->bind('date',date('Y-m-d',strtotime('-1 day')));
    $log = $db->query("SELECT * FROM bonus_date_logs WHERE date = :date;");
    return (count($log)>0?true:false);
}
function recordEksekusi(){
    global $db;
    $db->query('INSERT INTO bonus_date_logs(date) VALUES (:date);',array("date"=>date("Y-m-d",strtotime('-1 day'))));
}

// Bonus Pairing
include 'bonus.pairing.php';

// Bonus Devident
include 'bonus.devident.php';