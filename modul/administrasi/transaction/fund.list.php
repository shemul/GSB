<?php

ini_set('max_execution_time', 300);

$latest_week = getLatestWeek();
global $db;
if (isset($_SESSION["filtersum"]["uname"]) && $_SESSION["filtersum"]["uname"] != "") {
    $uidX = getUID($_SESSION["filtersum"]["uname"]);
}
// Important Variable
$page = $curpage; // <--- Get Current Page
$cur_page = $page;
$page -= 1;
$per_page = 10;
$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;
$addonwhere = "";
$tbl = "";
$total_string = "";
// Query The Transaction
$db->bind("page", $start);
// Additional WHERE
// Jika Semua User
// Jika Hanya Admin
if (isset($_SESSION["filtersum"]["transid"]) && $_SESSION["filtersum"]["transid"] != "") {
    $db->bind("transid", $_SESSION["filtersum"]["transid"]);
    $addonwhere .= " AND trans_id = :transid";
}
if (isset($_SESSION["filtersum"]["date"]) && $_SESSION["filtersum"]["date"] != "") {
    $db->bind("tgl", $_SESSION["filtersum"]["date"]);
    $addonwhere .= " AND DATE(date) = :tgl";
}
if (isset($_SESSION["filtersum"]["type"]) && $_SESSION["filtersum"]["type"] != "") {
    $db->bind("type", $_SESSION["filtersum"]["type"]);
    $addonwhere .= " AND type = :type";
}
if (isset($_SESSION["filtersum"]["week"]) && $_SESSION["filtersum"]["week"] != "") {
    //print_r($_SESSION["filtersum"]["week"]);
    $db->bind("week", $_SESSION["filtersum"]["week"]);
    $addonwhere .= " AND week = :week";
}
if (isset($_SESSION["filtersum"]["uname"]) && $_SESSION["filtersum"]["uname"] != "") {
    if ($_SESSION["filtersum"]["flow"] == "") {
        //echo "A";    
        $db->bind("from", $uidX);
        $db->bind("to", $uidX);
        $blegedes = " (to_id = :to OR from_id = :from)";
    } elseif ($_SESSION["filtersum"]["flow"] == "in") {
        //echo "B";
        $db->bind("to", $uidX);
        $blegedes = " to_id = :to";
    } else {
        //echo "C";
        $db->bind("from", $uidX);
        $blegedes = " from_id = :from";
    }
} else if (isset($_SESSION["filtersum"]["flow"]) && $_SESSION["filtersum"]["flow"] != "") {
    if ($_SESSION["filtersum"]["flow"] == "in") {
        //echo "D";
        $db->bind("to", $_SESSION["uid"]);
        $blegedes = " to_id = :to";
    } else {
        //echo "E";
        $db->bind("from", $_SESSION["uid"]);
        $blegedes = " from_id = :from";
    }
} else {
    if (!isset($_SESSION["filtersum"]["model"]) || $_SESSION["filtersum"]["model"] != "adm") {
        //echo "F";
        $db->bind("from", "x");
        $db->bind("to", "x");
        $blegedes = " (to_id <> :to OR from_id <> :from)";
    } else {
        //echo "G";
        $db->bind("from", $_SESSION["uid"]);
        $db->bind("to", $_SESSION["uid"]);
        $blegedes = " (to_id = :to OR from_id = :from)";
    }
}
//
//$db->bind("week", getLatestWeek());


$data = $db->query("SELECT * FROM fund_transaction WHERE " . $blegedes . " " . $addonwhere . " ORDER BY to_id ASC LIMIT 10 OFFSET :page"); // <-- Query with OFFSET
//


$tbl .='<div class="tblwrap">'
        . '<div id="loading">'
        . '<p>Retrieving Data From Server.....</p>'
        . '</div>'
        . '<table id="trans-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">';
$tbl .='<thead>
                                                <tr>

                                                    
                                                    <th>#ID</th>
                                                    
                                                    <th>UID</th>
                                                    <th>#DIN</th>
                                                    <th>Name</th>
                                                    <th>LTC</th>
                                                    <th>RTC</th>
                                                    <th>C.Match</th>
                                                    <th>L.Match</th>
                                                    <th>T.Match</th>
                                                    <th>STEP</th>

                                                    <!--
                                                    <th>LR</th>
                                                    <th>RR</th>
                                                    -->

                                                    <th>CH</th>
                                                    <th>T.Bill</th>
                                                    <th>Bill</th>
                                                    <th data-hide="phone,tablet">Date & Time</th>
                                                    <th>Week</th>
                                                   
                                                </tr>
                                            </thead>
            <tbody id="trans-tbl-content">';
