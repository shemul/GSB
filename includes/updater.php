<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/update', function() use($install, $app) {
    global $db;
    if ($install->updateExists() && $install->configExists()) {
        $filename = "includes/update.version";
        $handle = fopen($filename, "rb");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        $row = $db->query($contents);
        if ($row) {
            unlink($filename);
        }
        return $app->redirect('/');
    }
});

