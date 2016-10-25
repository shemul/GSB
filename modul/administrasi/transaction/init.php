<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);
global $hooks;
global $db2;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


$hooks->add_action('admin_action', 'the_trx'); // Tancapkan fungsi dashboard ke Trigger Silex
// Define Heading masing2 page

function trx_title() {
    echo "Transaction Lists";
}
function bill_title() {
    echo "BILL LIST";
}
function withdrawal_title() {
    echo "Withdrawal Demand";
}
function invoice_title() {
    echo "Purchase History";
}

// Define CSS
function trx_css() {
    ?>
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-timepicker/css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="/assets/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
    <link href="/assets/css/footable/footable.core.css" rel="stylesheet">
    <?php
}

// Define JS
function withdrawal_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script src="/assets/js/footable/footable.js"></script>
    <script type="text/javascript" src="/assets/modul-js/admin/withdrawal.js"></script>
    <script type="text/javascript" src="/assets/modul-js/admin/withdrawal-list.js"></script>
    <?php
}
function invoice_js() {
    ?>
    <script src="/assets/js/footable/footable.js"></script>
    <script type="text/javascript" src="/assets/modul-js/admin/invoice-list.js"></script>
    <?php
}



function trx_js() {
    ?>
    <script type="text/javascript" src="/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-daterangepicker/moment.min.js"></script>

    <script type="text/javascript" src="/assets/js/jspdf.min.js"></script>
    <script type="text/javascript" src="/assets/js/jspdf.plugin.autotable.js"></script>

    <script type="text/javascript" src="/assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script src="/assets/js/footable/footable.js"></script>
    <script type="text/javascript" src="/assets/modul-js/admin/summary.js"></script>
    <?php
}

