<?php

/**
 * Configuration settings of the entire application
 * Unless you are sure what you are doing, do not edit this file by hand.
 * @author Blessing Mashoko <projects@bmashoko.com>
 * @todo The config will be moved to config folder, which will contain all the config files
 * ,as for now let use this one.
 */
require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";
Dotenv::load(dirname(dirname(dirname(__FILE__))));

require_once dirname(dirname(__DIR__))."/config.php";


/* PROGRAM DETAILS */
define("THIS_VERSION", "1.0");
define("AUTHOR", "Blessing");
define("AUTHOR_WEBSITE", "http://www.bmashoko.com");
define("COPYRIGHT", date("Y"));
define("VERSION_RELEASE", "BETA RELEASE");
define("EDITION", "OPEN TUMERIC EDITION");
define("COMPANY", "Blessing Mashoko");
define("PRODUCT_NAME", "ACULYSE");
define("DESCRIPTION", "A software to make it easy and fast to assess student academic perfomance and manage student records .");
define("MANTRA", "Technologically driven education solutions for Africa");


/* internal paths to resources */
define("DS", "/");
define("ROOT", dirname(dirname(__FILE__)));
define('LOGS_FOLDER', dirname(dirname(dirname(__FILE__))) . "/logs");
define("LOGIC_FOLDER", ROOT . "/logic");
define("VIEWS_FOLDER", ROOT . "/views");
define("USERS_FOLDER", ROOT . "/users");
define("INCLUDES_FOLDER", ROOT . "/includes");
define("ASSETS_FOLDER", ROOT . "/assets");
define("AVATARS_FOLDER", ROOT . "/avatars");
define("HOST_URL", DOMAIN_NAME);
define("USER_FOLDER_URL", HOST_URL . "/users");
define("ASSETS_FOLDER_URL", HOST_URL . "/assets");
define("CSS_FOLDER_URL", ASSETS_FOLDER_URL . "/css");
define("AVATARS_FOLDER_URL", HOST_URL . "/avatars");
define("HELP_FOLDER_URL", HOST_URL . "/help_views/img");
define("LECTURER_HOME_URL", HOST_URL . "/teacher/profiler.php");
define("RECORDS_PERSONEL_HOME_URL", HOST_URL . "/admin/dash.php?overview");
define("PRINCIPALS_HOME_URL", HOST_URL . "/teacher/analytics.php");
define("ADMIN_HOME_URL", HOST_URL . "/admin/super.php");
define("SINGLE_HOME_URL", HOST_URL . "/admin/dash.php?overview");
define("GUARDIAN_HOME_URL",HOST_URL ."/guardian/dash");

/* security */
define("PRODUCTION_SERVER", TRUE);
define("MAINTAINANCE_MODE", FALSE);
define("DEMO", FALSE);
define("PRODUCTION_KEY", "H9L2SF57HMXZSA123ERHKIOLH");
define("SALT", "jY7yswO98@*(jhPI45bGSLhhiKOefoHDewxv()&5");
define("DATE_KEY", date("d"));
define("SESSION_KEY", sha1(DATE_KEY . '%@prq3qc^}M#W+yUwt-VFSS~FBOaHXf]g?nr]d<uE:|JYX`lxw|33_DfU&yc$l~c'));
define("PASSWORD_RESET_DUMMY_KEY", "78h*&bjdhjk(*&^%^%)5bhhhjys8()*YJBNPLLGFDskhuhsDRYSGBJTYSaSR^EW%#^");
define("SESSION_NAME", "KFPEBM");
/*
 * responses to queries done
 */
define("UPDATE_SUCCESS", 0);
define("QUERY_SUCCESS", 0);
define("RATING_NOT_NUM", 1);
define("EXEC_FAILURE", 2);
define("ROW_MISMATCH", 3);

/**
 *  account responses
 */
define("ACCOUNT_TAKEN", "taken");
define("ACCOUNT_AVAILABLE", "available");


/**
 * grading system
 */
define("PRY_LEVEL", 1);
define("JNR_LEVEL", 2);
define("O_LEVEL", 3);
define("A_LEVEL", 4);
define("TERTIARY_LEVEL", 5);