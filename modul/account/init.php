<?php
global $hooks;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$hooks->add_action('silex_action', 'the_account'); // Tancapkan fungsi dashboard ke Trigger Silex
$hooks->add_action('all_menu', 'menu_account');

// Define Heading masing2 page
function fund_title() {
    echo "Balance Overview";
}

function transfer_title() {
    echo "Transfer Fund";
}

function registerfund_title() {
    echo "Register Fund Overview";
}

function withdraw_title() {
    echo "Withdraw your balance";
}

function bank_title() {
    echo "Bank Accounts";
}

function addbank_title() {
    echo "Add Bank Account";
}

function editbank_title() {
    echo "Edit Bank Information";
}

// Declare The CSS
function fund_css() {
    ?>
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-timepicker/css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
    <link href="/assets/css/footable/footable.core.css" rel="stylesheet">
    <?php
}

function bank_css() {
    ?>
    <link href="/assets/css/footable/footable.core.css" rel="stylesheet">
    <?php
}

// Declare The JS
function fund_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script src="/assets/js/footable/footable.js"></script>
    <script type="text/javascript" src="/assets/modul-js/account/summary.js"></script>
    <?php
}

function transfer_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/modul-js/account/transfer.js"></script>
    <?php
}

function registerfund_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/modul-js/account/registerfund.js"></script>
    <?php
}

function bank_js() {
    ?>
    <script src="/assets/js/footable/footable.js"></script>
    <script type="text/javascript" src="/assets/modul-js/account/bank.js"></script>
    <?php
}

function addbank_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/modul-js/account/addbank.js"></script>
    <?php
}

function editbank_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/modul-js/account/editbank.js"></script>
    <?php
}

function withdraw_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
    <script src="/assets/js/footable/footable.js"></script>
    <script type="text/javascript" src="/assets/modul-js/account/withdraw.js"></script>
    <script type="text/javascript" src="/assets/modul-js/account/withdrawlist.js"></script>
    <?php
}

function menu_account() {
    global $menu_array;
    $accountmenu = array(
        "label" => "Account",
        "url" => "#",
        "icon" => "fa fa-user",
        "sub" => array(
            array(
                "label" => "Fund Summary",
                "url" => "/account/fund-summary",
                "icon" => "fa fa-dollar",
            ),
            array(
                "label" => "Transfer Fund",
                "url" => "/account/transfer",
                "icon" => "fa fa-mail-forward",
            ),
            array(
                "label" => "Register Balance",
                "url" => "/account/register-balance",
                "icon" => "fa fa-users",
            ),
            array(
                "label" => "Withdraw Balance",
                "url" => "/account/withdraw",
                "icon" => "fa fa-money",
            ),
            array(
                "label" => "Bank Accounts",
                "url" => "/account/bank",
                "icon" => "fa fa-credit-card",
            )
        )
    );
    //$menu_array[3] = $accountmenu;
}