function the_trx() {
    global $app;
    // Fund Balance
    $app->post('/transaction/list', function(Request $request) {
        $curpage = $request->get('page');
        include 'fund.list.php';
        return '';
    });

    $app->post('/transaction/bill/list', function(Request $request) {
        $curpage = $request->get('page');
        include 'bill.list.php';
        return '';
    });


    $app->post('/transaction/filter', function(Request $request) {
        $_SESSION["filtersum"]["transid"] = $request->get('transid');
        $_SESSION["filtersufm"]["date"] = $request->get('date');
        $_SESSION["filtersum"]["type"] = $request->get('type');
        $_SESSION["filtersum"]["flow"] = $request->get('flow');
        $_SESSION["filtersum"]["model"] = $request->get('model');
        $_SESSION["filtersum"]["uname"] = $request->get('uname');
        $_SESSION["filtersum"]["week"] = $request->get('week');
        return new Response('Success', 200);
    });
    $app->post('/transaction/clearfilter', function(Request $request) {
        $_SESSION["filtersum"] = "";
        return new Response('Success', 200);
    });
    $app->post('/transaction/generateweek', function(Request $request) {
        return generateweek() ;
    });
    $app->post('/transaction/flush', function(Request $request) {
        return flush_generate() ;
    });

    // testing purpose
    $app->post('/transaction/savetohistory', function(Request $request) {
        global $db;


        $total_form_this_week =count($db->query("SELECT * FROM fund_transaction where week =''")); //imp
        $latestweek = getLatestWeek();
        $week_free_form = $db->query("SELECT * FROM fund_transaction WHERE date >'" . $latestweek . "' AND week=''");
        $total_free = 0 ; // imp
        foreach ($week_free_form as $key => $value) {
            $user = $value["to_id"];

            $temp = $db->query("SELECT * FROM user_id where product = 49 and uid ='" . $user."'");
            $total_free = $total_free + count($temp);
        }

        $total_ban = count($db->query("SELECT * FROM fund_transaction where ban =1"));
        $bill_for = $_SESSION['bill_for'];
        $total_match = $_SESSION['total_matching'];
        $total_bill = $_SESSION['total_bill'];

         $deduct2 = $db->query("INSERT INTO history(date,total_form,total_free_form ,total_ban_form,bill_for,total_match,total_bill) VALUES(NOW(),".$total_form_this_week. ",". $total_free. "," . $total_ban. ",". $bill_for. "," .$total_match. "," .$total_bill. ")");

         if($deduct2) {
            

            unset($_SESSION['bill_for']);
            unset($_SESSION['total_matching']);
            unset($_SESSION['total_bill']);
            $_SESSION['ready'] = 1;

            return new Response('Success', 200);
        } else {
            return new Response('fail', 403);
        }



    });

    

    $app->get('/transaction', function() {
        global $hooks;
        $_SESSION["filtersum"] = "";
        $hooks->add_action('global_css', "trx_css");
        $hooks->add_action('global_js', "trx_js");
        $hooks->add_action('the_title', "trx_title");
        the_head();
        include 'fund.tpl.php';
        the_footer();
        return "";
    });
    $app->get('/transaction/bill', function() {
        global $hooks;
        $_SESSION["filtersum"] = "";
        $hooks->add_action('global_css', "trx_css");
        $hooks->add_action('global_js', "trx_js");
        $hooks->add_action('the_title', "bill_title");
        the_head();
        include 'bill.tpl.php';
        the_footer();
        return "";
    });    
    // Withdraw Lists
    $app->post('/withdrawal/clearfilter', function(Request $request) {
        $_SESSION["filterwithdraw"] = "";
        return new Response('Success', 200);
    });
    $app->post('/withdrawal/filter', function(Request $request) {
        $_SESSION["filterwithdraw"]["status"] = $request->get('status');
        $_SESSION["filterwithdraw"]["wdid"] = $request->get('wdid');
        $_SESSION["filterwithdraw"]["uname"] = $request->get('uname');
        $_SESSION["filterwithdraw"]["from"] = $request->get('from');
        $_SESSION["filterwithdraw"]["to"] = $request->get('to');
        return new Response('Success', 200);
    });
    $app->post('/withdrawal/pay', function(Request $request) {
        global $db;
        $id = $request->get('id');
        if ($id) {
            $idWithdraw = $id;
            $owner = wdOwner($id);
            $pending = pendingWdReg($id);
            $db->bind('id', $id);
            $tgl = date('Y-m-d H:i:s');
            $db->bind('tgl', $tgl);
            $update = $db->query("UPDATE withdrawal SET status = 'PAID', paid_date = :tgl WHERE id = :id");
            if ($update) {
                // If Update Success, insert it into transaction
                // PREPARE THE DATA
                $db->bind("takenregister", $pending);
                $db->bind("owner", $owner);
                $db->bind("notes", "WITHDRAW # " . $idWithdraw);
                // Execute
                $deduct2 = $db->query("INSERT INTO fund_transaction(date,type,nominal,from_id,details,to_id) VALUES(NOW(),10, :takenregister, 0,:notes,:owner)");
                if ($deduct2) {
                    return new Response('SUCCESS', 200);
                } else {
                    return new Response('FAILED', 201);
                }
            } else {
                return new Response('FAILED', 201);
            }
        }
    });
    $app->post('/withdrawal/list', function(Request $request) {
        $curpage = $request->get('page');
        include 'withdraw.list.php';
        return '';
    });
// Smarty untuk menu register balance
    $app->get('/withdrawal', function() {
        global $hooks;
        $_SESSION["filterwithdraw"] = "";
        $hooks->add_action('global_css', 'bank_css');
        $hooks->add_action('global_js', 'withdrawal_js');
        $hooks->add_action('the_title', "withdrawal_title");
        the_head();

        include 'withdraw.tpl.php';
        the_footer();
        return "";
    });
    // Invoiceing Lists
    $app->post('/invoice/clearfilter', function(Request $request) {
        $_SESSION["filterinvoice"] = "";
        return new Response('Success', 200);
    });

    $app->post('/invoice/filter', function(Request $request) {
        $_SESSION["filterinvoice"]["status"] = $request->get('status');
        $_SESSION["filterinvoice"]["wdid"] = $request->get('wdid');
        return new Response('Success', 200);
    });
    $app->post('/invoice/pay', function(Request $request) {
        global $db;
        $id = $request->get('id');
        if ($id) {
            $idWithdraw = $id;
            $owner = InvBuyer($id);
            $amount = InvAmount($id);
            $db->bind('id', $id);
            $update = $db->query("UPDATE invoice SET status = '1' WHERE id = :id");
            if ($update) {
                // If Update Success, insert it into transaction
                // PREPARE THE DATA
                $x = $db->query("INSERT INTO fund_transaction(type,nominal,details,from_id,to_id,date) VALUES(:tipe,:nominal,:notes,:from,:to,NOW())", 
                        array("tipe" => "1", "nominal" => $amount, "notes" => "PURCHASE POINT", "from" => "0", "to" => $owner));
                if ($x) {
                    return new Response('SUCCESS', 200);
                } else {
                    return new Response('FAILED', 201);
                }
            } else {
                return new Response('FAILED', 201);
            }
        }
    });
    $app->post('/invoice/list', function(Request $request) {
        $curpage = $request->get('page');
        include 'invoice.list.php';
        return '';
    });
// Smarty untuk menu register balance
    $app->get('/invoice', function() {
        global $hooks;
        $_SESSION["filterwithdraw"] = "";
        $hooks->add_action('global_css', 'bank_css');
        $hooks->add_action('global_js', 'invoice_js');
        $hooks->add_action('the_title', "invoice_title");
        the_head();

        include 'invoice.tpl.php';
        the_footer();
        return "";
    });
}

