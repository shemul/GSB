<?php
// pairing_log is used for the logs for pairing of the left and right after substracted
// It used for the calculation for the next day
//
global $hooks;
$hooks->add_action('hitung_bonus','bonus_pairing'); // <-- Inject ke hook hitung bonus;
function bonus_pairing(){
    hitungPairing();
}
function recordPLog($userid,$pL,$pR){
    global $db;
    $timestamp = time();
    // Reset the left leg and right leg to 0 every day 1 on the month
     if(date('j', $timestamp) === '1'){
         $pL = 0;
         $pR = 0;
    }
    echo "SUKSES , ID USER = ".$userid." KIRI SISA = ".$pL." Kanan SISA = ".$pR;
     $tgl = date( "Y-m-d", strtotime('-1 day') );
     $db->query("INSERT INTO pairing_log(idUser,`left`,`right`,`date`) VALUES(:iduser,:kiri,:kanan,:tgl)", 
                array("iduser"=>$userid,"kiri"=>$pL,"kanan"=>$pR,"tgl"=>$tgl));
}
function tembakBonusPair($uid,$bonus){
    global $db;
    $tgl = date( "Y-m-d 23:59", strtotime('-1 day') );
    $db->query("INSERT INTO fund_transaction(date,type,nominal,from_id,details,to_id) VALUES(:date,'4',:bonus,:from,:info,:to)", 
                array("date"=>$tgl,"bonus"=>  $bonus,"from"=>"0","info"=>"BONUS PAIRING 10%","to"=>$uid));
}
function hitungPairing(){
    global $db;
    $allUser = $db->query('SELECT uid FROM user_id WHERE banned <> "1" AND role <> "0";');
    foreach ($allUser as $key => $value) {
        $kanan = 0;
        $kiri = 0;
        $uid =$value["uid"];
        $batas = getActiveProduct($uid, 'max_pairing');
        $kiri += pairingWalker($uid,'left');
        $kanan += pairingWalker($uid,'right');
        $kiri += pairKemarin($uid, "left");
        $kanan += pairKemarin($uid, "right");
        // Hitung Besar Kiri Atau Kanan
        if($kiri<$kanan){
            //echo "UID : ".$uid.", KAKI KANAN = ".$kanan.", KAKI KIRI".$kiri."</br>";
            $bonus = (10/100)*($kiri);
            $pL = "0";
            $pR = $kanan-$kiri;
            recordPLog($uid, $pL, $pR);
            if($bonus>0){
                $bonus = ($bonus<=$batas?$bonus:$batas);
                tembakBonusPair($uid, $bonus);
            }
        }else if($kiri>$kanan){
            ////echo "UID : ".$uid.", KAKI KANAN = ".$kanan.", KAKI KIRI".$kiri."</br>";
            $bonus = (10/100)*($kanan);
            $pL = $kiri-$kanan;
            $pR = "0";
            recordPLog($uid, $pL, $pR);
            if($bonus>0){
                $bonus = ($bonus<=$batas?$bonus:$batas);
                tembakBonusPair($uid, $bonus);
            }
        }else{
            //echo "UID : ".$uid.", KAKI KANAN = ".$kanan.", KAKI KIRI".$kiri."</br>";
            $bonus = (10/100)*($kanan);
            $pL = "0";
            $pR = "0";
            recordPLog($uid, $pL, $pR);
            if($bonus>0){
                $bonus = ($bonus<=$batas?$bonus:$batas);
                tembakBonusPair($uid, $bonus);
            }
        }
    }
    updatePair();
}
function updatePair(){
    global $db;
    $allUser = $db->query('SELECT uid FROM user_id WHERE banned <> "1" AND role <> "0" AND paired <> "1" AND register_date <> CURDATE();');
    foreach ($allUser as $key => $value) {
        markPair($value["uid"]);
    }
}
function pairingWalker($uid,$position){
     global $db;
     global $downlinearray;
     $right = array();
     $left = array();
     $downlinearray = array();
     $db->bind("uid",$uid);
     $downline = $db->query("SELECT * FROM genealogy WHERE parentid=:uid");
     $i = 1;
    foreach ($downline as $key => $value) {
       if($i>1){
       $right[]=$value["uid"];    
       }else{
       $left[]=$value["uid"];
       }
       $i++;
    }
    
    // Get the left leg id's
    if(count($left)>0){
        downline($left[0]);
        $downlinearray[] = $left[0];
        asort($downlinearray);
        $left = $downlinearray;
        //return $left;
        // Reset Array
        $downlinearray = array();
    }
    // Get the right leg id's
     if(count($right)>0){
        downline($right[0]);
        $downlinearray[] = $right[0];
        asort($downlinearray);
        $right = $downlinearray;
        //return $left;
        // Reset Array
        $downlinearray = array();
    }
    
    // Calculate the left leg investation
    if(is_array($left)){
        $tmpLeft = 0;
        foreach ($left as $key => $value) {
            if(isRegToday($value)||  isRegHoliday($value)){
                $tmpLeft += regValue($value);
                
            }
        }
        $left = $tmpLeft;
    }    
    // Calculate the right left investation
    if(is_array($right)){
        $tmpRight = 0;
        foreach ($right as $key => $value) {
            if(isRegToday($value)||isRegHoliday($value)){
            $tmpRight += regValue($value);
                
            }
        }
        $right = $tmpRight;
    }    
    return ($position=="left" ? $left : ($position=="right" ? $right : ""));
}
function regValue($uid){
    global $db;
    $db->bind("uid",$uid);
    $user = $db->query("SELECT product FROM user_id WHERE uid = :uid;");
    $value = packagePrice($user[0]["product"]);
    return $value;
}
function markPair($uid){
    global $db;
    $db->bind('uid',$uid);
    $update = $db->query("UPDATE user_id SET paired = 1 WHERE uid = :uid;");
}
function isRegToday($uid){
    global $db;
    $db->bind('uid',$uid);
    $user = $db->query("SELECT register_date FROM user_id WHERE uid = :uid;");
    $tgl = date( "Y-m-d", strtotime('-1 day') ); // Its set to yesterday because its execute on 00:01;
    if($user[0]["register_date"]==$tgl){
        return true;
    }else{
        return false;
    }
}
function isRegHoliday($uid){
    global $db;
    $db->bind('uid',$uid);
    $user = $db->query("SELECT register_date FROM user_id WHERE uid = :uid AND paired <> 1 AND register_date <> CURDATE();");
    $tgL = $user[0]["register_date"];
    if(isWeekend($tgL)||isHariLibur($tgL)){ 
        return true;
    }else{
        return false;
    }
}
function pairKemarin($uid,$posisi){
    global $db;
    $tgl = date( "Y-m-d", strtotime('-2 day') ); // Dibuat Tanggal - 2 karena pengecekan dilakukan jam 00:01;
    $db->bind('uid',$uid);
    $pK = $db->query("SELECT * FROM pairing_log WHERE idUser = :uid ORDER BY date DESC LIMIT 1");
    return (count($pK)<1?"0":$pK[0][$posisi]);
}