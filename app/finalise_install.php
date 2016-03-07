<?php

/**
 * After finishing installation destroy the installation folder
 */
use Illuminate\Filesystem\Filesystem;

require_once dirname((__DIR__)) . "/vendor/autoload.php";


        const INSTALL_FOLDER = "install";

if (!is_dir(INSTALL_FOLDER)) {
    header("location:index.php");
    die();
}

$FileSystem = new Filesystem();

try {

    if ($FileSystem->deleteDirectory(INSTALL_FOLDER)) {
        header("location:signup.php?first_time");
        die();
    } 
} catch (Exception $exc) {
    die("Folder 'install' could not be deleted because of permissions, you will have to manually delete the folder it and <a href='signup.php?first_time'>click here</a>");
}