function InvBuyer($id) {
    global $db;
    $db->bind("id", $id);
    $owner = $db->query("SELECT buyer FROM invoice WHERE id = :id");
    return $owner[0]["buyer"];
}

function InvAmount($id) {
    global $db;
    $db->bind("id", $id);
    $owner = $db->query("SELECT amount FROM invoice WHERE id = :id");
    return $owner[0]["amount"];
}

/*
function countNodesBills($uid,$position){
     global $db;
     global $downlinearray;

     $right = array();
     $left = array();
     $downlinearray = array();
     
     $db->bind("uid",$uid);
     $downline = $db->query("SELECT * FROM genealogy WHERE parentid=:uid order by uid ASC ");
     $i = 1;
     
     foreach ($downline as $key => $value) {

        //echo "<pre>" . var_export($value) . "</pre>";
            if($i>1){
               $right[]=$value["uid"];
            }else{
               $left[]=$value["uid"];
            }
           $i++;
        //}
     }
    //  echo "for : " . $uid . "->" ;
    //  echo "<pre>" . var_dump($downline) . "</pre>";
    // echo "downline called ";
     //echo $left[0] . " -> " ;
     $late = getLatestWeek2();
    if(count($left)>0){
        
        downline_2($left[0],$late);

        //
        
        $db->bind("left_0",$left[0]);
        $db->bind("latestweek",$late);
        $null_qry = $db->query("SELECT * FROM fund_transaction WHERE uid=:left_0 and date >= :latestweek ");
        //
        
        if(count($null_qry) > 0) {
            $downlinearray[] = $left[0];
        }
       
        //var_dump($downlinearray);
        asort($downlinearray);

        $left = $downlinearray;
         //var_export($left);
        //return $left;
        // Reset Array
        $downlinearray = array();

    }
    // Ambil List ID kaki Kanan
     if(count($right)>0){
        downline_2($right[0],$late);
        //var_dump($temp2);
        

        $db->bind("right_0",$right[0]);
        $db->bind("latestweek",$late);
        $null_qry = $db->query("SELECT * FROM fund_transaction WHERE uid=:right_0 and date >= :latestweek");
        //
     
        if(count($null_qry) > 0) {
            $downlinearray[] = $right[0];
        }

        //$downlinearray[] = $right[0];
        asort($downlinearray);
        $right = $downlinearray;
        //var_dump($left);
        //return $left;
        // Reset Array
        $downlinearray = array();
    }
   // echo "<br><br>";
    return ($position=="left" ? count($left) : ($position=="right" ? count($right) : ""));
}
*/
function getMatching($sub_left_node , $sub_right_node , $last_match , $total_match) {
    
     // $matching ; 
     // $current_total_matching ;
     // $new_left_remaining = 0 ;
     // $new_right_remaining = 0 ;

     // if($left_node && $right_node > 0) {
     //        if($left_node <= $right_node) {
     //            $current_total_matching = $left_node + $last_match;
     //            if($current_total_matching <= 15) {
     //                $new_right_remaining = $right_node - $left_node ;
     //                return $left_node ;
     //            }
     //        } else {
     //            $current_total_matching = $right_node + $last_match;
     //            if($current_total_matching <= 15) {
     //                $new_left_remaining = $left_node - $right_node ;
     //                return $right_node ;
     //            }
     //        }

     // } else {
     //    return 0 ;
     // }

    

    $current_matching = 0 ; 
    $new_left_remaining = 0; 
    $new_right_remaining = 0; 

    $CL = $sub_left_node  ; 
    $CR = $sub_right_node ;

    // $CL = 10  ; 
    // $CR = 15  ;

   
    if ($CL == $CR && ($CL <=15 && $CR <=15)) {
        return $CL;
    } else if ($CL > $CR) {
        $current_matching = $CR ;

        // if($CL >= 15 ) {
        //     $new_left_remaining =  15 - $CR ;
        // } else {
        //     $new_left_remaining = $CL - $CR ;
        // }

        if($current_matching >= 15 ) {
            //$new_left_remaining = 0;
            $current_matching  = 15 ;
        }
        if($current_matching + $last_match >=15 ) {
            $current_matching = 15 - $last_match ;
            //$new_right_remaining = 0 ;
            //$new_left_remaining = 0 ;
        }
    } else {
        $current_matching = $CL ;

        // if($CR >=15) {
        //     $new_right_remaining = 15 - $CL;
        // } else {
        //     $new_right_remaining = $CR - $CL ;
        // }

        if($current_matching >= 15 ) {
            //$new_right_remaining = 0 ;
            $current_matching  = 15 ;
        }
        if($current_matching + $last_match >=15 ) {
            $current_matching = 15 - $last_match ;
            //$new_right_remaining = 0 ;
            //$new_left_remaining = 0 ;
        }
    }
    return $current_matching ;
    

}


