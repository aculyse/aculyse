<?php
require_once "../logic/AccessManager.php";

//before we authenticate lets destroy previous sessions
$logout = Aculyse\AccessManager::destroySession();

if(isset($_SESSION["user"])){
	echo "success";
}
else{
	echo "failed";
}