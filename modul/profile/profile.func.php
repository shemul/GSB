<?php

function pwdCorrect($pwd){
    global $db;
    $db->bind("uid",$_SESSION["uid"]);
    $db->bind("pwd",md5($pwd));
    $profile = $db->query("SELECT * FROM user_id WHERE uid=:uid AND password = :pwd");
    if(count($profile)>0){
        return true;
    }else{
        return false;
    }
}
function pinCorrect($pin){
    global $db;
    $db->bind("uid",$_SESSION["uid"]);
    $db->bind("pin",md5($pin));
    $profile = $db->query("SELECT * FROM user_id WHERE uid=:uid AND pin = :pin");
    if(count($profile)>0 || isset($_SESSION["godmode"]["status"])){
        return true;
    }else{
        return false;
    }
}
function getActiveProduct($uid,$data){
    global $db;
    $db->bind("uid",$uid);
    $user = $db->query("SELECT * FROM user_id WHERE uid=:uid");
    // GET PRODUCT NAME
    $db->bind("productid",$user[0]["product"]);
    $product = $db->query("SELECT * FROM product WHERE product_id = :productid");
    return $product[0][$data];
}
function lastLoginAttempt($max){
    global $db;
    $db->bind("uname",$_SESSION["uname"]);
    $db->bind("limitx",$max);
    $log = $db->query("SELECT * FROM `login_log` WHERE `uname` = :uname ORDER BY id DESC LIMIT :limitx");
    ?>
    <table id="log-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">
                                <thead>
                                    <tr>
                                        <th>IP Address</th>
                                        <th>Status</th>
                                        <th data-hide="phone,tablet">Date & Time</th>
                                        <th data-hide="phone,tablet">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="down-tbl-content">
                                    <?php
                                    foreach ($log as $key => $value) {  ?>
                                        <tr>
                                            <td><?php echo $value["ip_address"]; ?></td>
                                            <td><?php echo ($value["status"]=="SUCCESS" ? "<span class='label label-success'>SUCCESS</span>" : "<span class='label label-danger'>FAILED</span>"); ?></td>
                                            <td><?php echo $value["date"]; ?></td>
                                            <td><a href="http://www.infosniper.net/index.php?ip_address=<?php echo $value["ip_address"]; ?>&map_source=1&overview_map=1&lang=1&map_type=1&zoom_level=7" target="_blank">TRACK LOCATION</a></td>
                                        </tr>
                                   <?php  } ?>
                                </tbody>
     </table>
<?php
}