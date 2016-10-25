<?php

function InvestNominal($x = "x") {
    global $db;
    $uid = ($x == "x" ? "x" : $x);
    $devId = getActiveDevID($uid);
    $db->bind("idDev", $devId);
    $nom = $db->query("SELECT nominal FROM devident_log WHERE id= :idDev");
    return $nom[0]['nominal'];
}

function currentDevEarning() {
    global $db;
    $devId = getActiveDevID();
    $invest = InvestNominal();
    $totalBonus = 0;
    $db->bind("idDev", $devId);
    $nom = $db->query("SELECT percentage FROM devident_timeline WHERE devident_id= :idDev");
    foreach ($nom as $key => $value) {
        $xyz = ($value["percentage"] / 100) * $invest;
        $totalBonus += $nominal = number_format($xyz, 3);
    }
    return $totalBonus;
}

function getNominal() {
    global $db;
    $db->bind("uid", $_SESSION["uid"]);
    $profile = $db->query("SELECT nominal FROM devident_log WHERE uid= :uid AND status ='OPEN' ORDER BY uid DESC LIMIT 1 ");
    return $profile[0]['nominal'];
}

function hasDevidentAll($idx = "x") {
    global $db;
    $idUsr = ($idx == "x" ? $_SESSION["uid"] : $idx);
    $db->bind("uid", $idUsr);
    $profile = $db->query("SELECT * FROM devident_log WHERE uid= :uid");
    if ($_SESSION["role"] == "0") {
        return true;
    } else {
        if (count($profile) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

function hasDevident($idx = "x") {
    global $db;
    $idUsr = ($idx == "x" ? $_SESSION["uid"] : $idx);
    $db->bind("uid", $idUsr);
    $profile = $db->query("SELECT * FROM devident_log WHERE uid= :uid AND status ='OPEN' ");
    if ($_SESSION["role"] == "0") {
        return true;
    } else {
        if (count($profile) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

function getActiveDevID($id = "x") {
    global $db;
    $usrid = ($id == "x" ? $_SESSION["uid"] : $id);
    $db->bind("userid", $usrid);
    $profile = $db->query("SELECT * FROM devident_log WHERE uid= :userid AND status = 'OPEN' ORDER BY id DESC LIMIT 1");
    return $profile[0]['id'];
}

function devDate() {
    global $db;
    $id = getActiveDevID();
    $db->bind("idDev", $id);
    $date = $db->query("SELECT opendate FROM devident_log WHERE id= :idDev");
    return $date[0]["opendate"];
}

function getContentBar() {
    global $db;
    $devid = getActiveDevID();
    $db->bind("userid", $devid);
    $profile = $db->query("SELECT count(devident_id)as jumlah FROM devident_timeline WHERE devident_id= :userid");
    $hari = $profile[0]['jumlah'];
    $persen = ($hari == "" ? 0 : (($hari / 270) * 100));
    return $persen;
}

function xDDay() {
    global $db;
    $devid = getActiveDevID();
    $db->bind("iddev", $devid);
    $profile = $db->query("SELECT count(devident_id)as jumlah FROM devident_timeline WHERE devident_id= :iddev");
    $hari = $profile[0]['jumlah'];
    return $hari;
}
