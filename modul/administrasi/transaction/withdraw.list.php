<?php
global $db;
if(isset($_SESSION["filterwithdraw"]["uname"])&&$_SESSION["filterwithdraw"]["uname"]!=""){
$uidX = getUID($_SESSION["filterwithdraw"]["uname"]);
}  
// Important Variable
        $page = $curpage; // <--- Get Current Page
        $cur_page = $page;
        $page -= 1;
        $per_page = 20;
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
  if(isset($_SESSION["filterwithdraw"]["wdid"])&&$_SESSION["filterwithdraw"]["wdid"]!=""){
    $db->bind("wdid",$_SESSION["filterwithdraw"]["wdid"]);
    $addonwhere .= " AND id = :wdid";
 }
 if(isset($_SESSION["filterwithdraw"]["status"])&&$_SESSION["filterwithdraw"]["status"]!=""){
    $db->bind("status",$_SESSION["filterwithdraw"]["status"]);
    $addonwhere .= " AND status = :status";
 }
if((isset($_SESSION["filterwithdraw"]["from"])&&$_SESSION["filterwithdraw"]["from"]!="")&&(isset($_SESSION["filterwithdraw"]["to"])&&$_SESSION["filterwithdraw"]["to"]!="")){
    $from = $_SESSION["filterwithdraw"]["from"];
    $to = $_SESSION["filterwithdraw"]["to"];  
    $db->bind("from",$from);
    $db->bind("to",$to);
    $addonwhere .= " AND DATE(date) BETWEEN :from AND :to";
 }else if(isset($_SESSION["filterwithdraw"]["from"])&&$_SESSION["filterwithdraw"]["from"]!=""){
    $db->bind("from",$_SESSION["filterwithdraw"]["from"]);
    $addonwhere .= " AND DATE(date) >= :from";
 }else if(isset($_SESSION["filterwithdraw"]["to"])&&$_SESSION["filterwithdraw"]["to"]!=""){
    $db->bind("to",$_SESSION["filterwithdraw"]["to"]);
    $addonwhere .= " AND DATE(date) >= :to";
 }
if(isset($_SESSION["filterwithdraw"]["uname"])&&$_SESSION["filterwithdraw"]["uname"]!=""){
     $db->bind("uid",$uidX);
     $blegedes = " uid = :uid";
}else{
     $db->bind("uid","x");
     $blegedes = " uid <> :uid";
} 

     
 
//
$data = $db->query("SELECT * FROM withdrawal WHERE ".$blegedes." ".$addonwhere." ORDER BY id DESC LIMIT 20 OFFSET :page"); // <-- Query with OFFSET
//
$tbl .='<div class="tblwrap">'
        . '<div id="loading">'
        . '<p>Retrieving Data From Server.....</p>'
        . '</div>'
        . '<table id="withdraw-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">';
$tbl .='<thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Nominal</th>
                                                    <th data-hide="phone,tablet">Status</th>
                                                    <th data-hide="phone,tablet">Request Date</th>
                                                    <th data-hide="phone,tablet">Payment Date</th>
                                                    <th data-hide="phone,tablet">Pay To</th>
                                                    <th data-hide="phone,tablet">Action</th>
                                                </tr>
                                            </thead>
            <tbody id="withdraw-tbl-content">';
           foreach($data as $key => $value){
                  $tbl .= "<tr>"
                            . "<td>".$value["id"]."</td>"
                            . "<td>$".$value["nominal"]." ( TO YOUR BANK ) + $".$value["pendregs"]." ( REGISTER FUND )</td>"
                            . "<td>".($value["status"]!="PAID"?"<span class='label label-danger'>PENDING</span>":"<span class='label label-success'>PAID</span>")."</td>"
                            . "<td>".date('F d, Y H:i',strtotime($value["date"]))."</td>"
                            . "<td>".($value["paid_date"]!=""?date('F d, Y H:i',strtotime($value["paid_date"])):" - ")."</td>"
                            . "<td><strong>".  bankInfo($value["bank_id"], "bank_name",$value["uid"])." - ".bankInfo($value["bank_id"], "acnumber",$value["uid"])."</strong> <br>HOLDER : <strong>".bankInfo($value["bank_id"], "bankholder",$value["uid"])."</strong>"
                            . "<br>BRANCH NAME : <strong>".bankInfo($value["bank_id"], "branch_name",$value["uid"])."</strong>"
                            . "<br>SWIFT CODE : <strong>".bankInfo($value["bank_id"], "swiftcode",$value["uid"])."</strong>"
                            . "<br>USERNAME : <strong>".strtoupper(getUname($value['uid']))."</strong>"
                            . "</td>"
                            . "<td>".($value["status"]!="PAID"?"<a href='javascript:void();' class='btn btn-info pay' data-id='".$value['id']."'>MAKE PAYMENT</a>":" - ")."</td>"
                          . "</tr>";
           }
           
        $tbl .='</tbody></table></div>';
/* --------------------------------------------- */
$addonwhere = "";
if(isset($_SESSION["filterwithdraw"]["wdid"])&&$_SESSION["filterwithdraw"]["wdid"]!=""){
    $db->bind("wdid",$_SESSION["filterwithdraw"]["wdid"]);
    $addonwhere .= " AND id = :wdid";
 }
 if(isset($_SESSION["filterwithdraw"]["status"])&&$_SESSION["filterwithdraw"]["status"]!=""){
    $db->bind("status",$_SESSION["filterwithdraw"]["status"]);
    $addonwhere .= " AND status = :status";
 }
if((isset($_SESSION["filterwithdraw"]["from"])&&$_SESSION["filterwithdraw"]["from"]!="")&&(isset($_SESSION["filterwithdraw"]["to"])&&$_SESSION["filterwithdraw"]["to"]!="")){
    $from = $_SESSION["filterwithdraw"]["from"];
    $to = $_SESSION["filterwithdraw"]["to"];        
    $db->bind("from",$from);
    $db->bind("to",$to);
    $addonwhere .= " AND DATE(date) BETWEEN :from AND :to";
 }else if(isset($_SESSION["filterwithdraw"]["from"])&&$_SESSION["filterwithdraw"]["from"]!=""){
    $db->bind("from",$_SESSION["filterwithdraw"]["from"]);
    $addonwhere .= " AND DATE(date) >= :from";
 }else if(isset($_SESSION["filterwithdraw"]["to"])&&$_SESSION["filterwithdraw"]["to"]!=""){
    $db->bind("to",$_SESSION["filterwithdraw"]["to"]);
    $addonwhere .= " AND DATE(date) >= :to";
 }
if(isset($_SESSION["filterwithdraw"]["uname"])&&$_SESSION["filterwithdraw"]["uname"]!=""){
     $db->bind("uid",$uidX);
     $blegedes = " uid = :uid";
}else{
     $db->bind("uid","x");
     $blegedes = " uid <> :uid";
} 
//$db->bind("uid",$_SESSION["uid"]);
$baris = $db->query("SELECT COUNT(id) as jumlah FROM withdrawal WHERE ".$blegedes." ".$addonwhere);
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


