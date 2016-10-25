<?php
global $db;
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
$db->bind("page",$start);
// Additional WHERE
 if(isset($_SESSION["filtersum"]["transid"])&&$_SESSION["filtersum"]["transid"]!=""){
    $db->bind("transid",$_SESSION["filtersum"]["transid"]);
    $addonwhere .= " AND trans_id = :transid";
 }
 if(isset($_SESSION["filtersum"]["date"])&&$_SESSION["filtersum"]["date"]!=""){
    $db->bind("tgl",$_SESSION["filtersum"]["date"]);
    $addonwhere .= " AND DATE(date) = :tgl"; 
 }
 if(isset($_SESSION["filtersum"]["type"])&&$_SESSION["filtersum"]["type"]!=""){
    $db->bind("type",$_SESSION["filtersum"]["type"]);
    $addonwhere .= " AND type = :type"; 
 }
 if(isset($_SESSION["filtersum"]["flow"])&&$_SESSION["filtersum"]["flow"]!=""){
     if($_SESSION["filtersum"]["flow"]=="in"){
         $db->bind("to",$_SESSION["uid"]);
         $blegedes = " to_id = :to";
     }else{
         $db->bind("from",$_SESSION["uid"]);
         $blegedes = " from_id = :from";
     }
 }else{
     $db->bind("from",$_SESSION["uid"]);
     $db->bind("to",$_SESSION["uid"]);
     $blegedes = " (to_id = :to OR from_id = :from)";
 }
//
$data = $db->query("SELECT * FROM fund_transaction WHERE ".$blegedes." ".$addonwhere." ORDER BY trans_id DESC LIMIT 10 OFFSET :page"); // <-- Query with OFFSET
//
$tbl .='<div class="tblwrap">'
        . '<div id="loading">'
        . '<p>Retrieving Data From Server.....</p>'
        . '</div>'
        . '<table id="trans-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">';
$tbl .='<thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Nominal</th>
                                                    <th data-hide="phone,tablet">Type</th>
                                                    <th data-hide="phone,tablet">Flow</th>
                                                    <th data-hide="phone,tablet">Date & Time</th>
                                                    <th data-hide="phone,tablet">From</th>
                                                    <th data-hide="phone,tablet">To</th>
                                                    <th data-hide="phone,tablet">Notes</th>
                                                </tr>
                                            </thead>
            <tbody id="trans-tbl-content">';
           foreach($data as $key => $value){
                  $tbl .= "<tr>"
                            . "<td>".$value["trans_id"]."</td>"
                            . "<td>$".$value["nominal"]."</td>"
                            . "<td>".getTransName($value["type"])."</td>"
                            . "<td>".($value["from_id"]!=$_SESSION["uid"]?"<span class='label label-success'>INCOME</span>":"<span class='label label-danger'>EXPENSE</span>")."</td>"
                            . "<td>".date('F d, Y H:i',strtotime($value["date"]))."</td>"
                            . "<td>".($value["from_id"]=="0"?"SYSTEM":($value["from_id"]!=$_SESSION["uid"]?  getProfileData($value["from_id"], "first_name")." ".  getProfileData($value["from_id"], "last_name")."<br>( Username : <strong>".  getUname($value["from_id"])."</strong> )":"ME"))."</td>"
                            . "<td>".($value["to_id"]=="0"?"SYSTEM":($value["to_id"]!=$_SESSION["uid"]?  getProfileData($value["to_id"], "first_name")." ".  getProfileData($value["to_id"], "last_name")."<br>( Username : <strong>".  getUname($value["to_id"])."</strong> )":"ME"))."</td>"
                            . "<td>".$value["details"]."</td>"
                          . "</tr>";
           }
           
        $tbl .='</tbody></table></div>';
/* --------------------------------------------- */
$blegedes = "";
$addonwhere = "";
// Additional WHERE
 if(isset($_SESSION["filtersum"]["transid"])&&$_SESSION["filtersum"]["transid"]!=""){
    $db->bind("transid",$_SESSION["filtersum"]["transid"]);
    $addonwhere .= " AND trans_id = :transid";
 }
 if(isset($_SESSION["filtersum"]["date"])&&$_SESSION["filtersum"]["date"]!=""){
    $db->bind("tgl",$_SESSION["filtersum"]["date"]);
    $addonwhere .= " AND DATE(date) = :tgl"; 
 }
 if(isset($_SESSION["filtersum"]["type"])&&$_SESSION["filtersum"]["type"]!=""){
    $db->bind("type",$_SESSION["filtersum"]["type"]);
    $addonwhere .= " AND type = :type"; 
 }
 if(isset($_SESSION["filtersum"]["flow"])&&$_SESSION["filtersum"]["flow"]!=""){
     if($_SESSION["filtersum"]["flow"]=="in"){
         $db->bind("to",$_SESSION["uid"]);
         $blegedes = " to_id = :to";
     }else{
         $db->bind("from",$_SESSION["uid"]);
         $blegedes = " from_id = :from";
     }
 }else{
     $db->bind("from",$_SESSION["uid"]);
     $db->bind("to",$_SESSION["uid"]);
     $blegedes = " (to_id = :to OR from_id = :from)";
 }

//$db->bind("uid",$_SESSION["uid"]);
$baris = $db->query("SELECT COUNT(trans_id) as jumlah FROM fund_transaction WHERE ".$blegedes." ".$addonwhere);
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
$tbl = $tbl . "</ul></div>" . $total_string ;  // Content for pagination
echo $tbl;


