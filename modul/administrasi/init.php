<?php

global $hooks;
$hooks->add_action('admin_menu', 'menu_admin');

function menu_admin() {
    global $menu_array;
    $dashboardmenu = array(
        array(
            "label" => "Dashboard",
            "url" => "/dashboard",
            "icon" => "fa fa-home"
        ),
        array(
            "label" => "Transaction Summary",
            "url" => "/transaction",
            "icon" => "fa fa-bar-chart-o"
        ),
        array(
            "label" => "Products",
            "url" => "/products",
            "icon" => "fa fa-money"
        ),
        // array(
        //     "label" => "Withdrawal",
        //     "url" => "/withdrawal",
        //     "icon" => "fa fa-money"
        // ),
        array(
            "label" => "User Management",
            "url" => "/user-management",
            "icon" => "fa fa-users"
        ),
        // array(
        //     "label" => "Transfer Point",
        //     "url" => "/account/transfer",
        //     "icon" => "fa fa-mail-forward"
        // ),
        array(
            "label" => "New Registration",
            "url" => "/register-account",
            "icon" => "fa fa-plus"
        ),
        array(
            "label" => "Genealogy Tree",
            "url" => "/genealogy/tree",
            "icon" => "fa fa-sitemap"
        ),
        array(
            "label" => "Bill Sheet",
            "url" => "/transaction/bill",
            "icon" => "fa fa-money"
        ),
        // array(
        //     "label" => "Payment Settings",
        //     "url" => "/payment-setting",
        //     "icon" => "fa fa-money"
        // ),
        // array(
        //     "label" => "Invoices",
        //     "url" => "/invoice",
        //     "icon" => "fa fa-money"
        // ),
        array(
            "label" => "History",
            "url" => "/history",
            "icon" => "fa fa-sitemap"
        ),
        array(
            "label" => "Settings",
            "url" => "#",
            "icon" => "fa fa-cogs",
            "sub" => array(
                array(
                    "label" => "My Profile",
                    "url" => "/profile",
                    "icon" => "fa fa-glass",
                ),
                // array(
                //     "label" => "Edit Profile",
                //     "url" => "/profile/edit",
                //     "icon" => "fa fa-edit",
                // ),
                // array(
                //     "label" => "Change Password",
                //     "url" => "/profile/chpwd",
                //     "icon" => "fa fa-lock",
                // ),
                // array(
                //     "label" => "Change PIN",
                //     "url" => "/profile/chpin",
                //     "icon" => "fa fa-puzzle-piece",
                // )
            )
        )
    );
    $menu_array = $dashboardmenu;
}

function listFolderFiles($dir) {
    $x = array();
    foreach (new DirectoryIterator($dir) as $fileInfo) {
        if (!$fileInfo->isDot() && !strpos($fileInfo->getFilename(), '.')) {
            $x[] = $fileInfo->getFilename();
        }
    }
    return $x;
}

$x = listFolderFiles(dirname(__FILE__));
foreach ($x as $key => $name) {
    include $name . '/init.php';
}