function the_account() {
    global $app;
    global $csrf; 
    // ALL POSTS
    $app->post('/account/fund-summary/list', function(Request $request) {
        $curpage = $request->get('page');
        include 'fund.list.php';
        return '';
    });
    $app->post('/account/fund-summary/filter', function(Request $request) {
        $_SESSION["filtersum"]["transid"] = $request->get('transid');
        $_SESSION["filtersum"]["date"] = $request->get('date');
        $_SESSION["filtersum"]["type"] = $request->get('type');
        $_SESSION["filtersum"]["flow"] = $request->get('flow');
        return new Response('Success', 200);
    });
    $app->post('/account/fund-summary/clearfilter', function(Request $request) {
        $_SESSION["filtersum"] = "";
        return new Response('Success', 200);
    });
    $app->post('/account/transfer/exec', function(Request $request) {
        global $db;
        global $global_min_trf;
        $uname = $request->get('uname');
        $pin = $request->get('pin');
        $nominal = $request->get('nominal');
        $notes = $request->get('notes');
        $types = $request->get('types');
        $tox = userID($uname);
        // CEK JIKA BETUL
        if ($nominal >= $global_min_trf && userExist($uname) && pinCorrect($pin) && hasDevidentAll($_SESSION["uid"])) {
            if ($types == 'reg') {
                if (current_register_fund() >= $nominal) {
                    // Prepare & Prevent SQL Injection
                    $db->bind("nominal", $nominal);
                    $db->bind("notes", $notes);
                    $db->bind("from", $_SESSION["uid"]);
                    $db->bind("to", $tox);
                    // Execute
                    $row = $db->query("INSERT INTO fund_transaction(type,nominal,details,from_id,to_id,date) VALUES('10',:nominal,:notes,:from,:to,NOW())");
                    if ($row) {
                        return new Response('SUCCESS', 200);
                        //return var_dump($row);
                    }
                } else {
                    return new Response('FAILED', 201);
                }
            }
            if ($types == 'fund') {
                if (current_fund() >= $nominal) {
                    // Prepare & Prevent SQL Injection
                    $db->bind("nominal", $nominal);
                    $db->bind("notes", $notes);
                    $db->bind("from", $_SESSION["uid"]);
                    $db->bind("to", $tox);
                    // Execute
                    $row = $db->query("INSERT INTO fund_transaction(type,nominal,details,from_id,to_id,date) VALUES('1',:nominal,:notes,:from,:to,NOW())");
                    if ($row) {
                        return new Response('SUCCESS', 200);
                        //return var_dump($row);
                    }
                } else {

                    return new Response('FAILED', 201);
                }
            }
        } else {
            return new Response('Failed', 201);
        }
    });
    $app->post('/account/register-balance/convert', function(Request $request) {
        global $db;
        $pin = $request->get('pin');
        $nominal = $request->get('nominal');
        // Check if current fund is enough, the pin is correct, and user has a devident
        if (current_fund() >= $nominal && pinCorrect($pin) && hasDevidentAll($_SESSION["uid"])) {
            // PREPARE & PREVENT SQL INJECTION
            $db->bind("nominal", $nominal);
            $db->bind("notes", "CONVERSION TO REGISTER FUND");
            $db->bind("from", $_SESSION["uid"]);
            $db->bind("to", "0");
            // EXECUTE
            $row = $db->query("INSERT INTO fund_transaction(type,nominal,details,from_id,to_id,date) VALUES('2',:nominal,:notes,:from,:to,NOW())");
            if ($row) {
                return new Response('SUCCESS', 200);
            }
        } else {
            return new Response('Failed', 201);
        }
    });
    $app->post('/account/withdraw/clearfilter', function(Request $request) {
        $_SESSION["filterwithdraw"] = "";
        return new Response('Success', 200);
    });
    $app->post('/account/withdraw/filter', function(Request $request) {
        $_SESSION["filterwithdraw"]["status"] = $request->get('status');
        return new Response('Success', 200);
    });
    $app->post('/account/withdraw/exec', function(Request $request) {
        global $db;
        global $global_wdable;
        global $global_wdreg;
        global $global_min_wd;
        $pin = $request->get('pin');
        $nominal = $request->get('nominal');
        $bank = $request->get('bank');
        // Calculation
        $takenfund = ($global_wdable / 100) * $nominal; // Means n% Will be taken & transferable to user bank account, you can set it up on global.variable.php
        $takenregister = ($global_wdreg / 100) * $nominal; // Means n% Will be converted into REGISTER FUND, you can set it up on global.variable.php
        // Check the conditional
        if ($nominal >= $global_min_wd && current_fund() >= $takenfund && isBankMine($bank) && pinCorrect($pin) && hasDevidentAll($_SESSION["uid"])) {
            // PREPARE 
            $db->bind("userid", $_SESSION["uid"]);
            $db->bind("nominal", $takenfund);
            $db->bind("bank", $bank);
            $db->bind("pendreg", $takenregister);
            // Record To Withdraw
            $x = $db->query("INSERT INTO withdrawal(uid,date,nominal,bank_id,status,pendregs) VALUES(:userid,NOW(),:nominal,:bank,'PENDING',:pendreg)");
            $idWithdraw = $db->lastInsertId();
            if ($idWithdraw && $x) {
                // PREPARE
                $db->bind("takenfund", $nominal);
                $db->bind("from", $_SESSION["uid"]);
                $db->bind("notes", "WITHDRAW #" . $idWithdraw);
                // Record the Transaction
                $deduct1 = $db->query("INSERT INTO fund_transaction(date,type,nominal,from_id,details,to_id) VALUES(NOW(),8, :takenfund, :from,:notes,0)");
                if ($deduct1) {
                    return new Response('SUCCESS', 200);
                } else {
                    return new Response('Failed', 201);
                }
            } else {
                return new Response('Failed', 201);
            }
        } else {
            return new Response('Failed', 201);
        }
    });
    $app->post('/account/withdraw/list', function(Request $request) {
        $curpage = $request->get('page');
        include 'withdraw.list.php';
        return '';
    });
    $app->post('/account/bank/add/submit', function(Request $request) {
        global $db;
        $bankname = $request->get('bankname');
        $branchname = $request->get('branch');
        $holder = $request->get('holder');
        $acnumber = $request->get('acnumber');
        $swift = $request->get('swift');
        $beneficiary = $request->get('beneficiary');
        $pin = $request->get('pin');
        // CONDITIONAL FOR MAKE SURE PIN CORRECT AND BANK EXISTS
        if (pinCorrect($pin) && !bankExists($acnumber)) {
            // PREPARE
            $db->bind("bankname", $bankname);
            $db->bind("branchname", $branchname);
            $db->bind("acnumber", $acnumber);
            $db->bind("holder", $holder);
            $db->bind("swift", $swift);
            $db->bind("uid", $_SESSION["uid"]);
            // EXECUTE
            $row = $db->query("INSERT INTO user_bank(bank_name,branch_name,acnumber,bankholder,swiftcode,uid) VALUES(:bankname,:branchname,:acnumber,:holder,:swift,:uid)");
            if ($row) {
                return new Response('SUCCESS', 200);
            }
        } else {
            return new Response('Failed', 201);
        }
    });
    $app->post('/account/bank/editbank', function(Request $request) {
        global $db;
        $bankid = $request->get('idbank');
        $bankname = $request->get('bankname');
        $branchname = $request->get('branch');
        $holder = $request->get('holder');
        $acnumber = $request->get('acnumber');
        $swift = $request->get('swift');
        $beneficiary = $request->get('beneficiary');
        $pin = $request->get('pin');
        // CEK JIKA BETUL
        if (pinCorrect($pin) && isBankMine($bankid)) {
            $db->bind("bankid", $bankid);
            $db->bind("bankname", $bankname);
            $db->bind("branch", $branchname);
            $db->bind("holder", $holder);
            $db->bind("acnumber", $acnumber);
            $db->bind("swift", $swift);
            $db->bind("bene", $beneficiary);
            $row = $db->query("UPDATE user_bank SET bank_name = :bankname, branch_name = :branch, bankholder = :holder, acnumber = :acnumber, swiftcode = :swift, beneficiary = :bene WHERE bank_id = :bankid;");
            if ($row) {
                return new Response('SUCCESS', 200);
            }
        } else {
            return new Response('Failed', 201);
        }
    });
    $app->post('/account/bank/deletebank', function(Request $request) {
        global $db;
        $bankid = $request->get('idbank');
        // CEK JIKA BETUL
        if (isBankMine($bankid)) {
            $db->bind("bankid", $bankid);
            $row = $db->query("DELETE FROM user_bank WHERE bank_id = :bankid;");
            if ($row) {
                return new Response('SUCCESS', 200);
            }
        } else {
            return new Response('Failed', 201);
        }
    });
    $app->post('/account/bank/list', function(Request $request) {
        $curpage = $request->get('page');
        include 'bank.list.php';
        return '';
    });
    // ALL GET
    $app->get('/account/fund-summary', function() {
        global $hooks;
        $_SESSION["filtersum"] = "";
        $hooks->add_action('global_css', "fund_css");
        $hooks->add_action('global_js', "fund_js");
        $hooks->add_action('the_title', "fund_title");
        the_head();
        include 'fund.tpl.php';
        the_footer();
        return "";
    });
    $app->get('/account/transfer', function() {
        global $hooks;
        global $global_min_trf;
        $hooks->add_action('global_js', "transfer_js");
        $hooks->add_action('the_title', "transfer_title");
        the_head();
        include 'transfer.tpl.php';
        the_footer();
        return "";
    });
    $app->get('/account/register-balance', function() {
        global $hooks;
        $hooks->add_action('global_js', "registerfund_js");
        $hooks->add_action('the_title', "registerfund_title");
        the_head();
        include 'registerfund.tpl.php';
        the_footer();
        return "";
    });
    $app->get('/account/withdraw', function() {
        global $hooks;
        global $global_wdable;
        global $global_wdreg;
        global $global_min_wd;
        $_SESSION["filterwithdraw"] = "";
        $hooks->add_action('global_css', 'bank_css');
        $hooks->add_action('global_js', 'withdraw_js');
        $hooks->add_action('the_title', "withdraw_title");
        the_head();
        include 'withdraw.tpl.php';
        the_footer();
        return "";
    });
    $app->get('/account/bank/edit/{id}', function ($id) use ($app) {
        global $db;
        global $hooks;
        global $bankid;
        $bankid = $id;
        if (!isset($id) || !isBankMine($id)) {
            return $app->redirect('/account/bank');
        }

        $hooks->add_action('global_js', "editbank_js");
        $hooks->add_action('the_title', "editbank_title");
        the_head();
        include 'bank.edit.php';
        the_footer();
        return "";
    });
    $app->get('/account/bank/add', function() {
        global $hooks;
        $hooks->add_action('global_js', "addbank_js");
        $hooks->add_action('the_title', "addbank_title");
        the_head();
        include 'bank.add.php';
        the_footer();
        return "";
    });
    $app->get('/account/bank', function() {
        global $hooks;
        $hooks->add_action('global_css', "bank_css");
        $hooks->add_action('global_js', "bank_js");
        $hooks->add_action('the_title', "bank_title");
        the_head();
        include 'bank.tpl.php';
        the_footer();
        return "";
    });
// END
    $app->get('/account', function() use($app) {
        return $app->redirect('/account/fund-balance');
    });
}