foreach ($data as $key => $value) {
    
    $left_node =  countNodes($value["to_id"] ,"left");
    $right_node =  countNodes($value["to_id"] ,"right");
    
    //$right_node =  2;
    $last_match = $value["last_match"] ;
    $total_match = $value["total_match"]; 
    $cycle = $value["cycle"];

    $left_remain = $value["left_remain"];
    $right_remain = $value["right_remain"];
    
    $sub_left_node = $left_node + $left_remain;
    $sub_right_node = $right_node + $right_remain;
    

    $matches = getMatching($sub_left_node , $sub_right_node , $last_match , $total_match);

    $new_total_match = $matches + $last_match;


   

    if($new_total_match > 15) {
        $matches = 15 - $last_match;
        $new_total_match  = $matches + $last_match;
    }

    

    $bill = ( $matches * 1600 ) - ($matches * 1600  * 0.10);
    $tbl .= "<tr>"
            . "<td>" . $value["trans_id"] . "</td>" //ID
            . "<td>" . $value["to_id"] . "</td>"
            . "<td><strong>" . getUname($value["to_id"]) . "</strong></td>" //DIN
            . "<td>" . ($value["to_id"] == "0" ? "SYSTEM" : ($value["to_id"] != $_SESSION["uid"] ? getProfileData($value["to_id"], "first_name") . " " . getProfileData($value["to_id"], "mname") . " " . getProfileData($value["to_id"], "last_name")  . "<br>" : "ME")) . "</td>" //Name

            
            . "<td>" . $left_node .'+'. $left_remain  .'=' . $sub_left_node  . "</td>" // Left Node
            . "<td>" . $right_node.'+'. $right_remain .'=' . $sub_right_node . "</td>" // Left Node
            . "<td>" . $matches . "</td>" //matches
            . "<td>" . $last_match . "</td>"
            . "<td>" . $new_total_match . "</td>"
            . "<td>" . $cycle . "</td>"
            . "<td>" . "10%" . "</td>"
            . "<td>" .  $matches * 1600 . "</td>"
            . "<td>" .  $bill . "</td>"
            . "<td>" . date('F d, Y H:i', strtotime($value["date"])) 
            . "<td>" . $value["week"] . "</td>"
         
            
            . "</tr>";
    
}

$tbl .='</tbody></table></div>';
/* --------------------------------------------- */
$blegedes = "";
$addonwhere = "";
// Additional WHERE
if (isset($_SESSION["filtersum"]["transid"]) && $_SESSION["filtersum"]["transid"] != "") {
    $db->bind("transid", $_SESSION["filtersum"]["transid"]);
    $addonwhere .= " AND trans_id = :transid";
}
if (isset($_SESSION["filtersum"]["date"]) && $_SESSION["filtersum"]["date"] != "") {
    $db->bind("tgl", $_SESSION["filtersum"]["date"]);
    $addonwhere .= " AND DATE(date) = :tgl";
}
if (isset($_SESSION["filtersum"]["type"]) && $_SESSION["filtersum"]["type"] != "") {
    $db->bind("type", $_SESSION["filtersum"]["type"]);
    $addonwhere .= " AND type = :type";
}
if (isset($_SESSION["filtersum"]["uname"]) && $_SESSION["filtersum"]["uname"] != "") {
    if ($_SESSION["filtersum"]["flow"] == "") {
        //echo "A";    
        $db->bind("from", $uidX);
        $db->bind("to", $uidX);
        $blegedes = " (to_id = :to OR from_id = :from)";
    } elseif ($_SESSION["filtersum"]["flow"] == "in") {
        //echo "B";
        $db->bind("to", $uidX);
        $blegedes = " to_id = :to";
    } else {
        //echo "C";
        $db->bind("from", $uidX);
        $blegedes = " from_id = :from";
    }
} else if (isset($_SESSION["filtersum"]["flow"]) && $_SESSION["filtersum"]["flow"] != "") {
    if ($_SESSION["filtersum"]["flow"] == "in") {
        //echo "D";
        $db->bind("to", $_SESSION["uid"]);
        $blegedes = " to_id = :to";
    } else {
        //echo "E";
        $db->bind("from", $_SESSION["uid"]);
        $blegedes = " from_id = :from";
    }
} else {
    if (!isset($_SESSION["filtersum"]["model"]) || $_SESSION["filtersum"]["model"] != "adm") {
        //echo "F";
        $db->bind("from", "x");
        $db->bind("to", "x");
        $blegedes = " (to_id <> :to OR from_id <> :from)";
    } else {
        //echo "G";
        $db->bind("from", $_SESSION["uid"]);
        $db->bind("to", $_SESSION["uid"]);
        $blegedes = " (to_id = :to OR from_id = :from)";
    }
}

//$db->bind("uid",$_SESSION["uid"]);
$baris = $db->query("SELECT COUNT(trans_id) as jumlah FROM fund_transaction WHERE " . $blegedes . " " . $addonwhere);
$count = $baris[0]["jumlah"];
$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
/* ----------------------------------------------------------------------------------------------------------- */
$tbl .= "<div class='col-md-8'><ul class='pagination pagination-lg'>";

// FOR ENABLING THE FIRST BUTTON
if ($first_btn && $cur_page > 1) {
    $tbl .= "<li p='1' ><a>First</a></li>";
} else if ($first_btn) {
    $tbl .= "<li p='1' class='inactive'><a>First</a></li>";
}

// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
    $tbl .= "<li p='$pre' ><a>Previous</a></li>";
} else if ($previous_btn) {
    $tbl .= "<li class='inactive'><a>Previous</a></li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

    if ($cur_page == $i)
        $tbl .= "<li p='$i' class='active'><a>{$i}</a></li>";
    else
        $tbl .= "<li p='$i'><a>{$i}</a></li>";
}

// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    $tbl .= "<li p='$nex'><a>Next</a></li>";
} else if ($next_btn) {
    $tbl .= "<li class='inactive'><a>Next</a></li>";
}

// TO ENABLE THE END BUTTON
if ($last_btn && $cur_page < $no_of_paginations) {
    $tbl .= "<li p='$no_of_paginations'><a>Last</a></li>";
} else if ($last_btn) {
    $tbl .= "<li p='$no_of_paginations' class='inactive'><a>Last</a></li>";
}
//$total_string = "<div class='col-md-4'><span class='total' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span></div>";
$tbl = $tbl . "</ul></div>" . $total_string;  // Content for pagination
echo $tbl;


