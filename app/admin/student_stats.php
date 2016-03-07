<?php
namespace Aculyse;
use Aculyse\StudentStatistics;
require_once "../../vendor/autoload.php";


$StudentStats = new StudentStatistics();
print_r("all students " . $StudentStats->all_records() . " <br/>");
print_r("active " . $StudentStats->count("activated") . " <br/>");
print_r("suspended " . $StudentStats->count("suspended") . " <br/>");
print_r("graduated " . $StudentStats->count("graduated") . " <br/>");
print_r("defered " . $StudentStats->count("deferred") . " <br/>");
print_r("drop out " . $StudentStats->count("drop-out") . " <br/>");
print_r("deactivated " . $StudentStats->count("deactivated") . " <br/>");
print_r("deleted " . $StudentStats->count("deleted") . " <br/>");



