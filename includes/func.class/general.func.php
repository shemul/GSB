<?php

// Fungsi Cek Login
function is_login() {
    if (isset($_SESSION['uname']) && $_SESSION['uname'] != "") {
        return true;
    } else {
        return false;
    }
}

function getAllSubdirectories($base) {
    $dir_array = array();
    if (!is_dir($base)) {
        return $dir_array;
    }

    if ($dh = opendir($base)) {
        while (($file = readdir($dh)) !== false) {
            if ($file == '.' || $file == '..')
                continue;

            if (is_dir($base . '/' . $file)) {
                $dir_array[] = $file;
            } else {
                array_merge($dir_array, getAllSubdirectories($base . '/' . $file));
            }
        }
        closedir($dh);
        return $dir_array;
        
    }
}

function the_head() {
    require_once __DIR__ . '/../tpl/head.php';
}

function the_footer() {
    require_once __DIR__ . '/../tpl/footer.php';
}

function menu_render($menuarray) {
    ksort($menuarray);
    ?>
    <ul class="nav nav-pills nav-stacked custom-nav">
            <?php foreach ($menuarray as $key => $value) { ?>
            <li <?php echo (has_sub($value) ? 'class="menu-list"' : ''); ?>><a href="<?php echo $value["url"]; ?>"><i class="<?php echo $value["icon"]; ?>"></i> <span><?php echo $value["label"]; ?></span></a>
            <?php if (has_sub($value)) { ?>
                    <ul class="sub-menu-list">
            <?php the_sub($value["sub"]); ?>
                    </ul>
        <?php } ?>
            </li>
    <?php } ?>
    </ul>
    <?php
}

function has_sub($array) {
    if (array_key_exists("sub", $array)) {
        return true;
    } else {
        return false;
    }
}

function the_sub($array) {
    ksort($array);
    foreach ($array as $key => $value) {
        ?>
        <li><a href="<?php echo $value["url"]; ?>"><i class="<?php echo $value["icon"]; ?>"></i> <span><?php echo $value["label"]; ?></span></a></li>
    <?php
    }
}

function current_fund() {
    global $db;
    // Get The income
    $db->bind("to_id", $_SESSION["uid"]);
    $income = $db->query("SELECT SUM(nominal) as funds FROM fund_transaction WHERE to_id = :to_id AND type <> 10;");
    // Get The Expense
    $db->bind("from_id", $_SESSION["uid"]);
    $expense = $db->query("SELECT SUM(nominal) as expense FROM fund_transaction WHERE from_id = :from_id AND (type <> '10' AND type <> '9');");
    // Calculate Available Funds
    $available = $income[0]["funds"] - $expense[0]["expense"];
    return ($_SESSION["role"] == "1" ? $available : 999999999999999999999999999);
}

function current_register_fund() {
    global $db;
    // Get The register fund
    $db->bind("from_id", $_SESSION["uid"]);
    $db->bind("to_id", $_SESSION["uid"]);
    $available = $db->query("SELECT SUM(nominal) as funds FROM fund_transaction WHERE (type = 2 AND from_id = :from_id) OR (type = 10 AND to_id = :to_id);");
    // Register Fund Terpakai
    $db->bind("from_id", $_SESSION["uid"]);
    $used = $db->query("SELECT SUM(nominal) as funds FROM fund_transaction WHERE (type = 9 OR type = 10) AND from_id = :from_id;");
    $registerfund = $available[0]["funds"] - $used[0]["funds"];
    //return $registerfund;
    return ($_SESSION["role"] == "1" ? $registerfund : 999999999999999999999999999);
}

function getProfileData($uid, $data) {
    global $db;
    $db->bind("uid", $uid);
    $profile = $db->query("SELECT * FROM user_detail WHERE uid=:uid");
    return (count($profile)>0?$profile[0][$data]:"");
}

function getDin($uid, $data) {
    global $db;
    $db->bind("uid", $uid);
    $profile = $db->query("SELECT * FROM user_id WHERE uid=:uid");
    return (count($profile)>0?$profile[0][$data]:"");
}



function get_data($uid, $kolom) {
    global $db;
    $data = "";
    $db->bind("uid", $uid);
    $data = $db->query("SELECT * FROM user_id WHERE uid = :uid;");
    if ($data) {
        return $data[0][$kolom];
    } else {
        return "0";
    }
}

function getProduct($id, $kol) {
    global $db;
    $data = "";
    $db->bind("idprod", $id);
    $data = $db->query("SELECT * FROM product WHERE product_id = :idprod;");
    return $data[0][$kol];
}

function getUID($name) {
    global $db;
    $db->bind('user', $name);
    $dataz = $db->query("SELECT uid FROM user_id WHERE `uname` = :user");
    return $dataz[0]["uid"];
}

function get_parent($uid, $model = "int") {
    global $db;
    $data = "";
    $db->bind("uid", $uid);
    $data = $db->query("SELECT * FROM genealogy WHERE uid = :uid;");
    if ($model != "int") {
        get_data($data[0]["parentid"], $model);
    } else {
        return $data[0]["parentid"];
    }
}

function get_sponsor($uid, $model = "int") {
    global $db;
    $data = "";
    $db->bind("uid", $uid);
    $data = $db->query("SELECT * FROM genealogy WHERE uid = :uid;");
    if ($model != "int") {
        return get_data($data[0]["sponsorid"], $model);
    } else {
        return $data[0]["sponsorid"];
    }
}

function xToken($length = 8) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr(str_shuffle($chars), 0, $length);
    return $password;
}

function userExist($uname) {
    global $db;
    $db->bind("uname", $uname);
    $row = $db->query("SELECT * FROM user_id WHERE uname = :uname");
    return (count($row) > 0 ? true : false);
}

function userID($uname) {
    global $db;
    $db->bind("uname", $uname);
    $row = $db->query("SELECT * FROM user_id WHERE uname = :uname");
    return $row[0]["uid"];
}

function isHariLibur($tgl) {
    global $db;
    $db->bind("tanggal", $tgl);
    $hari = $db->query("SELECT * FROM holiday WHERE date = :tanggal");
    if (count($hari) > 0) {
        return true;
    } else {
        return false;
    }
}

function bankExists($acc) {
    global $db;
    $db->bind('acnum', $acc);
    $banks = $db->query("SELECT bank_id FROM user_bank WHERE acnumber = :acnum");
    return (count($banks) > 0 ? true : false);
}

function isWeekend($date) {
    return (date('N', strtotime($date)) >= 6);
}

function getSetting($key) {
    global $db;
    $db->bind('keys', $key);
    $result = $db->query("SELECT * FROM settings WHERE name = :keys");
    return (count($result)>0?$result[0]["value"]:"");
}
?>