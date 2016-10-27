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
$blegedes = "";
$addonwhere = "";
$tbl = "";
$total_string = "";
// Query The Transaction
$db->bind("page", $start);
// Additional WHERE
// Jika BUKAN Semua User
if (isset($_SESSION["filterusr"]["uname"]) && $_SESSION["filterusr"]["uname"] != "") {
    //$db->bind("usrname", $_SESSION["filterusr"]["uname"]);
    //$blegedes .= " uname like :usrname";
    $temp_uname = $_SESSION["filterusr"]["uname"];
    $blegedes .= " uname LIKE '%".$temp_uname."%'";
} else {
    $blegedes .= " uname <> 'a'";
}
if (isset($_SESSION["filterusr"]["date"]) && $_SESSION["filterusr"]["date"] != "") {
    $db->bind("tgl", $_SESSION["filterusr"]["date"]);
    $addonwhere .= " AND DATE(register_date) = :tgl";
}



//
$data = $db->query("SELECT * FROM history ORDER by date ASC" ); // <-- Query with OFFSET
//

// var_dump($_GET);
// if(isset($_GET["din"])) {
//   $din = $_GET["din"];
//   $data = $db->query("SELECT * FROM user_id WHERE uname = '". $din ."'"); // <-- Query with OFFSET
// }  else {
//     $din = "000000GSBGSB02";
//     $data = $db->query("SELECT * FROM user_id WHERE uname = '". $din ."'"); // <-- Query with OFFSET
// }




$tbl .='<div class="tblwrap">'
        . '<div id="loading">'
        . '<p>Retrieving Data From Server.....</p>'
        . '</div>'
        . '<table id="usr-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">';
$tbl .=' <thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>GENERATE DATE</th>
                                                     <th data-hide="phone,tablet">T. FORM</th>
                                                    <th data-hide="phone,tablet">T. FREE FORM</th>
                                                    <th data-hide="phone,tablet">T. BAN FORM</th>
                                                    <th data-hide="phone,tablet">BILL FOR</th>
                                                    <th data-hide="phone,tablet">T. Match</th>
                                                  
                                                    <th data-hide="phone,tablet">T. Bill</th>
                                                </tr>
                                            </thead>
            <tbody id="usr-tbl-content">';
foreach ($data as $key => $value) {
    //$data = get_data(get_parent($value['uid'], "int"), "uname");
    //$sponsor = get_sponsor($value['uid'], "uname");
    $tbl .= "<tr>"
            . "<td>" . $value["id"] . "</td>"
            . "<td>" . $value["date"] . "</td>"
            . "<td>" . $value["total_form"] . "</td>"
            . "<td>" . $value["total_free_form"] . "</td>"
            . "<td>" . $value["total_ban_form"] . "</td>"
            . "<td>" .  $value["bill_for"] ."</td>"
            . "<td>" .  $value["total_match"] ."</td>"
            . "<td>" .  $value["total_bill"] ."</td>"
            //. "<br>FAT. NAME : <strong>" . getProfileData($value['uid'], 'fatname') . "</strong>"
            //. "<br>DOB : <strong>" . getProfileData($value['uid'], 'dob') . "</strong>"
            //. "<br>GENDER <strong>" . getProfileData($value['uid'], 'gender') . "</strong>"
            //. "<br>Nominee : <strong>" . getProfileData($value['uid'], 'beneficiary') .'('. getProfileData($value['uid'], 'relation') .')'."</strong>"
            //. "<br>FULL ADDRESS : <strong>" . getProfileData($value['uid'], 'address') . "</strong>"
            
            . "</tr>";
}

$tbl .='</tbody></table></div>';
/* --------------------------------------------- */
$blegedes = "";
$addonwhere = "";
// Jika BUKAN Semua User
if (isset($_SESSION["filterusr"]["uname"]) && $_SESSION["filterusr"]["uname"] != "") {
    $db->bind("usrname", $_SESSION["filterusr"]["uname"]);
    $blegedes .= " uname = :usrname";
} else {
    $blegedes .= " uname <> 'a'";
}
if (isset($_SESSION["filterusr"]["date"]) && $_SESSION["filterusr"]["date"] != "") {
    $db->bind("tgl", $_SESSION["filterusr"]["date"]);
    $addonwhere .= " AND DATE(register_date) = :tgl";
}

//$db->bind("uid",$_SESSION["uid"]);
$baris = $db->query("SELECT COUNT(uid) as jumlah FROM user_id WHERE " . $blegedes . " " . $addonwhere . " AND role <> '0'");
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
/*
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
*/
echo $tbl;
