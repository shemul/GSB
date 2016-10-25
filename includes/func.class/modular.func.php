<?php
$all_modul = getAllSubdirectories('modul');
// Call All from modul init.php
foreach ($all_modul as $key => $val){
    include "modul/".$val."/init.php";
}