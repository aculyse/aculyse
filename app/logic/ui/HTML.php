<?php

namespace Aculyse\UI;

class HTML
{

    /**
     * Generate HTML for header file of pages
     * @param string $title
     */
    public static function header($title = "")
    {

        $header = '<!DOCTYPE html>
		<html lang="en">
		    <head>
		        <meta charset="utf-8">
		        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		        <meta name="description" content="">
		        <meta name="author" content="">

		        <title>' . $title . '</title>

		        <!-- Bootstrap core CSS -->

		        <link href="../assets/css/bootstrap.css" rel="stylesheet">
		        <link href="../assets/css/bootstro.css" rel="stylesheet">
		        <link href="../assets/css/master.css" rel="stylesheet">

		        <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css"/>
                        
                        <link rel="stylesheet" href="../assets/dist/css/font-awesome.min.css" type="text/css"/>
		        <link rel="stylesheet" href="../assets/fonts/simpleicon-education/flaticon.css" type="text/css"/>
		        <link rel="stylesheet" href="../assets/fonts/simpleicon-business/flaticon.css" type="text/css"/>
		        <link rel="stylesheet" href="../assets/fonts/icons/typicons.min.css"  type="text/css"/>
		        <!-- Custom styles for this template -->
		        <link href="../assets/css/dashboard.css" rel="stylesheet">
		        <script type="text/javascript" src="../js/jquery-1.11.0.js"></script>
                        <link href="../assets/css/print.css" rel="stylesheet">
                        <link href="../assets/css/jquery-ui.min.css" rel="stylesheet"/>
                        <link href="../favicon.ico" rel="shortcut icon">


		    </head>

		    <body class="skin-blue sidebar-mini fixed">';
        echo $header;

        echo '<div class="wrapper">';
        require_once dirname(dirname(dirname(__FILE__))) . '/includes/navigation.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/includes/side_bar.php';

        echo '<div class="row content-wrapper" style="margin-right: 0 !important;">';


        echo '<div>';

    }

}
