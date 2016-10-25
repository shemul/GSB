<?php
global $db;
if(isset($_SESSION["filterinvoice"]["uname"])&&$_SESSION["filterinvoice"]["uname"]!=""){
$uidX = getUID($_SESSION["filterinvoice"]["uname"]);
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
  if(isset($_SESSION["filterinvoice"]["wdid"])&&$_SESSION["filterinvoice"]["wdid"]!=""){
    $db->bind("wdid",$_SESSION["filterinvoice"]["wdid"]);
    $addonwhere .= " AND invoice_id = :wdid";
 }
 if(isset($_SESSION["filterinvoice"]["status"])&&$_SESSION["filterinvoice"]["status"]!=""){
    $db->bind("status",$_SESSION["filterinvoice"]["status"]);
    $addonwhere .= " AND status = :status";
 }
 

     
 
//
$data = $db->query("SELECT * FROM invoice WHERE 1 ".$addonwhere." ORDER BY id DESC LIMIT 20 OFFSET :page"); // <-- Query with OFFSET
//
$tbl .='<div class="tblwrap">'
        . '<div id="loading">'
        . '<p>Retrieving Data From Server.....</p>'
        . '</div>'
        . '<table id="invoice-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">';
$tbl .='<thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Nominal</th>
                                                    <th data-hide="phone,tablet">Status</th>
                                                    <th data-hide="phone,tablet">Purchase Date</th>
                                                    <th data-hide="phone,tablet">Pay To</th>
                                                    <th data-hide="phone,tablet">Action</th>
                                                </tr>
                                            </thead>
            <tbody id="withdrxaw-tbl-content">';
           foreach($data as $key => $value){
                  $tbl .= "<tr>"
                            . "<td>".$value["id"]."</td>"
                            . "<td>$".$value["amount"]."</td>"
                            . "<td>".($value["status"]!="1"?"<span class='label label-danger'>PENDING</span>":"<span class='label label-success'>APPROVED</span>")."</td>"
                            . "<td>".date('F d, Y H:i',strtotime($value["date"]))."</td>"
                            . "<td>".getUname($value['buyer'])."</strong></td>"
                            . "<td>".($value["status"]!="1"?"<a href='javascript:void();' class='btn btn-info pay' data-id='".$value['id']."'>APPROVE</a>":" - ")."</td>"
                          . "</tr>";
           }
           
        $tbl .='</tbody></table></div>';
/* --------------------------------------------- */
$addonwhere = "";
if(isset($_SESSION["filterinvoice"]["wdid"])&&$_SESSION["filterinvoice"]["wdid"]!=""){
    $db->bind("wdid",$_SESSION["filterinvoice"]["wdid"]);
    $addonwhere .= " AND invoice_id = :wdid";
 }
 if(isset($_SESSION["filterinvoice"]["status"])&&$_SESSION["filterinvoice"]["status"]!=""){
    $db->bind("status",$_SESSION["filterinvoice"]["status"]);
    $addonwhere .= " AND status = :status";
 }

//$db->bind("uid",$_SESSION["uid"]);
$baris = $db->query("SELECT COUNT(id) as jumlah FROM invoice WHERE 1 ".$addonwhere);
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


