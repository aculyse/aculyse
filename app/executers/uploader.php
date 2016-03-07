<?php

require_once '../logic/ImagesManager.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']) && isset($_POST["student_id"])) {
    $user = $_POST["student_id"];
    $Upload = new Aculyse\ImagesManager();
    $response = $Upload->uploadImage("thumbs", $user);
    $redirection_url = $_SERVER["HTTP_REFERER"];
     header("location:$redirection_url");
}