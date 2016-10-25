<?php
global $hooks;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$hooks->add_action('silex_action','the_gen'); // Tancapkan fungsi dashboard ke Trigger Silex
$hooks->add_action('all_menu','menu_genealogy');
function downline_title(){
    echo "Manage All Your Downline";
}
function legs_title(){
    echo "View your Pairing Legs";
}
function tree_title(){
    echo "Your Genealogy Network";
}
function downline_js(){ ?>
        <script src="/assets/js/footable/footable.js"></script>
        <script src="/assets/modul-js/genealogy/downline.js"></script>
<?php }
function downline_css(){ ?>
         <link href="/assets/css/footable/footable.core.css" rel="stylesheet">
<?php }
function legs_js(){ ?>
        <script src="/assets/js/footable/footable.js"></script>
        <script src="/assets/modul-js/genealogy/legs.js"></script>
<?php }
function legs_css(){ ?>
         <link href="/assets/css/footable/footable.core.css" rel="stylesheet">
<?php }
function treeview_js(){ ?>
        <script src="/assets/modul-js/genealogy/jquery.panzoom.js"></script>
        <script src="/assets/modul-js/genealogy/jquery.mousewheel.js"></script>
        <script src="/assets/modul-js/genealogy/treeview.js"></script>
<?php }
function treeview_css(){ ?>
       <link href="/assets/modul-css/genealogy/treeview.css" rel="stylesheet">
<?php }
function menu_genealogy(){
    global $menu_array;
    $genealogymenu = array(
        "label" => "Genealogy",
        "url" => "#",
        "icon" => "fa fa-sitemap",
        "sub" => array(
            array(
                "label" => "My Downline",
                "url" => "/genealogy/downline",
                "icon" => "fa fa-table",
            ),
            array(
                "label" => "Tree View",
                "url" => "/genealogy/tree",
                "icon" => "fa fa-sitemap",
            ),
             array(
                "label" => "Pair Legs",
                "url" => "/genealogy/legs",
                "icon" => "fa fa-sitemap",
            )
        )
    );
    $menu_array[2]=$genealogymenu;
}
function the_gen(){
global $app;    

// Smarty untuk generate array downline
$app->post('/genealogy/downline/list', function(Request $request) { 
    $curpage = $request->get('page');
    include 'downline.list.php';
    return '';
});
// Smarty untuk menu downline
$app->get('/genealogy/downline', function() { 
    global $hooks;
    $hooks->add_action('global_css','downline_css');
    $hooks->add_action('global_js','downline_js');
    $hooks->add_action('the_title',"downline_title");   
    the_head();
    include 'downline.tpl.php';
    the_footer();
    return "";
});
// Smarty untuk generate array downline
$app->post('/genealogy/legs/list', function(Request $request) { 
    $curpage = $request->get('page');
    include 'legs.list.php';
    return '';
});
// Smarty untuk menu downline
$app->get('/genealogy/legs', function() { 
    global $hooks;
    $hooks->add_action('global_css','legs_css');
    $hooks->add_action('global_js','legs_js');
    $hooks->add_action('the_title',"legs_title");   
    the_head();
    include 'legs.tpl.php';
    the_footer();
    return "";
});
// Fungsi Bagan Sub
$app->post('/genealogy/tree/sub', function(Request $request) { 
    $id = $request->get('id');
    return theTree(firstDownline($id));
});
// Smarty untuk menu bagan tree
$app->get('/genealogy/tree', function() { 
    global $hooks;
    $hooks->add_action('global_css','treeview_css');
    $hooks->add_action('global_js','treeview_js');
    $hooks->add_action('the_title',"tree_title");
    the_head();
    include 'tree.tpl.php';
    the_footer();
    return "";
});
$app->get('/genealogy', function() use($app) { 
    return $app->redirect('/genealogy/downline');
}); 
}

include 'gen.func.php';