function generateweek()
{
    

    global $db;
    //$db->bind("date","2016-03-27");


    //$data = $db->query("SELECT * FROM fund_transaction WHERE week = '" . getLatestWeek(). "'");

    if(isset($_SESSION["ready"])) {

        $data = $db->query("SELECT * FROM fund_transaction");
        foreach ($data as $key => $value) {

            // 
            $new_left_remaining = 0;
            $new_right_remaining = 0;
            // depend
            $left_node =  countNodes($value["to_id"] ,"left");
            $right_node =  countNodes($value["to_id"] ,"right");

            $last_match = $value["last_match"] ;
            $total_match = $value["total_match"];
            $cycle = $value["cycle"];

            $left_remain = $value["left_remain"];
            $right_remain = $value["right_remain"];

            $sub_left_node = $left_node + $left_remain;
            $sub_right_node = $right_node + $right_remain;
            
            $matches = getMatching($sub_left_node , $sub_right_node , $last_match , $total_match);



            // 12 May 2016 


            if($sub_left_node > $sub_right_node) {

                if($sub_left_node >= 15) {
                    $new_left_remaining = 15 - $sub_right_node;
                } else {
                    $new_left_remaining = $sub_left_node - $sub_right_node;
                }

                if($matches >= 15 ) {
                    $new_left_remaining = 0;
                }
                if($matches + $last_match >=15 ) {
               
                    $new_right_remaining = 0 ;
                    $new_left_remaining = 0 ;
                }

            } else {

                if($sub_right_node >=15) {
                    $new_right_remaining = 15 - $sub_left_node;
                } else {
                    $new_right_remaining = $sub_right_node - $sub_left_node ;
                }

                if($matches >= 15 ) {
                    $new_right_remaining = 0 ;
                }

                if($matches + $last_match >=15 ) {
                   
                    $new_right_remaining = 0 ;
                    $new_left_remaining  = 0 ;
                }


            }

            // 



            
            


            if($last_match + $matches > 15) {
                $matches = 15 - $last_match;
            }

            $total_match_s =  $last_match + $matches ;
            $new_last_match = $total_match_s;


            // Saymon bi bolse
            if($total_match_s >= 15) {
                $new_last_match = 0;

                $new_left_remaining = 0;
                $new_right_remaining = 0;
                $cycle = $cycle + 1  ;
            }



            
            


            
            //echo $value["to_id"] . "->" . $sub_left_node . " - " . $sub_right_node. " = " . $matches .  " Re : " . $new_last_match . ":" . $total_match_s . "\r\n" ;

            
            
            //$pinupdate = $db->query("UPDATE fund_transaction(date,type,to_id,last_match,total_match,week,uid,parentid) VALUES(:date,1,:to_id,:last_matched,:total_match,:week,:uid,:parentid)");
            
            $update = $db->query("UPDATE fund_transaction SET last_match =" . $new_last_match .", left_remain =".$new_left_remaining." , right_remain=".$new_right_remaining." , cycle=".$cycle." , total_match =".$total_match_s."  WHERE to_id =" . $value["to_id"]);
            
        }
        
        hitTheweek();
        unset($_SESSION['ready']);
        return count($data);
    } else {
        return "ERROR : Billsheet must be downloaded before generate" ;
    }
    
}

function flush_generate()
{
    

    global $db;
    $week = date('Y-m-d H:i:s');
    $latestweek = getLatestWeek();
    $data = $db->query("SELECT * FROM fund_transaction WHERE date >'" . $latestweek . "' AND week=''");
    foreach ($data as $key => $value) {
                $update = $db->query("UPDATE fund_transaction SET week = '$latestweek' , date ='".$latestweek."' WHERE to_id =" . $value["to_id"]);
    }  
    return count($data);
    
}



function hitTheweek() {

    global $db;
    $week = date('Y-m-d H:i:s');
    $data = $db->query("SELECT * FROM fund_transaction");

    foreach ($data as $key => $value) {

                $update = $db->query("UPDATE fund_transaction SET week = '$week' WHERE to_id =" . $value["to_id"]);

    }    
}