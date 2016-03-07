<?php

namespace Aculyse;

use Aculyse\Subject;

require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";

if (empty($_POST["subject"])) {
    die();
}

$subject = $_POST["subject"];
$Subject = new Subject();
if ($Subject->addNew($subject)) {
    header("location:../admin/subjects.php?only=custom");
    die();
}
die("Subject adding failed, click <a href='../subject'>here </a> to retry");


