<?php




function availPosition(){
    global $db;
    $downlineIdArray = downlinex($_SESSION["uid"]);
    foreach ($downlineIdArray as $key => $value) {
        if(slotAvail($value)){
            $valid .= '<option value="'.$value.'">'.getUname($value)." ". $value."</option>";
        }else{
            $valid .= '<option disabled>'.getUname($value)." ( This user already have 2 LEG, please select user below of this user by viewing your network tree first )</option>";
        }
    }
    return $valid;
}

function getDins(){
    global $db;
 
    $downline = $db->query("SELECT uname , uid FROM user_id");
    foreach ($downline as $key => $value) {
        $valid .= '<option value="'.$value['uid'].'">'.$value["uname"].'</option>';
    }  
    return $valid;
}
function slotAvail($uid){
    global $db;
    $db->bind("uid",$uid);
    $downline = $db->query("SELECT * FROM genealogy WHERE parentid=:uid");
    if(count($downline)<2){
        return true;
    }else{
        return false;
    }
}
function have2Leg($uid){
    global $db;
    $db->bind("uid",$uid);
    $downline = $db->query("SELECT * FROM genealogy WHERE parentid=:uid");
    if(count($downline)==2){
        return true;
    }else{
        return false;
    }
}
function thePackage(){
    global $db;
    $products = $db->query("SELECT * FROM product WHERE disable = 0");
    foreach ($products as $key => $value) {
        $product .= "<option value='".$value['product_id']."'>".$value['product_name'].' - $'.$value['value'].'</option>';
    }
    return $product;
}

function theWeeks(){
    global $db;

    $products = $db->query("SELECT DISTINCT week FROM fund_transaction ORDER BY week DESC");
    foreach ($products as $key => $value) {
        $product .= "<option value='".$value['week']."'>".$value['week'].'</option>';
    }
    return $product;
}

function getLatestWeek(){
    global $db;
    $products = $db->query("SELECT DISTINCT week FROM `fund_transaction` ORDER BY week DESC");
    $date = $products[0];
    return $date['week'];
}


function packageName($id){
    global $db;
    $db->bind('id',$id);
    $products = $db->query("SELECT * FROM product WHERE product_id = :id");
    return $products[0]['product_name'];
}
function packagePrice($id){
    global $db;
    $db->bind('id',$id);
    $products = $db->query("SELECT * FROM product WHERE product_id = :id");
    return $products[0]['value'];
}

function productExist($id){
    global $db;
    $db->bind('id',$id);
    $products = $db->query("SELECT * FROM product WHERE product_id = :id");
    return (count($products)>0?true:false);
}
function isLR($uid){
     global $db;
     global $downlinearray;
     $right = array();
     $left = array();
     $downlinearray = array();
     $db->bind("uid",$_SESSION["uid"]);
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
    return (in_array($uid, $left)?" LEFT NETWORK ":(in_array($uid, $right)?" RIGHT NETWORK ":""));
}
