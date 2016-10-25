<?php
function paging($input, $page, $show_per_page) {
    $start = ($page-1) * $show_per_page;
    $end = $start + $show_per_page;
    $count = count($input);

    // Conditionally return results
    if ($start < 0 || $count <= $start)
        // Page is out of range
        return array(); 
    else if ($count <= $end) 
        // Partially-filled page
        return array_slice($input, $start);
    else
        // Full page 
        return array_slice($input, $start, $end - $start);
}