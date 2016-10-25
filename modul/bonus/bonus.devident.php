<?php

global $hooks;
$hooks->add_action('hitung_bonus', 'bonus_devident'); // <-- Inject ke hook hitung bonus;

function bonus_devident() {
    hitungDevident();
}

function hitungDevident() {
    global $db;
    global $global_max_dev_day;
    $allUser = $db->query("SELECT uid FROM user_id WHERE banned <> '1' AND role <> '0'");
    foreach ($allUser as $key => $value) {
        if (hasDevident($value["uid"])) {
            // Count devident days
            // if the day is not greater than max devident day, count it, if it doesnt, close it
            if (countTimeLine($value["uid"]) < $global_max_dev_day) {
                // Count
                tembakDevident($value["uid"]);
            } else {
                // Close Devident
                closeDevident($value["uid"]);
            }
        }
    }
}

function tembakDevident($uid) {
    global $db;
    global $global_max_dev_day;
    $halfdevday = $global_max_dev_day / 2;
    $rate = getActiveProduct($uid, 'devident_rate');
    $rate = explode("/", $rate);
    $investasi = InvestNominal($uid);
    if (countTimeLine($uid) <= $halfdevday) {
        // Day 0 till $halfday
        logDevTimeline($uid, $rate[0]);
    } else {
        // Day $halfday till last day ( $global_max_dev_day )
        logDevTimeline($uid, $rate[1]);
    }
}

function logDevTimeline($uid, $percent) {
    global $db;
    $idDev = getActiveDevID($uid);
    $tgl = date("Y-m-d 23:59", strtotime('-1 day')); // Because the bonus calulation was on 00:00 on the next day
    if (berhakDevident($idDev)) {
        $logDev = $db->query("INSERT INTO devident_timeline(devident_id,date,percentage) VALUES(:dvid,:tgl,:percentage)", array(
            "dvid" => $idDev, "percentage" => $percent, "tgl" => $tgl
        ));
        if ($logDev) {
            logDevBonusTrf($uid, $percent);
        }
    }
}

function logDevBonusTrf($uid, $rate) {
    global $db;
    $nominalx = InvestNominal($uid);
    $nominal = ($rate / 100) * $nominalx;
    $nominal = number_format($nominal, 3);
    $idDev = getActiveDevID($uid);
    $tgl = date("Y-m-d 23:59", strtotime('-1 day'));
    $cashback = $db->query("INSERT INTO fund_transaction(type,nominal,details,from_id,to_id,date) VALUES('5',:nominalx,:notes,:fromx,:tox,:tgl)", array(
        "nominalx" => $nominal, "notes" => "DAILY DEVIDENT BONUS (" . $rate . "% OF $" . $nominalx . "), DEVID #" . $idDev, "fromx" => "0", "tox" => $uid, "tgl" => $tgl
    ));
    if ($cashback) {
        return true;
    } else {
        return false;
    }
}

function countTimeLine($id) {
    global $db;
    $idDev = getActiveDevID($id);
    $db->bind("idDev", $idDev);
    $row = $db->query("SELECT COUNT(id) as jumlah FROM devident_timeline WHERE devident_id = :idDev;");
    return $row[0]["jumlah"];
}

function closeDevident($uid) {
    global $db;
    $nominalx = InvestNominal($uid);
    $idDev = getActiveDevID($uid);
    $db->bind('idDev', $idDev);
    $tgl = date("Y-m-d 23:59", strtotime('-1 day'));
    $close = $db->query("UPDATE devident_log SET status = 'CLOSED' WHERE id = :idDev");
    $cashback = $db->query("INSERT INTO fund_transaction(type,nominal,details,from_id,to_id,date) VALUES('7',:nominalx,:notes,:fromx,:tox,:tgl)", array(
        "nominalx" => $nominalx, "notes" => "100% OF $" . $nominalx . " (FULL RETURN),DEVIDENT ID #" . $idDev, "fromx" => "0", "tox" => $uid, "tgl" => $tgl
    ));
}

function berhakDevident($id) {
    global $db;
    $db->bind("idDev", $id);
    $berhak = $db->query("SELECT * FROM devident_log WHERE DATE(opendate) <> CURDATE() AND id = :idDev");
    if (count($berhak) > 0) {
        return true;
    } else {
        return false;
    }
}