function transType() {
    global $db;
    $trans = $db->query("SELECT * FROM type_transaction");
    foreach ($trans as $key => $value) {
        echo "<option value='" . $value["id"] . "'>" . $value["name"] . "</option>";
    }
}

function getTransName($id) {
    global $db;
    $db->bind("id", $id);
    $trans = $db->query("SELECT * FROM type_transaction WHERE id= :id;");
    return $trans[0]["name"];
}

function isBankMine($id) {
    global $db;
    $db->bind("bankid", $id);
    $db->bind("userid", $_SESSION["uid"]);
    $banks = $db->query("SELECT * FROM user_bank WHERE uid = :userid AND bank_id = :bankid;");
    if (count($banks) > 0) {
        return true;
    } else {
        return false;
    }
}

function hasBank() {
    global $db;
    $db->bind("uid", $_SESSION["uid"]);
    $banks = $db->query("SELECT * FROM user_bank WHERE uid = :uid");
    if (count($banks) > 0) {
        return true;
    } else {
        return false;
    }
}

function bankInfo($id, $data, $uid = "x") {
    global $db;
    $userid = ($uid == "x" ? $_SESSION["uid"] : $uid);
    $db->bind("uid", $userid);
    $db->bind("id", $id);
    $banks = $db->query("SELECT * FROM user_bank WHERE uid = :uid AND bank_id = :id");
    return $banks[0][$data];
}

function theBanks() {
    global $db;
    $db->bind("uid", $_SESSION["uid"]);
    $banks = $db->query("SELECT * FROM user_bank WHERE uid = :uid");
    foreach ($banks as $key => $value) {
        echo "<option value='" . $value["bank_id"] . "'>" . $value["bank_name"] . " - " . $value["acnumber"] . "</option>";
    }
}
