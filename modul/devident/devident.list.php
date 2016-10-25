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
        $tbl = "";
        $total_string="";
// Query The Transaction
$idDevident = getActiveDevID(); 
// Fungsi getActiveDevID kui gawe return ID deviden seng sek open berdasarkan uid ( user id ) , uid dijupuk seko $_SESSION["uid"], Fungsi ne ono neng devident.func.php
$db->bind("page",$start);
// $db->bind("uid",$_SESSION["uid"]); <-- Ki code mu
//
// $data = $db->query("SELECT * FROM devident_timeline WHERE devident_id= id LIMIT 20 OFFSET :page"); // <-- Ki code mu

// Ki tak gaweke seng bener
// PErtama2 jupuk id deviden e user seng login seng status e jek open
$db->bind('idDevUser',$idDevident); 
$data = $db->query("SELECT * FROM devident_timeline WHERE devident_id = :idDevUser ORDER BY id DESC LIMIT 10 OFFSET :page");
// :idDevUser kui jupuk parameter seng di bind fer, di query iki kan seng di bind kui parameter page karo idDevUser
$tbl .='<div class="tblwrap">'
        . '<div id="loading">'
        . '<p>Retrieving Data From Server.....</p>'
        . '</div>'
        . '<table id="devident-tbl" class="footable table-bordered table-striped table-condensed" data-sort="false">';
$tbl .='<thead>
                                                <tr>
                                                    <th>Calculation Date</th>
                                                    <th>Devident Percentage</th>
                                                    <th>Bonus Nominal</th>
                                                    </tr>
                                            </thead>
            <tbody id="devident-tbl-content">';
//$db->bind('idDevUser',$idDevident); 
//$data = $db->query("SELECT * FROM devident_timeline WHERE devident_id = :idDevUser LIMIT 10 OFFSET :page");
            $nominalX = InvestNominal();
           foreach($data as $value){
               $nominal =($value['percentage']/100)*$nominalX;
                  $tbl .= "<tr>"
                            . "<td>".date('F d, Y H:i',strtotime($value['date']))."</td>"
                            . "<td>".$value['percentage']."% </td>"
                            . "<td>$".$nominal."</td>"
                            . "</tr>";
           }
           
        $tbl .='</tbody></table></div>';
/* --------------------------------------------- */
/*$blegedes = "";
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

//$db->bind("uid",$_SESSION["uid"]);*/
$db->bind('devID',$idDevident);         
$baris = $db->query("SELECT COUNT(id) as jumlah FROM devident_timeline WHERE devident_id = :devID" );
// $count = $baris["jumlah"]; <-- Ki Code mu
$count = $baris[0]["jumlah"]; // <-- kenapa ada [0] , karena result dari query merupakan associative array, 0 berfungsi untuk mengambil row 1 hasil query
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


