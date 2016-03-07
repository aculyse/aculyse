<?php

if(!isset($_GET["username"])  || !isset($_GET["action"])) {
    die("EmptyParameterException") ;
}

$action = $_GET["action"];
$username = $_GET["username"];

require_once "../logic/AccessManager.php" ;
require_once "../logic/Config.php";

//before we authenticate lets destroy previous sessions
Aculyse\AccessManager::destroySession() ;
$User = new Aculyse\AccessManager() ;

switch ($action) {
	case 'generate_key':
		$response = $User->generatePasswordResetKey($username);
		print_r($response);
		break;

	case 'get_key':
		$response = $User->getResetKey($username);
		print_r($response);
	break;

	case 'auth_key':
		if(!isset($_GET["emailed_key"])) {
    			die("EmptyParameterException") ;
		}
		$emailed_reset_key = $_GET["emailed_key"];
		$generated_reset_key = $User->getResetKey($username);

		if(!isset($generated_reset_key->key)){
			die("InvalidKeyFormat");
		}

		//create a reset password session
		if($emailed_reset_key === $generated_reset_key->key){
			@session_start();
			$session_data = array(
				"user"=>$username,
				"key"=>$generated_reset_key,
				"emailed_key"=>$emailed_reset_key,
				"dummy_key"=>PASSWORD_RESET_DUMMY_KEY
				);
			$_SESSION["user"]["id"] = $username;
			

			$_SESSION["reset"] = $session_data;
			if(isset($_SESSION["reset"])){
				header("location:../reset_pwd");
			}
			else{
			header("location:../index");
			}

		}

		
	break;
	
	
	default:
		# code...
	break;
}

