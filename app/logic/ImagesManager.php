<?php

/**
 * Description of ImagesManager
 *
 * @author mashcom
 */

namespace Aculyse {

    require_once 'Config.php';
    require_once 'StudentWriter.php';

    class ImagesManager {

        private $filename;

        /**
         * regenerate image into different size
         * @param int $width
         * @param int $height
         * @param string $mode
         * @param string $user
         * @return string|boolean
         */
        function resize($width, $height, $mode, $user) {
            /* Get original image x y */

            if (!getimagesize($_FILES['image']['tmp_name'])) {
                return FALSE;
            }
            list($w, $h) = getimagesize($_FILES['image']['tmp_name']);

            /* calculate new image size with ratio */
            $ratio = max($width / $w, $height / $h);
            $h = ceil($height / $ratio);
            $x = ($w - $width / $ratio) / 2;
            $w = ceil($width / $ratio);
            /* new file name */
            $save_dir = $width . "x" . $height;
            $file_dim_name = $save_dir . "_" . $this->filename;
            if ($mode == "thumbs") {
                $upload_catagory = "profile pics";
                $db_field = "profile pic";
            } else {
                $upload_catagory = "cover photos";
                $db_field = "cover photo";
            }
            $path = "../avatars/$file_dim_name";

            /* read binary data from image file */
            $imgString = file_get_contents($_FILES['image']['tmp_name']);
            /* create image from string */
            $image = imagecreatefromstring($imgString);
            $tmp = imagecreatetruecolor($width, $height);
            imagecopyresampled($tmp, $image, 0, 0, $x, 0, $width, $height, $w, $h);
            /* Save image */
            switch ($_FILES['image']['type']) {
                case 'image/jpeg':
                    imagejpeg($tmp, $path, 100);
                    break;
                case 'image/png':
                    imagepng($tmp, $path, 0);
                    break;
                case 'image/gif':
                    imagegif($tmp, $path);
                    break;
                default:
                    exit;
                    break;
            }

            $StudentWriter = new \Aculyse\StudentsWriter();
            print_r($StudentWriter->updateProfile("piclink", $this->filename, $user));

            return $path;
            /* cleanup memory */
            imagedestroy($image);
            imagedestroy($tmp);
        }

        /**
         * start uploading image
         * @param string $mode
         * the mode is thumbs for profile picture or else the pic will be produced as cover photo
         */
        function uploadImage($mode, $user) {

            $this->filename = sha1(rand(0, 100000) . date('Y-M-D H:i:s:u')).".png";
// settings
            $max_file_size = 1024 * 3000; // 1000kb
            $valid_exts = array('jpeg', 'jpg', 'png', 'gif');

            if ($mode == "thumbs") {
                $sizes = array(200 => 200, 100 => 100,50=>50);
            } else {
                $sizes = array(400 => 150, 600 => 200, 1200 => 400);
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['image'])) {
                if ($_FILES['image']['size'] < $max_file_size) {
// get file extension
                    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, $valid_exts)) {
                        /* resize image */
                        foreach ($sizes as $w => $h) {
                            $files[] = $this->resize($w, $h, $mode, $user);
                        }
                    } else {
                        return 'Unsupported file';
                    }
                } else {
                    return "imageTooBigException";
                }
            }
        }

    }

}