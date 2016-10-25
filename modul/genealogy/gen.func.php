<?php
// Fungsi Query Downline
function downline($uid){
    global $db;
    global $downlinearray;
    $downlinearray = array();
    
    $db->bind("uid",$uid);
    $downline = $db->query("SELECT * FROM genealogy WHERE parentid=:uid");
    foreach ($downline as $key => $value) {
       $downlinearray[]=$value["uid"];
       downlineloop($value["uid"]);
    }
    asort($downlinearray);
    return $downlinearray;
}
function downlinex($uid){
    global $db;
    global $downlinearray;
    $downlinearray = array();
    
    $db->bind("uid",$uid);
    $downline = $db->query("SELECT * FROM genealogy WHERE parentid=:uid");
    foreach ($downline as $key => $value) {
       $downlinearray[]=$value["uid"];
       downlineloop($value["uid"]);
    }
    //asort($downlinearray);
    return $downlinearray;
}




function downlineloop($uid){
    global $db;
    global $downlinearray;
    $downlinearray = (is_array($downlinearray)?$downlinearray:array());
    $db->bind("uid",$uid);
    $downline = $db->query("SELECT * FROM genealogy WHERE parentid=:uid");
    if(count($downline>0)){
        foreach ($downline as $key => $value) {
            $downlinearray[]=$value["uid"];
            downlineloop($value["uid"]);
        }
    }
}
function firstDownline($uid){
    global $db;
    global $downlinearray;
    $downlinearray = array();
    $db->bind("uid",$uid);
    $downline = $db->query("SELECT * FROM genealogy WHERE parentid=:uid");
    foreach ($downline as $key => $value) {
       $downlinearray[]=$value["uid"];
    }
    asort($downlinearray);
    return (count($downlinearray)>0 ? $downlinearray : "");
}
function theTree($array){
    if(is_array($array)){
      $list = "";  
      $list .= "<ul>";  
      
        foreach ($array as $key => $value) {
            $list .= "<li data-id='".$value."' class='subx'><a href='#'><div class='tree-user'>";
            $list .= "<h3><i class='fa fa-sitemap'></i> ".strtoupper(get_data($value, "uname"))."</h3><h5>".getLastName($value) ."</h5>";
            
            $list .= "<div class='col-md-12 nodes-info'>
                                        <div class='col-md-3'>
                                         ".  countNodes($value, 'left')."
                                        </div>
                                        <div class='col-md-6 midx'>
                                              ".$value."
                                        </div>
                                        <div class='col-md-3'>
                                            ".  countNodes($value, 'right')."
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>";
            
            $list .= "</div></a></li>";
        }
      $list .= "</ul>"; 
      return $list;
    }else{
        return "";
    }
}
function countNodes($uid,$position){
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
    
    // Ambil List ID kaki Kiri
    if(count($left)>0){
        downline($left[0]);
        $downlinearray[] = $left[0];
        asort($downlinearray);
        $left = $downlinearray;
        //return $left;
        // Reset Array
        $downlinearray = array();
    }
    // Ambil List ID kaki Kanan
     if(count($right)>0){
        downline($right[0]);
        $downlinearray[] = $right[0];
        asort($downlinearray);
        $right = $downlinearray;
        //return $left;
        // Reset Array
        $downlinearray = array();
    }

    $final_left = array();
    $final_left_s =0 ; 
    $final_right_s =0 ; 


    $lastest_week = getLatestWeek();


    foreach ($left as $key => $value) {
        $week_qry = $db->query("SELECT * FROM fund_transaction WHERE to_id=". $value ." and date >'" . $lastest_week . "'");
        $final_left_s = $final_left_s + count($week_qry);
    }
    foreach ($right as $key => $value) {
        $week_qry = $db->query("SELECT * FROM fund_transaction WHERE to_id=". $value ." and date >'" . $lastest_week . "'");
        $final_right_s = $final_right_s + count($week_qry);
    }
    //
    // echo 'F'. $final_left_s ;
    // echo $uid;
    // echo "<pre>";
    // var_dump($left);
    // echo "</pre>";
   
    return ($position=="left" ? $final_left_s : ($position=="right" ?  $final_right_s : ""));
}
function countInvest($uid,$position){
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
    
    // Ambil List ID kaki Kiri
    if(count($left)>0){
        downline($left[0]);
        $downlinearray[] = $left[0];
        asort($downlinearray);
        $left = $downlinearray;
        //return $left;
        // Reset Array
        $downlinearray = array();
    }
    // Ambil List ID kaki Kanan
     if(count($right)>0){
        downline($right[0]);
        $downlinearray[] = $right[0];
        asort($downlinearray);
        $right = $downlinearray;
        //return $left;
        // Reset Array
        $downlinearray = array();
    }
    
    // Kalkulasi Investasi kaki kiri
    if(is_array($left)){
        $tmpLeft = 0;
        foreach ($left as $key => $value) {
            $tmpLeft += theInvest($value);
        }
        $left = $tmpLeft;
    }    
    // Kalkulasi Investasi kaki kanan
    if(is_array($right)){
        $tmpRight = 0;
        foreach ($right as $key => $value) {
            $tmpRight += theInvest($value);
        }
        $right = $tmpRight;
    }    
    return ($position=="left" ? $left : ($position=="right" ? $right : ""));
}
function theInvest($uid){
    global $db;
    $db->bind("uid",$uid);
    $invest = $db->query("SELECT SUM(nominal) as total FROM devident_log WHERE uid=:uid");
    return ($invest[0]["total"]==""?0:$invest[0]["total"]);
}
function getUname($uid){
    global $db;
    $db->bind("uid",$uid);
    $data = $db->query("select * From user_id WHERE uid = :uid");
    return $data[0]["uname"];
}

function getLastName($uid){
    global $db;
    $db->bind("uid",$uid);
    $data = $db->query("select * From user_detail WHERE uid = :uid");
    return  $data[0]["first_name"] . " " . $data[0]["mname"] . " " .  $data[0]["last_name"]  ;
}


