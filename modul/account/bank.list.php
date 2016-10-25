<?php
global $db;
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
$db->bind("uid",$_SESSION["uid"]);
$data = $db->query("SELECT * FROM user_bank WHERE uid = :uid ORDER BY bank_id DESC LIMIT 20 OFFSET :page"); // <-- Query with OFFSET
//
if(count($data)<1){
echo "You dont have any bank account, make it one please";
exit;
}
$tbl .='<div class="tblwrap">'
        . '<div id="loading">'
        . '<p>Retrieving Data From Server.....</p>'
        . '</div>'
        . '<table id="bank-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">';
$tbl .='<thead>
                                                <tr>
                                                    <th>BANK NAME</th>
                                                    <th>ACC NUMBER</th>
                                                    <th data-hide="phone,tablet">HOLDER</th>
                                                    <th data-hide="phone,tablet">BRANCH</th>
                                                    <th data-hide="phone,tablet">SWIFTCODE</th>
                                                    
                                                    <th data-hide="phone,tablet">ACTION</th>
                                                </tr>
                                            </thead>
            <tbody id="bank-tbl-content">';
           foreach($data as $key => $value){
                  $tbl .= "<tr>"
                            . "<td>".$value["bank_name"]."</td>"
                            . "<td>".$value["acnumber"]."</td>"
                            . "<td>".$value["bankholder"]."</td>"
                            . "<td>".$value["branch_name"]."</td>"
                            . "<td>".$value["swiftcode"]."</td>"
                            . "<td><a href='/account/bank/edit/".$value["bank_id"]."'  class='btn btn-info' >EDIT</a> <a href='javascript:void();' class='deletebank btn btn-danger' data-id='".$value["bank_id"]."'>DELETE</a></td>"
                          . "</tr>";
           }
           
        $tbl .='</tbody></table></div>';
/* --------------------------------------------- */

$db->bind("uid",$_SESSION["uid"]);
$baris = $db->query("SELECT COUNT(bank_id) as jumlah FROM user_bank WHERE uid = :uid;");
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


